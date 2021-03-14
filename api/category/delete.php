<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

// Set ID to Delete
$category->id = $data->id;

// Delete Category
if ($category->delete()) {
    echo json_encode(
        array('message' => 'Category Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Deleted')
    );
}