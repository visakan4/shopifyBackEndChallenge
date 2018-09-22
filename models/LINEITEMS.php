<?php

/**
 * Created by PhpStorm.
 * User: visak
 * Date: 2018-09-21
 * Time: 9:13 PM
 */

namespace tables;

use Phalcon\Mvc\Model;

class LINEITEMS extends Model{

    public $lineItemId;

    public $productId;

    public $lineItemPrice;

    public $lineItemQuantity;

    public $orderId;

    public function initialize(){
        $this->setSource('LINEITEMS');
        $this->belongsTo("productId",
            "tables\PRODUCTS",
            "productId");
        $this->belongsTo("orderId",
            "tables\ORDERS",
            "orderId");
    }

    /**
     * @return mixed
     */
    public function getLineItemId()
    {
        return $this->lineItemId;
    }

    /**
     * @param mixed $lineItemId
     */
    public function setLineItemId($lineItemId)
    {
        $this->lineItemId = $lineItemId;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param mixed $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getLineItemPrice()
    {
        return $this->lineItemPrice;
    }

    /**
     * @param mixed $lineItemPrice
     */
    public function setLineItemPrice($lineItemPrice)
    {
        $this->lineItemPrice = $lineItemPrice;
    }

    /**
     * @return mixed
     */
    public function getLineItemQuantity()
    {
        return $this->lineItemQuantity;
    }

    /**
     * @param mixed $lineItemQuantity
     */
    public function setLineItemQuantity($lineItemQuantity)
    {
        $this->lineItemQuantity = $lineItemQuantity;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

}