<?php

declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

$request_pattern = ['firstname', 'lastname', 'email', 'age'];

$data = [];

foreach ($request_pattern as $field){
    $data[$field] = isset($_POST[$field]) ? trim($_POST[$field]) : '';
}

function get_request_data(array $request, array $wzor){

}

var_dump($data);