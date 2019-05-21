<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function show(Category $category)
    {
        return $this->render('category/show.html.twig', [
        	'category' => $category,
        ]);
    }

    public function headerCategories(CategoryRepository $categoryRepository)
    {
        return $this->render('category/header.html.twig', [
            'categories'=>$categoryRepository->findBy([], ['name'=>'ASC']),
        ]);
    }

}
