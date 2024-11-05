<?php
// Database configuration
$host = 'postgres';
$db = 'phpappdb';
$user = 'pguser';
$pass = 'Welcome123!';
$port = '5432'; // Default PostgreSQL port

try {
    // Establish a connection
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // SQL statement to create the users table
    $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(15) NOT NULL,
            names VARCHAR(50) NOT NULL,
            password VARCHAR(100) NOT NULL,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ";

    // Execute the query
    $pdo->exec($sql);
    echo "Table 'users' created successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null; // Close the connection
?>
