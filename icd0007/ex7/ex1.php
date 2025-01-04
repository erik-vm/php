<?php

const ORDER_FILE_NAME = 'data/order.txt';
require_once 'OrderLine.php';
require_once 'OrderLineRepository.php';


$repository = new OrderLineRepository(ORDER_FILE_NAME);

foreach ($repository->getOrderLines() as $orderLine) {

    $inStock = $orderLine->inStock
        ? 'yes' : 'no';
    printf('name: %s, price: %s; in stock: %s' . PHP_EOL,
        $orderLine->productName, $orderLine->price, $inStock);
}
