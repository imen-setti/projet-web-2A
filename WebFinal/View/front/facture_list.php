<?php
require_once(__DIR__.'/../../controller/factureC.php');
$factureC = new FactureC();
$pid = isset($_GET['paiement_id']) ? intval($_GET['paiement_id']) : 0;
$factures = $factureC->getFacturesByPaiementId($pid);

// Debug
error_log("Paiement ID reçu: " . $pid);
error_log("Nombre de factures récupérées: " . count($factures));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la facture</title>
    <link rel="stylesheet" href="../back/assets/css/material-dashboard.css?v=3.2.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"/>
</head>
<body class="g-sidenav-show bg-gray-100">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Facture du paiement #<?= htmlspecialchars($pid) ?></h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Numéro Facture</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Montant Total</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Statut</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Client</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($factures)): ?>
                                        <?php foreach ($factures as $facture): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-3">
                                                        <div class="my-auto">
                                                            <h6 class="mb-0 text-sm"><?= $facture['id'] ?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-3">
                                                        <div class="my-auto">
                                                            <h6 class="mb-0 text-sm"><?= htmlspecialchars($facture['numero_facture']) ?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-3">
                                                        <div class="my-auto">
                                                            <h6 class="mb-0 text-sm"><?= htmlspecialchars($facture['date_facture']) ?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-3">
                                                        <div class="my-auto">
                                                            <h6 class="mb-0 text-sm"><?= htmlspecialchars($facture['montant_total']) ?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-3">
                                                        <div class="my-auto">
                                                            <h6 class="mb-0 text-sm"><?= htmlspecialchars($facture['statut']) ?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-3">
                                                        <div class="my-auto">
                                                            <h6 class="mb-0 text-sm"><?= htmlspecialchars($facture['client_nom']) ?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group px-3">
                                                        <a href="facture_show.php?id=<?= $facture['id'] ?>&paiement_id=<?= $pid ?>" 
                                                           class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i> Afficher
                                                        </a>
                                                        <a href="facture_edit.php?id=<?= $facture['id'] ?>&paiement_id=<?= $pid ?>" 
                                                           class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i> Modifier
                                                        </a>
                                                        <a href="exportpdf.php?id=<?= $facture['id'] ?>&paiement_id=<?= $pid ?>" 
                                                           class="btn btn-danger btn-sm">
                                                            <i class="fas fa-file-pdf"></i> PDF
                                                        </a>
                                                        <a href="facture_delete.php?id=<?= $facture['id'] ?>&paiement_id=<?= $pid ?>" 
                                                           class="btn btn-primary btn-sm"
                                                           onclick="return confirm('Voulez-vous vraiment supprimer cette facture ?')">
                                                            <i class="fas fa-trash"></i> Supprimer
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <p class="text-sm mb-0">Aucune facture trouvée pour ce paiement.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="liste.php" class="btn btn-outline-dark">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <a href="facture_add.php?paiement_id=<?= $pid ?>" class="btn btn-dark">
                                <i class="fas fa-plus"></i> Nouvelle facture
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
