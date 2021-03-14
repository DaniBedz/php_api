<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

require_once '../../config/Database.php';
require_once '../../models/Category.php';

// Instatiate DB & Connect
$db = new Database();
$database = $db->connect();

// Instantiate Category Object
$category = new Category($database);

// Get Raw Posted Data
$data = json_decode(file_get_contents("php://input"));

// Set ID to Update
$category->id = $data->id;

$category->name = $data->name;

// Update Category
if ($category->update()) {
    echo json_encode(
        array('message' => 'Category Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Updated')
    );
}
