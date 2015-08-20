<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function homepageAction(Request $request)
    {
        $dailyMenus = $this->getDoctrine()->getRepository('AppBundle:DailyMenu')->findAll();

        return $this->render('default/homepage.html.twig', array(
                    'daily_menus' => $dailyMenus,
        ));
    }

    public function newspageAction(Request $request)
    {
        $news = $this->getDoctrine()->getRepository('AppBundle:News')->findAll();

        return $this->render('default/newspage.html.twig', array(
                    'news' => $news,
        ));
    }

    public function carteAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findBy(
        array('enable'=> 1),
        array('sort' => 'ASC')
        );

        return $this->render('default/carte.html.twig', array(
                    'categories' => $categories,
        ));
    }

    public function infosPratiquesAction(Request $request)
    {
        return $this->render('default/infos-pratiques.html.twig');
    }

    public function partenairesAction(Request $request)
    {
        $partner = $this->getDoctrine()->getRepository('AppBundle:Partner')->findAll();

        return $this->render('default/partenaires.html.twig', array(
                    'partners' => $partner,
        ));
    }

    public function trattoriaAction(Request $request)
    {
        return $this->render('default/trattoria.html.twig');
    }

    public function nousTrouverAction(Request $request)
    {
        return $this->render('default/nous-trouver.html.twig');
    }

    public function nousContacterAction(Request $request)
    {
        return $this->render('default/nous-contacter.html.twig');
    }

}
