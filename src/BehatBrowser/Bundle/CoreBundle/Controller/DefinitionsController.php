<?php

namespace BehatBrowser\Bundle\CoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use BehatBrowser\Bundle\CoreBundle\Document\Definition;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DefinitionsController extends FOSRestController
{
    /**
     * Get a single definition
     */
    public function getDefinitionAction(Definition $definition)
    {
        return $definition;
    }

    /**
     * Get all definitions
     */
    public function getDefinitionsAction()
    {
        $repository = $this->get('doctrine_mongodb')->getRepository('BehatBrowserCoreBundle:Definition');
        $data = array();
        $definitions = $repository->findAll();

        foreach ($definitions as $definition) {
            $data[] = $definition;
        }

        return $data;
    }
}
