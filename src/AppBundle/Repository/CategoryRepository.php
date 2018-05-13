<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Category;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOneBySlug($slug): ?Category
    {
        $category = $this->createQueryBuilder('category')
            ->where('category.slug = :slug')
            ->setParameter('slug',$slug)
            ->getQuery()
            ->getOneOrNullResult();
        if (!$category) {
            throw new NotFoundHttpException(sprintf('Unable to find category : "%s".!', $slug));
        }
        return $category;
    }
}
