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
                <a href="index.php" class="nav-item nav-link ">Home</a>
                <a href="#" class="nav-item nav-link">About</a>
                <a href="evenement.php" class="nav-item nav-link active">Evènement</a>
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
    <?php
require_once '../../config/connexion.php';

$idev = isset($_GET['idev']) ? intval($_GET['idev']) : 0;

try {
    $pdo = Config::getConnexion();
    $stmt = $pdo->prepare("SELECT * FROM evenement WHERE idevenement = :idev");
    $stmt->bindParam(':idev', $idev, PDO::PARAM_INT);
    $stmt->execute();

    $evenement = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($evenement) {
        // Image fallback
        $imagePath = !empty($evenement['image']) ? '../back/assets/uploads/' . $evenement['image'] : 'img/course-2.jpg';
        ?>
        
        <div class="container-fluid p-0 mb-5">
            <div class="owl-carousel header-carousel position-relative">
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="<?= htmlspecialchars($imagePath); ?>" alt="Image de l'événement">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-sm-10 col-lg-8 text-white">
                                    <h5 class="text-primary text-uppercase mb-3 animated slideInDown"><?= htmlspecialchars($evenement['categorie']); ?></h5>
                                    <h1 class="display-3 text-white animated slideInDown"><?= htmlspecialchars($evenement['titre']); ?></h1>
                                    
                                    <p class="fs-5 mb-2"><strong>Date :</strong> <?= htmlspecialchars($evenement['date']); ?></p>
                                    <p class="fs-5 mb-2"><strong>Lieu :</strong> <?= htmlspecialchars($evenement['lieu']); ?></p>
                                    <p class="fs-5 mb-2"><strong>Organisateur :</strong> <?= htmlspecialchars($evenement['idorganisateur']); ?></p>
                                    <p class="fs-5 mb-4 pb-2"><strong>Description :</strong><br><?= nl2br(htmlspecialchars($evenement['description'])); ?></p>

                                    <a href="reserver.php?idev=<?= $evenement['idevenement']; ?>" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">S'inscrire</a>
                                    <a href="javascript:history.back()" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Retour</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    } else {
        echo "<div class='container my-5'><div class='alert alert-warning'>Événement introuvable.</div></div>";
    }
} catch (PDOException $e) {
    echo "<div class='container my-5'><div class='alert alert-danger'>Erreur : " . $e->getMessage() . "</div></div>";
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