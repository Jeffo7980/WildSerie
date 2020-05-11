<?php


namespace App\Controller;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index()
    {
        return $this->render('home.html.twig', [
            'home' => 'Bienvenue',
            'website' => 'Wild Séries',
        ]);
    }
}