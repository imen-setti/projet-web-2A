<?php
require_once('config.php');

class PaiementC
{
    // Ajouter un paiement
    public function addPaiement($paiement)
    {
        $sql = "INSERT INTO paiement (montant, devise, methode, carte, description)
                VALUES (:montant, :devise, :methode, :carte, :description)";

        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'montant' => $paiement->getMontant(),
                'devise' => $paiement->getDevise(),
                'methode' => $paiement->getMethode(),
                'carte' => $paiement->getCarte(),
                'description' => $paiement->getDescription(),
            ]);
            return "Paiement ajouté avec succès!";
        } catch (PDOException $e) {
            echo 'Erreur PDO : ' . $e->getMessage();
            return "Erreur lors de l'ajout du paiement.";
        } catch (Exception $e) {
            echo 'Erreur générale : ' . $e->getMessage();
            return "Erreur générale.";
        }
    }

    // Liste des paiements
    public function listPaiements()
    {
        $sql = "SELECT * FROM paiement";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Supprimer un paiement
    public function deletePaiement($id)
    {
        $sql = "DELETE FROM paiement WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Afficher un paiement
    public function showPaiement($id)
    {
        $sql = "SELECT * FROM paiement WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            $paiement = $query->fetch();
            return $paiement;
        } catch (Exception $e) {
            throw new Exception('Erreur lors de l\'affichage du paiement : ' . $e->getMessage());
        }
    }

    // Mettre à jour un paiement
    public function updatePaiement($paiement, $id)
    {
        $sql = "UPDATE paiement SET
                    montant = :montant,
                    devise = :devise,
                    methode = :methode,
                    carte = :carte,
                    description = :description
                WHERE id = :id";

        $db = config::getConnexion();
        $query = $db->prepare($sql);

        $query->bindValue(':montant', $paiement->getMontant());
        $query->bindValue(':devise', $paiement->getDevise());
        $query->bindValue(':methode', $paiement->getMethode());
        $query->bindValue(':carte', $paiement->getCarte());
        $query->bindValue(':description', $paiement->getDescription());
        $query->bindValue(':id', $id);

        return $query->execute();
    }
    public function searchPaiementByCarte($carte) {
        $sql = "SELECT * FROM paiement WHERE carte LIKE :carte";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['carte' => "%$carte%"]);
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    public function getPaiementsByMontant($order = "ASC") {
        $sql = "SELECT * FROM paiement ORDER BY montant " . $order;
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    
}
?>
