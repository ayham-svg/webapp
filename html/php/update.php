<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: ../loginmain.php");
    exit();
}

$pdo = new PDO("mysql:host=db;dbname=mydatabase;charset=utf8", "user", "password");

$id = $_POST['id'];
$naam = $_POST['naam'];
$prijs = $_POST['prijs'];

$stmt = $pdo->prepare("UPDATE menu SET naam = ?, prijs = ? WHERE id = ?");
$stmt->execute([$naam, $prijs, $id]);

// Correct pad naar admin.php
header("Location: ../admin.php");
exit();
?>
