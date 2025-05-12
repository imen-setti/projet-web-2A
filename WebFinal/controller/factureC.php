<?php
require_once __DIR__ . '/../config/connexion.php';

class FactureC {
    private $pdo;

    public function __construct() {
        $this->pdo = config::getConnexion();
    }

    public function listFactures() {
        try {
            $query = "SELECT f.*, p.montant as montant_paiement, p.client as client_nom 
                     FROM facture f 
                     LEFT JOIN paiement p ON f.paiement_id = p.id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des factures : " . $e->getMessage());
            return [];
        }
    }

    public function getFactureById($id, $paiement_id = null) {
        try {
            // Construction de la requête de base
            $query = "SELECT f.* FROM facture f WHERE f.id = :id";
            
            // Si un paiement_id est fourni, on l'ajoute à la condition
            if ($paiement_id !== null && $paiement_id > 0) {
                $query .= " AND f.paiement_id = :paiement_id";
            }
            
            // Debug: afficher la requête
            error_log("Requête SQL: " . $query);
            error_log("ID facture: " . $id);
            error_log("ID paiement: " . $paiement_id);
            
            $stmt = $this->pdo->prepare($query);
            
            // Paramètres de base
            $params = ['id' => $id];
            
            // Ajout du paiement_id si nécessaire
            if ($paiement_id !== null && $paiement_id > 0) {
                $params['paiement_id'] = $paiement_id;
            }
            
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Debug: afficher le résultat
            error_log("Résultat de la requête: " . ($result ? "Facture trouvée" : "Aucune facture trouvée"));
            if ($result) {
                error_log("Données de la facture: " . print_r($result, true));
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de la facture : " . $e->getMessage());
            return null;
        }
    }

    public function addFacture($facture) {
        try {
            $query = "INSERT INTO facture (numero_facture, date_facture, montant_total, statut, client_nom, paiement_id) 
                     VALUES (:numero_facture, :date_facture, :montant_total, :statut, :client_nom, :paiement_id)";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([
                'numero_facture' => $facture->getNumeroFacture(),
                'date_facture' => $facture->getDateFacture(),
                'montant_total' => $facture->getMontantTotal(),
                'statut' => $facture->getStatut(),
                'client_nom' => $facture->getClientNom(),
                'paiement_id' => $facture->getPaiementId()
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de la facture : " . $e->getMessage());
            return false;
        }
    }

    public function updateFacture($facture) {
        try {
            $query = "UPDATE facture 
                     SET numero_facture = :numero_facture,
                         date_facture = :date_facture,
                         montant_total = :montant_total,
                         statut = :statut,
                         client_nom = :client_nom,
                         paiement_id = :paiement_id
                     WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([
                'id' => $facture->getId(),
                'numero_facture' => $facture->getNumeroFacture(),
                'date_facture' => $facture->getDateFacture(),
                'montant_total' => $facture->getMontantTotal(),
                'statut' => $facture->getStatut(),
                'client_nom' => $facture->getClientNom(),
                'paiement_id' => $facture->getPaiementId()
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de la facture : " . $e->getMessage());
            return false;
        }
    }

    public function deleteFacture($id) {
        try {
            $query = "DELETE FROM facture WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de la facture : " . $e->getMessage());
            return false;
        }
    }

    public function getFacturesByPaiementId($paiement_id) {
        try {
            $query = "SELECT * FROM facture WHERE paiement_id = :paiement_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['paiement_id' => $paiement_id]);
            
            // Debug log
            error_log("Recherche des factures pour le paiement_id: " . $paiement_id);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Nombre de factures trouvées: " . count($results));
            
            return $results;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des factures: " . $e->getMessage());
            return [];
        }
    }
}