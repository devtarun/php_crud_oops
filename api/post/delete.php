<?php

//HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once('../../config/Database.php');
require_once('../../models/Post.php');

// INSTANTIATE DB AND CONNECT
$database = new Database();
$db = $database->connect();

// INSTANTIATE POST
$post = new Post($db);

// GET RAW DATA

$data = json_decode(file_get_contents("PHP://input"));

// print_r($data);
// exit;

$post->id = isset($_GET['id']) ? $_GET['id'] : die();

if ($post->delete()) {
    echo json_encode(array(
        'data' => array(
            'message' => 'Post deleted'
        )
    ));
} else {
    echo json_encode(array(
        'data' => array(
            'message' => 'Post Not deleted'
        )
    ));
}
