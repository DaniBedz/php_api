<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

require_once '../../config/Database.php';
require_once '../../models/Post.php';

// Instatiate DB & Connect
$db = new Database();
$database = $db->connect();

// Instantiate Post Object
$post = new Post($database);

// Get Raw Posted Data
$data = json_decode(file_get_contents("php://input"));

// Set ID to Delete
$post->id = $data->id;

// Delete Post
if ($post->delete()) {
    echo json_encode(
        array('message' => 'Post Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Deleted')
    );
}