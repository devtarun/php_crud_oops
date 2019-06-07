<?php

//HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once('../../config/Database.php');
require_once('../../models/Category.php');

// INSTANTIATE DB AND CONNECT
$database = new Database();
$db = $database->connect();

// INSTANTIATE POST
$cat = new Category($db);

// GET ID
$cat->id = isset($_GET['id']) ? $_GET['id'] : die();
$result = $cat->read_single();

$cat_item = array(
    'data' => array(
        'id'            => $cat->id,
        'name'         => $cat->name
    )
);

print_r(json_encode($cat_item));
