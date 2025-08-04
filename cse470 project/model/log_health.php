<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = new mysqli("localhost", "root", "", "pet_health");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Collect inputs
$pet = trim($_POST['pet_name']);
$type = $_POST['record_type'];
$value = isset($_POST['value']) ? trim($_POST['value']) : "";
$notes = trim($_POST['notes']);
$date = $_POST['record_date'];
$time = $_POST['record_time'];

// ✅ Validate required fields
if (empty($pet) || empty($type) || empty($date) || empty($time)) {
    http_response_code(400);
    echo "Missing required fields.";
    exit;
}

// ✅ Validate future date
$today = date("Y-m-d");
if ($date < $today) {
    http_response_code(400);
    echo "Error: You cannot select a past date.";
    exit;
}

// ✅ Block manual input if vaccination
if ($type === "vaccination" && !empty($value)) {
    http_response_code(400);
    echo "Error: Vaccination should not contain a description.";
    exit;
}

// Prepare INSERT query
if ($type === "weight") {
    $stmt = $mysqli->prepare("INSERT INTO weight_logs (pet_name, value, notes, record_date, record_time) VALUES (?, ?, ?, ?, ?)");
} elseif ($type === "vaccination") {
    $value = ""; // enforce blank
    $stmt = $mysqli->prepare("INSERT INTO vaccinations (pet_name, value, notes, record_date, record_time) VALUES (?, ?, ?, ?, ?)");
} else {
    $stmt = $mysqli->prepare("INSERT INTO symptoms (pet_name, value, notes, record_date, record_time) VALUES (?, ?, ?, ?, ?)");
}

if (!$stmt) {
    http_response_code(500);
    echo "SQL prepare error: " . $mysqli->error;
    exit;
}

$stmt->bind_param("sssss", $pet, $value, $notes, $date, $time);

if ($stmt->execute()) {
    echo "Success";
} else {
    http_response_code(500);
    echo "Database error: " . $stmt->error;
}
?>
