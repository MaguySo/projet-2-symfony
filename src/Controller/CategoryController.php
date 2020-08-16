<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="categories_index")
     */
    public function index(CategoryRepository $repo)
    {
        $categories = $repo->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * Permet d'afficher chaque catégorie ainsi que leurs fruits
     * 
     * @Route("/categories/{id}", name="categories_show")
     * 
     * @return Response
     */
    public function show($id, CategoryRepository $repo)
    {
        $category = $repo->findOneById($id);
        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }
}
