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

    public function indexAction($page)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('Category"'.$page.'"inexistante.');
        }

        return $this->render('AdminCategoryBundle:List:index.html.twig');
    }

    public function detailAction($id)
    {

        $em = $this
                ->getDoctrine()
                ->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);

        if (!$category) {
//            throw $this->createNotFoundException(
//                    'Aucune catégrory trouvée pour cet id : '.$id);
            $ErrorMessage = "Désolé, aucune catégrory n'a trouvée pour cet id.";

            return $this->render('AdminCategoryBundle:List:error.html.twig', array('ErrorMessage' => $ErrorMessage, 'id' => $id));
        }

        $name = $category->getName();
        $description = $category->getDescription();

        return $this->render('AdminCategoryBundle:List:detail.html.twig', array('name' => $name, 'id' => $id, 'description' => $description));
    }

    public function addAction()
    {
//        $em = $this->getDoctrine()->getManager();
//        $category=$em->getRepository('AppBundle:Category');

        $category = new Category();
        $category = setName('Koko');
        $category = setDescription('La vie est Belle');
        $category = setEnable('true');

        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category');
        $em->persist($category);
        $em->flush();

        $id = $category->getId();
        $name = $category->getName();
        $description = $category->getDescription();
        $message = 'A été créée.';

        return $this->render('AdminCategoryBundle:list:add.html.twig', array('id' => $id, 'name' => $name, 'description' => $description, 'message' => $message));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);

        if (!$category) {
            $ErrorMessage = "Désolé, aucune catégrory n'a trouvée pour cet id.";
            return $this->render('AdminCategoryBundle:List:error.html.twig', array('ErrorMessage' => $ErrorMessage, 'id' => $id));
        }

        $category->setName('Dessert');
        $category->setDescription('Une douceur pour la vie');
        $em->flush();

        $name = $category->getName();
        $description = $category->getDescription();

        return $this->render('AdminCategoryBundle:List:edit.html.twig', array('name' => $name, 'description' => $description, 'id' => $id));
    }

    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);

        $id=$category->getId();
        $name=$category->getName();
        $description=$category->getDescription();
        
        $em->remove($category);
        $em->flush();
        
        return $this->render('AdminCategoryBundle:List:delet.html.twig', array(
                    'id' => $id, 'name' => $name, 'description' => $description
        ));
    }

}
