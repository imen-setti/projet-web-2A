<?php
require_once(__DIR__ . '/../config.php');

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

    
    public static function listeCommentaires($id_blog) {
        global $conn;
        $req = "SELECT * FROM commentaire WHERE id_blog = :id_blog ORDER BY date_creation DESC";
        $stmt = $conn->prepare($req);
        $stmt->bindParam(':id_blog', $id_blog);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCommentairesByBlogId($id_blog) {
        require(__DIR__ . '/../Config.php');
        $stmt = $conn->prepare("SELECT * FROM commentaire WHERE id_blog = ? ORDER BY date_creation DESC");
        $stmt->execute([$id_blog]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ajouterCommentaire($id_blog, $id_user, $contenu) {
        require(__DIR__ . '/../Config.php');
        $stmt = $conn->prepare("INSERT INTO commentaire (id_blog, id_user, contenu, date_creation) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$id_blog, $id_user, $contenu]);
    }

    public static function supprimerCommentaire($id_commentaire) {
        require(__DIR__ . '/../Config.php');
        $stmt = $conn->prepare("DELETE FROM commentaire WHERE id_commentaire = ?");
        $stmt->execute([$id_commentaire]);
    }

    public static function getById($id_commentaire) {
        require(__DIR__ . '/../Config.php');
        $stmt = $conn->prepare("SELECT * FROM commentaire WHERE id_commentaire = ?");
        $stmt->execute([$id_commentaire]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function modifierCommentaire($id, $contenu) {
        require(__DIR__ . '/../Config.php');
        $stmt = $conn->prepare("UPDATE commentaire SET contenu = :contenu WHERE id_commentaire = :id");
        $stmt->execute([
            'contenu' => $contenu,
            'id' => $id
        ]);
    }
    
    
}
    
?>
