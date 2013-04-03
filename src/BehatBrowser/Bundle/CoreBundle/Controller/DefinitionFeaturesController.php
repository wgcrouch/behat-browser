<?php

namespace BehatBrowser\Bundle\CoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use BehatBrowser\Bundle\CoreBundle\Document\Feature;
use BehatBrowser\Bundle\CoreBundle\Document\Definition;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DefinitionFeaturesController extends FOSRestController
{
    /**
     * Get all features
     */
    public function getFeaturesAction(Definition $definition)
    {
        $repository = $this->get('doctrine_mongodb')->getRepository('BehatBrowserCoreBundle:Feature');
        $data = array();
        $features = $repository->findBy(array('scenarios.steps.definition.$id' => new \MongoId ($definition->getId())));

        foreach ($features as $feature) {
            $data[] = $feature;
        }

        return $data;
    }
}
