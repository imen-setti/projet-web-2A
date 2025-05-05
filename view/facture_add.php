<?php
require_once(__DIR__.'/../controller/factureC.php');
require_once(__DIR__.'/../model/facture.php');

$factureC = new FactureC();
$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Contrôles de saisie
    if (
        empty($_POST['numero_facture']) ||
        empty($_POST['date_facture']) ||
        empty($_POST['montant_total']) ||
        empty($_POST['statut']) ||
        !is_numeric($_POST['montant_total']) ||
        floatval($_POST['montant_total']) <= 0
    ) {
        $error = 'Veuillez remplir tous les champs obligatoires et vérifier le montant.';
    } else {
        $facture = new Facture(
            null,
            $_POST['numero_facture'],
            $_POST['date_facture'],
            $_POST['montant_total'],
            $_POST['statut'],
            $_POST['client_nom'],
            $_POST['paiement_id']
        );
        $message = $factureC->addFacture($facture);
    }
}

$pid = isset($_GET['paiement_id']) ? intval($_GET['paiement_id']) : (isset($_POST['paiement_id']) ? intval($_POST['paiement_id']) : '');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter une facture</title>
  <link id="pagestyle" href="back-office/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>
<body class="bg-gray-100">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header bg-gradient-dark text-white">Ajouter une facture</div>
        <div class="card-body">
          <?php if($message) echo '<div class="alert alert-info">'.$message.'</div>'; ?>
          <?php if($error) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
          <form method="POST">
            <input type="hidden" name="paiement_id" value="<?= htmlspecialchars($pid) ?>">
            <div class="mb-3">
              <label for="numero_facture" class="form-label">Numéro Facture</label>
              <input type="text" class="form-control" id="numero_facture" name="numero_facture">
            </div>
            <div class="mb-3">
              <label for="date_facture" class="form-label">Date Facture</label>
              <input type="date" class="form-control" id="date_facture" name="date_facture">
            </div>
            <div class="mb-3">
              <label for="montant_total" class="form-label">Montant Total</label>
              <input type="number" step="0.01" class="form-control" id="montant_total" name="montant_total">
            </div>
            <div class="mb-3">
              <label for="statut" class="form-label">Statut</label>
              <input type="text" class="form-control" id="statut" name="statut">
            </div>
            <div class="mb-3">
              <label for="client_nom" class="form-label">Nom du Client</label>
              <input type="text" class="form-control" id="client_nom" name="client_nom">
            </div>
            <button type="submit" class="btn btn-dark">Ajouter</button>
            <a href="facture_list.php?paiement_id=<?= htmlspecialchars($pid) ?>" class="btn btn-outline-dark ms-2">Retour</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
