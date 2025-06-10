<?php
session_start();

try {
    $pdo = new PDO("mysql:host=db;dbname=mydatabase;charset=utf8", "root", "rootpassword");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM gebruikers WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $gebruiker = $stmt->fetch();

    if ($gebruiker && $password === $gebruiker['password']) {
        $_SESSION['logged_in'] = true;
        header("Location: /admin.php");
        exit();
    } else {
        echo "Ongeldige inloggegevens.";
    }

} catch (PDOException $e) {
    die("Databasefout: " . $e->getMessage());
}
?>
