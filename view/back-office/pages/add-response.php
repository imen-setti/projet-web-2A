<?php
require_once '../../../controller/reclamationC.php';
require_once '../../../controller/reponseC.php';
require_once '../../../model/reponse.php';

$reclamationC = new ReclamationC();
$listeReclamations = $reclamationC->listReclamations();

$error = "";
$success = "";

if (isset($_POST['submit'])) {
    if (
        isset($_POST['reclamation_id']) &&
        isset($_POST['contenu']) &&
        isset($_POST['staff_name'])
    ) {
        if (
            !empty($_POST['reclamation_id']) &&
            !empty($_POST['contenu']) &&
            !empty($_POST['staff_name'])
        ) {
            $reponse = new Reponse(
                null,
                $_POST['reclamation_id'],
                $_POST['contenu'],
                date('Y-m-d H:i:s'),
                isset($_POST['staff_id']) ? $_POST['staff_id'] : 1,
                $_POST['staff_name']
            );

            $reponseC = new ReponseC();
            $success = $reponseC->addReponse($reponse);
        } else {
            $error = "Tous les champs sont obligatoires";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76"
        href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Ajouter une réponse
    </title>
    <!-- Fonts and icons -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
        rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js"
        crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/corporate-ui-dashboard.css?v=1.0.0"
        rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="../index.html">
                <img src="../assets/img/logo-ct-dark.png"
                    class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold">Admin Panel</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto h-auto"
            id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../index.html">
                        <div
                            class="icon icon-shape icon-sm text-center me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="fa fa-dashboard text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="responses.php">
                        <div
                            class="icon icon-shape icon-sm text-center me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="fa fa-reply text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Gestion des
                            Réponses</span>
                    </a>
                </li>
                <!-- Add other menu items here -->
            </ul>
        </div>
    </aside>
    <main
        class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded"
            id="navbarBlur" navbar-scroll="true">
            <div class="container-fluid py-1 px-2">
                <nav aria-label="breadcrumb">
                    <h6 class="font-weight-bold mb-0">Ajouter une réponse</h6>
                </nav>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6
                                        class="font-weight-semibold text-lg mb-0">
                                        Nouvelle réponse</h6>
                                    <p class="text-sm">Ajoutez une réponse à une
                                        réclamation</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <a href="responses.php"
                                        class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
                                        <span class="btn-inner--icon">
                                            <i class="fa fa-arrow-left"></i>
                                        </span>
                                        <span
                                            class="btn-inner--text">Retour</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="p-4">
                                <?php if ($error) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= $error ?>
                                    </div>
                                <?php } ?>
                                <?php if ($success) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <?= $success ?>
                                        <meta http-equiv="refresh"
                                            content="2;url=responses.php">
                                    </div>
                                <?php } ?>
                                <form method="POST" action="">
                                    <div class="form-group">
                                        <label for="reclamation_id"
                                            class="form-control-label">Réclamation</label>
                                        <select class="form-control"
                                            id="reclamation_id"
                                            name="reclamation_id" required>
                                            <option value="">-- Sélectionnez une
                                                réclamation --</option>
                                            <?php foreach ($listeReclamations as $reclamation) { ?>
                                                <option
                                                    value="<?= $reclamation['id'] ?>">
                                                    <?= htmlspecialchars($reclamation['sujet']) ?>
                                                    -
                                                    <?= htmlspecialchars($reclamation['email']) ?>
                                                    (<?= $reclamation['status'] ?>)
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="contenu"
                                            class="form-control-label">Contenu
                                            de la réponse</label>
                                        <textarea class="form-control"
                                            id="contenu" name="contenu" rows="5"
                                            required></textarea>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="staff_name"
                                            class="form-control-label">Votre
                                            nom</label>
                                        <input class="form-control" type="text"
                                            id="staff_name" name="staff_name"
                                            required>
                                    </div>
                                    <input type="hidden" name="staff_id"
                                        value="1">
                                    <div class="form-group mt-4">
                                        <button type="submit" name="submit"
                                            class="btn btn-primary">Envoyer la
                                            réponse</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer pt-3">
                <div class="container-fluid">
                    <div
                        class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div
                                class="copyright text-center text-xs text-muted text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>, Réalisé par <i class="fa fa-heart"></i> par
                                <a href="#" class="text-secondary"
                                    target="_blank">CreativeTeam</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script>
        // Show details of selected reclamation
        document.getElementById('reclamation_id').addEventListener('change', function () {
            const selectedId = this.value;
            // You could add AJAX code here to fetch and display reclamation details
        });
    </script>
</body>

</html>