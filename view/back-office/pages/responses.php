<?php
session_start();
require_once '../../../controller/reponseC.php';

$reponseC = new ReponseC();
$listeReponses = $reponseC->listReponses();
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
        Gestion des Réponses aux Réclamations
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
                    <h6 class="font-weight-bold mb-0">Gestion des Réponses</h6>
                </nav>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4 px-5">
            <!-- Display success or error messages -->
            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?= $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php } ?>

            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php } ?>

            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6
                                        class="font-weight-semibold text-lg mb-0">
                                        Liste des réponses</h6>
                                    <p class="text-sm">Liste de toutes les
                                        réponses aux réclamations</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <a href="add-response.php"
                                        class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
                                        <span class="btn-inner--icon">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                        <span class="btn-inner--text">Ajouter
                                            une réponse</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th
                                                class="text-secondary text-xs font-weight-semibold opacity-7">
                                                ID</th>
                                            <th
                                                class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Réclamation</th>
                                            <th
                                                class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Email Client</th>
                                            <th
                                                class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Répondu Par</th>
                                            <th
                                                class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Date de Réponse</th>
                                            <th
                                                class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listeReponses as $reponse) { ?>
                                            <tr>
                                                <td
                                                    class="text-sm text-dark font-weight-semibold ps-4">
                                                    <?= $reponse['id'] ?></td>
                                                <td
                                                    class="text-sm text-dark font-weight-semibold">
                                                    <?= htmlspecialchars($reponse['sujet']) ?>
                                                </td>
                                                <td
                                                    class="text-sm text-dark font-weight-semibold">
                                                    <?= htmlspecialchars($reponse['email']) ?>
                                                </td>
                                                <td
                                                    class="text-sm text-dark font-weight-semibold">
                                                    <?= htmlspecialchars($reponse['staff_name']) ?>
                                                </td>
                                                <td
                                                    class="text-sm text-dark font-weight-semibold">
                                                    <?= htmlspecialchars($reponse['date_reponse']) ?>
                                                </td>
                                                <td class="text-sm">
                                                    <a href="view-response.php?id=<?= $reponse['id'] ?>"
                                                        class="btn btn-sm btn-info mb-0">Voir</a>
                                                    <a href="edit-response.php?id=<?= $reponse['id'] ?>"
                                                        class="btn btn-sm btn-primary mb-0">Modifier</a>
                                                    <button
                                                        onclick="deleteReponse(<?= $reponse['id'] ?>)"
                                                        class="btn btn-sm btn-danger mb-0">Supprimer</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom scripts -->
    <script>
        function deleteReponse(id) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Cette action est irréversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `delete-response.php?id=${id}`;
                }
            })
        }
    </script>
</body>

</html>