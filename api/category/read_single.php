<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

require_once '../../config/Database.php';
require_once '../../models/Category.php';

// Instatiate DB & Connect
$db = new Database();
$database = $db->connect();

// Instantiate Category Object
$category = new Category($database);

// Get ID from URL
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get Category
$category->readSingle();

// Create Array
$category_arr = array(
    'id' => $category->id,
    'name' => $category->name
);

// Make JSON
print_r(json_encode($category_arr));