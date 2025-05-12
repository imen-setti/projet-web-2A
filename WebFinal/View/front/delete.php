<?php

require_once('C:\xampp\htdocs\nada\controller\paiementC.php');

$paiementC = new PaiementC();

// Suppression du paiement via l'ID passé en GET
if (isset($_GET['id'])) {
    $paiementC->deletePaiement($_GET['id']);
    header('Location: liste.php');
    exit();
} else {
    echo "Erreur : ID de paiement non spécifié.";
}
?>
