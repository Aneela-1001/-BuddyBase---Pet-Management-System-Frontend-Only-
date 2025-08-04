<?php
session_start();
include('databasecon.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$profile_pic_path = '';

// Handle profile picture upload
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['profile_picture']['tmp_name'];
    $file_name = basename($_FILES['profile_picture']['name']);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($file_ext, $allowed)) {
        $target_dir = 'uploads/';
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $new_name = time() . '_' . $file_name;
        $target_file = $target_dir . $new_name;

        if (move_uploaded_file($file_tmp, $target_file)) {
            $profile_pic_path = $target_file;
        }
    }
}

// Update query (with or without profile picture)
if ($profile_pic_path) {
    $sql = "UPDATE users SET phone = ?, address = ?, profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $phone, $address, $profile_pic_path, $user_id);
} else {
    $sql = "UPDATE users SET phone = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $phone, $address, $user_id);
}

$stmt->execute();
$stmt->close();
$conn->close();

header("Location: profile.php");
exit();
?>

