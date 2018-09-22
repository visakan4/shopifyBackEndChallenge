<?php

/**
 * Created by PhpStorm.
 * User: visak
 * Date: 2018-09-21
 * Time: 9:10 PM
 */

namespace tables;

use Phalcon\Mvc\Model;

class SHOPS extends Model{

    public $shopId;

    public $shopName;

    public function initialize(){
        $this->setSource('SHOPS');
        $this->hasMany("shopId",
            "tables\PRODUCTS",
            "shopId"
        );
        $this->hasMany("shopId",
            "tables\ORDERS",
            "shopId"
        );
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

    /**
     * @return mixed
     */
    public function getShopName()
    {
        return $this->shopName;
    }

    /**
     * @param mixed $shopName
     */
    public function setShopName($shopName)
    {
        $this->shopName = $shopName;
    }
}