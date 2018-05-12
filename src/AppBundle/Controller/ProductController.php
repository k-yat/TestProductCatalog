<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    public const PRODUCT_COUNT_PER_PAGE = 4;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="show_products")
     */
    public function showAllAction(Request $request)
    {
        $productsQuery = $this->entityManager->getRepository(Product::class)->getProductsQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $productsQuery,
            $request->query->getInt('page', 1),
            self::PRODUCT_COUNT_PER_PAGE
        );

        return $this->render('product/show_all.html.twig', [
            'pagination' => $pagination
        ]);
    }
}
