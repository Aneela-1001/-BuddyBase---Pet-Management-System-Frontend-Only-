<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'pet_blog';

$conn = new mysqli($host, $user, $password, $db);

if (isset($_POST['id'])) {
  $id = intval($_POST['id']);
  $conn->query("UPDATE notifications SET is_read = 1 WHERE id = $id");
  echo 'success';
} else {
  echo 'error';
}
$conn->close();
?>
