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

            $ErrorMessage = "Une erreur est survenue. La Catégorie que vous avez selectionnée n'existe pas."
                    ."Veuillez prendre contact avec votre webmaster";

            return $this->render('AdminCategoryBundle:List:error.html.twig', array('ErrorMessage' => $ErrorMessage, 'id' => $id));
        }

        $name = $category->getName();
        $description = $category->getDescription();
        $enable = $category->getEnable();
        $sort = $category->getSort();

        return $this->render('AdminCategoryBundle:List:detail.html.twig', array('name' => $name, 'id' => $id, 'description' => $description,
                    'enable' => $enable, 'sort' => $sort));
    }

    /**
     * addAction() function created for a future developement and management
     */
//    public function addAction(Request $request)
//    {
//        $category = new Category();
//        $category->setSort(1);
//        $form = $this->createFormBuilder($category)
//                ->add('name', 'text')
//                ->add('description', 'textarea')
//                ->add('enable', 'checkbox')
//                ->add('save', 'submit')
//                ->getForm();
//
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($category);
//            $em->flush();
//
//            $request->getSession()->getFlashBag()->add('success', 'Categorie bien enregistrée.');
//            return $this->render('AdminCategoryBundle:List:task_success.html.twig');
//        }
//        $id = $category->getId();
//        $category->setSort($id);
//        return $this->render('AdminCategoryBundle:List:add.html.twig', array('form' => $form->createView(),));
//    }

    public function editAction(Request $request, $id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);

        $name = $category->getName();
        $description = $category->getDescription();
        $enable = $category->getEnable();
        $sort = $category->getSort();

        $category->setName($name);
        $category->setDescription($description);
        $category->setEnable($enable);
        $category->setSort($sort);

        $form = $this->createFormBuilder($category)
                ->add('name', 'text')
                ->add('description', 'textarea')
                ->add('enable', 'checkbox')
                ->add('sort', 'integer')
                ->add('save', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $SuccessMessage = 'La Catégorie a été modifiée avec succès.';

            $request->getSession()->getFlashBag()->add('success', 'Categorie a été modifiée.');
            return $this->render('AdminCategoryBundle:List:task_success.html.twig', array('SuccessMessage', $SuccessMessage));
        } else {
            $ErrorMessage = "Une erreur est survenu. La Catégorie n'a pas pu être modifiée."
                    ."Veuillez prendre contact avec votre webmaser.";

            return $this->render('AdminCategoryBundle:List:error.html.twig', array('ErrorMessage' => $ErrorMessage));
        }
        return $this->render('AdminCategoryBundle:List:edit.html.twig', array('form' => $form->createView(), 'id' => $id,));
    }

    /**
     * deleteAction() function created for a future developement and management.
     * Moreover this function needs a more important data processing because of 
     * the integrity constraint. In fact, Category entity possesses a foreign key
     * in Product entity (see diagram).
     */
//    public function deleteAction($id)
//    {
//        $em = $this
//                ->getDoctrine()
//                ->getManager();
//        $category = $em->getRepository('AppBundle:Category')->find($id);
//
//        $name = $category->getName();
//        $description = $category->getDescription();
//
//        $em->remove($category);
//        $em->flush();
//
//        return $this->render('AdminCategoryBundle:List:delete.html.twig', array(
//                    'id' => $id, 'name' => $name, 'description' => $description
//        ));
//    }
}
