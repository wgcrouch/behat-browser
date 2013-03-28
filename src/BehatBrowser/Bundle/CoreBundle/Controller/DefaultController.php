<?php

namespace BehatBrowser\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BehatBrowserCoreBundle:Default:index.html.twig', array());
    }
}
