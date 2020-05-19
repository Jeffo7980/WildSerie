<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/wild", name="wild_")
 */
Class WildController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index() : Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();
        if (!$programs){
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }
        return $this->render('wild/index.html.twig', [
            'programs' => $programs]
        );
    }

    /**
     ** @param string $categoryName the Category name
     * @Route("/category/{categoryName<^[a-z0-9-]+$>?}", name="category")
     * @return Response
     */
    public function showByCategory(string $categoryName):Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['Category' => $category], ['id' => 'DESC'], 3,0);
        return $this->render('wild/category.html.twig', [
                'category' => $categoryName,
                'programs' => $program,
            ]
        );
    }

    /**
     * @param string $slug
     * @Route("/show/{slug}", defaults={"slug" = null}, name="program_slug")
     * @return Response
     */
    public function showByProgram(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(['program' => $program]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' . $slug . ' title, found in program\'s table.'
            );
        }
        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
            'seasons' => $seasons,
        ]);
    }

    /**
     * @param integer $seasonId
     * @Route ("/show/season/{seasonId}", name="season")
     * @return Response A Response instance
     */
    public function showBySeason(int $seasonId)
    {
        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findBy(['season' => $seasonId]);
        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $seasonId]);
        return $this->render('wild/season.html.twig', [
            'episodes' => $episodes,
            'seasons' => $seasons,
        ]);
    }

    /**
     * @Route("/episode/{id}", name="episode")
     * @param Episode $episode
     * @return Response
     */
    public function showEpisode(Episode $episode): Response
    {
        $season = $episode->getSeason();
        $program = $season->getProgram();
        return $this->render('wild/episode.html.twig', [
            'episode' => $episode,
            'season' => $season,
            'program' => $program,
        ]);
    }
}