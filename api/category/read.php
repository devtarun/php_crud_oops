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
$category = new Category($db);
$result = $category->read();

// GET ROW COUNT
$num = $result->rowCount();

// CHECK IF ANY POST
if ($num > 0) {
    $post_arr = array();
    $post_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $post_item = array(
            'id'            => $id,
            'name'         => $name
        );
        array_push($post_arr['data'], $post_item);
    }

    // TURN TO JSON
    echo json_encode($post_arr);
} else {
    echo json_encode(array(
        'message' => 'No categories found'
    ));
}
