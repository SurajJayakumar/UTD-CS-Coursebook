<?php
require_once 'sessioncheck.php';
require_once 'login.php';

if ($_SESSION['usertype'] !== 'ADMIN') {
    http_response_code(403);
    die('403 Forbidden - Admins only.');
}

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if ($connection->connect_error) die($connection->connect_error);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userid'];
    $status = $_POST['status'];
    $update_query = "UPDATE user SET userstatus = '$status' WHERE userid = '$userid'";
    $connection->query($update_query);

    if($status=='ACTIVE'){
        $update_query = "UPDATE user SET failed_attempts = 0 WHERE userid = '$userid'";
        $connection->query($update_query);
    }
    echo "<p>User status updated successfully!</p>";
}

// Fetch users
$query = "SELECT userid,firstname,lastname, usertype, userstatus FROM user";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
    
    <h2>Manage Users</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Current Status</th>
            <th>Update Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <form method="post">
                    <td><?php echo htmlspecialchars($row['userid']); ?></td>
                    <td><?php echo htmlspecialchars($row['firstname']." ".$row['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($row['usertype']); ?></td>
                    <td><?php echo htmlspecialchars($row['userstatus']); ?></td>
                    <td>
                        <input type="hidden" name="userid" value="<?php echo $row['userid']; ?>">
                        <select name="status">
                            <option value="ACTIVE">Active</option>
                            <option value="INACTIVE">Inactive</option>
                            <option value="DELETED">Deleted</option>
                            <option value="REVOKED">Revoked</option>
                        </select>
                        <button type="submit">Update</button>
                    </td>
                </form>
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
