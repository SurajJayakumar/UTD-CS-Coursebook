<?php
require_once 'sessioncheck.php';

// Only allow admins
if ($_SESSION['usertype'] !== 'ADMIN') {
    http_response_code(403);
    die('403 Forbidden - Admins only.');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="task3.css">
</head>
<body>
    <header style="text-align: left;">
    <h2>Welcome, Administrator!</h2>
    <form method="post" action="logout.php" style="text-align:right;">
        <button class="button" type="submit">Logout</button>
    </form>
</header>
    <br></br>
    <a href="admin_manage_users.php" class="button" style="margin-left:20px;background-color: #C75B12;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;text-decoration: none;margin-top: 20px;" >Manage Users</a>
    <a class="button" href="admin_user_log.php" style="margin-left:20px;background-color: #C75B12;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;text-decoration: none;margin-top: 20px;">View User Log</a>
    

</body>
</html>
