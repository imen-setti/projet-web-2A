<?php
require_once __DIR__ . '/../../controller/ReservationController.php';
require_once __DIR__ . '/../../config/connexion.php';

$reservationController = new ReservationController();

$success = null;
$error = null;

// --- Traitement de la soumission du formulaire (méthode POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Pay'])) {
        // Redirection vers la page de paiement
        header('Location: paiement.html');
        exit();
    } elseif (isset($_POST['ajouter'])) {
        $client = trim($_POST['client']);
        $idev = trim($_POST['idev']);
        $date = date('Y-m-d');

        if (empty($client) || empty($idev)) {
            $error = "Champs manquants";
        } else {
            $reservation = new Reservation($client, $idev, $date);
            $result = $reservationController->ajouterReservation($reservation);

            if ($result['success']) {
                $success = $result['message'];
            } else {
                $error = $result['message'];
            }
        }
    }
}

// Récupération de l'événement
if (isset($_GET['idev'])) {
    $idev = $_GET['idev'];
    $sql = "SELECT * FROM evenement WHERE idevenement = :idev";
    $db = config::getConnexion();
    $stmt = $db->prepare($sql);
    $stmt->execute(['idev' => $idev]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        $error = "Événement non trouvé";
    }
} else {
    $error = "Aucun événement sélectionné";
}
session_start();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>StartHUb</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
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
            <a href="evenement.php" class="nav-item nav-link active">Evénement</a>
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

<div class="container mt-5">
    <h2>Inscription à l'événement : <?= isset($event['titre']) ? htmlspecialchars($event['titre']) : 'Non trouvé' ?></h2>
    <p>Date de l'événement : <?= isset($event['date']) ? htmlspecialchars($event['date']) : '-' ?></p>

    <!-- Alertes -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div id="success-message" class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="hidden" name="idev" value="<?= htmlspecialchars($event['idevenement'] ?? '') ?>">

        <div class="mb-3">
            <label for="client" class="form-label">Nom du client</label>
            <input
                type="text"
                class="form-control"
                id="client"
                name="client"
                value="<?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['nom']) : '' ?>"
                <?= isset($_SESSION['user']) ? 'readonly' : '' ?>
            >
            <div id="erreur-client" style="color: red; display: none; font-size: 0.9em;"></div>
        </div>

        <button type="submit" class="btn btn-primary" name="ajouter" value="1">S'inscrire</button>
        <button type="submit" class="btn btn-primary" name="Pay" value="1">Payer</button>
    </form>
</div>

    <!-- JS pour masque message de succès -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const successMsg = document.getElementById('success-message');
            if (successMsg) {
                setTimeout(() => {
                    successMsg.style.display = 'none';
                }, 3000);
            }
        });

        function validerFormulaire() {
            const champClient = document.getElementById('client');
            const erreur = document.getElementById('erreur-client');
            const valeur = champClient.value.trim();
            const regex = /^[A-Za-zÀ-ÿ\s]+$/;

            if (valeur === '') {
                erreur.textContent = "Le nom du client est obligatoire.";
                erreur.style.display = "block";
                return false;
            }

            if (!regex.test(valeur)) {
                erreur.textContent = "Le nom ne doit contenir que des lettres.";
                erreur.style.display = "block";
                return false;
            }

            erreur.style.display = "none";
            return true;
        }
    </script>

    <!-- JS Bootstrap & autres -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
