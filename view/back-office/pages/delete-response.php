<?php
require_once '../../../controller/reponseC.php';

// Check if ID parameter exists
if (!isset($_GET['id'])) {
    header("Location: responses.php");
    exit;
}

$id = $_GET['id'];
$reponseC = new ReponseC();

try {
    // First, get the response to check if it exists
    $reponse = $reponseC->showReponse($id);
    if (!$reponse) {
        // Response not found, redirect with error
        $_SESSION['error'] = "Réponse introuvable.";
        header("Location: responses.php");
        exit;
    }

    // Delete the response
    $result = $reponseC->deleteReponse($id);

    if ($result) {
        $_SESSION['success'] = "Réponse supprimée avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la suppression de la réponse.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Erreur: " . $e->getMessage();
}

// Redirect back to the responses list
header("Location: responses.php");
exit;
?>