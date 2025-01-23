<?php
function pdo_connect() {
    $host = 'localhost'; // Ganti sesuai kebutuhan
    $dbname = 'pdocrud'; // Nama database
    $username = 'root'; // Username database
    $password = ''; // Password database
    
    try {
        return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    } catch (PDOException $exception) {
        exit('Failed to connect to database: ' . $exception->getMessage());
    }
}

$pdo = pdo_connect();
if (!$pdo) {
    die('Database connection failed.');
}

function isValidUser($username, $password) {
    $pdo = pdo_connect();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
    $stmt->execute([$username, $password]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
}
?>
