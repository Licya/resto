<?php

namespace Admin\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AdminNewsBundle:Default:index.html.twig', array('name' => $name));
    }
}
