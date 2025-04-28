<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../../model/User.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Connexion à la base de données
    $db = config::getConnexion();
    $sql = "SELECT * FROM user WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
       
        $userPassword = $user['password'];

        
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            // Configuration SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sodratisarra2@gmail.com'; 
            $mail->Password = 'unol uhil gubt ytmx';  
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
// Désactivation de la vérification SSL

           
            $mail->setFrom('sodratisarra2@gmail.com', 'StartHub');
            $mail->addAddress($email);

            // Contenu du mail
            $mail->isHTML(true);
            $mail->Subject = 'Mot de passe oublie';
            $mail->Body = "Votre mot de passe est : " . $userPassword;

            // Envoi de l'email
            $mail->send();

            // Message de succès
            echo '<div class="alert alert-success">Un email contenant votre mot de passe a été envoyé.</div>';
        } catch (Exception $e) {
            echo '<div class="alert alert-danger">Le message n\'a pas pu être envoyé. Erreur : ' . $mail->ErrorInfo . '</div>';
        }
    } else {
        // Email non trouvé
        echo '<div class="alert alert-danger">Email non trouvé. Veuillez vérifier votre adresse.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Récupération de mot de passe - StartHUb</title>
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
        .success {
            color: green;
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

    <div class="container mt-5">
        <h2>Mot de passe oublié</h2>

        <!-- Formulaire pour saisir l'email -->
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>

        <div class="mt-3">
            <a href="login.php">Retour à la connexion</a>
        </div>
    </div>

    <!-- JS Bootstrap & dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('sendCode').addEventListener('click', function() {
            const contact = document.getElementById('contact').value.trim();
            document.getElementById('errorContact').textContent = '';
            
            if (!contact) {
                document.getElementById('errorContact').textContent = "Veuillez entrer votre email ou numéro de téléphone";
                return;
            }
            
            // Ici, vous devrez implémenter l'envoi du code
            console.log("Envoi du code à :", contact);
            alert("Un code de vérification a été envoyé à " + contact);
        });

        document.getElementById('recoveryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const code = document.getElementById('code').value.trim();
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Réinitialiser les messages d'erreur
            document.getElementById('errorCode').textContent = '';
            document.getElementById('errorNewPassword').textContent = '';
            document.getElementById('errorConfirmPassword').textContent = '';
            
            let isValid = true;
            
            if (!code) {
                document.getElementById('errorCode').textContent = "Veuillez entrer le code de vérification";
                isValid = false;
            }
            
            if (!newPassword) {
                document.getElementById('errorNewPassword').textContent = "Veuillez entrer un nouveau mot de passe";
                isValid = false;
            }
            
            if (newPassword !== confirmPassword) {
                document.getElementById('errorConfirmPassword').textContent = "Les mots de passe ne correspondent pas";
                isValid = false;
            }
            
            if (isValid) {
                // Ici, vous devrez implémenter la vérification du code et la mise à jour du mot de passe
                console.log("Tentative de réinitialisation du mot de passe");
            }
        });
    </script>
</body>
</html> 