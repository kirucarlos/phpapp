<?php
// Database connection function
function dbConnect()
{
    $serverName = "mssql";

    $connectionOptions = array(
        "Database" => "phpappdb",
        "Uid" => "sa",
        "PWD" => "Welcome123!"
    );
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        error_log(print_r(sqlsrv_errors(), true));
        die("Database connection error.");
    }
    return $conn;
}

$conn = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST['password'];
    $names = $_POST['name'];
    $confirmPassword = $_POST['confirmpassword'];

    // Confirm passwords match
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Check if username already exists
    $sql = "SELECT COUNT(*) AS user_count FROM users WHERE username = ?";
    $params = array($username);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        error_log(print_r(sqlsrv_errors(), true));
        die("Error checking username.");
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($row['user_count'] > 0) {
        die("Username already exists. Please choose a different one.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $sql = "INSERT INTO users (username, names, password) VALUES (?, ?, ?)";
    $params = array($username, $names, $hashedPassword);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        error_log(print_r(sqlsrv_errors(), true));
        die(print_r(sqlsrv_errors(), true));
    }

    header("Location: login.php");
    sqlsrv_free_stmt($stmt);
}
sqlsrv_close($conn);

?>





<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>PHP APP - Login</title>
</head>

<body>


    <div class="container mt-5">
        <h1>Enter Your Details to Sign Up</h1>
        <hr>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username"
                    Required>
            </div>
            <div class="form-group">
                <label for="name">Names</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your names">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                    Required>
            </div>
            <div class="form-group">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword"
                    placeholder="Confirm Password" Required>
            </div>

            <input class="btn btn-primary" type="submit" name="submit" value="Sign Up">
        </form>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>