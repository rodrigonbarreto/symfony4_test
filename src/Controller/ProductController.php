<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\ProductService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductController
 * @package App\Controller
 * @Route("product")
 */
class ProductController extends Controller
{
    /**
     * @Route("/", name="product_index")
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

    /**
     * @param Request $request
     * @param ProductService $productService
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request, ProductService $productService)
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();
            $productService->addProduct($product);
            $this->addFlash('success', "uhul Product Created");
            return $this->redirectToRoute('product_index');
        }
        return $this->render('products/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Product $product
     * @param ProductService $productService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Product $product, ProductService $productService)
    {
        $editForm = $this->createForm(ProductType::class, $product);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $productService->updateProduct($product);
            $this->addFlash('success', "uhul Product updated");
            return $this->redirectToRoute('product_index');
        }
        return $this->render('products/edit.html.twig', array(
            'product' => $product,
            'form' => $editForm->createView(),
        ));
    }
}
