<?php

namespace BehatBrowser\Bundle\CoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use BehatBrowser\Bundle\CoreBundle\Document\Feature;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class FeaturesController extends FOSRestController
{
    /**
     * Get a single feature
     */
    public function getFeatureAction(Feature $feature)
    {
        return $feature;
    }

    /**
     * Get all features
     */
    public function getFeaturesAction()
    {
        $repository = $this->get('doctrine_mongodb')->getRepository('BehatBrowserCoreBundle:Feature');
        $data = array();
        $features = $repository->findAll();

        foreach ($features as $feature) {
            $data[] = $feature;
        }

        return $data;
    }
}
