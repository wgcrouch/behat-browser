<?php 

namespace BehatBrowser\Bundle\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use BehatBrowser\Bundle\CoreBundle\Document\Definition;
use BehatBrowser\Bundle\CoreBundle\Document\Feature;
use BehatBrowser\Bundle\CoreBundle\Document\Scenario;
use BehatBrowser\Bundle\CoreBundle\Document\Step;

class ImportSuiteCommand extends ContainerAwareCommand
{

    protected $suitePath = null;
    protected $definitions = array();

    protected function configure()
    {
        $this
            ->setName('core:import-suite')
            ->setDescription('Import a behat suite');
    }

    protected $output = null;

    

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->suitePath = $this->getContainer()->getParameter('core.suite_path');
        $this->getSuiteFromBehat();
    }

    /**
     * Get the json from the behat suite and convert it into documents
     * 
     */
    protected function getSuiteFromBehat()
    {
        $process = new Process('bin/behat --dry-run --format json', $this->suitePath);
        $process->run();
        $exported = $process->getOutput();

        $jsons = explode('{--FEATURES--}', $exported);

        $definitions = json_decode($jsons[0]);
        $this->parseDefinitions($definitions);
        
        $features = json_decode($jsons[1]);
        $this->parseFeatures($features);
    }

    /**
     * Create documents for each definition returned, store them in an array for later reference
     * and store them in the db
     * @param array $definitions
     */
    protected function parseDefinitions($definitions)
    {
        $dm = $this->getDoctrine();
        $repository = $dm->getRepository('BehatBrowserCoreBundle:Definition');
        foreach ($definitions as $regex => $details) {
            $definition = $repository->findOneBy(array('regex' => $regex));
            if (!$definition) {
                $definition = new Definition();
            }
            $definition->setDescription($details->description);
            $definition->setPath($details->path);
            $definition->setRegex($regex);
            $definition->setType($details->type);

            $this->definitions[$regex] = $definition;
            $dm->persist($definition);
        }
        $dm->flush();
    }

    /**
     * Create features based on the data returned from behat and store in mongo
     * @param array $features
     */
    protected function parseFeatures($features)
    {
        $dm = $this->getDoctrine();
        $repository = $dm->getRepository('BehatBrowserCoreBundle:Feature');
        foreach ($features as $details) {
            $feature = $repository->findOneBy(array('name' => $details->name));
            if (!$feature) {
                $feature = new Feature();
            }
            $feature->setDescription($details->description);
            $feature->setName($details->name);
            $feature->setTags(array_values($details->tags));
            $this->parseScenarios($feature, $details->scenarios);

            $background = $this->parseSteps($details->background);
            $feature->clearBackGroundSteps();
            foreach ($background as $step) {
                $feature->addBackgroundStep($step);
            }

            $dm->persist($feature);
        }
        $dm->flush();
    }

    /**
     * Parse the scenarios and add them to a featuer
     * @param array $steps
     * @return array
     */
    protected function parseScenarios(Feature $feature, $scenarios)
    {
        $feature->clearScenarios();
        foreach ($scenarios as $details) {
            $scenario = new Scenario();
            $scenario->setTags(array_values($details->tags));
            $scenario->setTitle($details->title);
            $scenario->setType($details->type);
            $steps = $this->parseSteps($details->steps);
            $scenario->clearSteps();
            foreach ($steps as $step) {
                $scenario->addStep($step);
            }
            $feature->addScenario($scenario);
        }
        
    }


    /**
     * Parse the step details returning step objects linked to definitions
     * @param array $steps
     * @return array
     */
    protected function parseSteps($steps)
    {
        $newSteps = array();
        foreach ($steps as $details) {
            $step = new Step();
            $step->setType($details->type);
            $step->setText($details->text);
            $step->setArguments($details->arguments);
            if (array_key_exists($details->definition, $this->definitions)) {
                $step->setDefinition($this->definitions[$details->definition]);
            }
            $newSteps[] = $step;
        }
        return $newSteps;
    }
    
    protected function getDoctrine()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        return $dm;
    }

    protected function out($text)
    {
        $this->output->writeln($text);
    }

}
