<?php

use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        "tables" => __DIR__."/models/"
    ]
);

$loader->register();

$di = new FactoryDefault();

$di->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host'     => 'visakandatabase.mysql.database.azure.com',
                'username' => 'visakanadmin@visakandatabase',
                'password' => 'P@ssword@123',
                'dbname'   => 'shopify',
            ]
        );
    }
);

//$di->set(
//    'db',
//    function () {
//        return new PdoMysql(
//            [
//                'host'     => 'db.cs.dal.ca',
//                'username' => 'jeyakumar',
//                'password' => 'B00784080',
//                'dbname'   => 'jeyakumar',
//            ]
//        );
//    }
//);

$app = new Micro($di);

$app->get(
    "/test/{name}",
    function ($name) use ($app)
    {

        $response = new Response();
        $response->setJsonContent(
            [
                "status" => "SUCCESS",
                "data" => $name
            ]
        );
        return $response;
    }
);


$app->post(
    "/setShop",
    function () use ($app){
        try{
            $shop = $app -> request -> getJsonRawBody();

            $phql ='INSERT INTO tables\SHOPS (shopName) values (:shopName:)';

            $status =$app->modelsManager->executeQuery(
                $phql,[
                    "shopName" => $shop -> shop_name
                ]
            );

            $response = new Response();

            if ($status->success() === True){
                $model = $status ->getModel();
                $response->setStatusCode(201,"CREATED");
                $response->setJsonContent(
                    [
                        "status" => "SUCCESS",
                        "data" => array(["shopStatus" => "SHOP_ADDED",
                            "shopId" => $model->shopId])
                    ]
                );
            }
            else{
                $response->setStatusCode(409,"FAILURE");

                $errors = [];

                foreach ($status->getMessages() as $message) {
                    $errors[] = $message->getMessage();
                }

                $response->setJsonContent(
                    [
                        "status" => "SUCCESS",
                        "data" => array(["shopStatus" => "SHOP_NOT_ADDED"]),
                        "errors" => $errors
                    ]
                );
            }
            return $response;
        }catch (Exception $e){
            $response = new Response();
            $response->setStatusCode(409,"CONFLICT");
            $response->setJsonContent(
                [
                    "status" => "FAILURE",
                    "data" => array(["shopStatus" => "SHOP_NOT_ADDED"]),
                    "errors" => $e->getMessage()
                ]
            );
            return $response;
        }
    }
);


$app->delete(
    "/deleteShop",
    function () use ($app){
        try{
            $shop = $app -> request -> getJsonRawBody();

            $phql = 'SELECT * FROM tables\SHOPS where shopId = (:shop_id:)';

            $checkShop =$app->modelsManager->executeQuery(
                $phql,[
                    "shop_id" => $shop -> shop_id
                ]
            );

            $response = new Response();

            if (count($checkShop) != 0){

                $phql ='DELETE FROM tables\SHOPS where shopId = (:shop_id:)';

                $status =$app->modelsManager->executeQuery(
                    $phql,[
                        "shop_id" => $shop -> shop_id
                    ]
                );


                if ($status->success() === True){
                    $response->setStatusCode(200,"OK");
                    $response->setJsonContent(
                        [
                            "status" => "SUCCESS",
                            "data" => array(["shopStatus" => "SHOP_DELETED"])
                        ]
                    );
                }
                else{
                    $response->setStatusCode(404,"NOT FOUND");

                    $errors = [];

                    foreach ($status->getMessages() as $message) {
                        $errors[] = $message->getMessage();
                    }

                    $response->setJsonContent(
                        [
                            "status" => "SUCCESS",
                            "data" => array(["shopStatus" => "SHOP_NOT_DELETED"]),
                            "errors" => $errors
                        ]
                    );
                }
                return $response;
            }
            else{
                $response->setStatusCode(409,"CONFLICT");
                $response->setJsonContent(
                    [
                        "status" => "SUCCESS",
                        "data" => array(["shopStatus" => "SHOP_ID_NOT_FOUND"]),
                    ]
                );
                return $response;
            }
        }catch (Exception $e){
            $response = new Response();
            $response->setStatusCode(409,"CONFLICT");
            $response->setJsonContent(
                [
                    "status" => "FAILURE",
                    "data" => array(["shopStatus" => "SHOP_NOT_DELETED"]),
                    "errors" => $e->getMessage()
                ]
            );
            return $response;
        }
    }
);


$app->post(
    "/updateShop",
    function () use ($app){
        try{
            $shop = $app -> request -> getJsonRawBody();

            $phql = 'SELECT * FROM tables\SHOPS where shopId = (:shop_id:)';

            $checkShop =$app->modelsManager->executeQuery(
                $phql,[
                    "shop_id" => $shop -> shop_id
                ]
            );

            $response = new Response();

            if (count($checkShop) != 0){
                $phql ='UPDATE tables\SHOPS SET shopName = :shopName: WHERE shopId = :shopId:';

                $status =$app->modelsManager->executeQuery(
                    $phql,[
                        "shopName" => $shop -> shop_name,
                        "shopId" => $shop -> shop_id
                    ]
                );

                if ($status->success() === True){
                    $response->setStatusCode(201,"CREATED");
                    $response->setJsonContent(
                        [
                            "status" => "SUCCESS",
                            "data" => array(["shopStatus" => "SHOP_UPDATED"])
                        ]
                    );
                }
                else{
                    $response->setStatusCode(409,"FAILURE");

                    $errors = [];

                    foreach ($status->getMessages() as $message) {
                        $errors[] = $message->getMessage();
                    }

                    $response->setJsonContent(
                        [
                            "status" => "SUCCESS",
                            "data" => array(["shopStatus" => "SHOP_NOT_UPDATED"]),
                            "errors" => $errors
                        ]
                    );
                }
                return $response;
            }else{
                $response->setStatusCode(409,"CONFLICT");
                $response->setJsonContent(
                    [
                        "status" => "SUCCESS",
                        "data" => array(["shopStatus" => "SHOP_ID_NOT_FOUND"]),
                    ]
                );
                return $response;
            }
        }catch (Exception $e){
            $response = new Response();
            $response->setStatusCode(409,"CONFLICT");
            $response->setJsonContent(
                [
                    "status" => "FAILURE",
                    "data" => array(["shopStatus" => "SHOP_NOT_UPDATED"]),
                    "errors" => $e->getMessage()
                ]
            );
            return $response;
        }
    }
);


$app->get(
    "/getShops",
    function () use ($app){
        try{
            $phql = 'SELECT * FROM tables\SHOPS';

            $shops = $app->modelsManager->executeQuery($phql);

            $shopsList = [];

            foreach ($shops as $shop){
                $shopsList[] = [
                    "shop_id" => $shop -> shopId,
                    "shop_name" => $shop -> shopName
                ];
            }

            $response = new Response();
            $response->setStatusCode(201,"RETRIEVED");
            $response->setJsonContent(
                [
                    "status" => "SUCCESS",
                    "data" => $shopsList,
                ]
            );

            return $response;
        }catch (Exception $e){
            $response = new Response();
            $response->setJsonContent(
                [
                    "status" => "FAILURE",
                    "data" => [],
                    "errors" => $e->getMessage()
                ]
            );
            return $response;
        }
    }
);


$app->post(
    "/setProduct",
    function () use ($app){
        try{
            $product = $app -> request -> getJsonRawBody();

            $phql ='INSERT INTO tables\PRODUCTS (productName, productQuantity, productPrice, shopId) VALUES (:productName:,:productQuantity:, :productPrice:, :shopId:)';

            $status =$app->modelsManager->executeQuery(
                $phql,[
                    "productName" => $product -> product_name,
                    "productQuantity" => $product -> product_quantity,
                    "productPrice" => $product -> product_price,
                    "shopId" => $product -> shop_id
                ]
            );

            $response = new Response();

            if ($status->success() === True){
                $model = $status ->getModel();
                $response->setStatusCode(201,"CREATED");
                $response->setJsonContent(
                    [
                        "status" => "SUCCESS",
                        "data" => array(["productStatus" => "PRODUCT_ADDED",
                            "productId" => $model->productId])
                    ]
                );
            }
            else{
                $response->setStatusCode(409,"FAILURE");

                $errors = [];

                foreach ($status->getMessages() as $message) {
                    $errors[] = $message->getMessage();
                }

                $response->setJsonContent(
                    [
                        "status" => "SUCCESS",
                        "data" => array(["productStatus" => "PRODUCT_NOT_ADDED"]),
                        "errors" => $errors
                    ]
                );
            }
            return $response;
        }catch (PDOException $e){
            $response = new Response();
            $response->setJsonContent(
                [
                    "status" => "FAILURE",
                    "data" => array(["productStatus" => "PRODUCT_NOT_ADDED"]),
                    "errors" => $e->getMessage()
                ]
            );
            return $response;
        }
    }
);


$app->delete(
    "/deleteProduct",
    function () use ($app){
        try{
            $product = $app -> request -> getJsonRawBody();

            $phql = 'SELECT * FROM tables\PRODUCTS where productId = (:product_id:)';

            $checkProduct = $app->modelsManager->executeQuery(
                $phql,[
                    "product_id" => $product -> product_id
                ]
            );

            $response = new Response();

            if (count($checkProduct) != 0){
                $phql ='DELETE FROM tables\PRODUCTS where productId = :product_id:';

                $status =$app->modelsManager->executeQuery(
                    $phql,[
                        "product_id" => $product -> product_id
                    ]
                );

                if ($status->success() === True){
                    $response->setStatusCode(200,"OK");
                    $response->setJsonContent(
                        [
                            "status" => "SUCCESS",
                            "data" => array(["productStatus" => "PRODUCT_DELETED"])
                        ]
                    );
                }
                else{
                    $response->setStatusCode(404,"NOT FOUND");

                    $errors = [];

                    foreach ($status->getMessages() as $message) {
                        $errors[] = $message->getMessage();
                    }

                    $response->setJsonContent(
                        [
                            "status" => "SUCCESS",
                            "data" => array(["productStatus" => "PRODUCT_NOT_DELETED"]),
                            "errors" => $errors
                        ]
                    );
                }
                return $response;
            }else{
                $response->setStatusCode(409,"CONFLICT");
                $response->setJsonContent(
                    [
                        "status" => "SUCCESS",
                        "data" => array(["productStatus" => "PRODUCT_ID_NOT_FOUND"]),
                    ]
                );
                return $response;
            }
        }catch (PDOException $e){
            $response = new Response();
            $response->setJsonContent(
                [
                    "status" => "FAILURE",
                    "data" => array(["productStatus" => "PRODUCT_NOT_DELETED"]),
                    "errors" => $e->getMessage()
                ]
            );
            return $response;
        }
    }
);


$app->post(
    "/getProductsByshopId",
    function () use ($app){
        try{
            $product = $app -> request -> getJsonRawBody();

            $phql = 'SELECT * FROM tables\PRODUCTS where shopId = :shopId:';

            $products = $app->modelsManager->executeQuery($phql,[
                "shopId" => $product -> shop_id
            ]);

            $productList = [];

            foreach ($products as $product){
                $productList[] = [
                    "product_id" => $product -> productId,
                    "product_name" => $product -> productName,
                    "product_quantity" => $product -> productQuantity,
                    "product_price" => $product -> productPrice,
                    "shop_id" => $product -> shop_id
                ];
            }

            $response = new Response();
            $response->setStatusCode(201,"RETRIEVED");
            $response->setJsonContent(
                [
                    "status" => "SUCCESS",
                    "data" => $productList
                ]
            );

            return $response;
        }catch (PDOException $e){
            $response = new Response();
            $response->setStatusCode(409,"CONFLICT");
            $response->setJsonContent(
                [
                    "status" => "FAILURE",
                    "data" => array(["productStatus" => "PRODUCTS_NOT_FOUND"]),
                    "errors" => $e->getMessage()."Line Number: ".$e->getLine()
                ]
            );
            return $response;
        }
    }
);


$app->post(
    "/updateProduct",
    function () use ($app){
        try{
            $product = $app -> request -> getJsonRawBody();

            $phql = 'SELECT * FROM tables\PRODUCTS where productId = (:product_id:)';

            $checkProduct = $app->modelsManager->executeQuery(
                $phql,[
                    "product_id" => $product -> product_id
                ]
            );

            $response = new Response();

            if (count($checkProduct) != 0){
                $phql ='UPDATE tables\PRODUCTS SET productName = :productName:, shopId = :shopId:, productQuantity = :productQuantity:, productPrice = :productPrice: WHERE productId = :productId:';

                $status =$app->modelsManager->executeQuery(
                    $phql,[
                        "productName" => $product -> product_name,
                        "productQuantity" => $product -> product_quantity,
                        "productPrice" => $product -> product_price,
                        "productId" => $product -> product_id,
                        "shopId" => $product -> shop_id
                    ]
                );


                if ($status->success() === True){
                    $response->setStatusCode(201,"CREATED");
                    $response->setJsonContent(
                        [
                            "status" => "SUCCESS",
                            "data" => array(["productStatus" => "PRODUCT_UPDATED"])
                        ]
                    );
                }
                else{
                    $response->setStatusCode(409,"FAILURE");

                    $errors = [];

                    foreach ($status->getMessages() as $message) {
                        $errors[] = $message->getMessage();
                    }

                    $response->setJsonContent(
                        [
                            "status" => "SUCCESS",
                            "data" => array(["productStatus" => "PRODUCT_NOT_UPDATED"]),
                            "errors" => $errors
                        ]
                    );
                }
                return $response;
            }
            else{
                $response->setStatusCode(409,"CONFLICT");
                $response->setJsonContent(
                    [
                        "status" => "SUCCESS",
                        "data" => array(["productStatus" => "PRODUCTS_ID_NOT_FOUND"]),
                    ]
                );
                return $response;
            }
        }catch (Exception $e){
            $response = new Response();
            $response->setStatusCode(409,"CONFLICT");
            $response->setJsonContent(
                [
                    "status" => "FAILURE",
                    "data" => array(["productStatus" => "PRODUCTS_NOT_UPDATED"]),
                    "errors" => $e->getMessage()." Line Number: ".$e->getLine()
                ]
            );
            return $response;
        }
    }
);


$app->post("/setOrder",
    function () use ($app) {
        try{
            $order = $app->request->getJsonRawBody();

            settype($order_sum, "integer");

            $productPriceCheck = true;
            foreach ($order->product_details as $product) {

                $phql = 'SELECT productPrice FROM tables\PRODUCTS where productId = :productId:';

                $productPrice = $app->modelsManager->executeQuery(
                    $phql,
                    [
                        "productId" => $product->product_id,
                    ]
                );

                $inputPrice = ($product->lineItem_price / $product->lineItem_quantity);

                if ($inputPrice != $productPrice[0]->productPrice) {
                    $productPriceCheck = false;
                    break;
                }

                $order_sum += $product->lineItem_price;
            }

            if ($order_sum === $order->order_amount && $productPriceCheck === true) {

                $phql = 'INSERT INTO tables\ORDERS(orderAmount,OrderStatus,shopId, order_date) values(:orderAmount:,:OrderStatus:,:shopId:,CURRENT_TIMESTAMP())';

                $status = $app->modelsManager->executeQuery(
                    $phql,
                    [
                        "orderAmount" => $order->order_amount,
                        "OrderStatus" => $order->order_status,
                        "shopId" => $order->shop_id
                    ]
                );

                $response = new Response();

                if ($status->success() === True) {

                    $model = $status->getModel();
                    foreach ($order->product_details as $product) {

                        $phql = 'INSERT INTO  tables\LINEITEMS (orderId,productId,lineItemPrice,lineItemQuantity) values(:orderId:,:productId:,:lineItemPrice:,:lineItemQuantity:)';

                        $order = $app->modelsManager->executeQuery(
                            $phql,
                            [
                                "productId" => $product->product_id,
                                "lineItemPrice" => $product->lineItem_price,
                                "lineItemQuantity" => $product->lineItem_quantity,
                                "orderId" => $model->orderid
                            ]
                        );

                        if ($order->success() === True) {

                            $phql = "UPDATE tables\PRODUCTS 
                                    SET productQuantity = productQuantity - '$product->lineItem_quantity'
                                    WHERE productId = :productId: AND  
                                    productQuantity > 0";

                            $reduce_order = $app->modelsManager->executeQuery(
                                $phql,
                                [
                                    "productId" => $product->product_id,
                                ]
                            );

                            if ($reduce_order->success() === False) {
                                $response->setStatusCode(409, "CONFLICT");
                                $response->setJsonContent(
                                    [
                                        "status" => "FAILURE",
                                        "data" => array(["orderStatus" => "ORDER_NOT_PLACED"]),
                                    ]
                                );
                                return $response;
                                break;
                            }
                        }
                        else {
                            $response = new Response();
                            $response->setStatusCode(409, "CONFLICT");
                            $response->setJsonContent(
                                [
                                    "status" => "FAILURE",
                                    "data" => array(["orderStatus" => "ORDER_NOT_PLACED"]),
                                ]
                            );
                            return $response;
                            break;
                        }
                    }
                }else {
                    $response = new Response();
                    $response->setStatusCode(409, "CONFLICT");
                    $response->setJsonContent(
                        [
                            "status" => "FAILURE",
                            "data" => array(["orderStatus" => "ORDER_NOT_PLACED"]),
                        ]
                    );
                    return $response;
                }
                $response->setStatusCode(201,"CREATED");
                $response->setJsonContent(
                    [
                        "status" => "SUCCESS",
                        "data" => array(["orderStatus" => "ORDER_PLACED",
                            "orderID" => $model ->orderid])
                    ]
                );
                return $response;
            }else {
                $response = new Response();
                $response->setStatusCode(409, "CONFLICT");
                $response->setJsonContent(
                    [
                        "status" => "FAILURE",
                        "data" => array(["orderStatus" => "ORDER_DETAILS_NOT_MATCHING"]),
                    ]
                );
                return $response;
            }
        }catch (Exception $e){
            $response = new Response();
            $response->setStatusCode(409,"CONFLICT");
            $response->setJsonContent(
                [
                    "status" => "FAILURE",
                    "data" => array(["orderStatus" => "ORDER_NOT_PLACED"]),
                    "errors" => $e->getMessage()." Line Number: ".$e->getLine()
                ]
            );
            return $response;
        }
    }
);


$app->post("/getOrders",
    function () use ($app){
        try{
            $shopId = $app->request->getJsonRawBody();

            $phql = 'SELECT * FROM tables\ORDERS where shopId = :shopId:';

            $orderids = $app->modelsManager->executeQuery(
                $phql,
                [
                    "shopId" => $shopId -> shop_id
                ]
            );

            $ids = array();

            foreach ($orderids as $orderid){

                $temp = [];

                $phql = "SELECT tables\LINEITEMS.productId, tables\PRODUCTS.productName, tables\LINEITEMS.lineItemId, tables\LINEITEMS.lineItemQuantity, tables\LINEITEMS.lineItemPrice FROM tables\LINEITEMS
	                     INNER JOIN tables\PRODUCTS ON tables\LINEITEMS.productId = tables\PRODUCTS.productId
                         WHERE tables\LINEITEMS.orderId = :order_id:";

                $orders = $app->modelsManager->executeQuery(
                    $phql,
                    [
                        "order_id" => $orderid -> orderId
                    ]
                );

                $temp["orderId"] = $orderid->orderId;
                $temp["orderAmount"] = $orderid->orderAmount;
                $temp["OrderStatus"] = $orderid->OrderStatus;
                $temp["shopId"] = $orderid->shopId;
                $temp["order_date"] = $orderid->order_date;
                $temp["product_details"] = $orders;

                array_push($ids,$temp);
            }

            $response = new Response();
            $response->setJsonContent(
                [
                    "status" => "SUCCESS",
                    "data" => $ids
                ]
            );
            return $response;
        }catch (Exception $e){
            $response = new Response();
            $response->setStatusCode(409,"CONFLICT");
            $response->setJsonContent(
                [
                    "status" => "FAILURE",
                    "data" => array([]),
                    "errors" => $e->getMessage()." Line Number: ".$e->getLine()
                ]
            );
            return $response;
        }
    }
);


$app->post("/updateOrderStatus",
    function () use ($app){
        try{

            $order = $app -> request -> getJsonRawBody();

            $phql = 'SELECT * FROM tables\ORDERS where orderId = (:orderId:)';

            $checkOrder = $app->modelsManager->executeQuery(
                $phql,[
                    "orderId" => $order -> order_id
                ]
            );

            $response = new Response();

            if (count($checkOrder) != 0){
                $phql ='UPDATE tables\ORDERS SET OrderStatus = :OrderStatus: WHERE orderId = :orderId:';

                $status =$app->modelsManager->executeQuery(
                    $phql,[
                        "OrderStatus" => $order -> order_status,
                        "orderId" => $order -> order_id
                    ]
                );


                if ($status->success() === True){
                    $response->setStatusCode(201,"OK");
                    $response->setJsonContent(
                        [
                            "status" => "SUCCESS",
                            "data" => array(["orderStatus" => "ORDER_UPDATED"])
                        ]
                    );
                }
                else{
                    $response->setStatusCode(409,"FAILURE");

                    $errors = [];

                    foreach ($status->getMessages() as $message) {
                        $errors[] = $message->getMessage();
                    }

                    $response->setJsonContent(
                        [
                            "status" => "SUCCESS",
                            "data" => array(["orderStatus" => "ORDER_NOT_UPDATED"]),
                            "errors" => $errors
                        ]
                    );
                }
                return $response;
            }else{
                $response->setStatusCode(409,"CONFLICT");
                $response->setJsonContent(
                    [
                        "status" => "SUCCESS",
                        "data" => array(["orderStatus" => "ORDER_ID_NOT_FOUND"]),
                    ]
                );
                return $response;
            }
        }catch (Exception $e){
            $response = new Response();
            $response->setStatusCode(409,"CONFLICT");
            $response->setJsonContent(
                [
                    "status" => "FAILURE",
                    "data" => array(["orderStatus" => "ORDER_STATUS_NOT_UPDATED"]),
                    "errors" => $e->getMessage()." Line Number: ".$e->getLine()
                ]
            );
            return $response;
        }
    }
);


$app->post("/cancelOrder",
    function () use ($app){
        try{

            $order = $app -> request -> getJsonRawBody();

            $phql = 'SELECT * FROM tables\ORDERS where orderId = (:orderId:)';

            $checkOrder = $app->modelsManager->executeQuery(
                $phql,[
                    "orderId" => $order -> order_id
                ]
            );

            $response = new Response();

            if (count($checkOrder) != 0){

                $phql ='UPDATE tables\ORDERS SET OrderStatus = "CANCELLED" WHERE orderId = :orderId:';

                $status =$app->modelsManager->executeQuery(
                    $phql,[
                        "orderId" => $order -> order_id
                    ]
                );

                if ($status->success() === True){

                    $phql ='SELECT * FROM tables\LINEITEMS where orderId = :orderId:';

                    $lineItems = $app->modelsManager->executeQuery(
                        $phql,[
                            "orderId" => $order -> order_id
                        ]
                    );

                    foreach ($lineItems as $lineItem){

                        $phql = "UPDATE tables\PRODUCTS 
                                SET productQuantity = productQuantity + '$lineItem->lineItemQuantity'
	                            WHERE productId = :productId: ";

                        $update_order = $app->modelsManager->executeQuery(
                            $phql,
                            [
                                "productId" => $lineItem->productId,
                            ]
                        );

                        if ($update_order->success() === False){
                            $response->setStatusCode(201,"OK");
                            $response->setJsonContent(
                                [
                                    "status" => "SUCCESS",
                                    "data" => array(["orderStatus" => "ORDER_NOT_UPDATED"])
                                ]
                            );
                            break;
                        }
                    }

                    $phql ='DELETE FROM tables\LINEITEMS where orderId = :orderId:';

                    $lineItemsDelete = $app->modelsManager->executeQuery(
                        $phql,[
                            "orderId" => $order -> order_id
                        ]
                    );

                    if ($lineItemsDelete->success()){
                        $response->setStatusCode(201,"OK");
                        $response->setJsonContent(
                            [
                                "status" => "SUCCESS",
                                "data" => array(["orderStatus" => "ORDER_UPDATED"])
                            ]
                        );
                    }else{
                        $response->setStatusCode(409,"FAILURE");

                        $errors = [];

                        foreach ($status->getMessages() as $message) {
                            $errors[] = $message->getMessage();
                        }

                        $response->setJsonContent(
                            [
                                "status" => "SUCCESS",
                                "data" => array(["orderStatus" => "ORDER_NOT_UPDATED"]),
                                "errors" => $errors
                            ]
                        );
                    }
                }
                else{
                    $response->setStatusCode(409,"FAILURE");

                    $errors = [];

                    foreach ($status->getMessages() as $message) {
                        $errors[] = $message->getMessage();
                    }

                    $response->setJsonContent(
                        [
                            "status" => "SUCCESS",
                            "data" => array(["orderStatus" => "ORDER_NOT_UPDATED"]),
                            "errors" => $errors
                        ]
                    );
                }
                return $response;
            }else{
                $response->setStatusCode(409,"CONFLICT");
                $response->setJsonContent(
                    [
                        "status" => "SUCCESS",
                        "data" => array(["orderStatus" => "ORDER_ID_NOT_FOUND"]),
                    ]
                );
                return $response;
            }
        }catch (Exception $e){
            $response = new Response();
            $response->setStatusCode(409,"CONFLICT");
            $response->setJsonContent(
                [
                    "status" => "FAILURE",
                    "data" => array(["orderStatus" => "ORDER_STATUS_NOT_UPDATED"]),
                    "errors" => $e->getMessage()." Line Number: ".$e->getLine()
                ]
            );
            return $response;
        }
    }
);


$app->handle();

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo 'This is crazy, but this page was not found!';
});

?>