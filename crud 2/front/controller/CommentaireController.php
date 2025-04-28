<?php
require_once(__DIR__ . '/../Model/Commentaire.php');

// Fonction de validation de base pour les commentaires
function isValidCommentaire($id_blog, $id_user, $contenu, $date_creation) {
    return (
        preg_match('/^\d+$/', $id_blog) &&
        preg_match('/^\d+$/', $id_user) &&
        !empty($contenu) &&
        strlen(trim($contenu)) >= 3 &&
        !empty($date_creation)
    );
}

$errors = [];
$id_blog = $id_user = $contenu = $date_creation = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_blog = trim($_POST['id_blog']);
    $id_user = trim($_POST['id_user']);
    $contenu = trim($_POST['contenu']);
    $date_creation = $_POST['date_creation'];

    // Validation individuelle
    if (!preg_match('/^\d+$/', $id_blog)) {
        $errors['id_blog'] = "Veuillez saisir un identifiant de blog valide (chiffres uniquement).";
    }

    if (!preg_match('/^\d+$/', $id_user)) {
        $errors['id_user'] = "Veuillez saisir un identifiant utilisateur valide (chiffres uniquement).";
    }

    if (empty($contenu) || strlen($contenu) < 3) {
        $errors['contenu'] = "Le contenu du commentaire doit contenir au moins 3 caractères.";
    }

    if (empty($date_creation)) {
        $errors['date_creation'] = "La date de création est obligatoire.";
    }

    // Si aucune erreur, insertion
    if (empty($errors)) {
        $commentaire = new Commentaire($id_blog, $id_user, $contenu, $date_creation);
        $commentaire->ajouterCommentaire();
        header("Location: ./../commentaire.php"); 
        exit();
    } else {
        // Recharger le formulaire avec les messages d’erreurs
        include(__DIR__ . './../addCommentaire.php');
    }
}
?>
