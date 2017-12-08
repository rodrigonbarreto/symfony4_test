<?php

namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();
        
        return $this->render('products/index.html.twig',[
            'products' => $products
        ]);

    }
}
