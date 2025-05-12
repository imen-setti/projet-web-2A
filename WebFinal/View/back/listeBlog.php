<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<?php
session_start();

// Check if the user is logged in and has a id_user in the session
if (!isset($_SESSION['user'])) {
    die("User not logged in. Please log in to add a blog.");
}

require_once('../../model/Blog.php');

// Handle Add Blog
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addBlog'])) {
    $id_user = $_SESSION['user']; // Get the id_user from the session
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $contenu = $_POST['contenu'];
    $date_creation = date('Y-m-d H:i:s'); // Current date and time

    // Handle image upload
    $image = null;
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $temp_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($temp_name, '../../uploads/' . $image);
    }

    // Instantiate the Blog class and add the blog
    $blog = new Blog($id_user, $titre, $auteur, $date_creation, $image, $contenu);
    $blog->ajouterBlog();
    header("Location: listeBlog.php");
    exit();
}

// Handle Edit Blog
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editBlog'])) {
    $id_blog = $_POST['id_blog'];
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $contenu = $_POST['contenu'];
    
    // Fetch the existing blog to get the current `id_user` and `date_creation`
    $existingBlog = Blog::getBlogById($id_blog);
    $id_user = $existingBlog['id_user'];
    $date_creation = $existingBlog['date_creation'];

    // Handle image upload if a new image is provided
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $temp_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($temp_name, '../../uploads/' . $image);
    } else {
        $image = $existingBlog['image']; // Keep the existing image if no new image is uploaded
    }

    // Update the blog with all required parameters
    Blog::modifierBlog($id_blog, $id_user, $titre, $auteur, $date_creation, $image, $contenu);
    header("Location: listeBlog.php");
}

// Handle Delete Blog
if (isset($_GET['delete'])) {
    $id_blog = $_GET['delete'];
    Blog::supprimerBlog($id_blog);
    header("Location: listeBlog.php");
    exit();
}

$blogs = Blog::listeBlogs();
?>
<!DOCTYPE html>
<html lang="en">

<!-- Update the paths in the <head> section -->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
    <title>
        Material Dashboard 3 by Creative Tim
    </title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,7,900" />
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
                    <a class="nav-link active text-dark" href="listeBlog.php">
                        <i class="material-symbols-rounded opacity-5">table_view</i>
                        <span class="nav-link-text ms-1">Blogs</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark" href="listeCommentaire.php">
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
                    <a class="nav-link  bg-gradient-dark text-whitek" href="reservationback.php">
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
                                <h6 class="text-white text-capitalize m-0">Liste des Blogs</h6>
                                <button class="btn btn-sm btn-light text-dark font-weight-bold" data-bs-toggle="modal"
                                    data-bs-target="#addBlogModal">
                                    <i class="fas fa-plus me-1"></i> Ajouter un Blog
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
                                                ID Blog</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                ID User</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Titre</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Auteur</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Date</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Image</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Contenu</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($blogs as $blog): ?>
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    <?= htmlspecialchars($blog['id_blog']) ?></p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    <?= htmlspecialchars($blog['id_user']) ?></p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    <?= htmlspecialchars($blog['titre']) ?></p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    <?= htmlspecialchars($blog['auteur']) ?></p>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-secondary text-xs font-weight-bold"><?= htmlspecialchars($blog['date_creation']) ?></span>
                                            </td>
                                            <td>
                                                <?php if (!empty($blog['image']) && file_exists('../uploads/' . $blog['image'])): ?>
                                                <img src="<?= '../uploads/' . htmlspecialchars($blog['image']) ?>"
                                                    width="100" height="60" class="border-radius-lg img-fluid"
                                                    alt="Image du blog">
                                                <?php else: ?>
                                                <span class="text-muted">Aucune image</span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <p class="text-xs text-secondary mb-0"
                                                    style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    <?= htmlspecialchars($blog['contenu']) ?>
                                                </p>
                                            </td>
                                            <td class="align-middle">
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editBlogModal"
                                                    onclick="loadBlogData(<?= $blog['id_blog'] ?>, '<?= htmlspecialchars($blog['titre']) ?>', '<?= htmlspecialchars($blog['auteur']) ?>', '<?= htmlspecialchars($blog['contenu']) ?>')">
                                                    Modifier
                                                </button>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteBlogModal"
                                                    onclick="setDeleteLink(<?= $blog['id_blog'] ?>)">
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
        <footer class="footer py-4  ">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            © <script>
                            document.write(new Date().getFullYear())
                            </script>,
                            made with <i class="fa fa-heart"></i> by
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative
                                Tim</a>
                            for a better web.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link text-muted"
                                    target="_blank">Creative Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted"
                                    target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted"
                                    target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                                    target="_blank">License</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        </div>
    </main>
    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="material-symbols-rounded py-2">settings</i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Material UI Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="material-symbols-rounded">clear</i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark active" data-color="dark"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark"
                        onclick="sidebarType(this)">Dark</button>
                    <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent"
                        onclick="sidebarType(this)">Transparent</button>
                    <button class="btn bg-gradient-dark px-3 mb-2  active ms-2" data-class="bg-white"
                        onclick="sidebarType(this)">White</button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
                <!-- Navbar Fixed -->
                <div class="mt-3 d-flex">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-3">
                <div class="mt-2 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-sm-4">
                <a class="btn bg-gradient-info w-100"
                    href="https://www.creative-tim.com/product/material-dashboard-pro">Free Download</a>
                <a class="btn btn-outline-dark w-100"
                    href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View
                    documentation</a>
                <div class="w-100 text-center">
                    <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard"
                        data-icon="octicon-star" data-size="large" data-show-count="true"
                        aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
                    <h6 class="mt-3">Thank you for sharing!</h6>
                    <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard"
                        class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard"
                        class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
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
    <!-- Modal for Editing Blog -->
    <div class="modal fade" id="editBlogModal" tabindex="-1" aria-labelledby="editBlogModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBlogModalLabel">Modifier le Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="listeBlog.php" enctype="multipart/form-data">
                        <input type="hidden" name="id_blog" id="editBlogId">
                        <input type="hidden" name="editBlog" value="1">
                        <div class="mb-3">
                            <label for="editTitre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="editTitre" name="titre" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAuteur" class="form-label">Auteur</label>
                            <input type="text" class="form-control" id="editAuteur" name="auteur" required>
                        </div>
                        <div class="mb-3">
                            <label for="editContenu" class="form-label">Contenu</label>
                            <textarea class="form-control" id="editContenu" name="contenu" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editImage" class="form-label">Image</label>
                            <input type="file" class="form-control" id="editImage" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Deleting Blog -->
    <div class="modal fade" id="deleteBlogModal" tabindex="-1" aria-labelledby="deleteBlogModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBlogModalLabel">Supprimer le Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer ce blog ? Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a href="#" id="deleteBlogLink" class="btn btn-danger">Supprimer</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Blog -->
    <div class="modal fade" id="addBlogModal" tabindex="-1" aria-labelledby="addBlogModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBlogModalLabel">Ajouter un Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="listeBlog.php" enctype="multipart/form-data">
                        <input type="hidden" name="addBlog" value="1">
                        <input type="hidden" name="id_user" value="<?= $_SESSION['user'] ?>">
                        <!-- Pass the id_user from the session -->
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="titre" name="titre" required>
                        </div>
                        <div class="mb-3">
                            <label for="auteur" class="form-label">Auteur</label>
                            <input type="text" class="form-control" id="auteur" name="auteur" required>
                        </div>
                        <div class="mb-3">
                            <label for="contenu" class="form-label">Contenu</label>
                            <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Function to load blog data into the edit modal
    function loadBlogData(id, titre, auteur, contenu) {
        document.getElementById('editBlogId').value = id;
        document.getElementById('editTitre').value = titre;
        document.getElementById('editAuteur').value = auteur;
        document.getElementById('editContenu').value = contenu;
    }

    // Function to set the delete link in the delete modal
    function setDeleteLink(id) {
        document.getElementById('deleteBlogLink').href = `listeBlog.php?delete=${id}`;
    }
    </script>
</body>

</html>