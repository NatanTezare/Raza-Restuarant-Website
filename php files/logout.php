<?php
session_start();
session_unset();
session_destroy();
header('Location: ../homepage.html'); // Redirect to homepage or another page
exit();
?>
