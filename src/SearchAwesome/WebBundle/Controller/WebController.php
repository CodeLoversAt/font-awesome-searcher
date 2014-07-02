<?php

namespace SearchAwesome\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebController extends Controller
{
    public function indexAction()
    {
        return $this->render('SearchAwesomeWebBundle:Web:index.html.twig', array());
    }
}
