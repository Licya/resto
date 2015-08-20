<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DailyMenuController
 *
 * @author Licya
 */
namespace Admin\DailyMenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\DailyMenu;
use AppBundle\Form\DailyMenuType;

class DailyMenuController extends Controller
{
        public function indexAction()
    {
        $dailyMenu = $this->getDoctrine()
                        ->getRepository('AppBundle:DailyMenu')->findAll();

        return $this->render('AdminDailyMenuBundle:DailyMenu:index.html.twig', array('dailyMenu' => $dailyMenu,));
    }

    public function detailAction($id)
    {

        $em = $this
                ->getDoctrine()
                ->getManager();
        $dailyMenu = $em->getRepository('AppBundle:DailyMenu')->find($id);

        if (!$dailyMenu) {

            $this->addFlash('error', 'Ce menu du jour n\'existe pas.');
            return $this->redirectToRoute('admin_daily_menu_home');
        }

        $title = $dailyMenu->getTitle();
        $price = $dailyMenu->getPrice();
        $date = $dailyMenu->getDate();
        $enable = $dailyMenu->getEnable();

        return $this->render('AdminDailyMenuBundle:DailyMenu:detail.html.twig', array(
                    'title' => $title,
                    'price' => $price,
                    'id' => $id,
                    'date' => $date,
                    'enable' => $enable,
        ));
    }

    public function addAction(Request $request)
    {
        $dailyMenu = new DailyMenu();
        $form = $this->createForm(new DailyMenuType(), $dailyMenu);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dailyMenu);
            $em->flush();

            $this->addFlash('success', 'Menu du Jour bien enregistrée.');

            return $this->redirectToRoute('admin_daily_menu_detail', array('id' => $dailyMenu->getId()));
        }

        return $this->render('AdminDailyMenuBundle:DailyMenu:add.html.twig', array('form' => $form->createView(),));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dailyMenu = $em->getRepository('AppBundle:DailyMenu')->find($id);

        $form = $this->createForm(new \AppBundle\Form\DailyMenuType(), $dailyMenu);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($dailyMenu);
            $em->flush();

            $this->addFlash('success', 'Le Menu du Jour a été modifié.');
            return $this->redirectToRoute('admin_daily_menu_detail', array('id' => $dailyMenu->getId()));
        }

        return $this->render('AdminDailyMenuBundle:DailyMenu:edit.html.twig', array('form' => $form->createView(), 'id' => $id,));
    }

    public function deleteAction($id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $dailyMenu = $em->getRepository('AppBundle:DailyMenu')->find($id);

        if (!$dailyMenu) {

            $this->addFlash('error', 'Ce Menu du Jour n\'existe pas.');
            return $this->redirectToRoute('admin_daily_menu_home');
        }

        $em->remove($dailyMenu);
        $em->flush();

        $this->addFlash('success', 'Menu du Jour bien supprimé.');
        return $this->redirectToRoute('admin_daily_menu_home');
    }
}
