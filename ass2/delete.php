<?php
require_once 'dbconfig.inc.php';

if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

header("Location: products.php");
exit();
?>
