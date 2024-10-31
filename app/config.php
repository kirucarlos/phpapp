<?php
// Database connection parameters
$serverName = "mssql";

$connectionOptions = array(
    "Database" => "master",
    "Uid" => "sa",
    "PWD" => "Welcome123!"
);

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Create database if it does not exist
$dbName = "phpappdb";
$sqlCreateDatabase = "IF NOT EXISTS (SELECT name FROM sys.databases WHERE name = '$dbName') 
                       CREATE DATABASE [$dbName]";

$stmt = sqlsrv_query($conn, $sqlCreateDatabase);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
sqlsrv_free_stmt($stmt);

// Switch to the new database
$connectionOptions['Database'] = $dbName;
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Check connection
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Create users table if it does not exist
$sqlCreateTable = "
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'dbo.users') AND type in (N'U'))
BEGIN
    CREATE TABLE [dbo].[users] (
        [id] INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
        [username] NCHAR(15) NOT NULL,
        [names] NCHAR(50) NULL,
        [password] NCHAR(100) NULL,
        [timestamp] DATETIME NOT NULL DEFAULT GETDATE()
    )
END
";

$stmt = sqlsrv_query($conn, $sqlCreateTable);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

// Redirect to login page
header("Location: login.php");
exit();
