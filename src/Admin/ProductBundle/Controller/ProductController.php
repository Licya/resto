<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductController
 *
 * @author Licya
 */

namespace Admin\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;

class ProductController extends Controller
{

    public function indexAction()
    {
        $news = $this->getDoctrine()
                        ->getRepository('AppBundle:Product')->findAll();

        return $this->render('AdminProductBundle:Product:index.html.twig', array('product' => $news,));
    }

    public function detailAction($id)
    {

        $em = $this
                ->getDoctrine()
                ->getManager();
        $product = $em->getRepository('AppBundle:Product')->find($id);

        if (!$product) {

            $this->addFlash('error', 'Ce Produit n\'existe pas.');
            return $this->redirectToRoute('admin_product_home');
        }

        $name = $product->getName();
        $description = $product->getDescription();
        $mainPrice = $product->getMainPrice();
        $secondPrice = $product->getSecondPrice();
        $enable = $product->getEnable();

        return $this->render('AdminProductBundle:Product:detail.html.twig', array(
                    'name' => $name,
                    'description' => $description,
                    'mainPrice' => $mainPrice,
                    'secondPrice' => $secondPrice,
                    'enable' => $enable,
                    'id' => $id,
        ));
    }

    public function addAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(new ProductType(), $product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit bien enregistré.');

            return $this->redirectToRoute('admin_product_detail', array('id' => $product->getId()));
        }

        return $this->render('AdminProductBundle:Product:add.html.twig', array('form' => $form->createView(),));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->find($id);

        $form = $this->createForm(new \AppBundle\Form\ProductType(), $product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Le Produit a été modifié.');
            return $this->redirectToRoute('admin_product_detail', array('id' => $product->getId()));
        }

        return $this->render('AdminProductBundle:Product:edit.html.twig', array('form' => $form->createView(), 'id' => $id,));
    }

    public function deleteAction($id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $product = $em->getRepository('AppBundle:Product')->find($id);

        if (!$product) {

            $this->addFlash('error', 'Le Produit n\'existe pas.');
            return $this->redirectToRoute('admin_product_home');
        }

        $em->remove($product);
        $em->flush();

        $this->addFlash('success', 'Produit bien supprimé.');
        return$this->redirectToRoute('admin_product_home');
    }

}
