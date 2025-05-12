<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>


<?php 
session_start();

?>
    <!-- Navbar Start -->
   <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-briefcase me-3"></i>StartHUb</h2>
    </a>
    <button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link">Home</a>
            <a href="#" class="nav-item nav-link">About</a>
            <a href="evenement.php" class="nav-item nav-link active">Evènement</a>
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Pages</a>
                <div class="dropdown-menu fade-down m-0">
                    <a class="dropdown-item" href="#">Our Team</a>
                    <a class="dropdown-item" href="#">Testimonial</a>
                    <a class="dropdown-item" href="#">404 Page</a>
                </div>
            </div>
            <a href="#" class="nav-item nav-link">Contact</a>

            <?php if (isset($_SESSION['user'])): ?>
                <div class="nav-item nav-link d-flex align-items-center">
                    <div class="rounded-circle me-2 d-flex justify-content-center align-items-center"
                         style="width:30px; height:30px; background-color:#007bff; color:#fff; font-weight:bold;">
                        <?= strtoupper(substr($_SESSION['user']['prenom'],0,1) . substr($_SESSION['user']['nom'],0,1)) ?>
                    </div>
                    <span><strong>
                        <?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?>
                    </strong></span>
                </div>
                <a href="logout.php" class="nav-item nav-link">Déconnexion</a>
            <?php else: ?>
                <a href="login.php" class="nav-item nav-link">Connexion</a>
            <?php endif; ?>
        </div>

        <?php if (!isset($_SESSION['user'])): ?>
            <a href="register.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
                Join Now<i class="fa fa-arrow-right ms-3"></i>
            </a>
        <?php endif; ?>
    </div>
</nav>
    <!-- Navbar End -->
    <?php
require_once '../../config/connexion.php'; 

try {
    $pdo = Config::getConnexion();
    $stmt = $pdo->query("SELECT * FROM evenement");

    // Début du container
    echo '<div class="container py-5">';
    echo '<div class="row g-4">'; // g-4 ajoute de l'espace entre les colonnes

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Vérifier si l'image existe pour cet événement
        $imagePath = !empty($row['image']) ? '../back/assets/uploads/' . $row['image'] : 'img/course-2.jpg';  // Image par défaut si aucune image n'est définie
        ?>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="course-item bg-light shadow rounded-3 h-100 d-flex flex-column">
                <div class="position-relative overflow-hidden">
                    <!-- Afficher l'image de l'événement -->
                    <img class="img-fluid" src="<?= htmlspecialchars($imagePath); ?>" alt="event image" style="height: 200px; width: 100%; object-fit: cover; object-position: center;">
                    <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-3">
                    <a href="reserver.php?idev=<?= $row['idevenement']; ?>" class="btn btn-sm btn-outline-primary me-1 rounded-pill">Réserver</a>
                    <a href="evenement_details.php?idev=<?= $row['idevenement']; ?>" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Voir plus</a>

                    </div>
                </div>
                <div class="text-center p-4 pb-2 flex-grow-1">
                    <h5 class="mb-2"><?php echo htmlspecialchars($row['titre']); ?></h5>
                    <p class="text-muted"><i class="fa fa-tag text-primary me-2"></i><?php echo htmlspecialchars($row['categorie']); ?></p>
                </div>
                <div class="d-flex border-top text-center small">
                    
                    <div class="flex-fill py-2 border-end">
                        <i class="fa fa-map-marker-alt text-primary me-2"></i><?php echo htmlspecialchars($row['lieu']); ?>
                    </div>
                    <div class="flex-fill py-2">
                        <i class="fa fa-user text-primary me-2"></i>Organisateur: <?php echo htmlspecialchars($row['idorganisateur']); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    echo '</div>'; // Fin row
    echo '</div>'; // Fin container
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>





    
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>