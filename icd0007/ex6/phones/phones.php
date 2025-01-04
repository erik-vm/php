<?php

require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/Contact.php';

function getContacts(): array
{
    $conn = getConnection();

    $stmt = $conn->prepare('SELECT id, name, number FROM contact LEFT JOIN phone ON contact.id = phone.contact_id;');

    $stmt->execute();

    $contacts = [];

    foreach ($stmt as $row)
    {
        $id = $row['id'];
        $name = $row['name'];
        $number = $row['number'];

        if (array_key_exists($id, $contacts))
        {
            $contacts[$id]->addPhone($number);
        }
        else
        {
            $contact = new Contact($id, $name);

            if ($number)
                $contact->addPhone($number);

            $contacts[$id] = $contact;
        }
    }

    return array_values($contacts);
}