<?php

namespace BehatBrowser\Bundle\CoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use BehatBrowser\Bundle\CoreBundle\Document\Feature;
use BehatBrowser\Bundle\CoreBundle\Document\Scenario;
use itsallagile\CoreBundle\Document\Board;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use itsallagile\APIBundle\Form\ChatMessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Rest controller for scenarios
 */
class ScenariosController extends FOSRestController
{
    /**
     * Get a single scenario from this features scenarios
     *
     * @param Feature $feature
     * @param string $scenarioId
     */
    public function getScenarioAction(Feature $feature, $scenarioId)
    {
        $scenario = $feature->getScenario($scenarioId);
        if (!$scenario) {
            throw $this->createNotFoundException('Could not find scenario ' . $scenarioId);
        }
        return $scenario;
    }

    /**
     * Get all scenarios for a feature
     *
     * @param Board $feature
     */
    public function getScenariosAction(Feature $feature)
    {
        return $feature->getScenarios();
    }
}
