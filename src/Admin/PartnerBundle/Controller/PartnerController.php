<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of partnerController
 *
 * @author Licya
 */

namespace Admin\PartnerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Partner;
use AppBundle\Form\PartnerType;

class PartnerController extends Controller
{

    public function indexAction()
    {
        $partner = $this->getDoctrine()
                        ->getRepository('AppBundle:Partner')->findAll();

        return $this->render('AdminPartnerBundle:Partner:index.html.twig', array('partner' => $partner,));
    }

    public function detailAction($id)
    {

        $em = $this
                ->getDoctrine()
                ->getManager();
        $partner = $em->getRepository('AppBundle:Partner')->find($id);

        if (!$partner) {

            $this->addFlash('error', 'News n\'existe pas.');
            return $this->redirectToRoute('admin_news_home');
        }

        $name = $partner->getName();
        $websiteLink = $partner->getWebsiteLink();
        $enable = $partner->getEnable();
        $sort = $partner->getSort();

        return $this->render('AdminPartnerBundle:Partner:detail.html.twig', array(
                    'name' => $name,
                    'id' => $id,
                    'websiteLink' => $websiteLink,
                    'enable' => $enable,
                    'sort' => $sort));
    }

    public function addAction(Request $request)
    {
        $partner = new Partner();
        $form = $this->createForm(new PartnerType(), $partner);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($partner);
            $em->flush();

            $this->addFlash('success', 'Partner bien enregistré.');

            return $this->redirectToRoute('admin_partner_detail', array('id' => $partner->getId()));
        }

        return $this->render('AdminPartnerBundle:Partner:add.html.twig', array('form' => $form->createView(),));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $partner = $em->getRepository('AppBundle:Partner')->find($id);

        $form = $this->createForm(new \AppBundle\Form\PartnerType(), $partner);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($partner);
            $em->flush();

            $this->addFlash('success', 'Le Partenaire a été modifiée.');
            return $this->redirectToRoute('admin_partner_detail', array('id' => $partner->getId()));
        }
        return $this->render('AdminPartnerBundle:Partner:edit.html.twig', array('form' => $form->createView(), 'id' => $id,));
    }

    public function deleteAction($id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $partner = $em->getRepository('AppBundle:Partner')->find($id);

        if (!$partner) {
            
            $this->addFlash('error', 'Ce Partenaire n\'existe pas.');
            return $this->redirectToRoute('admin_partner_home');
        }

        $em->remove($partner);
        $em->flush();

        $this->addFlash('success', 'Partenaire bien supprimé.');
        return $this->redirectToRoute('admin_partner_home');
    }

}
