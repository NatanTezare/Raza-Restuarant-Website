<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    echo 'Please log in to place an order.';
    header('Location: ../login.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$menu_item = $_POST['menu_item'];
$item_price = $_POST['item_price'];

$query = "INSERT INTO orders (user_id, menu_item, item_price) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('iss', $user_id, $menu_item, $item_price);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
    <link rel="stylesheet" href="../css files/styles.css">
</head>
<body class="order-status-body">
    <div class="order-message-container">
        <?php
        if ($stmt->execute()) {
            echo '<h1 class="order-message-header">Order Placed Successfully!</h1>';
            echo '<p class="order-message-text">Your order has been placed successfully. If you want to order again, <a class="order-message-link" href="../menu.html">go back</a>.</p>';
        } else {
            echo '<h1 class="order-message-header">Order Failed</h1>';
            echo '<p class="order-message-text">There was an error placing your order: ' . $stmt->error . '. Please try again. <a class="order-message-link" href="../menu.html">Go back</a>.</p>';
        }
        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>