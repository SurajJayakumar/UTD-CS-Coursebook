<?php
require_once 'sessioncheck.php';
require_once 'login.php';

if ($_SESSION['usertype'] !== 'ADMIN') {
    http_response_code(403);
    die('403 Forbidden - Admins only.');
}

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if ($connection->connect_error) die($connection->connect_error);

$query = "SELECT  userid, logintime, logouttime, sessionid FROM userlog ORDER BY logintime DESC";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html>
<head>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Activity Log</title>
    <link rel="stylesheet" href="task3.css">
    <style>
        table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: white;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
th, td {
    border: 1px solid #ddd;
    padding: 12px 15px;
    text-align: left;
}
th {
    background-color: #C75B12;
    color: white;
}
tr:nth-child(even) {
    background-color: #f9f9f9;
}
select, button {
    padding: 5px;
    border-radius: 4px;
    border: 1px solid #ccc;
}
button {
    background-color: #006341;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}
button:hover {
    background-color: #004d31;
}
a {
    display: inline-block;
    margin-top: 20px;
    text-decoration: none;
    color: #006341;
}
a:hover {
    text-decoration: underline;
}
p {
    margin-top: 20px;
}
</style>
</head>
<body>
    <h2>User Login/Logout Log</h2>
    <table border="1" cellpadding="5">
        <tr>
            
            <th>User ID</th>
            <th>Login Time</th>
            <th>Logout Time</th>
            <th>Session ID</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['userid']); ?></td>
                <td><?php echo htmlspecialchars($row['logintime']); ?></td>
                <td><?php echo htmlspecialchars($row['logouttime'] ?: '---'); ?></td>
                <td><?php echo htmlspecialchars($row['sessionid']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="admin_dashboard.php">Back to Admin Dashboard</a>
</body>
</html>

<?php
$connection->close();
?>