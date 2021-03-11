<?php


namespace AppBundle\Event;


use AppBundle\Entity\Product;
use Symfony\Component\EventDispatcher\Event;

class ProductPublishedEvent extends Event
{

    const NAME = "product.published";

    /**
     * @var Product $_product
     */
    private $_product;

    public function __construct(Product $product)
    {
        $this->_product = $product;
    }

    public function getProduct(){

        return $this->_product;
    }

}