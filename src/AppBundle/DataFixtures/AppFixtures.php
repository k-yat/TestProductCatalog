<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {

            $category = new Category();
            $category->setName($this->getFaker()->lexify('Category ?????'));
            $category->setProducts($this->generateProductsCollection($manager, $category));
            $manager->persist($category);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param Category $category
     * @return ArrayCollection
     */
    private function generateProductsCollection($manager, Category $category): ArrayCollection
    {
        $arrayCollection = new ArrayCollection();
        for ($i = 0; $i < rand(1, 10); $i++) {
            $product = new Product();
            $product->setTitle($this->getFaker()->streetName);
            $product->setDescription($this->getFaker()->text);
            $product->setCategory($category);
            $manager->persist($product);
            $arrayCollection->add($product);
        }
        return $arrayCollection;
    }

    private function getFaker()
    {
        return Factory::create();
    }
}
