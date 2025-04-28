<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
    <title>StartHUb</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
  <!-- CSS Bootstrap -->


  <style>
    .error {
      color: red;
      font-size: 0.9em;
    }
  </style>
</head>
<body>
    

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-briefcase me-3"></i>StartHUb</h2>

        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="#" class="nav-item nav-link">About</a>
                <a href="evenement.php" class="nav-item nav-link">Evènement</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="#" class="dropdown-item">Our Team</a>
                        <a href="#" class="dropdown-item">Testimonial</a>
                        <a href="#" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="#" class="nav-item nav-link">Contact</a>
            </div>
            <a href="register.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->
  <!-- Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="registerForm" action="register.php" method="POST" novalidate>
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalLabel">Inscription</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <input type="text" id="nom" name="nom" class="form-control" placeholder="Nom">
            <span class="error" id="errorNom"></span>
          </div>
          <div class="mb-3">
            <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Prénom">
            <span class="error" id="errorPrenom"></span>
          </div>
          <div class="mb-3">
            <input type="email" id="email" name="email" class="form-control" placeholder="Email">
            <span class="error" id="errorEmail"></span>
          </div>
          <div class="mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe">
            <span class="error" id="errorPassword"></span>
          </div>
          <div class="mb-3">
            <input type="text" id="numtel" name="numtel" class="form-control" placeholder="Téléphone (+XXX XXXXXXXX)">
            <span class="error" id="errorNumtel"></span>
          </div>
          <div class="mb-3">
            <select id="sexe" name="sexe" class="form-select">
              <option value="">Sélectionnez le sexe</option>
              <option value="Homme">Homme</option>
              <option value="Femme">Femme</option>
            </select>
            <span class="error" id="errorSexe"></span>
          </div>
          <div class="mb-3">
            <select id="role" name="role" class="form-select">
              <option value="">Sélectionnez le rôle</option>
              <option value="admin">Admin</option>
              <option value="enseignant">Client</option>
              <option value="etudiant">Organisateur</option>
            </select>
            <span class="error" id="errorRole"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" name="submit" class="btn btn-primary">S'inscrire</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JS Bootstrap & dépendances -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script de validation -->
<script>
  document.getElementById('registerForm').addEventListener('submit', function(event) {
    // Réinitialiser les messages d'erreur
    document.getElementById('errorNom').textContent = "";
    document.getElementById('errorPrenom').textContent = "";
    document.getElementById('errorEmail').textContent = "";
    document.getElementById('errorPassword').textContent = "";
    document.getElementById('errorNumtel').textContent = "";
    document.getElementById('errorSexe').textContent = "";
    document.getElementById('errorRole').textContent = "";

    let valid = true;

    // Récupération des valeurs
    const nom = document.getElementById('nom').value.trim();
    const prenom = document.getElementById('prenom').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const numtel = document.getElementById('numtel').value.trim();
    const sexe = document.getElementById('sexe').value;
    const role = document.getElementById('role').value;

    // Expressions régulières pour la validation
    const nameRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/;
    const emailRegex = /^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/;
    const phoneRegex = /^\+\d{3}\s\d{8}$/;

    // Validation du nom
    if (nom === "") {
      document.getElementById('errorNom').textContent = "Ce champ est obligatoire.";
      valid = false;
    } else if (!nameRegex.test(nom)) {
      document.getElementById('errorNom').textContent = "Le nom ne doit contenir que des lettres.";
      valid = false;
    }

    // Validation du prénom
    if (prenom === "") {
      document.getElementById('errorPrenom').textContent = "Ce champ est obligatoire.";
      valid = false;
    } else if (!nameRegex.test(prenom)) {
      document.getElementById('errorPrenom').textContent = "Le prénom ne doit contenir que des lettres.";
      valid = false;
    }

    // Validation de l'email
    if (email === "") {
      document.getElementById('errorEmail').textContent = "Ce champ est obligatoire.";
      valid = false;
    } else if (!emailRegex.test(email)) {
      document.getElementById('errorEmail').textContent = "Veuillez entrer un email valide.";
      valid = false;
    }

    // Validation du mot de passe
    if (password === "") {
      document.getElementById('errorPassword').textContent = "Ce champ est obligatoire.";
      valid = false;
    } else if (password.length < 6) {
      document.getElementById('errorPassword').textContent = "Le mot de passe doit contenir au moins 6 caractères.";
      valid = false;
    }

    // Validation du numéro de téléphone
    if (numtel === "") {
      document.getElementById('errorNumtel').textContent = "Ce champ est obligatoire.";
      valid = false;
    } else if (!phoneRegex.test(numtel)) {
      document.getElementById('errorNumtel').textContent = "Le numéro doit être au format +XXX XXXXXXXX.";
      valid = false;
    }

    // Validation du sexe
    if (sexe === "") {
      document.getElementById('errorSexe').textContent = "Ce champ est obligatoire.";
      valid = false;
    }

    // Validation du rôle
    if (role === "") {
      document.getElementById('errorRole').textContent = "Ce champ est obligatoire.";
      valid = false;
    }

    // Empêcher l'envoi du formulaire en cas d'erreur
    if (!valid) {
      event.preventDefault();
    }
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var registerModal = new bootstrap.Modal(document.getElementById('registerModal'), {
      keyboard: false
    });
    registerModal.show();
  });
</script>

</body>
</html>


<?php
// Si le formulaire est soumis
if (isset($_POST['submit'])) {
    require_once __DIR__ . '/../../controller/UserController.php';

    // Création de l'objet utilisateur avec les données du formulaire
    $user = new User($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['password'], $_POST['numtel'], $_POST['sexe'], $_POST['role']);
    $controller = new UserController();
    
    // Ajouter l'utilisateur
    $controller->ajouterUser($user);

    // Affichage du message de succès
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; width: 300px;">
            <strong>Succès!</strong> Votre compte a été créé avec succès.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';

    // Redirection vers la page index.php après 3 secondes
    echo '<script>
            setTimeout(function() {
                window.location.href = "index.php";
            }, 3000);
          </script>';

    exit(); // Arrête l'exécution du script
}
?>


<<<<<<< HEAD
=======

>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
