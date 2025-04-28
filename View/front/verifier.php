<?php
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../controller/UserController.php';
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Vérifier que le client est passé en GET
if (!isset($_GET['client'])) {
    echo "Erreur : Client non spécifié.";
    exit;
}

$client = $_GET['client'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['code'])) {
        $codeSaisi = trim($_POST['code']);
        
        try {
            $db = config::getConnexion();

            // Récupérer la réservation du client avec le code
            $sql = "SELECT * FROM reservation WHERE client = :client ORDER BY idr DESC LIMIT 1";
            $stmt = $db->prepare($sql);
            $stmt->execute(['client' => $client]);
            $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($reservation) {
                if ($reservation['code_confirmation'] == $codeSaisi) {
                    // Code correct : mettre code_confirmation à NULL pour valider
                    $updateSql = "UPDATE reservation SET code_confirmation = NULL WHERE idr = :idr";
                    $updateStmt = $db->prepare($updateSql);
                    $updateStmt->execute(['idr' => $reservation['idr']]);

                    // Récupérer l'email du client
                    $sqlEmail = "SELECT email FROM user WHERE nom = :client";
                    $stmtEmail = $db->prepare($sqlEmail);
                    $stmtEmail->execute(['client' => $client]);
                    $emailData = $stmtEmail->fetch(PDO::FETCH_ASSOC);

                    if ($emailData && isset($emailData['email'])) {
                        $emailClient = $emailData['email'];

                        // Envoyer email de réservation réussie
                        $mail = new PHPMailer(true);

                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'sodratisarra2@gmail.com';
                            $mail->Password = 'unol uhil gubt ytmx';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;
                            $mail->SMTPOptions = [
                                'ssl' => [
                                    'verify_peer' => false,
                                    'verify_peer_name' => false,
                                    'allow_self_signed' => true
                                ]
                            ];

                            $mail->setFrom('sodratisarra2@gmail.com', 'StartHub');
                            $mail->addAddress($emailClient, $client);
                            $mail->Subject = 'Reservation confirmee avec succes';
                            $mail->Body = "Bonjour " . htmlspecialchars($client) . ",\n\nVotre reservation a ete confirmee avec succes.\n\nMerci pour votre confiance.\n\nCordialement.";

                            $mail->send();

                            // Message de confirmation avec redirection
                            echo "<div style='color:green;'>✔️ Réservation confirmée et email envoyé !</div>";
                            echo "<script>
                                    setTimeout(function() {
                                        window.location.href = 'evenement.php';
                                    }, 3000); // Redirection après 3 secondes
                                  </script>";
                        } catch (Exception $e) {
                            echo "<div style='color:red;'>❌ Réservation confirmée mais échec d'envoi de l'email : " . $mail->ErrorInfo . "</div>";
                        }
                    } else {
                        echo "<div style='color:red;'>❌ Email du client introuvable.</div>";
                    }
                } else {
                    echo "<div style='color:red;'>❌ Code incorrect, veuillez réessayer.</div>";
                }
            } else {
                echo "<div style='color:red;'>❌ Aucune réservation trouvée pour ce client.</div>";
            }

        } catch (Exception $e) {
            echo "<div style='color:red;'>Erreur lors de la vérification : " . $e->getMessage() . "</div>";
        }
    }
}
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
<!-- Formulaire pour entrer le code -->
<h2>Vérification du Code de Confirmation</h2>
<form method="POST">
    <label for="code">Entrez le code que vous avez reçu :</label><br>
    <input type="text" id="code" name="code" required><br><br>
    <button type="submit">Vérifier</button>
</form>

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


