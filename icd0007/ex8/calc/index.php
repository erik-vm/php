<?php

require '../vendor/autoload.php';

$cmd = $_REQUEST['cmd'] ?? 'ctf_form';
$temperature = $_POST['temperature'] ?? null;

$data = ['temperature' => $temperature];

if ($cmd === 'ctf_form') {
    $data['cmd'] = 'ctf_calculate';
    $data['title'] = 'Celsius to Fahrenheit';
    render('form_fragment.latte', $data);

} else if ($cmd === 'ftc_form') {
    $data['cmd'] = 'ftc_calculate';
    $data['title'] = 'Fahrenheit to Celsius';
    render('form_fragment.latte', $data);

} else if ($cmd === 'ctf_calculate') {
    // Validate and calculate for Celsius to Fahrenheit
    $errors = validate($temperature);
    if ($errors) {
        // Render the form again, showing the error and the temperature value
        render('form_fragment.latte', ['errors' => $errors, 'temperature' => $temperature, 'cmd' => 'ctf_calculate']);
        exit();
    }

    // If input is valid, perform calculation
    $input = $temperature;
    $result = celsiusToFahrenheit($input);
    $message = "$input degrees in Celsius is $result degrees in Fahrenheit";
    render('result_fragment.latte', ['message' => $message]);

} else if ($cmd === 'ftc_calculate') {
    // Validate and calculate for Fahrenheit to Celsius
    $errors = validate($temperature);
    if ($errors) {
        // Render the form again, showing the error and the temperature value
        render('form_fragment.latte', ['errors' => $errors, 'temperature' => $temperature, 'cmd' => 'ftc_calculate']);
        exit();
    }

    // If input is valid, perform calculation
    $input = $temperature;
    $result = fahrenheitToCelsius($input);
    $message = "$input degrees in Fahrenheit is $result degrees in Celsius";
    render('result_fragment.latte', ['message' => $message]);

} else {
    throw new Error('programming error');
}

// Function to render templates
function render(string $subTemplate, array $data): void {
    $latte = new Latte\Engine;
    $latte->render("main.latte", [...$data, 'template' => $subTemplate]);
}

// Validate temperature input
function validate(?string $temperature): array {
    if (!is_numeric($temperature)) {
        return ['Temperature must be a number'];
    }
    return []; // If valid
}

// Convert Celsius to Fahrenheit
function celsiusToFahrenheit($temp): float {
    return round($temp * 9 / 5 + 32, 2);
}

// Convert Fahrenheit to Celsius
function fahrenheitToCelsius($temp): float {
    return round(($temp - 32) * 5 / 9, 2);
}