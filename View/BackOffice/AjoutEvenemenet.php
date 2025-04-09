<?php
require_once 'C:\xampp\htdocs\Projet Web\Config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['event-id'];
    $titre = $_POST['title'];
    $description = $_POST['description'];
    $categorie = $_POST['category'];
    $date = $_POST['date'];
    $lieu = $_POST['location'];
    $id_organisateur = $_POST['organizer-id'];

    try {
        $pdo = config::getConnexion();
        $query = "INSERT INTO evenement (ID, Titre, Description, Catégorie, `Date & Heure`, Lieu, id_organisateur)
                  VALUES (:id, :titre, :description, :categorie, :date, :lieu, :id_organisateur)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':id' => $id,
            ':titre' => $titre,
            ':description' => $description,
            ':categorie' => $categorie,
            ':date' => $date,
            ':lieu' => $lieu,
            ':id_organisateur' => $id_organisateur
        ]);
        echo "<script>alert('Événement ajouté avec succès !'); window.location.href='AffEvenement.php';</script>";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un Événement</title>
  <link rel="stylesheet" href="style.css">
  <script>
    function validateForm(event) {
        let isValid = true;
        let errorMessage = '';

        // Clear previous error messages
        document.querySelectorAll('.error').forEach(el => el.textContent = '');

        // Validate ID
        let eventId = document.getElementById('event-id').value;
        if (eventId.trim() === '') {
            document.getElementById('event-id-error').textContent = 'L\'ID de l\'événement est requis.';
            isValid = false;
        }

        // Validate Title
        let title = document.getElementById('title').value;
        if (title.trim() === '') {
            document.getElementById('title-error').textContent = 'Le titre est requis.';
            isValid = false;
        }

        // Validate Description
        let description = document.getElementById('description').value;
        if (description.trim() === '') {
            document.getElementById('description-error').textContent = 'La description est requise.';
            isValid = false;
        }

        // Validate Category
        let category = document.getElementById('category').value;
        if (category.trim() === '') {
            document.getElementById('category-error').textContent = 'La catégorie est requise.';
            isValid = false;
        }

        // Validate Date
        let date = document.getElementById('date').value;
        if (date.trim() === '') {
            document.getElementById('date-error').textContent = 'La date et l\'heure sont requis.';
            isValid = false;
        }

        // Validate Location
        let location = document.getElementById('location').value;
        if (location.trim() === '') {
            document.getElementById('location-error').textContent = 'Le lieu est requis.';
            isValid = false;
        }

        // Validate Organizer ID
        let organizerId = document.getElementById('organizer-id').value;
        if (organizerId.trim() === '') {
            document.getElementById('organizer-id-error').textContent = 'L\'ID de l\'organisateur est requis.';
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission
        }
    }
  </script>
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
    <h1>Ajouter un Événement</h1>
    <form method="POST" onsubmit="validateForm(event)">
      <div class="form-group">
        <label for="event-id">ID Événement :</label>
        <input type="text" id="event-id" name="event-id">
        <span id="event-id-error" class="error" style="color:red;"></span>
      </div>
      <div class="form-group">
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title">
        <span id="title-error" class="error" style="color:red;"></span>
      </div>
      <div class="form-group">
        <label for="description">Description :</label>
        <textarea id="description" name="description"></textarea>
        <span id="description-error" class="error" style="color:red;"></span>
      </div>
      <div class="form-group">
        <label for="category">Catégorie :</label>
        <select id="category" name="category">
          <option value="">-- Choisir une catégorie --</option>
          <option>Entrepreneuriat</option>
          <option>Finance</option>
          <option>Networking</option>
          <option>Autre</option>
        </select>
        <span id="category-error" class="error" style="color:red;"></span>
      </div>
      <div class="form-group">
        <label for="date">Date & Heure :</label>
        <input type="datetime-local" id="date" name="date">
        <span id="date-error" class="error" style="color:red;"></span>
      </div>
      <div class="form-group">
        <label for="location">Lieu :</label>
        <input type="text" id="location" name="location">
        <span id="location-error" class="error" style="color:red;"></span>
      </div>
      <div class="form-group">
        <label for="organizer-id">ID de l'Organisateur :</label>
        <input type="text" id="organizer-id" name="organizer-id">
        <span id="organizer-id-error" class="error" style="color:red;"></span>
      </div>
      <div class="buttons">
        <button type="submit">Publier l'Événement</button>
        <button type="button" onclick="window.location.href='AffEvenement.php'">Retour</button>
      </div>
    </form>
  </div>
</body>
</html>