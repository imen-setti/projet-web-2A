<?php
require_once(__DIR__.'/../../controller/factureC.php');
require_once(__DIR__.'/../../model/facture.php');
$factureC = new FactureC();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$pid = isset($_GET['paiement_id']) ? intval($_GET['paiement_id']) : 0;
$facture = $factureC->getFactureById($id);
$message = '';
if (!$facture) {
    echo '<div class="alert alert-danger">Facture introuvable.</div>';
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $f = new Facture(
        $id,
        $_POST['numero_facture'],
        $_POST['date_facture'],
        $_POST['montant_total'],
        $_POST['statut'],
        $_POST['client_nom'],
        $pid
    );
    $factureC->updateFacture($f);
    $message = 'Facture modifiée avec succès!';
    $facture = $factureC->getFactureById($id);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier Facture</title>
  <link id="pagestyle" href="../back/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>
<body class="bg-gray-100">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header bg-gradient-dark text-white">Modifier la facture</div>
        <div class="card-body">
          <?php if($message) echo '<div class="alert alert-success">'.$message.'</div>'; ?>
          <form method="POST">
            <input type="hidden" name="paiement_id" value="<?= htmlspecialchars($pid) ?>">
            <div class="mb-3">
              <label for="numero_facture" class="form-label">Numéro Facture</label>
              <input type="text" class="form-control" id="numero_facture" name="numero_facture" value="<?= htmlspecialchars($facture['numero_facture']) ?>" required>
            </div>
            <div class="mb-3">
              <label for="date_facture" class="form-label">Date Facture</label>
              <input type="date" class="form-control" id="date_facture" name="date_facture" value="<?= htmlspecialchars($facture['date_facture']) ?>" required>
            </div>
            <div class="mb-3">
              <label for="montant_total" class="form-label">Montant Total</label>
              <input type="number" step="0.01" class="form-control" id="montant_total" name="montant_total" value="<?= htmlspecialchars($facture['montant_total']) ?>" required>
            </div>
            <div class="mb-3">
              <label for="statut" class="form-label">Statut</label>
              <input type="text" class="form-control" id="statut" name="statut" value="<?= htmlspecialchars($facture['statut']) ?>" required>
            </div>
            <div class="mb-3">
              <label for="client_nom" class="form-label">Nom du Client</label>
              <input type="text" class="form-control" id="client_nom" name="client_nom" value="<?= htmlspecialchars($facture['client_nom']) ?>">
            </div>
            <button type="submit" class="btn btn-dark">Modifier</button>
            <a href="facture_list.php?paiement_id=<?= htmlspecialchars($pid) ?>" class="btn btn-outline-dark ms-2">Retour</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
