<?php
// View/BackOffice/AffUser.php

require_once 'C:\xampp\htdocs\projet\config.php';

try {
    $pdo = config::getConnexion();
    $stmt = $pdo->query(
        "SELECT 
            Nom,
            Prenom,
            Email,
            Password,
            Num_Tél,
            Sexe,
            Role
         FROM user"
    );
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestion des Utilisateurs</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="sidebar">
    <img src="C:\Users\sodra\OneDrive\Bureau\StartHub.jpg" alt="Logo" class="logo">
    <h2>Menu</h2>
    <ul>
      <li onclick="window.location.href='AffUser.php'">Gestion des utilisateurs</li>
      <li onclick="window.location.href='AffEvenement.php'">Gestion des événements</li>
      <li>Gestion des blogs</li>
      <li>Gestion de paiement</li>
      <li>Gestion de réclamations</li>
    </ul>
  </div>

  <div class="main-content">
    <h1>Liste des utilisateurs</h1>
    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Email</th>
          <th>Mot de passe</th>
          <th>Numéro de téléphone</th>
          <th>Sexe</th>
          <th>Rôle</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($users) === 0): ?>
          <tr><td colspan="7">Aucun utilisateur trouvé.</td></tr>
        <?php else: ?>
          <?php foreach ($users as $u): ?>
            <tr>
              <td><?= htmlspecialchars($u['Nom']) ?></td>
              <td><?= htmlspecialchars($u['Prenom']) ?></td>
              <td><?= htmlspecialchars($u['Email']) ?></td>
              <td><?= htmlspecialchars($u['Password']) ?></td>
              <td><?= htmlspecialchars($u['Num_Tél']) ?></td>
              <td><?= htmlspecialchars($u['Sexe']) ?></td>
              <td><?= htmlspecialchars($u['Role']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="buttons">
      <button onclick="window.location.href='AjoutUser.php'">Ajouter</button>
      <button disabled>Modifier</button>
      <button disabled>Supprimer</button>
    </div>
  </div>
</body>
</html>
