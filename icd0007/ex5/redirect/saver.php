<?php

$data = $_POST['data'] ?? '';

$message = "Data saved!";


if (isset($_POST['save']) && $_POST['save']) {
    file_put_contents('data.txt', $data);
    $message = sprintf("\nSaved %s bytes\n", strlen($data));
}

$url = 'index.php?message=' . urlencode($message);

//error_log($url);

header('Location: ' . $url);
