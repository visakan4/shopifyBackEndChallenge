<?php

/**
 * Created by PhpStorm.
 * User: visak
 * Date: 2018-09-21
 * Time: 9:13 PM
 */

namespace tables;

use Phalcon\Mvc\Model;

class ORDERS extends Model
{
    public $orderId;

    public $orderAmount;

    public $OrderStatus;

    public $shopId;

    public function initialize(){
        $this->setSource('ORDERS');
        $this->belongsTo("shopId",
            "tables\SHOPS",
            "shopId"
        );
        $this->hasMany("orderId",
            "tables\LINEITEMS",
            "orderId"
        );
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

    /**
     * @return mixed
     */
    public function getOrderAmount()
    {
        return $this->orderAmount;
    }

    /**
     * @param mixed $orderAmount
     */
    public function setOrderAmount($orderAmount)
    {
        $this->orderAmount = $orderAmount;
    }

    /**
     * @return mixed
     */
    public function getOrderStatus()
    {
        return $this->OrderStatus;
    }

    /**
     * @param mixed $OrderStatus
     */
    public function setOrderStatus($OrderStatus)
    {
        $this->OrderStatus = $OrderStatus;
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