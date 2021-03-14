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

// Blog Category Query
$result = $category->read();

// Get Row Count
$num = $result->rowCount();

// Check if any categories
if ($num > 0) {
    // Category array
    $category_arr = array();
    $category_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'name' => $name
        );

        // Push to 'data'
        array_push($category_arr['data'], $category_item);
    }

    // Turn to JSON & ouput
    echo json_encode($category_arr);
} else {
    // No Categories
    echo json_encode(
        array('message' => 'No Categories Found')
    );
}
