<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'pet_blog';

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = [];

while ($row = $result->fetch_assoc()) {
    $posts[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'content' => $row['content'],
        'author' => $row['author'],
        'image' => $row['image'], 
        'created_at' => $row['created_at']
    ];
}

header('Content-Type: application/json');
echo json_encode($posts);
?>
