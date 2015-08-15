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

class PropositionController extends Controller
{

    public function indexAction()
    {
        $proposition = $this->getDoctrine()
                        ->getRepository('AppBundle:Proposition')->findAll();

        return $this->render('AdminPropositionBundle:Proposition:index.html.twig', array('proposition' => $proposition,));
    }

    /**
     * At this moment, the entity Proposition possesses just one parameter.
     * This is why detailAction() function is superfluous. However, in a future
     * the customer would like to add some other parameter to this entity
     */
//    public function detailAction($id)
//    {
//
//        $em = $this
//                ->getDoctrine()
//                ->getManager();
//        $proposition = $em->getRepository('AppBundle:Proposition')->find($id);
//
//        if (!$proposition) {
//
//            $ErrorMessage = "Désolé, aucune proposition n'a trouvée pour cet id.";
//
//            return $this->render('AdminPropositionBundle:Proposition:error.html.twig', array('ErrorMessage' => $ErrorMessage, 'id' => $id));
//        }
//
//        $title = $proposition->getTitle();
//
//        return $this->render('AdminPropositionBundle:Proposition:detail.html.twig', array('title' => $title, 'id' => $id,));
//    }

    /**
     * addAction() function created for a future developement and management.
     * In fact, for the moment the customer doesn't need to add proposition, but 
     * perhaps, one day he would like to propose several Dailymenus...
     * 
     */
//    public function addAction(Request $request)
//    {
//        $proposition = new Proposition();
//        $form = $this->createFormBuilder($proposition)
//                ->add('title', 'text')
//                ->add('save', 'submit')
//                ->getForm();
//
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($proposition);
//            $em->flush();
//
//            $request->getSession()->getFlashBag()->add('success', 'Proposition bien enregistrée.');
//        }
//
//        return $this->render('AdminPropositionBundle:Proposition:add.html.twig', array('form' => $form->createView(),));
//    }

    public function editAction(Request $request, $id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $proposition = $em->getRepository('AppBundle:Proposition')->find($id);

        $title = $proposition->getTitle();

        $proposition->setTitle($title);

        $form = $this->createFormBuilder($proposition)
                ->add('title', 'text')
                ->add('save', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($proposition);
            $em->flush();

            $successMessage = "La proposition a été correctement modifiée.";

            $request->getSession()->getFlashBag()->add('success', 'La proposition a été modifiée.');
            return $this->render('AdminPropositionBundle:Proposition:task_success.html.twig', array('SuccessMessage' => $successMessage));
        }
//        else {
//            $errorMessage = "Une erreur est survenue. La proposition n'a pas été modifée."
//                    ."Veuillez contacter votre webmaster";
//            return $this->render('AdminPropositionBundle:Proposition:error.html.twig', array('ErrorMessage' => $errorMessage));
//        }

        return $this->render('AdminPropositionBundle:Proposition:edit.html.twig', array('form' => $form->createView(), 'id' => $id,));
    }

    /**
     * deleteAction() function created for a future developement and management.
     * Moreover this function needs a more important data processing because of 
     * the integrity constraint. In fact, Proposition entity possesses a foreign key
     * in Daily_Menu entity (see diagram).
     */
//    public function deleteAction($id)
//    {
//        $em = $this
//                ->getDoctrine()
//                ->getManager();
//        $proposition = $em->getRepository('AppBundle:Proposition')->find($id);
//
//        $title =$proposition->getTitle();
//
//        $em->remove($proposition);
//        $em->flush();
//
//        return $this->render('AdminPropositionBundle:Proposition:delete.html.twig', array(
//                    'id' => $id, 'title' => $title
//        ));
//    }
}
