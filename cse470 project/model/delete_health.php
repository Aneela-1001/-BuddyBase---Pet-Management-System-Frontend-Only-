<?php
$mysqli = new mysqli("localhost", "root", "", "pet_health");

$id = $_POST['id'];
$type = $_POST['type'];

if ($type === "weight") {
    $mysqli->query("DELETE FROM weight_logs WHERE id=$id");
} elseif ($type === "vaccination") {
    $mysqli->query("DELETE FROM vaccinations WHERE id=$id");
} else {
    $mysqli->query("DELETE FROM symptoms WHERE id=$id");
}

echo "Deleted";
?>
