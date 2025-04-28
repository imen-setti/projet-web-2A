<?php
require_once(__DIR__ . '/../Model/Commentaire.php');

// Fonction de validation de base
function isValidComment($id_user, $id_blog, $contenu, $date_creation) {
    return (
        preg_match('/^\d+$/', $id_user) &&
        preg_match('/^\d+$/', $id_blog) &&
        !empty($date_creation) &&
        strlen(trim($contenu)) >= 3 
    );
}

$errors = [];
$id_user = $id_blog = $contenu = $date_creation = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = trim($_POST['id_user']);
    $id_blog = trim($_POST['id_blog']);
    $contenu = trim($_POST['contenu']);
    $date_creation = $_POST['date_creation'];

    // Validation individuelle
    if (!preg_match('/^\d+$/', $id_user)) {
        $errors['id_user'] = "Identifiant utilisateur invalide.";
    }

    if (!preg_match('/^\d+$/', $id_blog)) {
        $errors['id_blog'] = "Identifiant du blog invalide.";
    }

    if (empty($date_creation)) {
        $errors['date_creation'] = "La date de création est obligatoire.";
    }

    if (strlen($contenu) < 3) {
        $errors['contenu'] = "Le commentaire doit contenir au moins 3 caractères.";
    }

    // Si aucune erreur, insertion
    if (empty($errors)) {
        $commentaire = new Commentaire($id_user, $id_blog, $contenu, $date_creation);
        $commentaire->ajouterCommentaire();
        header("Location: ./../view/listeCommentaire.php");
        exit();
    } else {
        // Recharger le formulaire avec les erreurs
        include(__DIR__ . '/../view/addCommentaire.php');
    }
}
?>
