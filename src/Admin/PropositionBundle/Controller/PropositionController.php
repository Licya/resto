<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PropositionController
 *
 * @author Licya
 */

namespace Admin\PropositionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Proposition;
use AppBundle\Form\PropositionType;

class PropositionController extends Controller
{

    public function indexAction()
    {
        $proposition = $this->getDoctrine()
                        ->getRepository('AppBundle:Proposition')->findAll();

        return $this->render('AdminPropositionBundle:Proposition:index.html.twig', array('proposition' => $proposition,));
    }

    public function detailAction($id)
    {

        $em = $this
                ->getDoctrine()
                ->getManager();
        $proposition = $em->getRepository('AppBundle:Proposition')->find($id);

        if (!$proposition) {
            $this->addFlash('error', 'Cette Proposition n\'existe pas.');
            return$this->redirectToRoute('admin_proposition_home');
        }

        $title = $proposition->getTitle();

        return $this->render('AdminPropositionBundle:Proposition:detail.html.twig', array('title' => $title, 'id' => $id,));
    }

    public function addAction(Request $request)
    {
        $proposition = new Proposition();
        $form = $this->createForm(new PropositionType(), $proposition);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proposition);
            $em->flush();

            $this->addFlash('success', 'Proposition bien enregistrée.');
            
            return $this->redirectToRoute('admin_proposition_detail', array('id' => $proposition->getId()));
        }

        return $this->render('AdminPropositionBundle:Proposition:add.html.twig', array('form' => $form->createView(),));
    }

    public function editAction(Request $request, $id)
    {
       $em = $this->getDoctrine()->getManager();
       $proposition = $em->getRepository('AppBundle:Proposition')->find($id);
       
       $form = $this->createForm(new \AppBundle\Form\PropositionType(), $proposition);
       $form->handleRequest($request);
       
        if ($form->isValid()) {
            $em->persist($proposition);
            $em->flush();

            $this->addFlash('success', 'La Proposition a été modifiée.');
            return $this->redirectToRoute('admin_proposition_detail', array('id' => $proposition->getId()
            ));
        }

        return $this->render('AdminPropositionBundle:Proposition:edit.html.twig', array('form' => $form->createView(), 'id' => $id,));
    }

     /**
     * deleteAction() function created for a future developement and management.
     * Moreover this function needs a more important data processing because of 
     * the integrity constraint. In fact, Proposition entity possesses a foreign key
     * in Product entity and in DailyMenu entity (see diagram).
     */
    
//    public function deleteAction($id)
//    {
//        $em = $this
//                ->getDoctrine()
//                ->getManager();
//        $proposition = $em->getRepository('AppBundle:Proposition')->find($id);
//
//        if (!$proposition) {
//            
//            $this->addFlash('error', 'Proposition n\'existe pas.');
//            return$this->redirectToRoute('admin_proposition_home');
//        }
//
//        $em->remove($proposition);
//        $em->flush();
//        
//        $this->addFlash('success', 'Proposition bien supprimée.');
//        return$this->redirectToRoute('admin_proposition_home');
//
//    }
}
