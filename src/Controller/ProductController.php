<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{productSlug}", name="product_show")
     */
    public function show($productSlug, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['slug' => $productSlug]);

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
