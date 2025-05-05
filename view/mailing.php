<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Chemin avec __DIR__ pour une meilleure portabilité
require_once __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['message'])) {
        $mail = new PHPMailer(true);
        try {
            // Paramètres du serveur
            $mail->isSMTP();                                      
            $mail->Host       = 'smtp.gmail.com';                
            $mail->SMTPAuth   = true;                             
            $mail->Username   = 'hmaied.nada1@gmail.com';   
            $mail->Password   = 'twfr nnfg uyoh aldz';           
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
            $mail->Port       = 587;                              
            
            // Débogue SMTP - Commenter ces lignes en production
            $mail->SMTPDebug = SMTP::DEBUG_OFF; // Mettre DEBUG_SERVER pour le débogage
            
            // Destinataires
            $mail->setFrom('hmaied.nada1@gmail.com', 'Admin');
            $mail->addAddress($_POST['email'], 'Destinataire');
            
            // Contenu
            $mail->isHTML(true);
            $mail->Subject = 'Confirmation du paiement';
            $mail->Body    = nl2br($_POST['message']); 
            $mail->AltBody = strip_tags($_POST['message']);
            
            $mail->send();
            
            // Redirection après envoi réussi
            header('Location: liste.php');
            exit();
            
        } catch (Exception $e) {
            $error = $mail->ErrorInfo;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation de paiement</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="back-office/assets/css/material-dashboard.css?v=3.2.0">
</head>
<body class="bg-gray-100">

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container py-4">
      <div class="row justify-content-center">
        <div class="col-md-8">

          <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-white bg-gradient-danger text-center">
              ❌ Erreur d'envoi : <?= htmlspecialchars($error) ?>
            </div>
          <?php endif; ?>

          <div class="card my-4">
            <div class="card-header bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
              <h6 class="text-white text-center">Envoyer une confirmation de paiement</h6>
            </div>
            <div class="card-body">
              <form method="POST">
                <div class="mb-3">
                  <label for="email" class="form-label">Adresse Email du destinataire</label>
                  <input type="email" class="form-control" name="email" id="email" required placeholder="exemple@email.com">
                </div>
                <div class="mb-3">
                  <label for="message" class="form-label">Contenu du message</label>
                  <textarea class="form-control" name="message" id="message" rows="5" required placeholder="Votre message ici..."></textarea>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-dark">Envoyer</button>
                  <a href="liste.php" class="btn btn-outline-dark ms-2">Retour à la liste</a>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </main>

  <script src="back-office/assets/js/core/bootstrap.min.js"></script>
  <script src="back-office/assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>
</html>
