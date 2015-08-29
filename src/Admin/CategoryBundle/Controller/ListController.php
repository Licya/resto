<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ListController
 *
 * @author Licya
 */

namespace Admin\CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;

class ListController extends Controller
{

    public function indexAction()
    {
        $category = $this->getDoctrine()
                        ->getRepository('AppBundle:Category')->findAll();

        return $this->render('AdminCategoryBundle:List:index.html.twig', array('category' => $category,));
    }

    public function detailAction($id)
    {

        $em = $this
                ->getDoctrine()
                ->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);

        if (!$category) {

            $this->addFlash('error', 'News n\'existe pas.');
            return $this->redirectToRoute('admin_news_home');
        }

        $name = $category->getName();
        $description = $category->getDescription();
        $enable = $category->getEnable();
        $sort = $category->getSort();

        return $this->render('AdminCategoryBundle:List:detail.html.twig', array(
                    'name' => $name,
                    'id' => $id,
                    'description' => $description,
                    'enable' => $enable,
                    'sort' => $sort,
        ));
    }

    /**
     * addAction() function created for a future developement and management
     */
    
    public function addAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Catégorie bien enregistrée.');

            return $this->redirectToRoute('admin_category_detail', array('id' => $category->getId()));
        }
       return $this->render('AdminCategoryBundle:List:add.html.twig', array('form' => $form->createView(),));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);

        $form = $this->createForm(new \AppBundle\Form\CategoryType(), $category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'La Catégorie a été modifiée.');
            return $this->redirectToRoute('admin_category_detail', array('id' => $category->getId()));
        } 
        return $this->render('AdminCategoryBundle:List:edit.html.twig', array('form' => $form->createView(), 'id' => $id,));
    }

    /**
     * deleteAction() function created for a future developement and management.
     * Moreover this function needs a more important data processing because of 
     * the integrity constraint. In fact, Category entity possesses a foreign key
     * in Product entity (see diagram).
     */
    public function deleteAction($id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);

        if (!$category) {

            $this->addFlash('error', 'Cette Catégorie n\'existe pas.');
            return $this->redirectToRoute('admin_category_home');
        }

        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'Catégorie bien supprimée.');
        return$this->redirectToRoute('admin_category_home');
    }
}
