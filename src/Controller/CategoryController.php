<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @param Request $request
     * @Route("/category/add", name="add_category")
     * @return Response
     */
    public function add(Request $request)
    {
        $test = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        if (!$test) {
            throw $this->createNotFoundException(
                'Niet.'
            );
        }

            $category = new Category();
            $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);


        if ($form->isSubmitted()) {
            $data = $this->getDoctrine()->getManager();
            $data->persist($category);
            $data->flush();

        }

            return $this->render('category/index.html.twig', [
                'category' => $category,
                'test' => $test,
                'form' => $form->createView()
            ]);
    }
}

