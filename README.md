# Shopify Back End Challenge

## Summary

This repo contains the code for the [Shopify - Developer Winter 2019 Challenge](https://docs.google.com/document/d/1YYDRf_CgQRryf5lZdkZ2o3Hm3erFSaISL1L1s8kLqsI/edit). In order to solve the problem, an micro application is created with help from [Phalcon (PHP Framework)](https://en.wikipedia.org/wiki/Phalcon_(framework)). Below listed are some highlights of the application

* Application supports CRUD operations for all the tables (SHOPS, PRODUCTS, ORDERS, LINEITEMS).
* Application secure from the SQL Injection.
* Database instance is created in Azure.
* Application is hosted in Dalhousie bluenose server.

## Technologies

**Languages:** PHP

**Framework:** Phalcon (Micro application)

**Database:** MySQL

## Database

### Details

**HOST** : visakandatabase.mysql.database.azure.com

**User name**: visakanadmin@visakandatabase

**Password** : P@ssword@123

**Database name**: shopify

### Database schema

![Database Schema](https://github.com/visakan4/shopifyBackEndChallenge/blob/master/images/schema.png "Database Schema")

## Architecture

![Architecture](https://github.com/visakan4/shopifyBackEndChallenge/blob/master/images/architecture.PNG "Architecture")

## Functionalities

1. API: https://web.cs.dal.ca/~jeyakumar/csci5709/shopifyDeveloperChallenge/setShop

REQUEST TYPE: POST

*STEPS*

1. Get the Input JSON
2. Prepare the Query to insert into the Shops table
3. Execute the query
4. If the query execution is successful set the shopStatus to SHOP_ADDED and statusCode to 201.
5. If the query is not successful set the shopStatus to SHOP_NOT_ADDED and statusCode to 409. 
5. Get the shopId from and form the response JSON
6. Return the response

REQUEST

```
{
	"shop_name" : "Walmart"
}
```

Response:

SUCCESS:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "shopStatus": "SHOP_ADDED",
            "shopId": "2"
        }
    ]
}
```

FAILURE:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "shopStatus": "SHOP_NOT_ADDED",
        }
    ]
	"errors": <Error Messages>
}
```

2. API: https://web.cs.dal.ca/~jeyakumar/csci5709/shopifyDeveloperChallenge/setShop

REQUEST TYPE: DELETE

*STEPS*

1. Get the Input JSON
2. Check if the shopId exists.
3. If the shopId does not exist set the shopStatus to SHOP_ID_NOT_FOUND and return the response.
4. Prepare the Query to delete the shop from Shops table
5. Execute the query
6. If the query execution is successful set the shopStatus to SHOP_DELETED and statusCode to 201.
7. If the query is not successful set the shopStatus to SHOP_NOT_DELETED and statusCode to 409. 
8. Form the response JSON and return it.

REQUEST

```
{
	"shop_id" : 2
}
```

RESPONSE

SUCCESS:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "shopStatus": "SHOP_DELETED"
        }
    ]
}
```

FAILURE:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "shopStatus": "SHOP_ID_NOT_FOUND"
        }
    ]
}
```

```
{
    "status": "FAILURE",
    "data": [
        {
            "shopStatus": "SHOP_NOT_DELETED",
        }
    ]
	"errors": <Error Messages>
}
```

3. API: https://web.cs.dal.ca/~jeyakumar/csci5709/shopifyDeveloperChallenge/updateShop

REQUEST TYPE: POST

*STEPS*

1. Get the Input JSON
2. Check if the shopId exists.
3. If the shopId does not exist set the shopStatus to SHOP_ID_NOT_FOUND and return the response.
4. Prepare the Query to update the shop from Shops table
5. Execute the query
6. If the query execution is successful set the shopStatus to SHOP_UPDATED and statusCode to 201.
7. If the query is not successful set the shopStatus to SHOP_NOT_UPDATED and statusCode to 409. 
8. Form the response JSON and return it.

REQUEST

```
{
	"shop_id" : "4",
	"shop_name" : "Walmart"
}
```

RESPONSE

SUCCESS

```
{
    "status": "SUCCESS",
    "data": [
        {
            "shopStatus": "SHOP_UPDATED"
        }
    ]
}
```

FAILURE
```
{
    "status": "SUCCESS",
    "data": [
        {
            "shopStatus": "SHOP_ID_NOT_FOUND"
        }
    ]
}
```
```
{
    "status": "FAILURE",
    "data": [
        {
            "shopStatus": "SHOP_NOT_DELETED",
        }
    ]
	"errors": <Error Messages>
}
```

4. API: https://web.cs.dal.ca/~jeyakumar/csci5709/shopifyDeveloperChallenge/getShops

REQUEST TYPE: GET

*STEPS*

1. Execute the query
2. If the query execution is successful iterate rhough the results and form the response JSON.
3. If the query is not successful set the shopStatus to SHOP_NOT_UPDATED and statusCode to 409. 
4. Return the response JSON.

RESPONSE

SUCCESS
```
{
    "status": "SUCCESS",
    "data": [
        {
            "shop_id": "1",
            "shop_name": "Atlantic"
        }
    ]
}
```

5. API: https://web.cs.dal.ca/~jeyakumar/csci5709/shopifyDeveloperChallenge/setProduct

REQUEST TYPE: POST

*STEPS*

1. Get the Input JSON.
2. Prepare the Query to insert into the Product table.
3. Execute the query.
4. If the query execution is successful set the productStatus to PRODUCT_ADDED and statusCode to 201.
5. If the query is not successful set the productStatus to PRODUCT_NOT_ADDED and statusCode to 409. 
5. Get the productId from and form the response JSON.
6. Return the response.


REQUEST
```
{
	"product_name" : "Heater",
	"product_quantity" : 1000,
	"product_price":100,
	"shop_id": 1
}
```
RESPONSE

SUCCESS
```
{
    "status": "SUCCESS",
    "data": [
        {
            "productStatus": "PRODUCT_ADDED",
            "shopId": "2"
        }
    ]
}
```

FAILURE:
```
{
    "status": "FAILURE",
    "data": [
        {
            "productStatus": "PRODUCT_NOT_ADDED"
        }
    ],
    "errors": "SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (`shopify`.`products`, CONSTRAINT `products_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`shopId`))"
}
```

6. API: https://web.cs.dal.ca/~jeyakumar/csci5709/shopifyDeveloperChallenge/deleteProduct

REQUEST TYPE: DELETE

*STEPS*

1. Get the Input JSON
2. Check if the productId exists.
3. If the productId does not exist set the productStatus to PRODUCT_ID_NOT_FOUND and return the response.
4. Prepare the Query to delete the product from Products table
5. Execute the query
6. If the query execution is successful set the shopStatus to PRODUCT_DELETED and statusCode to 201.
7. If the query is not successful set the shopStatus to PRODUCT_NOT_DELETED and statusCode to 409. 
8. Form the response JSON and return it.

REQUEST:
```
{
	"product_id" : 6
}
```
RESPONSE:

SUCCESS:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "productStatus": "PRODUCT_DELETED"
        }
    ]
}
```

FAILURE:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "productStatus": "PRODUCT_ID_NOT_FOUND"
        }
    ]
}
```

7. API: https://web.cs.dal.ca/~jeyakumar/csci5709/shopifyDeveloperChallenge/getProductsByshopId

REQUEST TYPE: POST

*STEPS*

1. Get the Input JSON.
2. Prepare the query to get the products by shopId.
3. Execute the query.
4. If the query execution is successful iterate though the results and form the response JSON.
5. If the query is not successful get the error messages and form the response JSON.
6. Return the response JSON.

REQUEST:

```
{
	"shop_id" : 1
}
```

RESPONSE:

SUCCESS:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "product_id": "2",
            "product_name": "Heater",
            "product_quantity": "1000",
            "product_price": "100.00",
            "shop_id": "1"
        },
        {
            "product_id": "3",
            "product_name": "Duvet",
            "product_quantity": "1000",
            "product_price": "100.00",
            "shop_id": "1"
        }
    ]
}
```

8. API: https://web.cs.dal.ca/~jeyakumar/csci5709/shopifyDeveloperChallenge/updateProduct

REQUEST TYPE: POST

*STEPS*

1. Get the Input JSON
2. Check if the productId exists.
3. If the productId does not exist set the productStatus to PRODUCT_ID_NOT_FOUND and return the response.
4. Prepare the Query to update the shop from Products table.
5. Execute the query.
6. If the query execution is successful set the productStatus to PRODUCT_UPDATED and statusCode to 201.
7. If the query is not successful set the productStatus to PRODUCT_NOT_UPDATED and statusCode to 409 and get the error message. 
8. Form the response JSON(with error message) and return it.

REQUEST:
```
{
	"product_name" : "Pillow",
	"product_quantity" : 1000,
	"product_price":100,
	"shop_id": 1,
	"product_id":2
}
```

RESPONSE:

SUCCESS:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "productStatus": "PRODUCT_UPDATED"
        }
    ]
}
```

FAILURE:
```
{
    "status": "FAILURE",
    "data": [
        {
            "productStatus": "PRODUCTS_NOT_UPDATED"
        }
    ],
    "errors": "SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (`shopify`.`products`, CONSTRAINT `products_ibfk_1` FOREIGN KEY (`shopId`) REFERENCES `shops` (`shopId`)) Line Number: 534"
}
```
9. API: https://web.cs.dal.ca/~jeyakumar/csci5709/shopifyDeveloperChallenge/setOrder

REQUEST TYPE: POST

REQUEST:
```
{
	"order_amount": 300,
	"order_status": "CREATED",
	"shop_id": 1,
	"product_details": [{
			"product_id": "2",
			"lineItem_price": "100",
			"lineItem_quantity": "1"
		},
		{
			"product_id": "3",
			"lineItem_price": "200",
			"lineItem_quantity": "2"
		}
	]
}
```
RESPONSE:

SUCCESS:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "orderStatus": "ORDER_PLACED",
            "orderID": "1"
        }
    ]
}
```
FAILURE:
```
{
    "status": "FAILURE",
    "data": [
        {
            "orderStatus": "ORDER_DETAILS_NOT_MATCHING"
        }
    ]
}
```

10. API:https://web.cs.dal.ca/~jeyakumar/csci5709/shopifyDeveloperChallenge/getOrders

REQUEST TYPE: POST

REQUEST:
```
{
	"shop_id": "2"
}
```
RESPONSE:

SUCCESS
```
{
    "status": "SUCCESS",
    "data": [
        {
            "orderId": "1",
            "orderAmount": "300.00",
            "OrderStatus": "CREATED",
            "shopId": "1",
            "order_date": "2018-09-23 00:37:39",
            "product_details": [
                {
                    "productId": "2",
                    "productName": "Pillow",
                    "lineItemId": "1",
                    "lineItemQuantity": "1",
                    "lineItemPrice": "100.00"
                },
                {
                    "productId": "3",
                    "productName": "Duvet",
                    "lineItemId": "2",
                    "lineItemQuantity": "2",
                    "lineItemPrice": "200.00"
                }
            ]
        }
    ]
}
```

11. API:https://web.cs.dal.ca/~jeyakumar/csci5709/shopifyDeveloperChallenge/updateOrderStatus

REQUEST TYPE: POST

REQUEST:
```
{
	"order_status": "TESTING",
	"order_id":1
}
```
RESPONSE:

SUCCESS:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "orderStatus": "ORDER_UPDATED"
        }
    ]
}
```
FAILURE:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "orderStatus": "ORDER_ID_NOT_FOUND"
        }
    ]
}
```
12. API: https://web.cs.dal.ca/~jeyakumar/csci5709/shopifyDeveloperChallenge/cancelOrder

REQUEST TYPE: POST

REQUEST:
```
{
	"order_id":1
}
```
RESPONSE:

SUCCESS:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "orderStatus": "ORDER_UPDATED"
        }
    ]
}
```
FAILURE:
```
{
    "status": "SUCCESS",
    "data": [
        {
            "orderStatus": "ORDER_ID_NOT_FOUND"
        }
    ]
}
```

## Setup

* Install PHP
* Install Phalcon
* Setup IDE Stubs for Phalcon
* Setup XAMPP
* Clone the repository using `git@github.com:visakan4/shopifyBackEndChallenge.git`
* Place the cloned repo in the htdocs folder of the XAMPP server
* Run the server and test the API using Postman or any other tool
