<?php
try {
    $pdo = new PDO("mysql:host=db;dbname=mydatabase;charset=utf8", "root", "rootpassword");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = (int) $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM menu WHERE id = ?");
        $stmt->execute([$id]);
    }

    header("Location: ../admin.php");

    exit();

} catch (PDOException $e) {
    die("Databasefout: " . $e->getMessage());
}
