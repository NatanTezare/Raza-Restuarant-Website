<!DOCTYPE html>
<html style="background-color:#fad78a;">
<head>
    <title>Login</title>
</head>
<body>
<?php
session_start();
include 'db_config.php'; // Include your database configuration file

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) { // Verify hashed password
            $_SESSION['user_id'] = $user['id'];
            echo "<script>
                sessionStorage.setItem('user_id', '{$user['id']}');
                window.location.href = '../menu.html';
            </script>";
            exit();
        } else {
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
        ">Invalid password. Please try again.</div>';
        }
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
        ">No user found with this email. Please sign up first.</div>';
    }
}
?>
</body>
</html>
