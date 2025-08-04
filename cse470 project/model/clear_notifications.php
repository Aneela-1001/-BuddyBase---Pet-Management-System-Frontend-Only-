<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'pet_blog';

$conn = new mysqli($host, $user, $password, $db);

$conn->query("DELETE FROM notifications");

echo 'success';
$conn->close();
?>
