<?php
require_once(__DIR__.'/../controller/factureC.php');
$factureC = new FactureC();
$pid = isset($_GET['paiement_id']) ? intval($_GET['paiement_id']) : 0;
$factures = $pid ? $factureC->listFactures() : [];
?>
<style>
.btn-pdf {
  background-color: #d32f2f;
  color: white;
  border: none;
  transition: background-color 0.3s ease;
}
.btn-pdf:hover {
  background-color: #b71c1c;
}


</style>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des factures</title>
  <link id="pagestyle" href="back-office/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>
<body class="bg-gray-100">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header bg-gradient-dark text-white">Factures du paiement #<?= htmlspecialchars($pid) ?></div>
        <div class="card-body">
          <a href="facture_add.php?paiement_id=<?= htmlspecialchars($pid) ?>" class="btn btn-dark mb-3">Ajouter une facture</a>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Numéro Facture</th>
                <th>Date</th>
                <th>Montant Total</th>
                <th>Statut</th>
                <th>Client</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($factures as $facture) {
                if ($facture['paiement_id'] == $pid) { ?>
                  <tr>
                    <td><?= $facture['id'] ?></td>
                    <td><?= htmlspecialchars($facture['numero_facture']) ?></td>
                    <td><?= htmlspecialchars($facture['date_facture']) ?></td>
                    <td><?= htmlspecialchars($facture['montant_total']) ?></td>
                    <td><?= htmlspecialchars($facture['statut']) ?></td>
                    <td><?= htmlspecialchars($facture['client_nom']) ?></td>
                    <td>
                      <a href="facture_show.php?id=<?= $facture['id'] ?>&paiement_id=<?= $pid ?>" class="btn btn-sm btn-info">Afficher</a>
                      <a href="facture_edit.php?id=<?= $facture['id'] ?>&paiement_id=<?= $pid ?>" class="btn btn-sm btn-warning">Modifier</a>
                      <a href="exportpdf.php?id=<?= $facture['id'] ?>&paiement_id=<?= $pid ?>" class="btn btn-sm btn-pdf">Exporter PDF</a>

                      <a href="facture_delete.php?id=<?= $facture['id'] ?>&paiement_id=<?= $pid ?>" class="btn btn-sm btn-primary" onclick="return confirm('Supprimer cette facture ?')">Supprimer</a>
                    </td>
                  </tr>
              <?php }} ?>
            </tbody>
          </table>
          <a href="liste.php" class="btn btn-outline-dark mt-3">Retour à la liste des paiements</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
