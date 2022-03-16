<?php
/**
 * Created by PhpStorm.
 * User: maxim / WEB Котлас / www.web-kotlas.ru
 * Date: 11/03/2022
 * Time: 12:51
 */
include_once "../src/iikoApi.php";
include_once "../src/iikoApiCore.php";
include_once "../src/Descriptions.php";

use webkotlas\iiko\iikoApi;

iikoApi::init([
    'api_key' => '',
    'organization_id' => '593cbccd-3e9f-4eca-9eb3-7ad1a5162456'
]);

$token = iikoApi::getToken();
$requestCode = iikoApi::getLastRequestHttpCode();
$requestError = iikoApi::getRequestHttpError();

if($requestCode === 200){
    iikoApi::setAccessToken($token);
    try {
        $groups = iikoApi::terminalGroup()->get();
        //$clientsCategories = iikoApi::clients()->getCategories();
        //$clientsAddCard = iikoApi::clients()->addCard('','','');
        //$clientsAddCategory = iikoApi::clients()->addCategoryForClient('','');
        //$clientsProgram = iikoApi::clients()->programDiscounts();

        $terminalGroupId = iikoApi::terminalGroup()->getGroup($groups, 1)->id;
        $orders = iikoApi::orders();
        $orderSetNew = $orders->new();
        $orderSetNew
            ->setCustomerInfo(['name' => 'Максим'])
            ->setPhone('+79999999999')
            ->setPersons(1)
            ->setComment('Тестовый заказ')
            ->setOrderServiceType('DeliveryByClient') //DeliveryByCourier OR DeliveryByClient
            ->setTerminalGroupId($terminalGroupId)
            /*->setDeliveryPoint([
                'street' => [
                    'city' => 'Петрозаводск',
                    'name' => 'Герцена'
                ],
                'house' => '23', //дом
                'building' => '',//здание
                'flat' => '15', //квартира
                'floor' => '2',//этаж
                'entrance' => '1',//подъезд
                'doorphone' => '15',//домофон
            ])*/
            ->setItems([
                [
                    'productId' => '3777efce-2bce-436c-afac-c5d42844502b',
                    'price' => 59.00, // Цена за единицу товара. Возможна отправка отличной от цены в базовом меню.
                    'amount' => 2, //кол-во товара
                    'type' => 'Product',
                    'modifiers' => [
                        ['productId' => '82d909bd-8c53-4787-8f81-43dc59adf7b7', 'productGroupId'=> '8ae862a8-a141-4168-af42-ceafa533f921', 'amount' => 1, 'price' => 0.00]
                    ]
                ],
                [
                    'productId' => 'f6c13009-9cae-4bc1-aaeb-b048b2eddf92',
                    'price' => 169.00, // Цена за единицу товара. Возможна отправка отличной от цены в базовом меню.
                    'amount' => 2, //кол-во товара
                    'type' => 'Product',
                    'modifiers' => [
                        ['productId' => '9e1f3852-dd82-4a8e-95cc-4eda92e9f22b', 'productGroupId'=> 'da3cd6d9-ec46-4e21-8634-058d5a01fc7b', 'amount' => 1, 'price' => 0.00],
                        ['productId' => '081e0773-4442-4c08-82e3-50d4f43e8f1a', 'productGroupId'=> '530d59b3-1718-40bc-ba56-824c3276df92', 'amount' => 1, 'price' => 29.00],
                    ]
                ]
            ])
        ;
        //$orderCalculate = iikoApi::orders()->calculate(); //Если есть купон
        // $orderCreate = $orders->create();
        $orderCreateDelivery = '';
        //$orderCreateDelivery = $orders->createDelivery();
        //$orderSearch = iikoApi::orders()->searchOrder('');
        $orderSearchDelivery = iikoApi::orders()->searchOrderDelivery('7ce50391-0cbb-40ae-9ccc-d6cb2e40f58a');
        //$orderCancel = iikoApi::orders()->cancel('');
        //$orderCancelDelivery = iikoApi::orders()->cancelDelivery('');
         //$status = iikoApi::operations()->status('a63278fa-c138-4274-ab76-bef6a93ea26e');

        //$organization = iikoApi::organization()->get();

        //$discount = iikoApi::dictionary()->getDiscount();
        //$order = iikoApi::dictionary()->getOrder();
       // $payment = iikoApi::dictionary()->getPayment();
        //$removal = iikoApi::dictionary()->getRemoval();
        //$products = iikoApi::menu()->nomenclature()->getProducts();

        dd($terminalGroupId, $orderCreateDelivery, $orderSearchDelivery);
    }catch (Exception $e ){
        dd($e->getMessage(), $e->getCode());
    }
}else{
    dd($requestError);
}

function dd(...$arguments){
    echo "<pre>"; print_r($arguments); echo "</pre>";
}