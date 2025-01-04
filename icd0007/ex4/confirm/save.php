<?php

saveData($_GET['data']);

header('Location: index.php?message=' . 'success');

function saveData(string $data) {
    // log to server console (for debugging)
    error_log('Saving data: ' . $data);

    // actual saving is not important in this context
}