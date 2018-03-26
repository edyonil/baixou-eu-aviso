<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 25/03/2018
 * Time: 21:01
 */

namespace App\Service;


use App\Document\Values;
use App\Repository\ProductMercadoLivreRepository;
use PHPHtmlParser\Dom;

class ProductMercadoLivreObservable
{
    protected $dom;
    /**
     * @var ProductMercadoLivreRepository
     */
    private $repository;

    public function __construct(ProductMercadoLivreRepository $repository)
    {

        $this->repository = $repository;
        $this->dom = new Dom();
    }

    public function verify()
    {
        $products = $this->repository->all();

        $totalNotification = 0;

        foreach ($products as $product) {

            $dom = $this->dom->loadFromUrl($product->getIdProduct());

            $price = (float)$this->handlerPrice($dom);

            if ($price < $product->getPrice()) {

                //@ToDo Implementar Notificação por email
                $totalNotification++;
            }

            $values = new Values();
            $values->setValue($price)
                ->setDayVerify(new \Datetime());

            $product->setValues($values);

            $this->repository->create($product);

        }

        return [
            'totalProducts'     => count($products),
            'totalNotification' => $totalNotification
        ];

    }

    protected function handlerPrice($dom)
    {

        $priceFactional = $dom->find('.price-tag-fraction', 0)->text;
        $priceDecimal = $dom->find('.price-tag-cents', 0);

        if ($priceDecimal == null || $priceDecimal->text == '') {
            $priceDecimal = 0;
        } else {
            $priceDecimal = $priceDecimal->text;
        }

        return str_replace(".", "", $priceFactional) . "." . $priceDecimal;
    }

}