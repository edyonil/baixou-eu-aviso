<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as Mongo;

/**
 * Class Product
 *
 * @package App\Document
 *
 * @Mongo\Document
 */
class Product
{
    /**
     * @var
     * @Mongo\Id
     */
    protected $id;

    /**
     * @var
     * @Mongo\Field(type="string")
     */
    protected $idProduct;

    /**
     * @var
     * @Mongo\Field(type="string")
     */
    protected $title;

    /**
     * @var
     * @Mongo\Field(type="float")
     */
    protected $price;


    /**
     * @var
     * @Mongo\Field(type="string")
     */
    protected $image;

    /**
     * @var
     * @Mongo\Field(type="string")
     */
    protected $user;

    /**
     * @var bool
     * @Mongo\Field(type="boolean")
     */
    protected $notification = true;


    /**
     * @var array
     * @Mongo\EmbedMany(targetDocument="Values")
     */
    private $values = [];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * @param mixed $idProduct
     *
     * @return Product
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     *
     * @return Product
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return bool
     */
    public function getNotification(): bool
    {
        return $this->notification;
    }

    /**
     * @param bool $notification
     *
     * @return Product
     */
    public function setNotification(bool $notification): Product
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param Values $value
     *
     * @return Product
     */
    public function setValues(Values $value): Product
    {
        $this->values[] = $value;

        return $this;
    }


}