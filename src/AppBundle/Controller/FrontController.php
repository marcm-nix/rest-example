<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FrontController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        $food = $this->getDoctrine()
            ->getManager()
            ->getRepository("AppBundle:Food")
            ->findAll();

        return $this->render('AppBundle:Front:homepage.html.twig', ['food' => $food]);
    }

}
