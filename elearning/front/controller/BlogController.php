<?php
require_once(__DIR__ . '/../Model/Blog.php');

// Fonction de validation de base
function isValidData($id_user, $titre, $auteur, $date_creation, $contenu) {
    return (
        preg_match('/^\d+$/', $id_user) &&
        preg_match('/^[a-zA-Z\s]+$/', $titre) &&
        preg_match('/^[a-zA-Z\s]+$/', $auteur) &&
        !empty($date_creation) &&
        strlen(trim($contenu)) >= 50
    );
}

$errors = [];
$id_user = $titre = $auteur = $date_creation = $contenu = $image = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = trim($_POST['id_user']);
    $titre = trim($_POST['titre']);
    $auteur = trim($_POST['auteur']);
    $date_creation = $_POST['date_creation'];
    $contenu = trim($_POST['contenu']);

    // Validation individuelle
    if (!preg_match('/^\d+$/', $id_user)) {
        $errors['id_user'] = "Veuillez saisir un identifiant utilisateur valide (chiffres uniquement).";
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', $titre)) {
        $errors['titre'] = "Le titre ne doit contenir que des lettres et des espaces.";
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', $auteur)) {
        $errors['auteur'] = "Le nom de l'auteur doit contenir uniquement des lettres et des espaces.";
    }

    if (empty($date_creation)) {
        $errors['date_creation'] = "La date de création est obligatoire.";
    }

    if (strlen($contenu) < 50) {
        $errors['contenu'] = "Le contenu doit contenir au moins 50 caractères.";
    }

    // Image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target = "../uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    // Si aucune erreur, insertion
    if (empty($errors)) {
        $blog = new Blog($id_user, $titre, $auteur, $date_creation, $image, $contenu);
        $blog->ajouterBlog();
        header("Location: ./../blog.php");
        exit();
    } else {
        // Recharger le formulaire avec les messages d’erreurs
        include(__DIR__ . './../addBlog.php');
    }
}
?>
