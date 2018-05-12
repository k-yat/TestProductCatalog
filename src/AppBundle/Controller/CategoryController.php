<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/{category_name}", name="show_category")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllAction(Request $request)
    {
        // Name restoration
        $categoryName = ucfirst(str_replace('_', ' ', $request->get('category_name')));
        $currentCategory = $this->entityManager->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        $products = $this->entityManager->getRepository(Product::class)
            ->findBy(['category' => $currentCategory]);

        return $this->render('category/show.html.twig', [
            'current_category' => $currentCategory,
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
