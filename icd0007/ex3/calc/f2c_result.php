<?php

require_once 'functions.php';

$input = $_POST['temperature'] ?? null;

if ($input === null || $input === "") {
    $message = "Insert temperature";
} else if (!is_numeric($input)) {
    $message = "Temperature must be a numeric value";
} else {
    $inputTemp = intval($input);
    $result = f2c($inputTemp);
    $message = sprintf("%d degrees in Fahrenheit is %d degrees in Celsius", $inputTemp, $result);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fahrenheit to Celsius</title>
</head>
<body>

<nav>
    <a id="c2f" href="index.html">Celsius to Fahrenheit</a> |
    <a id="f2c" href="f2c.html">Fahrenheit to Celsius</a>
</nav>

<main>
    <h3>Fahrenheit to Celsius</h3>
    <em><?php
        print $message
        ?></em>

</main>

</body>
</html>