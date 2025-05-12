<?php

session_start();
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../controller/UserController.php';
$userController = new UserController();
$userController->login(); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion - StartHUb</title>
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
            <a href="register.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
    Join Now<i class="fa fa-arrow-right ms-3"></i>
</a>
        </div>
    </nav>
    <!-- Navbar End -->
    <div class="container mt-5">
        <h2>Connexion</h2>

        <!-- Formulaire de connexion -->
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <a href="register.php">Créer Votre compte</a>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
        <div class="mt-3">
    <a href="forgot_password.php">Mot de passe oublié ?</a>
</div>

        <!-- Affichage du message d'erreur ou de succès -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                <strong><?php echo $_SESSION['message']; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
    </div>
    <!-- JS Bootstrap & dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   
</body>
</html> 