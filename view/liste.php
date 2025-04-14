<?php



// Include the necessary userC.php file
require_once('C:\xampp\htdocs\nada\controller\paiementC.php');

// Create an instance of UserC class
$paiement = new paiementC();

// Fetch the list of users
$tab = $paiement->listPaiements();
?>

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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="back-office/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="back-office/assets/img/favicon.png">
  <title>
    Material Dashboard 3 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="back-office/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="back-office/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="back-office/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="back-office/assets/img/logo-ct-dark.png" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">Dashboard</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
   
     
        <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5"></i>
            <span class="nav-link-text ms-1">Gestion du paiement </span>
          </a>
        </li>
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn btn-outline-dark mt-4 w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree" type="button">Documentation</a>
        <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a>
      </div>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
 
       

    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Paiements </h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID </th>

                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Methode du paiement</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Devise</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Numero de carte </th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Montant</th>

                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Afficher </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Modifier  </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Supprimer </th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <?php
												foreach ($tab as $paiement) {
													?>
                  <tbody>
                    <tr>  
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">                            <?= $paiement['id']; ?>
                      </span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">  <?= $paiement['methode']; ?></span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">  <?= $paiement['devise']; ?></span>
                      </td>     <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">  <?= $paiement['carte']; ?></span>
                     
                    </td> 
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">  <?= $paiement['montant']; ?></span>
                     
                    </td>   
                        <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">  <?= $paiement['description']; ?></span>
                      </td> 
                          <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">           <a                 href="show.php?id=<?= $paiement['id']; ?>">ici</a>
                        </span>
                      </td>     <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">
                      <a  href="update.php?id=<?= $paiement['id']; ?>">ici</a>

                        </span>
                      </td>    
                       <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">
                            <a
                        href="delete.php?id=<?= $paiement['id']; ?>">ici</a>

                        </span>
                      </td>
                    </tr>
        
             
                  </tbody>
                  <?php
												}
												?>  
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
       
    
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="back-office/assets/js/core/popper.min.js"></script>
  <script src="back-office/assets/js/core/bootstrap.min.js"></script>
  <script src="back-office/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="back-office/assets/js/plugins/smooth-scrollbar.min.js"></script>
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
</body>

</html>