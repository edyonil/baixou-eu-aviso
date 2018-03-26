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

    public function __construct(ProductMercadoLivreRepository $repository, \Swift_Mailer $mailer, \Twig_Environment $templating)
    {

        $this->repository = $repository;
        $this->dom = new Dom();
		$this->mailer = $mailer;
		$this->templating = $templating;
    }

    public function verify()
    {
        $products = $this->repository->all();

        $totalNotification = 0;

        foreach ($products as $product) {

            $dom = $this->dom->loadFromUrl($product->getIdProduct());

            $price = (float)$this->handlerPrice($dom);

            if ($price < $product->getPrice()) {

				$this->notification($product->getUser(), $product->getTitle());
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

	protected function notification($email, $product)
	{
		$message = (new \Swift_Message('Notification product'))
        ->setFrom($email)
        ->setTo($email)
        ->setBody(
            $this->templating->render(
                'email.html.twig',
                array('name' => $product)
            ),
            'text/html'
        );

		$this->mailer->send($message);

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
