<?php
session_start();
$conn = new mysqli("localhost", "root", "", "bb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your donation history.";
    exit;
}

$user_id = $_SESSION['user_id']; // Get user ID from session

// Get donation history for the user
$stmt = $conn->prepare("SELECT amount, donated_at FROM donation_history WHERE user_id = ? ORDER BY donated_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation History</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.html">Buddy Base</a>

            <div class="input-group">

            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">

                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav flex-column">
                        <div class="sb-sidenav-menu-heading text-uppercase small">Account</div>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a class="nav-link text-white" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a>
                            <a class="nav-link text-white" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
                        <?php else: ?>
                            <a class="nav-link text-white" href="login.html"><i class="fas fa-sign-in-alt me-2"></i>Login</a>
                            <a class="nav-link text-white" href="register.html"><i class="fas fa-user-plus me-2"></i>Register</a>
                        <?php endif; ?>

                        <div class="sb-sidenav-menu-heading text-uppercase small">Pet Features</div>
                        <a class="nav-link text-white" href="#"><i class="fas fa-paw me-2"></i>Pet Adoption</a>
                        <a class="nav-link text-white" href="food.html"><i class="fas fa-bone me-2"></i>Pet Food</a>
                        <a class="nav-link text-white" href="#"><i class="fas fa-capsules me-2"></i>Supplements</a>
                        <a class="nav-link text-white" href="#"><i class="fas fa-video me-2"></i>Training</a>
                        <a class="nav-link text-white" href="donate.html"><i class="fas fa-donate me-2"></i>Donation</a>
                        <a class="nav-link text-white" href="#"><i class="fas fa-home me-2"></i>Daycare</a>
                        <a class="nav-link text-white" href="#"><i class="fas fa-notes-medical me-2"></i>Appointments</a>
                        <a class="nav-link text-white" href="#"><i class="fas fa-comments me-2"></i>Vet Chat</a>
                        <a class="nav-link text-white" href="groom1.html"><i class="fas fa-cut me-2"></i>Grooming</a>
                        <a class="nav-link text-white" href="#"><i class="fas fa-chart-line me-2"></i>Activity</a>
                        <a class="nav-link text-white" href="donation_history.php"><i class="fas fa-exclamation-triangle me-2"></i>Abuse Alerts</a>
                        <a class="nav-link text-white" href="#"><i class="fas fa-heartbeat me-2"></i>Health</a>
                    </div>
                </div>
                <div class="sb-sidenav-footer text-white small">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        Logged in as: <?= $_SESSION['first_name'] ?> <?= $_SESSION['last_name'] ?>
                    <?php else: ?>
                        Logged out
                    <?php endif; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Your Donation History</h1>
                    <ol class="breadcrumb mb-4"></ol>

                    <?php if ($result->num_rows > 0): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Amount Donated</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['amount']); ?> USD</td>
                                        <td><?php echo htmlspecialchars($row['donated_at']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No donations found.</p>
                    <?php endif; ?>

                    <a href="donate.html" class="btn btn-primary mt-4">Make a Donation</a>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto"></footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
