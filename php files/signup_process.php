<!DOCTYPE html>
<html style="background-color:#fad78a;">
<head>
    <title>Sign Up</title>
</head>
<body>
<?php
session_start();
include 'db_config.php'; // Include your database configuration file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; //check password

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists
    $checkQuery = "SELECT * FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param('s', $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Email already exists
        echo '<div style="
            background-color:#f19c63;
            color: #721c24;
            padding: 15px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            text-align: center;
            max-width: 400px;
            margin: 20px auto;
            font-size: 16px;
            font-family: Arial, sans-serif;
        ">Email already exists. Please use a different email.</div>';
    } else {
        // Proceed with insertion
        $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $name, $email, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id; // Set session with user ID
            header('Location: ../menu.html'); // Redirect to menu page
            exit();
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
    }
}
?>
</body>
</html>
