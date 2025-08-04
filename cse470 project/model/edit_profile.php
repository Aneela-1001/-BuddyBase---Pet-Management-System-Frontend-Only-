<?php
session_start();
include('databasecon.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current user info
$sql = "SELECT phone, address, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
    <h2>Edit Your Profile</h2>
    <form action="update_contact.php" method="POST" enctype="multipart/form-data">
        <label>Phone:</label><br>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>"><br><br>

        <label>Address:</label><br>
        <textarea name="address"><?= htmlspecialchars($user['address']) ?></textarea><br><br>

        <label>Profile Picture:</label><br>
        <?php if (!empty($user['profile_picture'])): ?>
            <img src="<?= htmlspecialchars($user['profile_picture']) ?>" width="100"><br>
        <?php endif; ?>
        <input type="file" name="profile_picture"><br><br>

        <button type="submit">Update Profile</button>
    </form>
    <a href="profile.php">Back to Profile</a>
</body>
</html>
