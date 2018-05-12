<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query;

class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    public function getProductsQuery(): Query
    {
        return $this->getEntityManager()
            ->createQuery('Select p From AppBundle:Product p');
    }
}
