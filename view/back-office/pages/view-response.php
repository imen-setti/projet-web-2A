<?php
require_once '../../../controller/reponseC.php';

$reponseC = new ReponseC();
$error = "";

// Check if id exists in query parameter
if (!isset($_GET['id'])) {
    header("Location: responses.php");
    exit;
}

$id = $_GET['id'];

// Get the response details
try {
    $reponseDetails = $reponseC->showReponse($id);
    if (!$reponseDetails) {
        header("Location: responses.php");
        exit;
    }
} catch (Exception $e) {
    $error = $e->getMessage();
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
        Détails de la réponse
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
                    <h6 class="font-weight-bold mb-0">Détails de la réponse</h6>
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
                                        Détails de la réponse #<?= $id ?></h6>
                                    <p class="text-sm">Réponse à la réclamation:
                                        <?= htmlspecialchars($reponseDetails['sujet']) ?>
                                    </p>
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
                                    <a href="edit-response.php?id=<?= $id ?>"
                                        class="btn btn-sm btn-primary btn-icon d-flex align-items-center me-2">
                                        <span class="btn-inner--icon">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <span
                                            class="btn-inner--text">Modifier</span>
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

                                <div class="row mb-4">
                                    <div class="col-12 col-md-6">
                                        <div class="card border mb-4">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">Détails de la
                                                    réclamation</h6>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Sujet:</strong>
                                                    <?= htmlspecialchars($reponseDetails['sujet']) ?>
                                                </p>
                                                <p><strong>Client:</strong>
                                                    <?= htmlspecialchars($reponseDetails['email']) ?>
                                                </p>
                                                <p><strong>Date de
                                                        réclamation:</strong>
                                                    <?= htmlspecialchars($reponseDetails['daterec']) ?>
                                                </p>
                                                <p><strong>Statut:</strong>
                                                    <span
                                                        class="badge <?= $reponseDetails['status'] === 'En attente' ? 'bg-warning' : 'bg-success' ?>">
                                                        <?= htmlspecialchars($reponseDetails['status']) ?>
                                                    </span>
                                                </p>
                                                <p><strong>Description:</strong>
                                                </p>
                                                <div
                                                    class="border p-3 bg-gray-100 border-radius-lg">
                                                    <?= nl2br(htmlspecialchars($reponseDetails['reclamation_descrip'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="card border mb-4">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">Détails de la
                                                    réponse</h6>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Répondu par:</strong>
                                                    <?= htmlspecialchars($reponseDetails['staff_name']) ?>
                                                </p>
                                                <p><strong>Date de
                                                        réponse:</strong>
                                                    <?= htmlspecialchars($reponseDetails['date_reponse']) ?>
                                                </p>
                                                <p><strong>Contenu de la
                                                        réponse:</strong></p>
                                                <div
                                                    class="border p-3 bg-gray-100 border-radius-lg">
                                                    <?= nl2br(htmlspecialchars($reponseDetails['contenu'])) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
</body>

</html>