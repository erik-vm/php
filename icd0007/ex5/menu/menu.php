<?php

require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/MenuItem.php';

function getMenu(): array
{
    $conn = getConnection();

    $stmt = $conn->prepare('SELECT id, parent_id, name FROM menu_item ORDER BY id');

    $stmt->execute();

    $temp = [];
    $menu = [];

    foreach ($stmt as $row)
    {
        $id = $row['id'];
        $parent_id = $row['parent_id'];
        $name = $row['name'];

        $item = new MenuItem($id, $name);

        $temp[$id] = $item;

        if ($parent_id)
            $temp[$parent_id]->addSubItem($item);
        else
            $menu[] = $item;
    }

    return $menu;
}

function printMenu($items, $level = 0): void
{
    $padding = str_repeat(' ', $level * 3);

    foreach ($items as $item)
    {
        printf("%s%s\n", $padding, $item->name);

        if ($item->subItems)
            printMenu($item->subItems, $level + 1);
    }
}