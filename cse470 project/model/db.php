<?php
$mysqli = new mysqli("localhost", "root", "", "pet_portal");
if ($mysqli->connect_error) {
  die("Database connection failed: " . $mysqli->connect_error);
}
?>
