<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: /loginmain.php");
    exit();
}

$pdo = new PDO("mysql:host=db;dbname=mydatabase;charset=utf8", "user", "password");

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->execute([$id]);
$gerecht = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gerecht bewerken</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Bewerk gerecht</h2>
    <form action="/php/update.php" method="POST">
        <input type="hidden" name="id" value="<?= $gerecht['id'] ?>">
        <input type="text" name="naam" value="<?= htmlspecialchars($gerecht['naam']) ?>" required>
        <input type="number" step="0.01" name="prijs" value="<?= $gerecht['prijs'] ?>" required>
        <button type="submit">Opslaan</button>
    </form>
</body>
</html>
 