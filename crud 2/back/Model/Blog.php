<?php
require_once(__DIR__ . '/../config.php');

class Blog {
    public $id_user;
    public $titre;
    public $auteur;
    public $date_creation;
    public $image;
    public $contenu;

    public function __construct($id_user, $titre, $auteur, $date_creation, $image, $contenu) {
        $this->id_user = $id_user;
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->date_creation = $date_creation;
        $this->image = $image;
        $this->contenu = $contenu;
    }

    public function ajouterBlog() {
        global $conn;
        $req = "INSERT INTO blog (id_user, titre, auteur, date_creation, image, contenu)
                VALUES (:id_user, :titre, :auteur, :date_creation, :image, :contenu)";
        $stmt = $conn->prepare($req);
        $stmt->bindParam(':id_user', $this->id_user);
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':auteur', $this->auteur);
        $stmt->bindParam(':date_creation', $this->date_creation);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':contenu', $this->contenu);
        $stmt->execute();
    }

    public static function listeBlogs() {
        global $conn;
        $req = "SELECT * FROM blog";
        return $conn->query($req)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function supprimerBlog($id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM blog WHERE id_blog = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function getBlogById($id_blog) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM blog WHERE id_blog = :id_blog");
        $stmt->bindParam(':id_blog', $id_blog);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function modifierBlog($id_blog, $id_user, $titre, $auteur, $date_creation, $image, $contenu) {
        global $conn;
        $stmt = $conn->prepare("
            UPDATE blog SET
                id_user = :id_user,
                titre = :titre,
                auteur = :auteur,
                date_creation = :date_creation,
                image = :image,
                contenu = :contenu
            WHERE id_blog = :id_blog
        ");
        $stmt->bindParam(':id_blog', $id_blog);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->bindParam(':date_creation', $date_creation);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->execute();
    }
    
}
?>
