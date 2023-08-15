<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/api/products/categories', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        $categoryNames = [];
        foreach ($categories as $category) {
            $categoryNames[] = $category->getName();
        }

        return $this->json($categoryNames);
    }
    // #[Route('/categories/category/{name}', name: 'app_category_name')]
    // public function getCategoryByName(CategoryRepository $categoryRepository, string $name): Response
    // {
    //     $category = $categoryRepository->findOneBy(['name' => $name]);

    //     if (!$category) {
    //         throw $this->createNotFoundException('Category not found');
    //     }

    //     return $this->json($category);
    // }
}
