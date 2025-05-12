<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Assurez-vous que le chemin est correct

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $emailUser = $_POST['email'];

    // Connexion à la base de données
    require_once __DIR__ . '/../config/connexion.php';
    $db = config::getConnexion();
    $stmt = $db->prepare("SELECT password FROM user WHERE email = :email");
    $stmt->bindParam(':email', $emailUser);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $password = $user['password'];

        // Envoi de l'e-mail
        $mail = new PHPMailer(true);
        try {
            // Paramètres du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sodratisarra2@gmail.com';
                    $mail->Password = 'unol uhil gubt ytmx';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinataires
            $mail->setFrom('sodratisarra2@gmail.com', 'StartHub');
            $mail->addAddress($emailUser);

            // Contenu
            $mail->isHTML(true);
            $mail->Subject = 'Votre mot de passe';
            $mail->Body    = "Votre mot de passe est : <b>$password</b>";
            $mail->AltBody = "Votre mot de passe est : $password";

            // Envoi de l'e-mail
            $mail->send();
            echo 'Le mot de passe a été envoyé à votre adresse e-mail.';
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de l'e-mail: {$mail->ErrorInfo}";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet e-mail.";
    }
} else {
    echo "Veuillez fournir une adresse e-mail.";
}
?>
