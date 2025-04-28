<?php


require_once __DIR__ . '/../../controller/UserController.php';

$controller = new UserController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'update') {
        
        $controller->update();
    } elseif ($action === 'delete') {
        $controller->delete();
    }
}

$users = $controller->afficherUsers();
?>
<<<<<<< HEAD

=======
>>>>>>> 70499b9bcc7183004bd0a9a31ee83419233a63a4
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
                    <a class="nav-link active bg-gradient-dark text-white" href="dashboard.php">
                        <i class="material-symbols-rounded opacity-5">dashboard</i>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="evenementback.php">
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
        <div class="container-fluid py-2">
            <div class="row">
                <div class="ms-3">
                    <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
                    
                </div>
                <div class="container mt-5">
    <h2 class="mb-4">Liste des Utilisateurs</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
          
          <th>Nom</th>
          <th>Prénom</th>
          <th>Email</th>
          <th>Password</th>
          <th>Téléphone</th>
          <th>Sexe</th>
          <th>Rôle</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($users)): ?>
          <?php foreach ($users as $user): ?>
            <tr>
              
              <td><?= htmlspecialchars($user['nom']) ?></td>
              <td><?= htmlspecialchars($user['prenom']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= htmlspecialchars($user['password']) ?></td>
              <td><?= htmlspecialchars($user['numtel']) ?></td>
              <td><?= htmlspecialchars($user['sexe']) ?></td>
              <td><?= htmlspecialchars($user['role']) ?></td>
              <td>
                <!-- Bouton Modifier : Ouvre le modal avec les données via data-* -->
                <button 
                  class="btn btn-sm btn-primary action-btn editBtn"
                  data-id="<?= $user['iduser'] ?>"
                  data-nom="<?= htmlspecialchars($user['nom']) ?>"
                  data-prenom="<?= htmlspecialchars($user['prenom']) ?>"
                  data-email="<?= htmlspecialchars($user['email']) ?>"
                  data-password="<?= htmlspecialchars($user['password']) ?>"
                  data-numtel="<?= htmlspecialchars($user['numtel']) ?>"
                  data-sexe="<?= htmlspecialchars($user['sexe']) ?>"
                  data-role="<?= htmlspecialchars($user['role']) ?>"
                  data-bs-toggle="modal" data-bs-target="#editUserModal"
                >Modifier</button>
                <!-- Bouton Supprimer : Ouvre le modal de confirmation -->
               <!-- Exemple d'un bouton de suppression dans un tableau -->
               <a href="javascript:void(0);" onclick="confirmerSuppression(<?= $user['iduser'] ?>)" class="btn btn-danger">Supprimer</a>

              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="text-center">Aucun utilisateur trouvé.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Modal de modification -->
  <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Le formulaire de modification pointe vers index.php avec action=update -->
        <form id="editUserForm" action="dashboard.php?action=update" method="POST" novalidate>
          <div class="modal-header">
            <h5 class="modal-title" id="editUserModalLabel">Modifier l'utilisateur</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <!-- Champ caché pour l'ID -->
            <input type="hidden" id="editId" name="id">
            <div class="mb-3">
              <label for="editNom" class="form-label">Nom</label>
              <input type="text" class="form-control" id="editNom" name="nom" required>
              <span class="error text-danger" id="errorEditNom"></span>
            </div>
            <div class="mb-3">
              <label for="editPrenom" class="form-label">Prénom</label>
              <input type="text" class="form-control" id="editPrenom" name="prenom" required>
              <span class="error text-danger" id="errorEditPrenom"></span>
            </div>
            <div class="mb-3">
              <label for="editEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="editEmail" name="email" required>
              <span class="error text-danger" id="errorEditEmail"></span>
            </div>
            <div class="mb-3">
                <label for="editPassword" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="editPassword" name="password" required>
                <span class="error text-danger" id="errorEditPassword"></span>
            </div>

            <div class="mb-3">
              <label for="editNumtel" class="form-label">Téléphone</label>
              <input type="text" class="form-control" id="editNumtel" name="numtel" placeholder="+XXX XXXXXXXX" required>
              <span class="error text-danger" id="errorEditNumtel"></span>
            </div>
            <div class="mb-3">
              <label for="editSexe" class="form-label">Sexe</label>
              <select class="form-select" id="editSexe" name="sexe" required>
                <option value="">Sélectionnez le sexe</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
              </select>
              <span class="error text-danger" id="errorEditSexe"></span>
            </div>
            <div class="mb-3">
              <label for="editRole" class="form-label">Rôle</label>
              <select class="form-select" id="editRole" name="role" required>
                <option value="">Sélectionnez le rôle</option>
                <option value="admin">Admin</option>
                <option value="client">Client</option>
                <option value="organisateur">Organisateur</option>
              </select>
              <span class="error text-danger" id="errorEditRole"></span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  

  <!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="deleteUserForm" action="dashboard.php?action=delete" method="GET">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteUserModalLabel">Confirmer la suppression</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="deleteId" name="id">
          <p>Êtes-vous sûr de vouloir supprimer l'utilisateur <strong id="deleteNom"></strong> ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-danger">Oui, supprimer</button>
        </div>
      </form>
    </div>
  </div>
</div>

  
  <!-- Inclusion du JS Bootstrap Bundle qui inclut Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    // Remplissage du modal de modification
    const editButtons = document.querySelectorAll('.editBtn');
    editButtons.forEach(button => {
      button.addEventListener('click', function () {
        document.getElementById('editId').value = this.dataset.id;
        document.getElementById('editNom').value = this.dataset.nom;
        document.getElementById('editPrenom').value = this.dataset.prenom;
        document.getElementById('editEmail').value = this.dataset.email;
        document.getElementById('editPassword').value = this.dataset.password;
        document.getElementById('editNumtel').value = this.dataset.numtel;
        document.getElementById('editSexe').value = this.dataset.sexe;
        document.getElementById('editRole').value = this.dataset.role;

        // Reset erreurs
        document.querySelectorAll('#editUserForm .error').forEach(span => span.textContent = '');
        
      });
    });

    // Remplissage du modal de suppression
    const deleteButtons = document.querySelectorAll('.deleteBtn');
    deleteButtons.forEach(button => {
      button.addEventListener('click', function () {
        document.getElementById('deleteId').value = this.dataset.id;
        document.getElementById('deleteNom').textContent = this.dataset.nom;
      });
    });

    // Validation JS lors de la soumission du formulaire de modification
    const form = document.getElementById('editUserForm');
    form.addEventListener('submit', function (e) {
      let valid = true;

      const nom = document.getElementById('editNom').value.trim();
      const prenom = document.getElementById('editPrenom').value.trim();
      const email = document.getElementById('editEmail').value.trim();
      const numtel = document.getElementById('editNumtel').value.trim();
      const sexe = document.getElementById('editSexe').value;
      const role = document.getElementById('editRole').value;
      const password = document.getElementById('editPassword').value.trim();

      // Regex
      const regexNom = /^[a-zA-ZÀ-ÿ\s\-]+$/;
      const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const regexTel = /^\+\d{3}\s\d{8}$/;

      // Nettoyage erreurs
      document.querySelectorAll('#editUserForm .error').forEach(span => span.textContent = '');

      if (nom === "") {
        document.getElementById('errorEditNom').textContent = "Le nom est obligatoire.";
        valid = false;
      } else if (!regexNom.test(nom)) {
        document.getElementById('errorEditNom').textContent = "Le nom ne doit contenir que des lettres.";
        valid = false;
      }

      if (prenom === "") {
        document.getElementById('errorEditPrenom').textContent = "Le prénom est obligatoire.";
        valid = false;
      } else if (!regexNom.test(prenom)) {
        document.getElementById('errorEditPrenom').textContent = "Le prénom ne doit contenir que des lettres.";
        valid = false;
      }

      if (email === "") {
        document.getElementById('errorEditEmail').textContent = "L'email est obligatoire.";
        valid = false;
      } else if (!regexEmail.test(email)) {
        document.getElementById('errorEditEmail').textContent = "Format d'email invalide.";
        valid = false;
      }

      if (numtel === "") {
        document.getElementById('errorEditNumtel').textContent = "Le téléphone est obligatoire.";
        valid = false;
      } else if (!regexTel.test(numtel)) {
        document.getElementById('errorEditNumtel').textContent = "Format de téléphone invalide (+XXX XXXXXXXX).";
        valid = false;
      }

      if (sexe === "") {
        document.getElementById('errorEditSexe').textContent = "Le sexe est obligatoire.";
        valid = false;
      }

      if (role === "") {
        document.getElementById('errorEditRole').textContent = "Le rôle est obligatoire.";
        valid = false;
      }
      if (password === "") {
  document.getElementById('errorEditPassword').textContent = "Le mot de passe est obligatoire.";
  valid = false;
}

      if (password !== "" && password.length < 6) {
        document.getElementById('errorEditPassword').textContent = "Le mot de passe doit contenir au moins 6 caractères.";
        valid = false;
      }

      if (!valid) e.preventDefault();
    });
  });
</script>
<script>
    function confirmerSuppression(id) {
        // Afficher une boîte de confirmation
        var confirmation = confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");
        
        // Si l'utilisateur confirme, rediriger vers la page de suppression
        if (confirmation) {
            window.location.href = "dashboard.php?action=delete&id=" + id;
        }
    }
</script>



                <!-- Github buttons -->
                <script async defer src="https://buttons.github.io/buttons.js"></script>

                <script src="assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>