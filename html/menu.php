<?php
$pdo = new PDO("mysql:host=db;dbname=mydatabase;charset=utf8", "user", "password");

// Zoekterm ophalen
$zoekterm = isset($_GET['zoek']) ? $_GET['zoek'] : '';

// SQL-query met zoekfunctie
if ($zoekterm) {
    $stmt = $pdo->prepare("SELECT * FROM menu WHERE naam LIKE ?");
    $stmt->execute(['%' . $zoekterm . '%']);
    $gerechten = $stmt->fetchAll();
} else {
    $gerechten = $pdo->query("SELECT * FROM menu")->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Menu - La Lune French Bistro</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <header>
    <h1>Ons Menu</h1>
    <a href="../index.php" class="hero-button">Terug naar Home</a>
  </header>

  <main class="menu-section">
    <!-- Zoekformulier -->
    <form method="get" style="margin-bottom: 20px;">
      <input type="text" name="zoek" placeholder="Zoek gerecht..." value="<?= htmlspecialchars($zoekterm) ?>" />
      <button type="submit">Zoeken</button>
    </form>

    <?php if (count($gerechten) > 0): ?>
      <?php foreach ($gerechten as $gerecht): ?>
        <div class="menu-item">
          <h2><?= htmlspecialchars($gerecht['naam']) ?> - €<?= number_format($gerecht['prijs'], 2, ',', '.') ?></h2>
        </div>
        <hr>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Geen gerechten gevonden.</p>
    <?php endif; ?>
  </main>

  <footer>
    <p>&copy; <?= date("Y") ?> La Lune French Bistro</p>
  </footer>
</body>
</html>
