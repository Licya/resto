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

            $ErrorMessage = "Désolé, aucune News été n'a trouvée pour cet id.";

            return $this->render('AdminNewsBundle:News:error.html.twig', array('ErrorMessage' => $ErrorMessage, 'id' => $id, ));
        }

        $title = $news->getTitle();
        $subtitle = $news->getSubtitle();
        $description = $news->getDescription();
        $enable = $news->getEnable();
        $sort = $news->getSort();

        return $this->render('AdminNewsBundle:News:detail.html.twig', array('title' => $title, 'subtitle' => $subtitle, 'id' => $id, 'description' => $description,
                    'enable' => $enable, 'sort' => $sort, ));
    }

    public function addAction(Request $request)
    {
        $news = new News();
        $news->setSort(1);
        $form = $this->createFormBuilder($news)
                ->add('title', 'text')
                ->add('subtitle', 'text')
                ->add('description', 'textarea')
                ->add('enable', 'checkbox')
                ->add('save', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'News bien enregistrée.');
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
                ->add('subtitle','text')
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

            $request->getSession()->getFlashBag()->add('success', 'La News a été modifiée.');
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

        $em->remove($news);
        $em->flush();

        return $this->render('AdminNewsBundle:News:delete.html.twig', array(
                    'id' => $id, 'title' => $title, 'subtitle' => $subtitle, 'description' => $description,
        ));
    }

}
