<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: /loginmain.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=db;dbname=mydatabase;charset=utf8", "root", "rootpassword");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $naam = $_POST['naam'];
        $prijs = $_POST['prijs'];

        $stmt = $pdo->prepare("INSERT INTO menu (naam, prijs) VALUES (?, ?)");
        $stmt->execute([$naam, $prijs]);
    }

    $gerechten = $pdo->query("SELECT * FROM menu")->fetchAll();

} catch (PDOException $e) {
    die("Databasefout: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Welkom in het Admin Paneel</h1>

    <h2>Gerecht Toevoegen</h2>
    <form method="POST">
        <input type="text" name="naam" placeholder="Naam gerecht" required>
        <input type="number" step="0.01" name="prijs" placeholder="Prijs" required>
        <button type="submit">Toevoegen</button>
    </form>

    <h2>Menu</h2>
    <table border="1">
        <tr>
            <th>Naam</th>
            <th>Prijs (€)</th>
            <th>Acties</th>
        </tr>
        <?php foreach ($gerechten as $gerecht): ?>
            <tr>
                <td><?= htmlspecialchars($gerecht['naam']) ?></td>
                <td><?= $gerecht['prijs'] ?></td>
                <td>
                <a href="php/edit.php?id=<?= $gerecht['id'] ?>">✏️</a>
<a href="php/delete.php?id=<?= $gerecht['id'] ?>" onclick="return confirm('Weet je zeker dat je dit gerecht wilt verwijderen?')">❌</a>

                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
