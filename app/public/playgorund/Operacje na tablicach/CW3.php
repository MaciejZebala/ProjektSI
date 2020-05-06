<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

$persons = [
    [
        'first_name' => 'Mark',
        'surname' => 'Brown',
    ],
    [
        'first_name' => 'Ann',
        'surname' => 'Smith',
    ],
    [
        'first_name' => 'John',
        'surname' => 'Doe',
    ],
];
$imie = array_column($persons, 'first_name');
array_multisort($persons, SORT_ASC, $imie);
var_dump($persons);