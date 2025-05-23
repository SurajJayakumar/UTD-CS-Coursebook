<?php
require_once 'login.php';
$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if ($connection->connect_error) die($connection->connect_error);

session_start();

function sanitize_input($connection, $string) {
    return htmlentities($connection->real_escape_string(stripslashes($string)));
}

function show_login_form($error = '') {
    echo <<<_END
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Login - Course Management</title>
        <link rel="stylesheet" href="task3.css">
    </head>
    <body>
        <header>
            <h1><img src="logo2.svg" alt="The University of Texas at Dallas" />Course Catalog</h1>
        </header>

        <main>
            <section id="login-section">
                <h2>Login to Your Account</h2>
                <form action="loginpage.php" method="post" id="loginForm">
                    <label>Username:<br><input type="text" name="username" required></label><br><br>
                    <label>Password:<br><input type="password" name="password" required></label><br><br>
                    <input class="button" type="submit" value="Log In">
                </form>
                <p style="color:red;">$error</p>
            </section>
        </main>

        <footer>
            <p>&copy; 2025 The University of Texas at Dallas</p>
        </footer>
    </body>
    </html>
_END;
}

function track_failed_login($connection, $userRow) {
    $currentFails = isset($userRow['FAILED_ATTEMPTS']) ? $userRow['FAILED_ATTEMPTS'] : 0;
    $currentFails++;

    $userid = $userRow['USERID'];

    if ($currentFails >= 3) {
        $updateQuery = "UPDATE user SET USERSTATUS='REVOKED', LASTUPDATED=NOW() WHERE USERID='$userid'";
    } else {
        $updateQuery = "UPDATE user SET FAILED_ATTEMPTS='$currentFails', LASTUPDATED=NOW() WHERE USERID='$userid'";
    }

    $connection->query($updateQuery);
}

// Main logic
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = sanitize_input($connection, $_POST['username']);
    $password = sanitize_input($connection, $_POST['password']);

    $query = "SELECT * FROM user WHERE USERID='$username'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);

    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        $salt1 = "qm&h*";
        $salt2 = "pg!@";
        $token = hash('ripemd128', "$salt1$password$salt2");

        if ($token == $row['PASSWORD']|| $row['USERSTATUS']!=='ACTIVE') {
            if ($row['USERSTATUS'] !== 'ACTIVE') {
                show_login_form("Your account status is '{$row['USERSTATUS']}'. Please contact admin.");
                exit;
            }

            $_SESSION['userid'] = $row['USERID'];
            $_SESSION['usertype'] = $row['USERTYPE'];
            $_SESSION['firstname'] = $row['FIRSTNAME'];
            $_SESSION['lastname'] = $row['LASTNAME'];
            $_SESSION['sessionid'] = session_id();

            $userid = $row['USERID'];
            $sessionid = session_id();
            $logintime = date('Y-m-d H:i:s');
            $logQuery = "INSERT INTO userlog (userid, sessionid, logintime) VALUES ('$userid', '$sessionid', '$logintime');";
            $connection->query($logQuery);
            $_SESSION['logid'] = $connection->insert_id;

            if ($row['USERTYPE'] == 'ADMIN') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: task3.php");
            }
            exit;

        } else {
            track_failed_login($connection, $row);
            $remaining_attempts = 2 - $row['FAILED_ATTEMPTS'];
            show_login_form("Invalid username/password. You have $remaining_attempts attempt(s) left.");
            exit;
        }

    } else {
        show_login_form("Invalid username/password combination.");
        exit;
    }
} else {
    show_login_form();
}

$connection->close();
?>
