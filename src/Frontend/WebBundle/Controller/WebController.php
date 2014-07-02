<?php

namespace Frontend\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontendWebBundle:Web:index.html.twig', array());
    }
}
