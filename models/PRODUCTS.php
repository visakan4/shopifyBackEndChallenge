<?php

/**
 * Created by PhpStorm.
 * User: visak
 * Date: 2018-09-21
 * Time: 9:12 PM
 */

namespace tables;

use Phalcon\Mvc\Model;

class PRODUCTS extends Model{

    public $productId;

    public $productName;

    public $productQuantity;

    public $productPrice;

    public $shopId;

    public function initialize(){
        $this->setSource('PRODUCTS');
        $this->belongsTo("shopId",
            "tables\SHOPS",
            "shopId"
        );
        $this->hasMany("productId",
            "tables\LINEITEMS",
            "productId"
        );
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
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @param mixed $productName
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    /**
     * @return mixed
     */
    public function getProductQuantity()
    {
        return $this->productQuantity;
    }

    /**
     * @param mixed $productQuantity
     */
    public function setProductQuantity($productQuantity)
    {
        $this->productQuantity = $productQuantity;
    }

    /**
     * @return mixed
     */
    public function getProductPrice()
    {
        return $this->productPrice;
    }

    /**
     * @param mixed $productPrice
     */
    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;
    }

    /**
     * @return mixed
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @param mixed $shopId
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
    }
}