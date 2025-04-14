<?php

require_once __DIR__ . '/../../controller/EvenementController.php';

$evenementController = new EvenementController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    // Appeler la méthode pour ajouter un événement
    $evenementController->add();
}

// Mise à jour d'un événement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Vérification si l'ID existe et n'est pas vide
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Appeler la méthode pour mettre à jour l'événement
        $evenementController->update();
    }
}

// Suppression d'un événement
if (isset($_GET['delete'])) {
    $idEvenement = $_GET['delete'];

    // Supprimer l'événement avec l'ID spécifié
    if ($evenementController->supprimerEvenement($idEvenement)) {
        header('Location: evenementback.php?success=Événement supprimé avec succès');
        exit;
    } else {
        header('Location: evenementback.php?error=Erreur lors de la suppression');
        exit;
    }
}
// Afficher les événements
$evenements = $evenementController->afficherEvenements();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <title>
    StartHUB
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
                <img src="assets/img/logo-ct-dark.png" class="navbar-brand-img" width="26" height="26" alt="main_logo">
                <span class="ms-1 text-sm text-dark">Creative Tim</span>
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
                    <a class="nav-link active bg-gradient-dark text-white" href="evenementback.php">
                        <i class="material-symbols-rounded opacity-5">table_view</i>
                        <span class="nav-link-text ms-1">Evenement</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="reservationback.php">
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
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="pages/profile.html">
                        <i class="material-symbols-rounded opacity-5">person</i>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="pages/sign-in.html">
                        <i class="material-symbols-rounded opacity-5">login</i>
                        <span class="nav-link-text ms-1">Sign In</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="pages/sign-up.html">
                        <i class="material-symbols-rounded opacity-5">assignment</i>
                        <span class="nav-link-text ms-1">Sign Up</span>
                    </a>
                </li>
            </ul>
        </div>

    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
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
                            <a class="btn btn-outline-primary btn-sm mb-0 me-3" target="_blank" href="https://www.creative-tim.com/builder?ref=navbar-material-dashboard">Online Builder</a>
                        </li>
                        <li class="mt-1">
                            <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
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
                            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="material-symbols-rounded">notifications</i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
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
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New album</span> by Travis Scott
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i> 1 day
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                                <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <title>credit-card</title>
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                              <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(453.000000, 454.000000)">
                                  <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                  <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                </g>
                              </g>
                            </g>
                          </g>
                        </svg>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Payment successfully completed
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i> 2 days
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item d-flex align-items-center">
                            <a href="../pages/sign-in.html" class="nav-link text-body font-weight-bold px-0">
                                <i class="material-symbols-rounded">account_circle</i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container mt-5">
    <h2>Gestion des événements</h2>

    <!-- Messages de succès -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <!-- Bouton Ajouter un événement -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#ajoutModal">Ajouter un événement</button>

    <!-- Modal d'ajout d'événement -->
    <div class="modal fade" id="ajoutModal" tabindex="-1" aria-labelledby="ajoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajoutModalLabel">Ajouter un événement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="ajoutForm" novalidate>

                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="titre" name="titre">
                            <span class="error text-danger" id="errorTitre"></span>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                            <span class="error text-danger" id="errorDescription"></span>
                        </div>

                        <div class="mb-3">
                            <label for="categorie" class="form-label">Catégorie</label>
                            <input type="text" class="form-control" id="categorie" name="categorie">
                            <span class="error text-danger" id="errorCategorie"></span>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" placeholder="YYYY-MM-DD">
                            <span class="error text-danger" id="errorDate"></span>
                        </div>

                        <div class="mb-3">
                            <label for="lieu" class="form-label">Lieu</label>
                            <input type="text" class="form-control" id="lieu" name="lieu">
                            <span class="error text-danger" id="errorLieu"></span>
                        </div>

                        <div class="mb-3">
                            <label for="idorganisateur" class="form-label">ID Organisateur</label>
                            <input type="text" class="form-control" id="idorganisateur" name="idorganisateur">
                            <span class="error text-danger" id="errorIdOrganisateur"></span>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>


                        <button type="submit" name="ajouter" class="btn btn-primary">Ajouter l'événement</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Affichage des événements -->

<!-- Affichage des événements -->
<h3 class="mt-5">Liste des événements</h3>
<table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Catégorie</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>Organisateur</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($evenements as $evenement): ?>
            <tr>
                <td><?= htmlspecialchars($evenement['titre']) ?></td>
                <td><?= htmlspecialchars($evenement['description']) ?></td>
                <td><?= htmlspecialchars($evenement['categorie']) ?></td>
                <td><?= htmlspecialchars($evenement['date']) ?></td>
                <td><?= htmlspecialchars($evenement['lieu']) ?></td>
                <td><?= htmlspecialchars($evenement['idorganisateur']) ?></td>
                <td>
                    <!-- Modifier l'événement -->
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modifierModal<?= $evenement['idevenement'] ?>">Modifier</button>
                    <!-- Supprimer l'événement -->
                    <a href="evenementback.php?delete=<?= $evenement['idevenement'] ?>" class="btn btn-danger" onclick="return confirmDeletion(<?= $evenement['idevenement'] ?>)">Supprimer</a>
                </td>
            </tr>
             <!-- Modal Modifier -->
             <div class="modal fade" id="modifierModal<?= $evenement['idevenement'] ?>" tabindex="-1" aria-labelledby="modifierModalLabel<?= $evenement['idevenement'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modifierModalLabel<?= $evenement['idevenement'] ?>">Modifier l'événement</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="evenementback.php" method="POST" novalidate onsubmit="return validateForm(this)">
                                <input type="hidden" name="id" value="<?= $evenement['idevenement'] ?>"> <!-- ID de l'événement -->
                                <input type="hidden" name="update" value="1"> <!-- Indicateur de mise à jour -->

                                <div class="mb-3">
                                    <label for="titre" class="form-label">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre" value="<?= htmlspecialchars($evenement['titre']) ?>" required>
                                    <div id="titreError" class="text-danger"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($evenement['description']) ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="categorie" class="form-label">Catégorie</label>
                                    <input type="text" class="form-control" id="categorie" name="categorie" value="<?= htmlspecialchars($evenement['categorie']) ?>" required>
                                    <div id="categorieError" class="text-danger"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" value="<?= htmlspecialchars($evenement['date']) ?>" required>
                                    <div id="dateError" class="text-danger"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="lieu" class="form-label">Lieu</label>
                                    <input type="text" class="form-control" id="lieu" name="lieu" value="<?= htmlspecialchars($evenement['lieu']) ?>" required>
                                    <div id="lieuError" class="text-danger"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="idorganisateur" class="form-label">Organisateur</label>
                                    <input type="text" class="form-control" id="idorganisateur" name="idorganisateur" value="<?= htmlspecialchars($evenement['idorganisateur']) ?>" required>
                                    <div id="idorganisateurError" class="text-danger"></div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Sauvegarder les modifications</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function confirmDeletion(idEvenement) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ? Cette action est irréversible.')) {
            window.location.href = 'evenementback.php?delete=' + idEvenement;
        } else {
            return false;  // Empêche l'exécution du lien si l'utilisateur annule
        }
    }

    function validateForm(form) {
        let isValid = true;

        // Reset error messages
        document.getElementById('titreError').textContent = '';
        document.getElementById('categorieError').textContent = '';
        document.getElementById('dateError').textContent = '';
        document.getElementById('lieuError').textContent = '';
        document.getElementById('idorganisateurError').textContent = '';

        // Vérification du titre (lettres uniquement)
        const titre = form['titre'].value;
        if (!/^[a-zA-Z\s]+$/.test(titre)) {
            document.getElementById('titreError').textContent = 'Le titre ne doit contenir que des lettres.';
            isValid = false;
        }

        // Vérification de la catégorie (lettres uniquement)
        const categorie = form['categorie'].value;
        if (!/^[a-zA-Z\s]+$/.test(categorie)) {
            document.getElementById('categorieError').textContent = 'La catégorie ne doit contenir que des lettres.';
            isValid = false;
        }

        // Vérification de la date (doit être supérieure à aujourd\'hui)
        const date = new Date(form['date'].value);
        const today = new Date();
        if (date <= today) {
            document.getElementById('dateError').textContent = 'La date doit être supérieure à aujourd\'hui.';
            isValid = false;
        }

        // Vérification du lieu (lettres et chiffres uniquement)
        const lieu = form['lieu'].value;
        if (!/^[a-zA-Z0-9\s]+$/.test(lieu)) {
            document.getElementById('lieuError').textContent = 'Le lieu ne doit contenir que des lettres et des chiffres.';
            isValid = false;
        }

        // Vérification de l'ID de l'organisateur (chiffres uniquement)
        const idorganisateur = form['idorganisateur'].value;
        if (!/^\d+$/.test(idorganisateur)) {
            document.getElementById('idorganisateurError').textContent = 'L\'ID de l\'organisateur doit être un nombre.';
            isValid = false;
        }

        return isValid;
    }
</script>


<!-- Inclusion du JS Bootstrap Bundle qui inclut Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Validation du formulaire d'ajout d'événement
    const form = document.querySelector('form');
    form.addEventListener('submit', function (e) {
        let valid = true;

        // Récupérer les valeurs des champs
        const titre = document.getElementById('titre').value.trim();
        const description = document.getElementById('description').value.trim();
        const categorie = document.getElementById('categorie').value.trim();
        const date = document.getElementById('date').value.trim();
        const lieu = document.getElementById('lieu').value.trim();
        const idorganisateur = document.getElementById('idorganisateur').value.trim();

        // Regex pour les champs
        const regexTitreCategorie = /^[a-zA-ZÀ-ÿ\s\-]+$/;  // Lettres, espaces et tirets pour titre et catégorie
        const regexLieu = /^[a-zA-Z0-9\s\-]+$/;  // Lettres, chiffres, espaces et tirets pour lieu
        const regexIdOrganisateur = /^[0-9]+$/;  // Seulement des chiffres pour idorganisateur
        const today = new Date(); // Date actuelle

        // Réinitialiser les erreurs
        document.querySelectorAll('.error').forEach(span => span.textContent = '');

        // Validation des champs

        // Titre
        if (titre === "") {
            document.getElementById('errorTitre').textContent = "Le titre est obligatoire.";
            valid = false;
        } else if (!regexTitreCategorie.test(titre)) {
            document.getElementById('errorTitre').textContent = "Le titre ne doit contenir que des lettres.";
            valid = false;
        }

        // Description
        if (description === "") {
            document.getElementById('errorDescription').textContent = "La description est obligatoire.";
            valid = false;
        }

        // Catégorie
        if (categorie === "") {
            document.getElementById('errorCategorie').textContent = "La catégorie est obligatoire.";
            valid = false;
        } else if (!regexTitreCategorie.test(categorie)) {
            document.getElementById('errorCategorie').textContent = "La catégorie ne doit contenir que des lettres.";
            valid = false;
        }

        // Date
        if (date === "") {
            document.getElementById('errorDate').textContent = "La date est obligatoire.";
            valid = false;
        } else {
            const eventDate = new Date(date);
            if (eventDate <= today) {
                document.getElementById('errorDate').textContent = "La date doit être supérieure à la date actuelle.";
                valid = false;
            }
        }

        // Lieu
        if (lieu === "") {
            document.getElementById('errorLieu').textContent = "Le lieu est obligatoire.";
            valid = false;
        } else if (!regexLieu.test(lieu)) {
            document.getElementById('errorLieu').textContent = "Le lieu peut contenir des lettres et des chiffres.";
            valid = false;
        }

        // ID Organisateur
        if (idorganisateur === "") {
            document.getElementById('errorIdOrganisateur').textContent = "L'ID organisateur est obligatoire.";
            valid = false;
        } else if (!regexIdOrganisateur.test(idorganisateur)) {
            document.getElementById('errorIdOrganisateur').textContent = "L'ID organisateur doit contenir uniquement des chiffres.";
            valid = false;
        }

        // Si le formulaire est invalide, empêcher l'envoi
        if (!valid) e.preventDefault();
    });

});
</script>


</body>

</html>