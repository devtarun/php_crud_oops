<?php

//HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once('../../config/Database.php');
require_once('../../models/Category.php');

// INSTANTIATE DB AND CONNECT
$database = new Database();
$db = $database->connect();

// INSTANTIATE category
$category = new Category($db);

// GET RAW DATA

$data = json_decode(file_get_contents("PHP://input"));

// print_r($data);
// exit;

$category->name = $data->name;

if ($category->create()) {
    echo json_encode(array(
        'data' => array(
            'message' => 'category created'
        )
    ));
} else {
    echo json_encode(array(
        'data' => array(
            'message' => 'category Not created'
        )
    ));
}
