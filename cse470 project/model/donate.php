<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "Please log in to make a donation.";
        exit;
    }

    // Validate amount
    if (!is_numeric($amount) || $amount <= 0) {
        echo "Invalid donation amount.";
        exit;
    }

    $user_id = $_SESSION['user_id']; // Get user ID from session

    // Begin transaction to ensure data integrity
    $conn->begin_transaction();

    try {
        // Insert into donation_history
        $stmt = $conn->prepare("INSERT INTO donation_history (user_id, amount) VALUES (?, ?)");
        $stmt->bind_param("id", $user_id, $amount);
        if (!$stmt->execute()) {
            throw new Exception("Error inserting donation history.");
        }
        $stmt->close();

        // Update user's total_donated
        $stmt = $conn->prepare("UPDATE users SET total_donated = total_donated + ? WHERE id = ?");
        $stmt->bind_param("di", $amount, $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Error updating total donations.");
        }
        $stmt->close();

        // Commit transaction
        $conn->commit();

        echo "Donation successfully recorded.";
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}

$conn->close();
?>
