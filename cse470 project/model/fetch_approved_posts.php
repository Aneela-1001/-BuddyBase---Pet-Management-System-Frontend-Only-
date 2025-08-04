<?php
include 'db.php';

// Fix: select required columns including action_type and id
$query = "SELECT id, reporter_name, contact_email, location, description, image, action_type 
          FROM abuse_reports 
          WHERE status = 'approved' AND (rescued IS NULL OR rescued = 0)
          ORDER BY created_at DESC";

$result = $mysqli->query($query);

$posts = [];
while ($row = $result->fetch_assoc()) {
  $posts[] = $row;
}

header('Content-Type: application/json');
echo json_encode($posts);
?>
