<?php
// View/BackOffice/AffEvenement.php

// 1) Include your database config
require_once 'C:\xampp\htdocs\Projet Web\Config.php';

// 2) Fetch all events
try {
    $pdo = config::getConnexion();
    $stmt = $pdo->query(
        "SELECT 
            ID,
            Titre,
            Description,
            Catégorie,
            `Date & Heure` AS date_heure,
            Lieu,
            id_organisateur
         FROM evenement
         ORDER BY `Date & Heure` DESC"
    );
    $events = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des événements : " . $e->getMessage());
}

// --- Suppression d’un événement ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_btn'])) {
    $deleteId = intval($_POST['delete_id']);
    try {
        $pdo = config::getConnexion();
        $stmt = $pdo->prepare("DELETE FROM evenement WHERE ID = ?");
        $stmt->execute([$deleteId]);
        header("Location: AffEvenement.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la suppression : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestion des Événements</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="sidebar">
    <img src="C:\Users\sodra\OneDrive\Bureau\StartHub.jpg" alt="Logo" class="logo">
    <h2>Menu</h2>
    <ul>
      <li onclick="window.location.href='users.html'">Gestion des utilisateurs</li>
      <li onclick="window.location.href='AffEvenement.php'">Gestion des événements</li>
      <li>Gestion des blogs</li>
      <li>Gestion de paiement</li>
      <li>Gestion de réclamations</li>
    </ul>
  </div>

  <div class="main-content">
    <h1>Liste des événements</h1>
    <table>
      <thead>
        <tr>
          <th>ID Événement</th>
          <th>Titre</th>
          <th>Description</th>
          <th>Catégorie</th>
          <th>Date &amp; Heure</th>
          <th>Lieu</th>
          <th>ID Organisateur</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($events) === 0): ?>
          <tr><td colspan="7">Aucun événement trouvé.</td></tr>
        <?php else: ?>
          <?php foreach ($events as $e): ?>
            <tr>
              <td><?= htmlspecialchars($e['ID']) ?></td>
              <td><?= htmlspecialchars($e['Titre']) ?></td>
              <td><?= htmlspecialchars($e['Description']) ?></td>
              <td><?= htmlspecialchars($e['Catégorie']) ?></td>
              <td><?= htmlspecialchars($e['date_heure']) ?></td>
              <td><?= htmlspecialchars($e['Lieu']) ?></td>
              <td><?= htmlspecialchars($e['id_organisateur']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="buttons">
      <button onclick="window.location.href='AjoutEvenemenet.php'">Ajouter</button>
      <button disabled>Modifier</button>
    </div>

    <h1>Supprimer un événement</h1>
    <!-- Formulaire pour supprimer un événement -->
    <form method="POST">
        <div class="form-group">
            <label for="delete_id">ID à supprimer :</label>
            <!-- Champ select avec texte par défaut -->
            <select name="delete_id" id="delete_id" required>
                <option value="" disabled selected>Choisissez un ID</option>
                <?php foreach ($events as $e): ?>
                    <option value="<?= htmlspecialchars($e['ID']) ?>"><?= htmlspecialchars($e['ID']) ?> - <?= htmlspecialchars($e['Titre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="buttons">
            <button type="submit" name="delete_btn" class="btn-supprimer">Supprimer</button>
        </div>
    </form>
  </div>
</body>
</html>
