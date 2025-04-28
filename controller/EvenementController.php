<?php
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../model/Evenement.php';

class EvenementController {

<<<<<<< HEAD
    public function ajouterEvenement(Evenement $evenement) {
=======
    
    public function ajouterEvenement(Evenement $evenement) {
        
>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
        $sql = "SELECT * FROM evenement WHERE titre = :titre";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->execute(['titre' => $evenement->getTitre()]);
    
        if ($req->rowCount() > 0) {
<<<<<<< HEAD
            header('Location: evenementback.php?error=Cet événement existe déjà');
            exit();
        }
    

=======
            // Vous pouvez choisir de renvoyer un message ou d'utiliser les sessions pour les flash messages
            // Ici, nous redirigeons avec un message d'erreur dans l'URL
            header(header: 'Location: evenementback.php?error=Cet événement existe déjà');
            exit();
        }
    
        // Insertion de l'événement
>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
        $sql = "INSERT INTO evenement (titre, description, categorie, date, lieu, idorganisateur, image)
                VALUES (:titre, :description, :categorie, :date, :lieu, :idorganisateur, :image)";
        $req = $db->prepare($sql);
        $req->execute([
            'titre'         => $evenement->getTitre(),
            'description'   => $evenement->getDescription(),
            'categorie'     => $evenement->getCategorie(),
            'date'          => $evenement->getDateEvenement(),
            'lieu'          => $evenement->getLieu(),
            'idorganisateur'=> $evenement->getIdOrganisateur(),
            'image'         => $evenement->getImage()
        ]);
    
        header('Location: evenementback.php?success=Événement créé avec succès');
        exit();
    }
    
    public function add() {
        if (
            isset($_POST['titre']) &&
            isset($_POST['description']) &&
            isset($_POST['categorie']) &&
            isset($_POST['date']) &&
            isset($_POST['lieu']) &&
            isset($_POST['idorganisateur'])
        ) {
<<<<<<< HEAD
=======
            
>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
            $imageName = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = "../back/assets/uploads/";
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }
    
                $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
                $targetFilePath = $targetDir . $imageName;
<<<<<<< HEAD
=======
    
>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
                } else {
                    header("Location: evenementback.php?error=Le fichier n'est pas une image valide");
                    exit();
                }
            }
    
<<<<<<< HEAD
=======
            
>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
            $evenement = new Evenement(
                $_POST['titre'],
                $_POST['description'],
                $_POST['categorie'],
                $_POST['date'],
                $_POST['lieu'],
                $_POST['idorganisateur'],
                $imageName 
            );
    
            $this->ajouterEvenement($evenement);
            header('Location: evenementback.php?success=Événement ajouté avec succès');
            exit();
        } else {
            header('Location: evenementback.php?error=Champs manquants pour l’ajout');
            exit();
        }
    }
    

    public function afficherEvenements() {
        $sql = "SELECT * FROM evenement";
        $db = config::getConnexion();
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

<<<<<<< HEAD
    public function supprimerEvenement($id) {
        try {
            $db = config::getConnexion();
=======
    
    public function supprimerEvenement($id) {
        try {
            $db = config::getConnexion();
             // Supprimer les réservations liées
>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
        $sqlRes = "DELETE FROM reservation WHERE idev = :id";
        $reqRes = $db->prepare($sqlRes);
        $reqRes->bindParam(':id', $id, PDO::PARAM_INT);
        $reqRes->execute();

            $sql = "DELETE FROM evenement WHERE idevenement = :id";
            
            $req = $db->prepare($sql);
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();

            if ($req->rowCount() > 0) {
                header('Location: evenementback.php?success=Événement supprimé avec succès');
                exit;
            } else {
                header('Location: evenementback.php?error=Événement non trouvé');
                exit;
            }
        } catch (Exception $e) {
            header('Location: evenementback.php?error=Erreur lors de la suppression');
            exit;
        }
    }

<<<<<<< HEAD
    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->supprimerEvenement($id);
        } else {
            header('Location: evenementback.php?error=Aucun ID spécifié pour la suppression');
            exit;
        }
    }


=======
    
>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
    public function modifierEvenement($id, Evenement $evenement) {
        $sql = "UPDATE evenement SET 
                    titre = :titre,
                    description = :description,
                    categorie = :categorie,
                    date = :date,
                    lieu = :lieu,
                    idorganisateur = :idorganisateur
                WHERE idevenement = :id";

        $db1 = config::getConnexion();
        $req = $db1->prepare($sql);
        $req->execute([
            'id'             => $id,
            'titre'          => $evenement->getTitre(),
            'description'    => $evenement->getDescription(),
            'categorie'      => $evenement->getCategorie(),
            'date'           => $evenement->getDateEvenement(),
            'lieu'           => $evenement->getLieu(),
            'idorganisateur' => $evenement->getIdOrganisateur()
        ]);
    }


<<<<<<< HEAD
=======



>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
public function update() {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

<<<<<<< HEAD
=======
        
>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
        $evenement = new Evenement(
            $_POST['titre'],
            $_POST['description'],
            $_POST['categorie'],
            $_POST['date'],
            $_POST['lieu'],
            $_POST['idorganisateur']
        );

<<<<<<< HEAD
=======
        
>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
        $this->modifierEvenement($id, $evenement);

        header('Location: evenementback.php?success=Événement mis à jour avec succès');
        exit;
    } else {
        header('Location: evenementback.php?error=Événement introuvable');
        exit;
    }
}

<<<<<<< HEAD
=======

    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->supprimerEvenement($id);
        } else {
            header('Location: evenementback.php?error=Aucun ID spécifié pour la suppression');
            exit;
        }
    }
>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
}
?>
