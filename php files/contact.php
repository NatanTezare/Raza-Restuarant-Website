<html style="background-color:#fad78a;">
<?php
session_start();

include 'db_config.php'; // Include your database configuration file

// Get form data
$name = $conn->real_escape_string(trim($_POST['name']));
$email = $conn->real_escape_string(trim($_POST['email']));
$message = $conn->real_escape_string(trim($_POST['message']));
$terms = isset($_POST['terms']) ? $_POST['terms'] : '';

// Basic validation
if (empty($name)) {
    echo 'Please enter your name';
    exit();
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Please enter a valid email address';
    exit();
}

if (empty($message)) {
    echo 'Please enter your message';
    exit();
}

if ($terms !== 'on') {
    echo 'Please accept the Terms of Service';
    exit();
}

// Insert contact message into the database
$sql = "INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo '<div style="
            background-color: #f19c63;
            color: #155724;
            padding: 15px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            text-align: center;
            max-width: 400px;
            margin: 20px auto;
            font-size: 16px;
            font-family: Arial, sans-serif;
        ">Thank you for your message. We will get back to you soon!</div>';
    } else {
        echo '<div style="
             background-color: #f19c63;
            color: #721c24;
            padding: 15px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            text-align: center;
            max-width: 400px;
            margin: 20px auto;
            font-size: 16px;
            font-family: Arial, sans-serif;
        ">Error: ' . $stmt->error . '</div>';
    }

$stmt->close();
$conn->close();
?>
</html>