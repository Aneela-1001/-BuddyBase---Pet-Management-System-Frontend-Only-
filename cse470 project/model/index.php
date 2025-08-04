<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buddy Base Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .cart-icon {
      position: fixed;
      top: 10px;
      right: 10px;
      background-color: #ffffff;
      padding: 6px 12px;
      border-radius: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.15);
      font-weight: bold;
      text-decoration: none;
      color: #333;
      z-index: 9999;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .cart-icon i {
      font-size: 20px;
      transition: color 0.3s ease;
    }

    .cart-icon i:hover {
      color: #007bff;
    }

    .cart-icon span {
      background-color: red;
      color: white;
      border-radius: 50%;
      padding: 2px 6px;
      font-size: 0.9em;
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
      pointer-events: none;
    }

    .hero-section h1 {
      position: relative;
      z-index: 1;
      color: white;
      font-size: 3rem;
      font-weight: bold;
      text-align: center;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
      top: 40%;
    }

    .footer {
      background-color: #343a40;
      color: white;
      padding-top: 30px;
      padding-bottom: 30px;
      margin-top: 50px;
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
  <div class="d-flex" id="wrapper">
    <div id="layoutSidenav_nav" class="sb-sidenav bg-dark text-white p-3">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav flex-column">
            <div class="sb-sidenav-menu-heading text-uppercase small">Account</div>
            <div class="nav-link dropdown-toggle text-white" data-bs-toggle="collapse" href="#accountMenu" role="button" aria-expanded="false" aria-controls="accountMenu">
              <i class="fas fa-user-circle me-2"></i>Account Options
            </div>
            <div class="collapse" id="accountMenu">
              <div class="list-group list-group-flush">
                <a class="nav-link text-white ps-4" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                  <a class="nav-link text-white ps-4" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
                <?php else: ?>
                  <a class="nav-link text-white ps-4" href="login.html"><i class="fas fa-sign-in-alt me-2"></i>Login</a>
                  <a class="nav-link text-white ps-4" href="register.html"><i class="fas fa-user-plus me-2"></i>Register</a>
                <?php endif; ?>
              </div>
            </div>

            <div class="sb-sidenav-menu-heading text-uppercase small">Pet Features</div>
            <a class="nav-link text-white" href="pets.html"><i class="fas fa-paw me-2"></i>Our pets</a>
            <a class="nav-link text-white" href="adoption.html"><i class="fas fa-paw me-2"></i>Pet Adoption</a>
            <a class="nav-link text-white" href="food.html"><i class="fas fa-bone me-2"></i>Pet Food</a>
            <a class="nav-link text-white" href="accessories1.html"><i class="fas fa-capsules me-2"></i>Accessories</a>
            <a class="nav-link text-white" href="pet_training.html"><i class="fas fa-video me-2"></i>Training</a>
            <a class="nav-link text-white" href="donate.html"><i class="fas fa-donate me-2"></i>Donation</a>
            <a class="nav-link text-white" href="donation_history.php"><i class="fas fa-donate me-2"></i>Donation History</a>
            <a class="nav-link text-white" href="notification.html"><i class="fas fa-notes-medical me-2"></i>Notifications</a>
            <a class="nav-link text-white" href="#"><i class="fas fa-cut me-2"></i>Post</a>
            <a class="nav-link text-white" href="health.html"><i class="fas fa-cut me-2"></i>Health</a>
            <a class="nav-link text-white" href="abuse_and_rescue.html"><i class="fas fa-exclamation-triangle me-2"></i>Abuse and Rescue Alerts</a>
            
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

    <div class="content-wrapper container-fluid p-4">
      <button class="sidebar-toggle-btn" id="sidebarToggleBtn">
        <i class="fas fa-bars"></i>
      </button>

      <div class="hero-section">
        <video autoplay loop muted playsinline>
          <source src="assets/catvideo.mp4" type="video/mp4" />
          Your browser does not support the video tag.
        </video>
        <h1>Welcome to Buddy Base</h1>
      </div>

      <a href="cart.html" class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
        <span id="cart-count">0</span>
      </a>

      <div class="row mt-4 justify-content-center">
        <div class="col-md-6 text-center">
          <h5 style="font-size: 1.5rem; font-weight: 600;"> 🐾𝑩𝒖𝒅𝒅𝒚 𝑩𝒂𝒔𝒆 🐾</h5>
          <p style="font-size: 1rem;">Buddy Base is your trusted companion for all pet-related needs, offering services from adoption to health monitoring, ensuring your pet's well-being is always prioritized.</p>
        </div>
      </div>

      <footer class="footer">
        <div class="container">
          <div class="row">
            <div class="col-md-3">
              <div class="newsletter">
                <input type="email" class="form-control mt-2" placeholder="Subscribe to our newsletter">
              </div>
            </div>
            <div class="col-md-3">
              <h6>About</h6>
              <ul class="list-unstyled">
                <li><a href="about.html" class="text-white">About Us</a></li>
                <li><a href="#" class="text-white" onclick="toggleContact()">Contact</a></li>
                <li><a href="#" class="text-white">FAQs</a></li>
              </ul>
              <div id="contactInfo" style="display: none;" class="mt-2 text-white small">
                📞 (+88) 01322 908 241<br>📧 supportbuddybase@gmail.com
              </div>
            </div>
            <div class="col-md-3">
              <h6>Policies</h6>
              <ul class="list-unstyled">
                <li><a href="privacy policy.html" class="text-white">Privacy Policy</a></li>
                <li><a href="terms of use.html" class="text-white">Terms of Use</a></li>
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
    </div>
  </div>

  <script>
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebar = document.getElementById('layoutSidenav_nav');
    sidebarToggleBtn.addEventListener('click', () => sidebar.classList.toggle('collapsed'));

    function toggleContact() {
      const contact = document.getElementById("contactInfo");
      contact.style.display = contact.style.display === "none" ? "block" : "none";
    }

    function updateCartCount() {
      const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
      const cartCountElement = document.getElementById("cart-count");
      if (cartCountElement) {
        cartCountElement.textContent = cartItems.length;
        cartCountElement.style.display = cartItems.length > 0 ? "inline" : "none";
      }
    }

    updateCartCount();

    window.addEventListener("pageshow", updateCartCount);
    window.addEventListener("storage", updateCartCount);
  </script>

  <script src="//code.tidio.co/vlyplqqeaf1xyccgbepwdwhtl20kptcb.js" async></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



