<?php
include 'db.php';

$reporter_name = $_POST['reporter_name'];
$contact_email = $_POST['contact_email'];
$action_type = $_POST['action_type'];
$location = $_POST['location'];
$description = $_POST['description'];

$image_path = "";
if (!empty($_FILES['image']['name'])) {
  $upload_dir = "uploads/";
  if (!is_dir($upload_dir)) mkdir($upload_dir);
  $image_path = $upload_dir . basename($_FILES['image']['name']);
  move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
}

$stmt = $mysqli->prepare("INSERT INTO abuse_reports (reporter_name, contact_email, action_type, location, description, image, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
$stmt->bind_param("ssssss", $reporter_name, $contact_email, $action_type, $location, $description, $image_path);
$stmt->execute();

header("Location: abuse_and_rescue.html");
exit;
?>
