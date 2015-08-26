<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContactWebmaster
 *
 * @author Licya
 */

namespace Admin\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ContactController extends Controller
{

    public function indexAction()
    {

        return $this->render('AdminContactBundle:Contact:index.html.twig');
    }

}
