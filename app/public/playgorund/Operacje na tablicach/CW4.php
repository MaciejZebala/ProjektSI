<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

$tab = ['plum', 'orange', 'banana', 'apple'];

$nowaTab = array_map(function ($value){
    return strtoupper($value);
}, $tab);

var_dump($tab);
var_dump($nowaTab);