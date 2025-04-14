<?php
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../model/Reservation.php';

class ReservationController {

    public function ajouterReservation(Reservation $reservation) {
        if (empty($reservation->getIdev())) {
            return ['success' => false, 'message' => 'Aucun événement sélectionné'];
        }
    
        try {
            $sql = "INSERT INTO reservation (client, idev, date)
                    VALUES (:client, :idev, :date)";
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->execute([
                'client' => $reservation->getClient(),
                'idev'   => $reservation->getIdev(),
                'date'   => $reservation->getDate()
            ]);
            return ['success' => true, 'message' => 'Inscription réalisée avec succès'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de l\'inscription'];
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