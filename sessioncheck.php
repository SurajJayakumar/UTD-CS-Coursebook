<?php
session_start();

if (!isset($_SESSION['userid'])) {
    // User is not logged in
    http_response_code(403);
    die("403 Forbidden: Access denied. Please <a href='loginpage.php'>log in</a>.");
}
?>
