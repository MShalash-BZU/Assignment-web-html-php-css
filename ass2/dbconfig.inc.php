<?php
$host = 'localhost';
$dbname = 'web1220920_clothingstore'; 
$user = 'root';
$pass = '';

try {
    $pdo = new PDO(
        "mysql:host=".$host.";dbname=".$dbname,
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>