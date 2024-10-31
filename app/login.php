<?php

//function to check connection
function checkConnection($database, $username, $password)
{
    $serverName = "mssql";

    $connectionOptions = array(
        "Database" => $database,
        "Uid" => $username,
        "PWD" => $password
    );
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    return $conn;
}

// Database connection function
function dbConnect()
{
    $conn = checkConnection("phpappdb", "sa", "Welcome123!");

    //check database connection
    if ($conn === false) {
        //confirm that the database is not missing (if it is running for the first time)
        $conn = checkConnection("master", "sa", "Welcome123!");

        if ($conn === false) {
            error_log(print_r(sqlsrv_errors(), true));
            die("Database connection error.");
        } else {
            header("Location: config.php");
        }

        error_log(print_r(sqlsrv_errors(), true));
        die("Database connection error.");
    }
    return $conn;
}

$conn = dbConnect();

if (isset($_POST['submit'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST['password'];

    // Prepare and execute query with hashed password verification
    $sql = "SELECT password FROM users WHERE username = ?";
    $params = array($username);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        if (password_verify($password, trim($row['password']))) {
            // Password matches
            session_start();
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
    var_dump($params, $stmt, sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC), password_verify($password, trim($row['password'])));
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
        <h1>Welcome to My App</h1>
        <hr>
        <form method="post" action="">
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp"
                    placeholder="Enter Username">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>

            <input class="btn btn-primary" type="submit" name="submit" value="Login"> If you don't have an account <a href="signup.php">Signup</a>
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