<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    
    /**
     * @Route("/nos-produits", name="products")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
}
