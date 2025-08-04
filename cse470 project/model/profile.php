<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

// Include database connection
$mysqli = new mysqli('localhost', 'root', '', 'bb');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}
// Fetch the user's data from the database
$user_id = $_SESSION['user_id'];
$stmt = $mysqli->prepare("SELECT first_name, last_name, email, address, phone, profile_picture FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($first_name, $last_name, $email, $address, $phone, $profile_picture);
$stmt->fetch();
$appointment_stmt = $mysqli->prepare("SELECT service, appointment_date FROM appointments WHERE user_id = ?");
$appointment_stmt->bind_param("i", $user_id);
$appointment_stmt->execute();
$result = $appointment_stmt->get_result();

$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}
$appointment_stmt->close();


$stmt->close();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Prepare the update statement
    $stmt = $mysqli->prepare("UPDATE users SET address = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("ssi", $address, $phone, $user_id);
    
    if ($stmt->execute()) {
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buddy Base Profile</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .hero-section {
      position: relative;
      height: 100vh;
      overflow: hidden;
    }

    .hero-section video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
    }

    .hero-section h1 {
      position: relative;
      z-index: 1;
      color: white;
      font-size: 3rem;
      text-align: center;
      top: 40%;
    }

    .footer {
      background-color: #343a40;
      color: white;
      padding-top: 30px;
      padding-bottom: 30px;
    }

    .footer h5 {
      font-weight: bold;
    }

    .footer .social-icons a {
      color: white;
      margin-right: 10px;
    }

    .footer .social-icons a:hover {
      color: #007bff;
    }
  </style>
</head>
<body>

  <!-- Layout Wrapper -->
  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div id="layoutSidenav_nav" class="sb-sidenav bg-dark text-white p-3">
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
            <!-- Add your other links here -->
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
            <a class="nav-link text-white" href="profile.php"><i class="fas fa-exclamation-triangle me-2"></i>Abuse Alerts</a>
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

    <!-- Main Content -->
    <div class="content-wrapper container-fluid p-4">


      </button>


      <!-- Profile Details -->
      <div class="row mt-4">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">Profile Information</h3>
			                  <!-- Display Profile Picture if Available -->
                <?php if ($profile_picture): ?>
                    <p><strong>Profile Picture:</strong></p>
                    <img src="<?= htmlspecialchars($profile_picture) ?>" alt="Profile Picture" class="img-fluid" style="max-width: 200px;">
                <?php endif; ?>
              <p><strong>First Name:</strong> <?= htmlspecialchars($first_name) ?></p>
              <p><strong>Last Name:</strong> <?= htmlspecialchars($last_name) ?></p>
              <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
              <p><strong>Address:</strong> <?= htmlspecialchars($address) ?: 'Not provided' ?></p>
              <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?: 'Not provided' ?></p>
			  					<h4 class="mt-4">Grooming Appointments Made For Buddy</h4>
<?php if (!empty($appointments)): ?>
    <ul class="list-group">
        <?php foreach ($appointments as $appt): ?>
            <li class="list-group-item">
                <strong><?= htmlspecialchars($appt['service']) ?></strong><br>
                Date: <?= htmlspecialchars($appt['appointment_date']) ?> | 

            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No appointment history found.</p>
<?php endif; ?>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">

              <form action="edit_profile.php" method="POST">

                <button type="submit" class="btn btn-primary">Edit Profile</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <h5>Buddy Base 🐾</h5>
          <p>Buddy Base is your trusted companion for all pet-related needs, offering services from adoption to health monitoring, ensuring your pet's well-being is always our priority.</p>
        </div>
        <div class="col-md-3">
          <h6>About</h6>
          <ul class="list-unstyled">
            <li><a href="about.html" class="text-white">About Us</a></li>
            <li><a href="#" class="text-white" onclick="toggleContact()">Contact</a></li>
            <li><a href="#" class="text-white">FAQs</a></li>
            <li><a href="#" class="text-white">Blog</a></li>
          </ul>
          <div id="contactInfo" style="display: none;" class="mt-2 text-white small">
            📞 (+88) 01322 908 241<br>📧 supportbuddybase@gmail.com
          </div>
        </div>
        <div class="col-md-3">
          <h6>Policies</h6>
          <ul class="list-unstyled">
            <li><a href="privacypolicy.html" class="text-white">Privacy Policy</a></li>
            <li><a href="#" class="text-white">Terms of Use</a></li>
            <li><a href="#" class="text-white">Refund Policy</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h6>Location</h6>
          <p>📍 Zakir Complex, Kuril Chowrasta, Dhaka-1229</p>
          <a class="btn btn-outline-light btn-sm" href="https://www.google.com/maps/place/AmarPet/@23.8158517,90.4221124" target="_blank">Get Directions</a>
          <div class="social-icons mt-3">
            <a href="https://www.facebook.com" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white me-2"><i class="fab fa-youtube"></i></a>
            <a href="#" class="text-white"><i class="fab fa-tiktok"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script>
    function toggleContact() {
      const contact = document.getElementById("contactInfo");
      contact.style.display = contact.style.display === "none" ? "block" : "none";
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>