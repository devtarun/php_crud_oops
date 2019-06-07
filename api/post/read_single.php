<?php

//HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once('../../config/Database.php');
require_once('../../models/Post.php');

// INSTANTIATE DB AND CONNECT
$database = new Database();
$db = $database->connect();

// INSTANTIATE POST
$post = new Post($db);

// GET ID
$post->id = isset($_GET['id']) ? $_GET['id'] : die();
$result = $post->read_single();

$post_item = array(
    'data' => array(
        'id'            => $post->id,
        'title'         => $post->title,
        'body'          => html_entity_decode($post->body),
        'author'        => $post->author,
        'category_id'   => $post->category_id,
        'category_name' => $post->category_name
    )
);

print_r(json_encode($post_item));
