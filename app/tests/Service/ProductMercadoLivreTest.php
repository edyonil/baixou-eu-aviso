<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 24/03/2018
 * Time: 13:42
 */

namespace App\Tests;

use App\Document\Product;
use App\Repository\ProductMercadoLivreRepository;
use App\Service\ProductMercadoLivre;
use PHPHtmlParser\Dom;
use PHPUnit\Framework\TestCase;

class ProductMercadoLivreTest extends TestCase
{

    public function testCreate()
    {

        $link = "https://produto.mercadolivre.com.br/MLB-927660792-apple-iphone-8-64gb-lacrado-garantia-1-ano-nota-fiscal-_JM#c_id=/home/category/deal-items/element";

        $service = new ProductMercadoLivre(new Dom(), $this->mockRepository()->reveal());

        $product = $service->register($link);

        $this->assertInstanceOf(Product::class, $product);


    }

    protected function mockRepository()
    {
        return $this->prophesize(ProductMercadoLivreRepository::class);
    }
}
