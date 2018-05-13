<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package AppBundle\Controller
 */
class CategoryController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CategoryController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/{slug}", name="show_category")
     *
     * @param Request $request
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, string $slug)
    {
        $repository = $this->entityManager->getRepository(Category::class);
        $currentCategory = $repository->getOneBySlug($slug);
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
