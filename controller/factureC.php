<?php
require_once('config.php');
require_once(__DIR__.'/../model/facture.php');

class FactureC
{
    // Ajouter une facture
    public function addFacture($facture)
    {
        $sql = "INSERT INTO facture (numero_facture, date_facture, montant_total, statut, client_nom, paiement_id) VALUES (:numero_facture, :date_facture, :montant_total, :statut, :client_nom, :paiement_id)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'numero_facture' => $facture->getNumeroFacture(),
                'date_facture' => $facture->getDateFacture(),
                'montant_total' => $facture->getMontantTotal(),
                'statut' => $facture->getStatut(),
                'client_nom' => $facture->getClientNom(),
                'paiement_id' => $facture->getPaiementId(),
            ]);
            return "Facture ajoutée avec succès!";
        } catch (PDOException $e) {
            echo 'Erreur PDO : ' . $e->getMessage();
            return "Erreur lors de l'ajout de la facture.";
        } catch (Exception $e) {
            echo 'Erreur générale : ' . $e->getMessage();
            return "Erreur générale.";
        }
    }

    // Liste des factures
    public function listFactures()
    {
        $sql = "SELECT * FROM facture";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
            return null;
        }
    }

    // Supprimer une facture
    public function deleteFacture($id)
    {
        $sql = "DELETE FROM facture WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return "Facture supprimée.";
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
            return null;
        }
    }

    // Modifier une facture
    public function updateFacture($facture)
    {
        $sql = "UPDATE facture SET numero_facture = :numero_facture, date_facture = :date_facture, montant_total = :montant_total, statut = :statut, client_nom = :client_nom, paiement_id = :paiement_id WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id' => $facture->getId(),
                'numero_facture' => $facture->getNumeroFacture(),
                'date_facture' => $facture->getDateFacture(),
                'montant_total' => $facture->getMontantTotal(),
                'statut' => $facture->getStatut(),
                'client_nom' => $facture->getClientNom(),
                'paiement_id' => $facture->getPaiementId(),
            ]);
            return "Facture modifiée.";
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
            return null;
        }
    }

    // Récupérer une facture par ID
    public function getFactureById($id)
    {
        $sql = "SELECT * FROM facture WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch();
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
            return null;
        }
    }
}
?>
