<?php
include 'db.php';

$id = $_POST['id'];
$action = $_POST['action'];

if ($action === 'approved') {
  $mysqli->query("UPDATE abuse_reports SET status='approved' WHERE id=$id");
} elseif ($action === 'decline') {
  $mysqli->query("DELETE FROM abuse_reports WHERE id=$id");
}

echo "Done";
?>
