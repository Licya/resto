<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewsController
 *
 * @author Licya
 */

namespace Admin\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\News;

class NewsController extends Controller
{

    public function indexAction()
    {
        $news = $this->getDoctrine()
                        ->getRepository('AppBundle:News')->findAll();

        return $this->render('AdminNewsBundle:News:index.html.twig', array('news' => $news,));
    }

    public function detailAction($id)
    {

        $em = $this
                ->getDoctrine()
                ->getManager();
        $news = $em->getRepository('AppBundle:News')->find($id);

        if (!$news) {

            $ErrorMessage = "Une erreur est survenue. Cette news n'existe pas";

            return $this->render('AdminNewsBundle:News:error.html.twig', array('ErrorMessage' => $ErrorMessage,));
        }

        $title = $news->getTitle();
        $subtitle = $news->getSubtitle();
        $description = $news->getDescription();
        $enable = $news->getEnable();
        $sort = $news->getSort();

        return $this->render('AdminNewsBundle:News:detail.html.twig', array('title' => $title, 'subtitle' => $subtitle, 'id' => $id, 'description' => $description,
                    'enable' => $enable, 'sort' => $sort,));
    }

    public function addAction(Request $request)
    {
        $news = new News();
        $news->setSort(1);
        $form = $this->createFormBuilder($news)
                ->add('title', 'text')
                ->add('subtitle', 'text')
                ->add('description', 'textarea')
                ->add('enable', 'checkbox', array(
                    'required' => false
                ))
                ->add('save', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            $SuccessMessage = 'La News a été ajoutée correctement.';

            $request->getSession()->getFlashBag()->add('success', 'News bien enregistrée.');
            return $this->render('AdminNewsBundle:News:task_success.html.twig', array('SuccessMessage' => $SuccessMessage));
        }
        $id = $news->getId();
        $news->setSort($id);
        return $this->render('AdminNewsBundle:News:add.html.twig', array('form' => $form->createView(),));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $news = $em->getRepository('AppBundle:News')->find($id);

        $title = $news->getTitle();
        $subtitle = $news->getSubtitle();
        $description = $news->getDescription();
        $enable = $news->getEnable();
        $sort = $news->getSort();

        $news->setTitle($title);
        $news->setSubtitle($subtitle);
        $news->setDescription($description);
        $news->setEnable($enable);
        $news->setSort($sort);

        $form = $this->createFormBuilder($news)
                ->add('title', 'text')
                ->add('subtitle', 'text')
                ->add('description', 'textarea')
                ->add('enable', 'checkbox')
                ->add('sort', 'integer')
                ->add('save', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            $SuccessMessage = 'La News a été modifiée avec succès.';

            $request->getSession()->getFlashBag()->add('success', 'La News a été modifiée.');
            return $this->render('AdminNewsBundle:News:task_success.html.twig', array('SuccessMessage' => $SuccessMessage));
        } else {
            $ErrorMessage = "Une erreur est survenue. La News n' pas pu être modifiée. Veuillez contacter votre webmaster.";
            return $this->render('AdminNewsBundle:News:error.html.twig', array('ErrorMessage' => $ErrorMessage));
        }

        return $this->render('AdminNewsBundle:News:edit.html.twig', array('form' => $form->createView(), 'id' => $id,));
    }

    public function deleteAction($id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $news = $em->getRepository('AppBundle:News')->find($id);

        $title = $news->getTitle();
        $subtitle = $news->getSubtitle();
        $description = $news->getDescription();

        if (!$news) {

            $ErrorMessage = "Une erreur est survenue. Cette news n'existe pas. Veuillez contacter votre webmaster.";

            return $this->render('AdminNewsBundle:News:error.html.twig', array('ErrorMessage' => $ErrorMessage,));
        }

        $em->remove($news);
        $em->flush();
        
        $SuccessMessage = "La News a été correctement effacée.";
        return $this->render('AdminNewsBundle:News:task_success.html.twig', array('SuccessMessage' => $SuccessMessage,));

        return $this->render('AdminNewsBundle:News:delete.html.twig', array(
                    'id' => $id, 'title' => $title, 'subtitle' => $subtitle, 'description' => $description,
        ));
    }

}
