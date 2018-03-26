<?php

declare(strict_types=1);

namespace App\Repository;


use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * Class ProductMercadoLivreRepository
 *
 * @package App\Repository
 */
class ProductMercadoLivreRepository
{
    /**
     * @var DocumentManager
     */
    private $dm;


    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function create(Product $product) : Product
    {
        $this->dm->persist($product);
        $this->dm->flush();

        return $product;
    }

    public function all()
    {
        $repository = $this->dm->getRepository(Product::class);

        $products = $repository->findBy(['notification' => true]);

        if (is_null($products)) {
            return [];
        }

        return $products;
    }
}