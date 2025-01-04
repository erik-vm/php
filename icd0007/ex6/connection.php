<?php

const USERNAME = 'erikvme';
const PASSWORD = '920428';

function getConnection(): PDO {
    $host = 'db.mkalmo.eu';

    $address = sprintf('mysql:host=%s;port=3306;dbname=%s',
        $host, USERNAME);

    return new PDO($address, USERNAME, PASSWORD);
}
