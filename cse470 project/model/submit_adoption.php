<?php
include('databasecon.php');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form values
$full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$pet_id = isset($_POST['pet_id']) ? $_POST['pet_id'] : '';
$reason = isset($_POST['reason']) ? $_POST['reason'] : '';


// Insert into database
$stmt = $conn->prepare("INSERT INTO adoption_requests (full_name, email, phone, pet_id, reason, status) VALUES (?, ?, ?, ?, ?, 'pending')");
$stmt->bind_param("sssss", $full_name, $email, $phone, $pet_id, $reason);

if ($stmt->execute()) {
  echo "Adoption request submitted successfully!";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();

$conn->close();
?>
