<?php

namespace Admin\ContactWebmasterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AdminContactWebmasterBundle:Default:index.html.twig', array('name' => $name));
    }
}
