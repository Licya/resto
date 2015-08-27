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

    public function indexAction(Request $request)
    { {
            $form = $this->createFormBuilder()
                    ->add('subject', 'text')
                    //->add('email', 'email')
                    ->add('message', 'textarea')
                    //->add('copyWanted', 'checkbox')
                    ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $message = \Swift_Message::newInstance()
                        ->setSubject($data['subject'])
                        ->setFrom('info@trattorie-italia.ch')
                        ->setTo('dev@delicya.ch')   
                        ->setBody("\n message: ".$data['message'])
                // setBody avec un template rendu (cf doc)  
                ;

                $this->get('mailer')->send($message);

                $this->addFlash('success', 'Le mail a bien été envoyé.');
                // reset des data du form
            }

            return $this->render('AdminContactBundle:Contact:index.html.twig', array(
                        'form' => $form->createView(),
            ));
        }
    }

}
