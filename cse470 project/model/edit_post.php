<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'pet_blog';

$conn = new mysqli($host, $user, $password, $db);


if (isset($_POST['id'], $_POST['title'], $_POST['content'])) {
  $id = intval($_POST['id']);
  $title = $conn->real_escape_string($_POST['title']);
  $content = $conn->real_escape_string($_POST['content']);

  $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
  $stmt->bind_param("ssi", $title, $content, $id);

  if ($stmt->execute()) {
    echo "success";
  } else {
    echo "error";
  }
  $stmt->close();
}
$conn->close();
?>
