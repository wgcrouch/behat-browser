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
        //$this->parseDefinitions($definitions);
        
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
        foreach ($definitions as $regex => $details) {
            $definition = new Definition();
            $definition->setDescription($details->description);
            $definition->setPath($details->path);
            $definition->setRegex($regex);

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
        foreach ($features as $details) {
            $feature = new Feature();
            $feature->setDescription($details->description);
            $feature->setName($details->name);
            
            $dm->persist($feature);
        }
        $dm->flush();
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
