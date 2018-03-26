<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 25/03/2018
 * Time: 21:25
 */

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as Mongo;

/**
 * Class Values
 *
 * @package App\Document
 *
 * @Mongo\EmbeddedDocument
 * @Mongo\HasLifecycleCallbacks
 */
class Values
{
    /**
     * @var
     * @Mongo\Field(type="float")
     */
    protected $value;

    /**
     * @var
     * @Mongo\Field(type="date")
     */
    protected $dayVerify;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return Values
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDayVerify()
    {
        return $this->dayVerify;
    }

    /**
     * @param mixed $dayVerify
     *
     * @return Values
     */
    public function setDayVerify(\Datetime $datetime)
    {
        $this->dayVerify = $datetime;

        return $this;
    }



}