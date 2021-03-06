<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Many Products has One Category.
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category", cascade={"persist"})
     */
    private $products;

    /**
     * @Gedmo\Slug(fields={"name"},separator="_")
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     * @return Category
     */
    public function setProducts($products): Category
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @param Product $product
     * @return Category
     */
    public function addProduct(Product $product): Category
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }
        return $this;
    }

    /**
     * @param Product $product
     * @return Category
     */
    public function removeProduct(Product $product): Category
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName() ?: '';
    }
}
