<?php

require_once '../vendor/tpl.php';
require_once 'Book.php';

$book = new Book('Head First HTML and CSS', 4, true);
$errors = ['Pealkiri peab olema 2 kuni 10 märki', 'Hinne peab olema määratud'];

$data = ['book' => $book, 'errors' => $errors, 'isEditForm' => true];

print renderTemplate('form.html', $data);