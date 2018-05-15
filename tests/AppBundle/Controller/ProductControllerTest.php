<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Product;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\DataFixtures\AppFixtures;

class ProductControllerTest extends WebTestCase
{
    private $client;
    private $container;
    private $doctrine;
    private $entityManager;
    private $repository;
    private $crawler;

    protected function setUp()
    {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->doctrine = $this->container->get('doctrine');
        $this->entityManager = $this->doctrine->getManager();
        $this->crawler = $this->client->request('GET', '/');
        $this->repository = $this->entityManager->getRepository(Product::class);
        //load fixtures
        $loader = new Loader();
        $loader->addFixture(new AppFixtures());
        $purger = new ORMPurger();
        //purge data before load fixtures
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }

    public function testShowAll()
    {
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        //get all products from repository
        $products = $this->repository->findAll();
        $this->assertCount(30, $products);
        $this->assertNotCount(34, $products);

        $link = $this->crawler
            ->filter('a.card-title:contains("Category ")')
            ->eq(0)
            ->link();
        $this->client->click($link);
//        $this->client->followRedirect();
//        $this->assertTrue($this->client->getResponse()->isRedirect());
    }

    public function testGETProductsCollectionPaginated()
    {
        //in '/' url on page 4 projects
        $this->assertEquals(
            4,
            $this->crawler->filter('span:contains("Title")')->count()
        );
        //in the last page have 2 product
        $crawler = $this->client->request('GET', '/?page=8');
        $this->assertEquals(
            2,
            $crawler->filter('span:contains("Title")')->count()
        );
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->client = null;
        $this->container = null;
        $this->doctrine = null;
        $this->entityManager = null;
        $this->crawler = null;
        $this->repository = null;
    }
}
