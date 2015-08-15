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

            $ErrorMessage = "Une erreur est survenue. Ce partenaires n'existe pas."
                    ."Veuillez contacter votre webmaster.";

            return $this->render('AdminPartnerBundle:Partner:error.html.twig', array('ErrorMessage' => $ErrorMessage,));
            ;
        }

        $name = $partner->getName();
        $websiteLink = $partner->getWebsiteLink();
        $enable = $partner->getEnable();
        $sort = $partner->getSort();

        return $this->render('AdminPartnerBundle:Partner:detail.html.twig', array('name' => $name, 'id' => $id, 'websiteLink' => $websiteLink,
                    'enable' => $enable, 'sort' => $sort));
    }

    public function addAction(Request $request)
    {
        $partner = new Partner();
        $partner->setSort(1);
        $form = $this->createFormBuilder($partner)
                ->add('name', 'text')
                ->add('websiteLink', 'text')
                ->add('enable', 'checkbox')
                ->add('save', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($partner);
            $em->flush();

            $SuccessMessage = 'Le Partenaire a été ajouté correctement.';

            $request->getSession()->getFlashBag()->add('success', 'Partneaire bien enregistré.');
            return $this->render('AdminPartnerBundle:Partner:task_success.html.twig', array('SuccessMessage' => $SuccessMessage));
        }
        $id = $partner->getId();
        $partner->setSort($id);
        return $this->render('AdminPartnerBundle:Partner:add.html.twig', array('form' => $form->createView(),));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $partner = $em->getRepository('AppBundle:Partner')->find($id);

        $name = $partner->getName();
        $websiteLink = $partner->getWebsiteLink();
        $enable = $partner->getEnable();
        $sort = $partner->getSort();

        $partner->setName($name);
        $partner->setWebsiteLink($websiteLink);
        $partner->setEnable($enable);
        $partner->setSort($sort);

        $form = $this->createFormBuilder($partner)
                ->add('name', 'text')
                ->add('websiteLink', 'text')
                ->add('enable', 'checkbox')
                ->add('sort', 'integer')
                ->add('save', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($partner);
            $em->flush();

            $SuccessMessage = 'Partenaire modifié avec succès.';

            $request->getSession()->getFlashBag()->add('success', 'Le Partenaire a été correctement modifié.');
            return $this->render('AdminPartnerBundle:Partner:task_success.html.twig', array('SuccessMessage' => $SuccessMessage));
        }
        return $this->render('AdminPartnerBundle:Partner:edit.html.twig', array('form' => $form->createView(), 'id' => $id,));
    }

    public function deleteAction($id)
    {
        $em = $this
                ->getDoctrine()
                ->getManager();
        $partner = $em->getRepository('AppBundle:Partner')->find($id);

        $name = $partner->getName();
        $websiteLink = $partner->getWebsiteLink();

        if (!$partner) {
            $ErrorMessage = "Une erreur est survenue. Ce Partner n'existe pas. Veuillez contacter votre webmaster.";

            return $this->render('AdminPartnerBundle:Partner:error.html.twig', array('ErrorMessage' => $ErrorMessage,));
        }

        $em->remove($partner);
        $em->flush();

        $SuccessMessage = "Le Partner a été correctement effacé.";
        return $this->render('AdminPartnerBundle:Partner:task_success.html.twig', array('SuccessMessage' => $SuccessMessage,));

        return $this->render('AdminPartnerBundle:Partner:delete.html.twig', array(
                    'id' => $id, 'name' => $name, 'websiteLink' => $websiteLin,));
    }

}
