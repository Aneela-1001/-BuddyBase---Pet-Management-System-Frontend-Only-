<?php

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'pet_blog';

$conn = new mysqli($host, $user, $password, $db);


error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['title'], $_POST['content'], $_POST['author'])) {
  $title = $conn->real_escape_string($_POST['title']);
  $content = $conn->real_escape_string($_POST['content']);
  $author = $conn->real_escape_string($_POST['author']);


  $imagePath = '';
  if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
    $targetDir = 'upload/';
    $targetFile = $targetDir . $imageName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
      $imagePath = $targetFile;
    }
  }


  $sql = "INSERT INTO posts (title, content, author, image) VALUES ('$title', '$content', '$author', '$imagePath')";
  if ($conn->query($sql)) {

    $message = "$author just posted a new blog: $title";
    $conn->query("INSERT INTO notifications (message, type) VALUES ('$message', 'blog')");

    echo 'success';
  } else {
    echo 'error';
  }
} else {
  echo 'missing_fields';
}

$conn->close();
?>
