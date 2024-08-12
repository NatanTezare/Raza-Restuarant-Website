<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant_db";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);
    $guests = trim($_POST['guests']);

    // Basic validation
    if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time) || empty($guests)) {
        echo 'All fields are required.';
        exit();
    }

    // Insert reservation into database
    $query = "INSERT INTO reservations (name, email, phone, date, time, guests) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssi', $name, $email, $phone, $date, $time, $guests);

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reservation Status</title>
        <link rel="stylesheet" href="../css files/styles.css">
    </head>
    <body class="reservation-status-body">
        <div class="reservation-message-container">
            <?php
            if ($stmt->execute()) {
                echo '<h1 class="reservation-message-header">Reservation Successful!</h1>';
                echo '<p class="reservation-message-text">Your table has been reserved successfully. If you want to make another reservation, <a class="reservation-message-link" href="../reservation.html">go back</a>.</p>';
            } else {
                echo '<h1 class="reservation-message-header">Reservation Failed</h1>';
                echo '<p class="reservation-message-text">There was an error making your reservation: ' . $stmt->error . '. Please try again. <a class="reservation-message-link" href="../reservation.html">Go back</a>.</p>';
            }
            $stmt->close();
            $conn->close();
            ?>
        </div>
    </body>
    </html>
    <?php
}
?>
