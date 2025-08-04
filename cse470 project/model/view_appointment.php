<?php
$id = $_GET['id'] ?? '';

$conn = new mysqli("localhost", "root", "", "bb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!$id || !is_numeric($id)) {
    echo "Invalid appointment ID.";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()):
?>
<h2>Appointment Details</h2>
<p><strong>Owner:</strong> <?= htmlspecialchars($row['owner_name']) ?></p>
<p><strong>Pet:</strong> <?= htmlspecialchars($row['pet_type']) ?></p>
<p><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></p>
<p><strong>Weight:</strong> <?= htmlspecialchars($row['weight']) ?></p>
<p><strong>Date:</strong> <?= htmlspecialchars($row['appointment_date']) ?></p>
<p><strong>Service:</strong> <?= htmlspecialchars($row['service']) ?></p>
<?php else: ?>
<p>Appointment not found.</p>
<?php
endif;

$stmt->close();
$conn->close();
?>