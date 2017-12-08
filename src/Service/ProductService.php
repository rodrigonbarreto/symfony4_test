<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ProductService
 * @package App\Service
 */
class ProductService
{
    protected $manager;
    /**
     * ExerciseService constructor.
     *
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Product $product
     * @return Product
     */
    public function addProduct(Product $product)
    {
        $product->setCreatedAt(new \DateTime());
        $product->setUpdatedAt(new \DateTime());
        $this->manager->persist($product);
        $this->manager->flush();

        return $product;
    }

    /**
     * @param Product $product
     * @return Product
     */
    public function updateProduct(Product $product)
    {
        $product->setUpdatedAt(new \DateTime());
        $this->manager->flush();

        return $product;
    }
}
