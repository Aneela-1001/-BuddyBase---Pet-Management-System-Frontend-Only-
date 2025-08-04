<?php
include 'db.php';

$id = intval($_POST['id']);

if ($id > 0) {
  $stmt = $mysqli->prepare("UPDATE abuse_reports SET rescued = 1 WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  echo "Marked as rescued.";
} else {
  echo "Invalid ID.";
}
?>
