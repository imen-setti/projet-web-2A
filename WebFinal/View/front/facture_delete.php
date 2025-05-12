<?php
require_once(__DIR__.'/../../controller/factureC.php');
$factureC = new FactureC();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$pid = isset($_GET['paiement_id']) ? intval($_GET['paiement_id']) : 0;
if ($id) {
    $factureC->deleteFacture($id);
    header('Location: facture_list.php?paiement_id=' . $pid);
    exit;
} else {
    echo '<div class="alert alert-danger">Facture introuvable.</div>';
}
?>
