<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{categorySlug}", name="category_show")
     */
    public function show($categorySlug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['slug' => $categorySlug]);
        $products = $category->getProducts();
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'products' => $products
        ]);
    }
}
