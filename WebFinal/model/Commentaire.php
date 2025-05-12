<?php
require_once(__DIR__ . '/../config/connexion.php');

class Commentaire {
    public $id_blog;
    public $id_user;
    public $contenu;
    public $date_creation;

    public function __construct($id_blog, $id_user, $contenu, $date_creation) {
        $this->id_blog = $id_blog;
        $this->id_user = $id_user;
        $this->contenu = $contenu;
        $this->date_creation = $date_creation;
    }

    
    public static function listeCommentaires() {
        $db = Config::getConnexion();
        $req = "SELECT * FROM commentaire ORDER BY date_creation DESC";
        $stmt = $db->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCommentairesByBlogId($id_blog) {
        $db = Config::getConnexion();
        $stmt = $db->prepare("
            SELECT c.*, u.nom as user_name 
            FROM commentaire c 
            JOIN user u ON c.id_user = u.id_user 
            WHERE c.id_blog = ? 
            ORDER BY c.date_creation DESC
        ");
        $stmt->execute([$id_blog]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ajouterCommentaire($id_blog, $id_user, $contenu) {
        $conn = Config::getConnexion();
        $sql = "INSERT INTO commentaire (id_blog, id_user, contenu, date_creation) VALUES (:id_blog, :id_user, :contenu, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id_blog' => $id_blog,
            ':id_user' => $id_user,
            ':contenu' => $contenu
        ]);
    }

    public static function supprimerCommentaire($id_commentaire) {
        $db = Config::getConnexion();
        $stmt = $db->prepare("DELETE FROM commentaire WHERE id_commentaire = ?");
        $stmt->execute([$id_commentaire]);
    }

    public static function getById($id_commentaire) {
        $db = Config::getConnexion();
        $stmt = $db->prepare("SELECT c.*, u.nom as user_name 
                FROM commentaire c 
                JOIN user u ON c.id_user = u.id_user 
                WHERE c.id_commentaire = :id_commentaire");
        $stmt->execute(['id_commentaire' => $id_commentaire]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function modifierCommentaire($id_commentaire, $contenu) {
        $conn = Config::getConnexion();
        $sql = "UPDATE commentaire SET contenu = :contenu WHERE id_commentaire = :id_commentaire";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id_commentaire' => $id_commentaire,
            ':contenu' => $contenu
        ]);
    }
    public static function getNomParId($id_user) {
        $db = Config::getConnexion();
        $stmt = $db->prepare("SELECT prenom FROM user WHERE id_user = ?");
        $stmt->execute([$id_user]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
    
?>
