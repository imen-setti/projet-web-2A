<?php
require_once(__DIR__.'/../controller/factureC.php');
$factureC = new FactureC();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$facture = $factureC->getFactureById($id);
$pid = isset($_GET['paiement_id']) ? intval($_GET['paiement_id']) : 0;
if (!$facture) {
    echo '<div class="alert alert-danger">Facture introuvable.</div>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Détail Facture</title>
  <link id="pagestyle" href="back-office/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>
<body class="bg-gray-100">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header bg-gradient-dark text-white">Détail de la facture</div>
        <div class="card-body">
          <ul class="list-group">
            <li class="list-group-item"><b>ID :</b> <?= $facture['id'] ?></li>
            <li class="list-group-item"><b>Numéro Facture :</b> <?= htmlspecialchars($facture['numero_facture']) ?></li>
            <li class="list-group-item"><b>Date :</b> <?= htmlspecialchars($facture['date_facture']) ?></li>
            <li class="list-group-item"><b>Montant Total :</b> <?= htmlspecialchars($facture['montant_total']) ?></li>
            <li class="list-group-item"><b>Statut :</b> <?= htmlspecialchars($facture['statut']) ?></li>
            <li class="list-group-item"><b>Client :</b> <?= htmlspecialchars($facture['client_nom']) ?></li>
            <li class="list-group-item"><b>Paiement ID :</b> <?= htmlspecialchars($facture['paiement_id']) ?></li>
          </ul>
          <a href="facture_list.php?paiement_id=<?= $pid ?>" class="btn btn-outline-dark mt-3">Retour à la liste des factures</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
