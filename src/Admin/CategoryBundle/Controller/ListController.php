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

            $ErrorMessage = "Désolé, aucune catégrory n'a trouvée pour cet id.";

            return $this->render('AdminCategoryBundle:List:error.html.twig', array('ErrorMessage' => $ErrorMessage, 'id' => $id));
        }

        $name = $category->getName();
        $description = $category->getDescription();
        $enable = $category->getEnable();
        $sort = $category->getSort();

        return $this->render('AdminCategoryBundle:List:detail.html.twig', array('name' => $name, 'id' => $id, 'description' => $description,
            'enable'=>$enable, 'sort'=>$sort));
    }

    public function addAction(Request $request)
    {
        $category = new Category();
        $category->setSort(1);
        $form = $this->createFormBuilder($category)
                ->add('name', 'text')
                ->add('description', 'textarea')
                ->add('enable', 'checkbox')
                ->add('save', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Categorie bien enregistrée.');
        }
        $id = $category->getId();
        $category->setSort($id);
        return $this->render('AdminCategoryBundle:List:add.html.twig', array('form' => $form->createView(),));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);
        
        $name=$category->getName();
        $description=$category->getDescription();
        $enable=$category->getEnable();
        $sort=$category->getSort();

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

            $request->getSession()->getFlashBag()->add('success', 'Categorie a été modifiée.');
        }

        return $this->render('AdminCategoryBundle:List:edit.html.twig', array('form' => $form->createView(), 'id'=>$id,));
    }

    public function deleteAction($id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);

        $name = $category->getName();
        $description = $category->getDescription();

        $em->remove($category);
        $em->flush();

        return $this->render('AdminCategoryBundle:List:delete.html.twig', array(
                    'id' => $id, 'name' => $name, 'description' => $description
        ));
    }

}
