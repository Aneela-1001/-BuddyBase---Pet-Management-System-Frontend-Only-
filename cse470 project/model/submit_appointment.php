<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $owner = $_POST['ownerName'];
    $petType = $_POST['petType'];
    $phone = $_POST['phone'];
    $weight = $_POST['weight'];
    $date = $_POST['appointmentDate'];
    $service = $_POST['selectedService'];

    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        echo "Please log in to book an appointment.";
        exit;
    }

    $conn = new mysqli("localhost", "root", "", "bb");
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $stmt = $conn->prepare("INSERT INTO appointments (owner_name, pet_type, phone, weight, appointment_date, service, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $owner, $petType, $phone, $weight, $date, $service, $userId);

    if ($stmt->execute()) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            <title>Booking Successful</title>
            <style>
#loadingScreen {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: #F8E7F6;
    color: #333;  /* changed text color to dark for readability */
    font-size: 1.5rem;
    font-weight: bold;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}
                /* Spinner styles */
.spinner {
    margin: 20px 0;
    width: 60px;
    height: 60px;
    border: 6px solid #f3f3f3;
    border-top: 6px solid #6A669D; /* updated color */
    border-radius: 50%;
    animation: spin 1s linear infinite;
}


                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            </style>
        </head>
        <body>
            <div id="loadingScreen">
                Booking successful 🎉 Redirecting to home...
                <div class="spinner"></div>
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 3000);
            </script>
        </body>
        </html>
        <?php
    } else {
        echo "Error booking appointment: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
