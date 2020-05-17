<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Class WildController extends AbstractController
{
    /**
     * @Route("/wild", name="wild_index")
     */
    public function index() : Response
    {
        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }
    /**
     * @Route("/wild/show/{slug<[a-z0-9.-]*>}", name="wild_show_slug")
     */
    public function show(string $slug) :Response
    {
        if(!empty($slug)){
            $maSerie = str_replace('-', ' ', $slug);
            $maSerie = ucwords($maSerie);
        }else{
            $maSerie = 'Aucune série sélectionnée !';
        }

        return $this->render('wild/show.html.twig', [
            'maSerie' => $maSerie,
        ]);
    }
}