<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/api/products', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        $data = $productRepository->findAll();

        $arrayOfProducts = [];
        foreach ($data as $item) {
            $arrayOfProducts[] = $item->toArray();
        }

        return $this->json($arrayOfProducts);
    }


    #[Route('/api/products/product/{id}', name: 'app_product_by_id')]
    public function show(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->json($product->toArray());
    }

    #[Route('/api/products/category/{name}', name: 'app_products_by_category')]
    public function productsByCategory(
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        string $name
    ): Response {
        $category = $categoryRepository->findOneBy(['name' => $name]);

        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        $products = $productRepository->findBy(['category' => $category]);

        $response = [];
        foreach ($products as $product) {
            $response[] = $product->toArray();
        }

        return $this->json($response);
    }

    #[Route('/api/products/search/{searchTerm}', name: 'app_search_products')]
    public function searchProducts(string $searchTerm, ProductRepository $productRepository): Response
    {
        if (!$searchTerm) {
            throw $this->createNotFoundException('Missing search term');
        }

        $products = $productRepository->findBySearchTerm($searchTerm);

        $response = [];
        foreach ($products as $product) {
            $response[] = $product->toArray();
        }

        return $this->json($response);
    }
}
