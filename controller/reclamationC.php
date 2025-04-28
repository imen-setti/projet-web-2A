<?php
require_once('config.php');

class ReclamationC
{
    // Ajouter une réclamation
    function addReclamation($reclamation)
    {
        $sql = "INSERT INTO reclamation (email, sujet, descrip, daterec, status) 
                VALUES (:email, :sujet, :descrip, :daterec, :status)";

        $db = config::getConnexion();

        try {
            // Préparation de la requête SQL
            $query = $db->prepare($sql);

            // Exécution de la requête avec les paramètres
            $query->execute([
                'email' => $reclamation->getEmail(),
                'sujet' => $reclamation->getSujet(),
                'descrip' => $reclamation->getDescription(),
                'daterec' => $reclamation->getDateRec(),
                'status' => $reclamation->getStatus(),
            ]);

            return "Réclamation ajoutée avec succès!";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return "Erreur lors de l'ajout de la réclamation.";
        } catch (Exception $e) {
            echo 'Erreur générale: ' . $e->getMessage();
            return "Erreur générale.";
        }
    }

    // Liste des réclamations
    public function listReclamations()
    {
        $sql = "SELECT * FROM reclamation";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // Supprimer une réclamation
    function deleteReclamation($id)
    {
        $sql = "DELETE FROM reclamation WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // Afficher une réclamation
    function showReclamation($id)
    {
        $sql = "SELECT * FROM reclamation WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id);
            $query->execute();
            $reclamation = $query->fetch();
            return $reclamation;
        } catch (Exception $e) {
            throw new Exception('Error showing reclamation: ' . $e->getMessage());
        }
    }

    // Mettre à jour une réclamation
    public function updateReclamation($reclamation, $id)
    {
        $sql = "UPDATE reclamation SET
                    email = :email,
                    sujet = :sujet,
                    descrip = :descrip,
                    daterec = :daterec,
                    status = :status
                WHERE id = :id";

        $db = config::getConnexion();
        $query = $db->prepare($sql);

        $query->bindValue(':email', $reclamation->getEmail());
        $query->bindValue(':sujet', $reclamation->getSujet());
        $query->bindValue(':descrip', $reclamation->getDescription());
        $query->bindValue(':daterec', $reclamation->getDateRec());
        $query->bindValue(':status', $reclamation->getStatus());
        $query->bindValue(':id', $id);

        return $query->execute();
    }
}
?>
