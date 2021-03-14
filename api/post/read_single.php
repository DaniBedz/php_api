<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

require_once '../../config/Database.php';
require_once '../../models/Post.php';

// Instatiate DB & Connect
$db = new Database();
$database = $db->connect();

// Instantiate Post Object
$post = new Post($database);

// Get ID from URL
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get Post
$post->readSingle();

// Create Array
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
);

// Make JSON
print_r(json_encode($post_arr));