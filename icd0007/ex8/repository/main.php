<?php

require_once 'OrderLine.php';
require_once 'OrderLineRepository.php';

$repo = new OrderLineRepository('orders.txt');

foreach ($repo->getOrderLines() as $line) {
    printf("name: %s, price: %s; in stock: %s \n", $line->productName, $line->price, $line->inStock);
}

exit();

