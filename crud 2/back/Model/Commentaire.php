<?php
require_once(__DIR__ . '/../config.php');

class Commentaire {
    public $id_user;
    public $id_blog;
    public $contenu;
    public $date_creation;

    public function __construct($id_user, $id_blog, $contenu, $date_creation) {
        $this->id_user = $id_user;
        $this->id_blog = $id_blog;
        $this->contenu = $contenu;
        $this->date_creation = $date_creation;
    }

    public function ajouterCommentaire() {
        global $conn;
        $req = "INSERT INTO commentaire (id_user, id_blog, contenu, date_creation)
                VALUES (:id_user, :id_blog, :contenu, :date_creation)";
        $stmt = $conn->prepare($req);
        $stmt->bindParam(':id_user', $this->id_user);
        $stmt->bindParam(':id_blog', $this->id_blog);
        $stmt->bindParam(':contenu', $this->contenu);
        $stmt->bindParam(':date_creation', $this->date_creation);
        $stmt->execute();
    }

    public static function listeCommentaires() {
        global $conn;
        $req = "SELECT * FROM commentaire";
        return $conn->query($req)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function supprimerCommentaire($id_commentaire) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM commentaire WHERE id_commentaire = :id_commentaire");
        $stmt->bindParam(':id_commentaire', $id_commentaire);
        $stmt->execute();
    }

    public static function getCommentaireById($id_commentaire) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM commentaire WHERE id_commentaire = :id_commentaire");
        $stmt->bindParam(':id_commentaire', $id_commentaire);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function modifierCommentaire($id, $id_user, $id_blog, $contenu, $date_creation) {
        global $conn;
        $stmt = $conn->prepare("
            UPDATE commentaire 
            SET id_user = :id_user, id_blog = :id_blog, contenu = :contenu, date_creation = :date_creation 
            WHERE id_commentaire = :id
        ");

        $stmt->execute([
            'id_user' => $id_user,
            'id_blog' => $id_blog,
            'contenu' => $contenu,
            'date_creation' => $date_creation,
            'id' => $id
        ]);
    }
    
}
?>
