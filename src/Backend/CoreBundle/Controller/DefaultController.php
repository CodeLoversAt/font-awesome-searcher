<?php

namespace Backend\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BackendCoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
