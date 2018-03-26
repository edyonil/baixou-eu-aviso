<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 24/03/2018
 * Time: 12:16
 */

namespace App\Service;


use App\Document\Product;
use App\Repository\ProductMercadoLivreRepository;
use PHPHtmlParser\Dom;

class ProductMercadoLivre
{
    /**
     * @var Dom
     */
    private $dom;
    /**
     * @var ProductMercadoLivreRepository
     */
    private $repository;

    public function __construct(ProductMercadoLivreRepository $repository)
    {

        $this->dom = new Dom();
        $this->repository = $repository;
    }


    public function register(array $input)
    {
        $dom = $this->dom->loadFromUrl($input['link']);

        $title = $dom->find('.item-title__primary')[0]->text;
        $priceFactional = $dom->find('.price-tag-fraction', 0)->text;
        $priceDecimal = $dom->find('.price-tag-cents', 0);

        if ($priceDecimal == null || $priceDecimal->text == '') {
            $priceDecimal = 0;
        } else {
            $priceDecimal = $priceDecimal->text;
        }

        $price = str_replace(".", "", $priceFactional) .".". $priceDecimal;

        $image = $dom->find('.gallery-image-container')[0];
        $image = $image->find('img', 0);

        $image = $image->src;

        $product = new Product();
        $product->setIdProduct($input['link'])
            ->setUser($input['email'])
            ->setImage($image)
            ->setTitle($title)
            ->setPrice((float)$price);

        $product = $this->repository->create($product);

        return $product;
    }
}