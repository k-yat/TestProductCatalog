<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @Route("/{category_name}", name="show_category")
     * @ParamConverter("category", class="AppBundle\Entity\Category", options={"mapping": {"category_name": "slug"}})
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, Category $category)
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        $products = $this->entityManager->getRepository(Product::class)
            ->findBy(['category' => $category]);

        if (is_null($category)) {
            throw new NotFoundHttpException('The category does not exist');
        }
        return $this->render('category/show.html.twig', [
            'current_category' => $category,
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
