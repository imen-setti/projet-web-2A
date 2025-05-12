<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once(__DIR__ . '/vendor/autoload.php');

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
    <link id="pagestyle" href="../back/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"/>
</head>
<body class="g-sidenav-show bg-gray-100">
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3 text-center">Envoyer une confirmation de paiement</h6>
                        </div>
                    </div>
                    <div class="card-body px-4">
                        <form method="POST">
                            <div class="input-group input-group-static mb-4">
                                <label for="email">Adresse Email du destinataire</label>
                                <input type="email" class="form-control" name="email" id="email" required 
                                       placeholder="exemple@email.com">
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label for="message">Contenu du message</label>
                                <textarea class="form-control" name="message" id="message" rows="5" required 
                                          placeholder="Votre message ici..."></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-paper-plane me-2"></i>Envoyer
                                </button>
                                <a href="liste.php" class="btn btn-outline-dark ms-2">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../back/assets/js/core/bootstrap.min.js"></script>
    <script src="../back/assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>
</html>
