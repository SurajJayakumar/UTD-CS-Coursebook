<?php
// setupusers.php
require_once 'login.php';

// Connect to database
$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if ($connection->connect_error) die($connection->connect_error);

// Salts for password hashing
$salt1 = "qm&h*";
$salt2 = "pg!@";

// Add Admin User
add_user('admin', 'adminpassword', 'ADMIN', 'ACTIVE', 'Admin', 'User', 'admin@example.com');

// Add Normal User
add_user('bsmith', 'mysecret', 'USER', 'ACTIVE', 'Bill', 'Smith', 'bsmith@example.com');

// Add Another User
add_user('pjones', 'acrobat', 'USER', 'ACTIVE', 'Pauline', 'Jones', 'pjones@example.com');

// Add Instructor User
add_user('rkm010300', 'rkm010300', 'ADMIN', 'ACTIVE', 'Richard', 'Min', 'rkm010300@example.com');

// Function to insert user
function add_user($userid, $password, $usertype, $userstatus, $firstname, $lastname, $email) {
    global $connection, $salt1, $salt2;

    // Hash the password
    $token = hash('ripemd128', "$salt1$password$salt2");

    // Prepare timestamps
    $now = date("Y-m-d H:i:s");

    // Prepare statement to prevent SQL injection
    $stmt = $connection->prepare("INSERT INTO user (`USERID`, `PASSWORD`, `USERTYPE`, `USERSTATUS`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `TIMECREATED`, `LASTUPDATED`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssssss', $userid, $token, $usertype, $userstatus, $firstname, $lastname, $email, $now, $now);

    // Execute and check result
    if ($stmt->execute()) {
        echo "User $userid added successfully.<br>";
    } else {
        die("Error adding user $userid: " . $stmt->error);
    }

    $stmt->close();
}

$connection->close();
?>
