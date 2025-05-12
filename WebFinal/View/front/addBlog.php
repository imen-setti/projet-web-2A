<?php
session_start(); // Ensure the session is started
// Check if the user is logged in
if (!isset($_SESSION['user'])) {
  header("Location: login.php"); // Redirect to the login page
  exit();
}
require_once(__DIR__ . '/../../model/Blog.php');
require_once(__DIR__ . '/../../config/connexion.php'); // Include the database connection file

$errors = [];
$titre = $auteur = $date_creation = $contenu = $image = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_SESSION['user']['id']; // Get the user_id from the session
    $titre = trim($_POST['titre']);
    $auteur = trim($_POST['auteur']);
    $date_creation = $_POST['date_creation'];
    $contenu = trim($_POST['contenu']);

    // ✅ VALIDATION
    if (!preg_match('/^[a-zA-Z\s]+$/', $titre)) {
        $errors['titre'] = "Le titre ne doit contenir que des lettres et espaces.";
    }
    if (!preg_match('/^[a-zA-Z\s]+$/', $auteur)) {
        $errors['auteur'] = "L'auteur doit contenir uniquement des lettres et espaces.";
    }
    if (empty($date_creation)) {
        $errors['date_creation'] = "La date est obligatoire.";
    }
    if (strlen($contenu) < 50) {
        $errors['contenu'] = "Le contenu doit faire au moins 50 caractères.";
    }

    // ✅ TRAITEMENT DE L'IMAGE
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = uniqid("blog_", true) . '.' . $extension;
        $target = __DIR__ . '/../../back/uploads/' . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = ""; // or default image
    }

    // ✅ AJOUT DANS LA BDD SI PAS D'ERREURS
    if (empty($errors)) {
        $blog = new Blog($id_user, $titre, $auteur, $date_creation, $image, $contenu);
        $blog->ajouterBlog();
        header("Location: Blog.php"); // Redirect after success
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-10">
    <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-briefcase me-3"></i>StartHUb</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link active">Home</a>
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

            <?php if (isset($_SESSION['user'])): ?>
            <div class="nav-item nav-link d-flex align-items-center">

                <div class="avatar me-2 d-flex justify-content-center align-items-center"
                    style="width: 30px; height: 30px; border-radius: 50%; background-color: #007bff; color: white; font-weight: bold;">
                    <?= strtoupper(substr($_SESSION['user']['prenom'], 0, 1)) . strtoupper(substr($_SESSION['user']['nom'], 0, 1)) ?>
                </div>
                <span><strong><?= htmlspecialchars($_SESSION['user']['prenom']) . ' ' . htmlspecialchars($_SESSION['user']['nom']) ?></strong></span>
            </div>
            <a href="logout.php" class="nav-item nav-link">Déconnexion</a>
            <?php else: ?>
            <a href="login.php" class="nav-item nav-link">Connexion</a>
            <?php endif; ?>


        </div>
</nav>

<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="text-black text-capitalize m-0">Ajouter un Blog</h5>
                <a href="blog.php" class="btn btn-sm btn-light text-dark font-weight-bold">�� Voir la liste</a>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">

                    <!-- Titre -->
                    <div class="mb-3">
                        <label class="form-label">Titre :</label>
                        <input type="text" name="titre" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>">
                        <?php if (isset($errors['titre'])): ?>
                        <div class="text-danger"><?= $errors['titre'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Auteur -->
                    <div class="mb-3">
                        <label class="form-label">Auteur :</label>
                        <input type="text" name="auteur" value="<?= htmlspecialchars($_POST['auteur'] ?? '') ?>">
                        <?php if (isset($errors['auteur'])): ?>
                        <div class="text-danger"><?= $errors['auteur'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Date de création -->
                    <div class="mb-3">
                        <label class="form-label">Date de création :</label>
                        <input type="date" name="date_creation"
                            value="<?= htmlspecialchars($_POST['date_creation'] ?? '') ?>">
                        <?php if (!empty($errors['date_creation'])): ?>
                        <div class="text-danger"><?= $errors['date_creation'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Image -->
                    <div class="mb-3">
                        <label class="form-label">Image :</label>
                        <input type="file" name="image" accept="image/*">
                        <?php if (!empty($errors['image'])): ?>
                        <div class="text-danger"><?= $errors['image'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Contenu -->
                    <div class="mb-3">
                        <label class="form-label">Contenu :</label>
                        <textarea name="contenu" rows="5"><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
                        <?php if (!empty($errors['contenu'])): ?>
                        <div class="text-danger"><?= $errors['contenu'] ?></div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-dark">➕ Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>