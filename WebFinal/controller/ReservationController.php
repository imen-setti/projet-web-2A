<?php
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../model/Reservation.php';
require_once __DIR__ . '/vendor/autoload.php'; // charge PHPMailer automatiquement
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ReservationController {

   
    
    
    
    public function ajouterReservation(Reservation $reservation) {
        if (empty($reservation->getIdev())) {
            return ['success' => false, 'message' => 'Aucun événement sélectionné'];
        }

        try {
            $db = config::getConnexion();

            // Vérifier si le client a déjà réservé cet événement
            $sqlCheck = "SELECT COUNT(*) FROM reservation WHERE client = :client AND idev = :idev";
            $stmtCheck = $db->prepare($sqlCheck);
            $stmtCheck->execute([
                'client' => $reservation->getClient(),
                'idev' => $reservation->getIdev()
            ]);
            $existingReservation = $stmtCheck->fetchColumn();

            if ($existingReservation > 0) {
                return ['success' => false, 'message' => 'Ce client est déjà inscrit à cet événement.'];
            }

            // Vérifier le nombre de places disponibles
            $sqlNbPlaces = "SELECT nbplace FROM evenement WHERE idevenement = :idev";
            $stmtNbPlaces = $db->prepare($sqlNbPlaces);
            $stmtNbPlaces->execute(['idev' => $reservation->getIdev()]);
            $eventData = $stmtNbPlaces->fetch(PDO::FETCH_ASSOC);

            if (!$eventData || $eventData['nbplace'] <= 0) {
                return ['success' => false, 'message' => 'Aucune place disponible pour cet événement.'];
            }

            // Générer un code de confirmation unique
            $codeConfirmation = random_int(100000, 999999);

            // Ajouter la réservation avec code
            $sql = "INSERT INTO reservation (client, idev, date, code_confirmation)
                    VALUES (:client, :idev, :date, :code_confirmation)";
            $req = $db->prepare($sql);
            $req->execute([
                'client' => $reservation->getClient(),
                'idev' => $reservation->getIdev(),
                'date' => $reservation->getDate(),
                'code_confirmation' => $codeConfirmation
            ]);

            // Décrémenter le nombre de places
            $sqlUpdatePlaces = "UPDATE evenement SET nbplace = nbplace - 1 WHERE idevenement = :idev";
            $stmtUpdate = $db->prepare($sqlUpdatePlaces);
            $stmtUpdate->execute(['idev' => $reservation->getIdev()]);

            // Récupérer l'email du client via son nom
            $clientNom = $reservation->getClient();
            error_log("Nom du client recherché : " . $clientNom);

            $sqlEmail = "SELECT email FROM user WHERE LOWER(nom) = LOWER(:client) LIMIT 1";
            $stmtEmail = $db->prepare($sqlEmail);
            $stmtEmail->execute(['client' => strtolower($clientNom)]);
            $emailData = $stmtEmail->fetch(PDO::FETCH_ASSOC);

            error_log("Données récupérées pour l'email : " . var_export($emailData, true));

            if ($emailData && isset($emailData['email'])) {
                $emailClient = $emailData['email'];

                // Envoi de l'email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = '!sodratisarra2@gmail.com';
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
                    $mail->addAddress($emailClient, $clientNom);
                    $mail->Subject = 'Code de confirmation de réservation';
                    $mail->Body = "Bonjour " . htmlspecialchars($clientNom) . ",\n\n"
                                . "Voici votre code de confirmation : " . $codeConfirmation . "\n\n"
                                . "Veuillez saisir ce code pour confirmer votre inscription.\n\nCordialement.";

                    $mail->send();

                    header('Location: verifier.php?client=' . urlencode($clientNom));
                    exit();

                } catch (Exception $e) {
                    return ['success' => true, 'message' => 'Inscription OK mais erreur d\'envoi d\'email : ' . $mail->ErrorInfo];
                }
            } else {
                error_log("Aucun email trouvé pour le client : " . $clientNom);
                return ['success' => true, 'message' => 'Inscription réalisée, mais email du client introuvable'];
            }

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de l\'inscription : ' . $e->getMessage()];
        }
    }

    
    
    

    public function afficherReservations() {
        try {
            $sql = "SELECT * FROM reservation";
            $db = config::getConnexion();
            return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo '<div class="alert alert-danger">Erreur lors de la récupération des réservations</div>';
            exit();
        }
    }

 public function modifierReservation($idr, Reservation $reservation) {
    try {
        $sql = "UPDATE reservation SET 
                    client = :client,
                    idev = :idev,
                    date = :date
                WHERE idr = :idr";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->execute([
            'idr'    => $idr,
            'client' => $reservation->getClient(),
            'idev'   => $reservation->getIdev(),
            'date'   => $reservation->getDate()
        ]);
        return ['success' => true, 'message' => 'Réservation mise à jour avec succès'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur lors de la modification: ' . $e->getMessage()];
    }
}


public function updateReservationFromRequest() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        if (isset($_POST['idr'], $_POST['client'], $_POST['idev'], $_POST['date'])) {
            $reservation = new Reservation($_POST['client'], $_POST['idev'], $_POST['date']);
            return $this->modifierReservation($_POST['idr'], $reservation);
        } else {
            return ['success' => false, 'message' => 'Certains champs sont manquants pour la mise à jour'];
        }
    }
    return null;
}


public function supprimerReservation($idr) {
    try {
        $sql = "DELETE FROM reservation WHERE idr = :idr";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindParam(':idr', $idr, PDO::PARAM_INT);
        $req->execute();
        if ($req->rowCount() > 0) {
            return ['success' => true, 'message' => 'Réservation supprimée avec succès'];
        } else {
            return ['success' => false, 'message' => 'Réservation non trouvée'];
        }
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur lors de la suppression: ' . $e->getMessage()];
    }
}


public function deleteReservationFromRequest() {
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['idr'])) {
        $idr = $_GET['idr'];
        return $this->supprimerReservation($idr);
    }
    return null;
}
}
?>