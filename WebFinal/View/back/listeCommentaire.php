<?php
session_start();

// Check if the user is logged in and has a user_id in the session
if (!isset($_SESSION['user'])) {
    die("User not logged in. Please log in to add a comment.");
}

require_once('../../model/Commentaire.php');

// Handle Add Comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addCommentaire'])) {
    $id_blog = $_POST['id_blog'];
    $id_user = $_SESSION['user'];
    $contenu = $_POST['contenu'];
    // Add the comment
    Commentaire::ajouterCommentaire($id_blog, $id_user, $contenu);
    header("Location: listeCommentaire.php");
    exit();
}

// Handle Edit Comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editCommentaire'])) {
    $id_commentaire = $_POST['id_commentaire'];
    $comment = Commentaire::getCommentById($id_commentaire);
    if ($comment) {
        // Use the comment details
        $id_blog = $comment['id_blog'];
        $id_user = $comment['id_user'];
        $contenu = $comment['contenu'];
        $date_creation = $comment['date_creation'];
    } else {
        // Handle the case where the comment is not found
        echo "Comment not found.";
    }

    // Update the comment
    Commentaire::modifierCommentaire($id_commentaire, $contenu);
    header("Location: listeCommentaire.php");
    exit();
}

// Handle Delete Comment
if (isset($_GET['delete'])) {
    $id_commentaire = $_GET['delete'];
    Commentaire::supprimerCommentaire($id_commentaire);
    header("Location: listeCommentaire.php");
    exit();
}

$commentaires = Commentaire::listeCommentaires();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon type=" image/png" href="../../assets/img/favicon.png">
    <title>
        Material Dashboard 3 by Creative Tim
    </title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,6,900" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand px-4 py-3 m-0"
                href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
                <img src="assets/img/logo-ct-dark.png" class="navbar-brand-img" width="26" height="26" alt="main_logo">
                <span class="ms-1 text-sm text-dark">StartHUB</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="dashboard.php">
                        <i class="material-symbols-rounded opacity-5">dashboard</i>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  text-dark" href="listeBlog.php">
                        <i class="material-symbols-rounded opacity-5">table_view</i>
                        <span class="nav-link-text ms-1">Blogs</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark active" href="listeCommentaire.php">
                        <i class="material-symbols-rounded opacity-5">table_view</i>
                        <span class="nav-link-text ms-1">Commentaires</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="evenementback.php">
                        <i class="material-symbols-rounded opacity-5">table_view</i>
                        <span class="nav-link-text ms-1">Evenement</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link   text-dark" href="reservationback.php">
                        <i class="material-symbols-rounded opacity-5">receipt_long</i>
                        <span class="nav-link-text ms-1">Réservation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">
                        <i class="material-symbols-rounded opacity-5">view_in_ar</i>
                        <span class="nav-link-text ms-1">Virtual Reality</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">
                        <i class="material-symbols-rounded opacity-5">format_textdirection_r_to_l</i>
                        <span class="nav-link-text ms-1">RTL</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="pages/notifications.html">
                        <i class="material-symbols-rounded opacity-5">notifications</i>
                        <span class="nav-link-text ms-1">Notifications</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages
                    </h6>
                </li>

            </ul>
        </div>

    </aside>
    <?php
require_once('../../model/Commentaire.php');
$commentaires = Commentaire::listeCommentaires();
?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
            data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Statistiques</li>
                    </ol>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group input-group-outline">
                            <label class="form-label">Type here...</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <ul class="navbar-nav d-flex align-items-center  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a class="btn btn-outline-primary btn-sm mb-0 me-3" target="_blank"
                                href="https://www.creative-tim.com/builder?ref=navbar-material-dashboard">Online
                                Builder</a>
                        </li>
                        <li class="mt-1">
                            <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard"
                                data-icon="octicon-star" data-size="large" data-show-count="true"
                                aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0">
                                <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="material-symbols-rounded">notifications</i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                                aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New message</span> from Laur
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i> 13 minutes ago
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item d-flex align-items-center">

                            <?php if (isset($_SESSION['user'])): ?>
                            <div class="nav-link d-flex align-items-center px-0">
                                <div class="rounded-circle me-2 d-flex justify-content-center align-items-center"
                                    style="width:30px; height:30px; background-color:#007bff; color:#fff; font-weight:bold;">
                                    <?= strtoupper(substr($_SESSION['user']['prenom'],0,1) . substr($_SESSION['user']['nom'],0,1)) ?>
                                </div>
                                <span class="me-3">
                                    <strong><?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?></strong>
                                </span>
                                <a href="../front/logout.php" class="text-danger">Déconnexion</a>
                            </div>
                            <?php else: ?>
                            <a href="../front/login.php" class="nav-link text-body font-weight-bold px-0">
                                <i class="material-symbols-rounded">account_circle</i>
                            </a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- End Navbar -->
        <div class="container-fluid py-2">

            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize m-0">Liste des Commentaires</h6>
                                <button class="btn btn-sm btn-light text-dark font-weight-bold" data-bs-toggle="modal"
                                    data-bs-target="#addCommentaireModal">
                                    <i class="fas fa-plus me-1"></i> Ajouter un Commentaire
                                </button>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ID Commentaire</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                ID Blog</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                ID User</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Contenu</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Date</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($commentaires as $commentaire): ?>
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    <?= htmlspecialchars($commentaire['id_commentaire']) ?></p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    <?= htmlspecialchars($commentaire['id_blog']) ?></p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    <?= htmlspecialchars($commentaire['id_user']) ?></p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0"
                                                    style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    <?= htmlspecialchars($commentaire['contenu']) ?>
                                                </p>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?= htmlspecialchars($commentaire['date_creation']) ?></span>
                                            </td>
                                            <td class="align-middle">
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editCommentaireModal"
                                                    onclick="loadCommentaireData(<?= $commentaire['id_commentaire'] ?>, '<?= htmlspecialchars($commentaire['contenu']) ?>')">
                                                    Modifier
                                                </button>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteCommentaireModal"
                                                    onclick="setDeleteLink(<?= $commentaire['id_commentaire'] ?>)">
                                                    Supprimer
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addCommentaireModal" tabindex="-1" aria-labelledby="addCommentaireModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCommentaireModalLabel">Ajouter un Commentaire</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="listeCommentaire.php">
                            <input type="hidden" name="addCommentaire" value="1">
                            <input type="hidden" name="id_blog" value="<?= $blog_id ?>">
                            <!-- Replace $blog_id with the actual blog ID -->
                            <div class="mb-3">
                                <label for="contenu" class="form-label">Contenu</label>
                                <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for Editing Comment -->
        <div class="modal fade" id="editCommentaireModal" tabindex="-1" aria-labelledby="editCommentaireModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCommentaireModalLabel">Modifier le Commentaire</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="listeCommentaire.php">
                            <input type="hidden" name="id_commentaire" id="editCommentaireId">
                            <input type="hidden" name="editCommentaire" value="1">
                            <div class="mb-3">
                                <label for="editContenu" class="form-label">Contenu</label>
                                <textarea class="form-control" id="editContenu" name="contenu" rows="5"
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Sauvegarder</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Deleting Comment -->
        <div class="modal fade" id="deleteCommentaireModal" tabindex="-1" aria-labelledby="deleteCommentaireModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCommentaireModalLabel">Supprimer le Commentaire</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Ê
                        <p>Êtes-vous sûr de vouloir supprimer ce commentaire ? Cette action est irréversible.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <a href="#" id="deleteCommentaireLink" class="btn btn-danger">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Core JS Files -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>

    <!-- JavaScript for Modals -->
    <script>
    // Function to load comment data into the edit modal
    function loadCommentaireData(id, contenu) {
        document.getElementById('editCommentaireId').value = id;
        document.getElementById('editContenu').value = contenu;
    }

    // Function to set the delete link in the delete modal
    function setDeleteLink(id) {
        document.getElementById('deleteCommentaireLink').href = `listeCommentaire.php?delete=${id}`;
    }
    </script>
</body>

</html>