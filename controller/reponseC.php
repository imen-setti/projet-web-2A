<?php
require_once('config.php');
require_once(__DIR__ . '/../model/reponse.php');
require_once(__DIR__ . '/../model/reclamation.php'); // Added this line to import the Reclamation class
require_once(__DIR__ . '/reclamationC.php');

class ReponseC
{
    // Add a new response
    function addReponse($reponse)
    {
        $sql = "INSERT INTO reponse (reclamation_id, contenu, date_reponse, staff_id, staff_name) 
                VALUES (:reclamation_id, :contenu, :date_reponse, :staff_id, :staff_name)";

        $db = config::getConnexion();

        try {
            // Prepare SQL query
            $query = $db->prepare($sql);

            // Execute query with parameters
            $query->execute([
                'reclamation_id' => $reponse->getReclamationId(),
                'contenu' => $reponse->getContenu(),
                'date_reponse' => $reponse->getDateReponse(),
                'staff_id' => $reponse->getStaffId(),
                'staff_name' => $reponse->getStaffName(),
            ]);

            // Update reclamation status if response is added successfully
            $reclamationC = new ReclamationC();
            $reclamation = $reclamationC->showReclamation($reponse->getReclamationId());

            if ($reclamation) {
                $updateRec = new Reclamation(
                    $reclamation['id'],
                    $reclamation['email'],
                    $reclamation['sujet'],
                    $reclamation['descrip'],
                    $reclamation['daterec'],
                    'Répondu'
                );
                $reclamationC->updateReclamation($updateRec, $reclamation['id']);
            }

            return "Réponse ajoutée avec succès!";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return "Erreur lors de l'ajout de la réponse.";
        } catch (Exception $e) {
            echo 'Erreur générale: ' . $e->getMessage();
            return "Erreur générale.";
        }
    }

    // List all responses
    public function listReponses()
    {
        $sql = "SELECT r.*, rec.sujet, rec.email 
                FROM reponse r 
                JOIN reclamation rec ON r.reclamation_id = rec.id 
                ORDER BY r.date_reponse DESC";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // Delete a response
    function deleteReponse($id)
    {
        $sql = "DELETE FROM reponse WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);
        try {
            $req->execute();
            return true;
        } catch (Exception $e) {
            echo 'Error:' . $e->getMessage();
            return false;
        }
    }

    // Show details of a specific response
    function showReponse($id)
    {
        $sql = "SELECT r.*, rec.sujet, rec.descrip as reclamation_descrip, rec.email, rec.daterec, rec.status 
                FROM reponse r 
                JOIN reclamation rec ON r.reclamation_id = rec.id 
                WHERE r.id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            $reponse = $query->fetch();
            return $reponse;
        } catch (Exception $e) {
            throw new Exception('Error showing response: ' . $e->getMessage());
        }
    }

    // Get responses for a specific reclamation
    function getReponsesByReclamation($reclamationId)
    {
        $sql = "SELECT * FROM reponse WHERE reclamation_id = :reclamation_id ORDER BY date_reponse DESC";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':reclamation_id', $reclamationId);
            $query->execute();
            $reponses = $query->fetchAll();
            return $reponses;
        } catch (Exception $e) {
            throw new Exception('Error fetching responses: ' . $e->getMessage());
        }
    }

    // Update a response
    public function updateReponse($reponse, $id)
    {
        $sql = "UPDATE reponse SET
                    contenu = :contenu,
                    staff_id = :staff_id,
                    staff_name = :staff_name
                WHERE id = :id";

        $db = config::getConnexion();
        $query = $db->prepare($sql);

        $query->bindValue(':contenu', $reponse->getContenu());
        $query->bindValue(':staff_id', $reponse->getStaffId());
        $query->bindValue(':staff_name', $reponse->getStaffName());
        $query->bindValue(':id', $id);

        try {
            $query->execute();
            return true;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}
?>