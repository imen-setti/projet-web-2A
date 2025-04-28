<?php
require_once 'C:\xampp\htdocs\projet\config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $num_tel = $_POST['num_tel'];
    $sexe = $_POST['sexe'];
    $role = $_POST['role'];

    try {
        $pdo = config::getConnexion();
        $query = "INSERT INTO user (Nom, Prenom, Email, Password, Num_Tél, Sexe, Role)
                  VALUES (:nom, :prenom, :email, :password, :num_tel, :sexe, :role)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':password' => $password,
            ':num_tel' => $num_tel,
            ':sexe' => $sexe,
            ':role' => $role
        ]);
        echo "<script>alert('Utilisateur ajouté avec succès !'); window.location.href='AffUser.php';</script>";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un Utilisateur</title>
  <link rel="stylesheet" href="style.css">
  <script>
    function validateForm(event) {
      let isValid = true;
      document.querySelectorAll('.error').forEach(el => el.textContent = '');

      const nom = document.getElementById('nom').value.trim();
      const prenom = document.getElementById('prenom').value.trim();
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();
      const numTel = document.getElementById('num_tel').value.trim();
      const sexe = document.getElementById('sexe').value;
      const role = document.getElementById('role').value;

      const alphaRegex = /^[A-Za-zÀ-ÿ\s]+$/;
      const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/;
      const phoneRegex = /^[259][0-9]{7}$/;

      if (!alphaRegex.test(nom)) {
        document.getElementById('nom-error').textContent = "Le nom ne doit contenir que des lettres.";
        isValid = false;
      }
      if (!alphaRegex.test(prenom)) {
        document.getElementById('prenom-error').textContent = "Le prénom ne doit contenir que des lettres.";
        isValid = false;
      }
      if (!emailRegex.test(email)) {
        document.getElementById('email-error').textContent = "Email invalide (exemple@gmail.com).";
        isValid = false;
      }
      if (password.length > 8) {
        document.getElementById('password-error').textContent = "Mot de passe max 8 caractères.";
        isValid = false;
      }
      if (!phoneRegex.test(numTel)) {
        document.getElementById('num_tel-error').textContent = "Téléphone invalide (8 chiffres, commence par 2, 5 ou 9).";
        isValid = false;
      }
      if (!sexe) {
        document.getElementById('sexe-error').textContent = "Choisissez un sexe.";
        isValid = false;
      }
      if (!role) {
        document.getElementById('role-error').textContent = "Choisissez un rôle.";
        isValid = false;
      }

      if (!isValid) {
        event.preventDefault();
      }
    }

    function enforceMaxLength(el, maxLength) {
      if (el.value.length > maxLength) {
        el.value = el.value.slice(0, maxLength);
      }
    }

    function blockDigitsInText(e) {
      e.target.value = e.target.value.replace(/[0-9]/g, '');
    }
  </script>
</head>
<body>
  <div class="sidebar">
    <img src="C:\Users\sodra\OneDrive\Bureau\StartHub.jpg" alt="Logo" class="logo">
    <h2>Menu</h2>
    <ul>
      <li onclick="window.location.href='AffUser.php'">Gestion des utilisateurs</li>
      <li onclick="window.location.href='AffEvenement.php'">Gestion des événements</li>
      <li>Gestion des blogs</li>
      <li>Gestion des paiements</li>
      <li>Gestion des réclamations</li>
    </ul>
  </div>

  <div class="main-content">
    <h1>Ajouter un Utilisateur</h1>
    <form method="POST" onsubmit="validateForm(event)">
      <div class="form-group">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" oninput="blockDigitsInText(event)">
        <span id="nom-error" class="error" style="color:red;"></span>
      </div>
      <div class="form-group">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" oninput="blockDigitsInText(event)">
        <span id="prenom-error" class="error" style="color:red;"></span>
      </div>
      <div class="form-group">
        <label for="email">Email :</label>
        <input type="text" id="email" name="email">
        <span id="email-error" class="error" style="color:red;"></span>
      </div>
      <div class="form-group">
        <label for="password">Mot de passe :</label>
        <input type="text" id="password" name="password" oninput="enforceMaxLength(this, 8)">
        <span id="password-error" class="error" style="color:red;"></span>
      </div>
      <div class="form-group">
        <label for="num_tel">Numéro de téléphone :</label>
        <input type="text" id="num_tel" name="num_tel" maxlength="8" oninput="this.value=this.value.replace(/[^0-9]/g,''); enforceMaxLength(this, 8)">
        <span id="num_tel-error" class="error" style="color:red;"></span>
      </div>
      <div class="form-group">
        <label for="sexe">Sexe :</label>
        <select id="sexe" name="sexe">
          <option value="">-- Choisir --</option>
          <option value="Homme">Homme</option>
          <option value="Femme">Femme</option>
          <option value="Autre">Autre</option>
        </select>
        <span id="sexe-error" class="error" style="color:red;"></span>
      </div>
      <div class="form-group">
        <label for="role">Rôle :</label>
        <select id="role" name="role">
          <option value="">-- Choisir --</option>
          <option value="Admin">Admin</option>
          <option value="Client">Client</option>
          <option value="Organisateur">Organisateur</option>
        </select>
        <span id="role-error" class="error" style="color:red;"></span>
      </div>
      <div class="buttons">
        <button type="submit">Ajouter l'Utilisateur</button>
        <button type="button" onclick="window.location.href='AffUser.php'">Retour</button>
      </div>
    </form>
  </div>
</body>
</html>
