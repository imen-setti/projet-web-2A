<?php
// Inclure les fichiers nécessaires
require_once('C:\xampp\htdocs\nada\controller\paiementC.php');
require_once('C:\xampp\htdocs\nada\model\paiement.php');

$paiement = null;
$paiementC = new PaiementC();

if (
    isset($_POST["montant"], $_POST["devise"], $_POST["methode"], $_POST["carte"], $_POST["description"]) &&
    !empty($_POST["montant"]) &&
    !empty($_POST["devise"]) &&
    !empty($_POST["methode"]) &&
    !empty($_POST["carte"]) &&
    !empty($_POST["description"])
) {
    // Création de l'objet Paiement avec les données du formulaire
    $paiement = new Paiement(
        null,   // id auto-incrémenté
        $_POST['montant'],
        $_POST['devise'],
        $_POST['methode'],
        $_POST['carte'],
        $_POST['description']
    );

    // Appel de la méthode d'ajout
    $paiementC->updatePaiement($paiement,$_GET['id']);
    header('Location: liste.php'); // Rediriger après ajout
}
?>



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
   
  <nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-2">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Dashboard</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tables</li>
          </ol>
          <h6 class="font-weight-bold mb-0">      Mise a jour  des paiements  
          </h6>
          <ul class="list-group">
		
     <!-- End Navbar -->
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-lg-0">
                <div class="card h-200">
                    <div class="card-header pb-10 p-30">
                        <div class="row">
                             
                                 <button class="btn btn-outline-primary btn-sm mb-2"> <a href="liste.php">
                                        Retour
                                        à la liste </a></button>
                                <?php
                                if (isset($_GET['id'])) {
                                    $oldpaiement = $paiementC->showPaiement($_GET['id']);
                                    ?>
                                </div>
                                <form action="" method="POST">
                            <div class="card-body p-2 pb-5">
                                <ul class="list-group">
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <tr>
                                                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                    <td><label for="id">ID :</label></td>
                                                </h6>
                                                <span class="text-xs">
                                                    <td>
                                                        <input type="text" id="id" name="id"
                                                            value="<?php echo $_GET['id'] ?>" readonly />
                                                    </td>
                                                </span>
                                            </tr>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-group">
    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">
            <tr>
                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                    <td><label for="montant">montant :</label></td>
                </h6>
                <span class="text-xs">
                    <td><input type="text" id="montant" name="montant" value="<?php echo $oldpaiement['montant']; ?>" /></td>
                </span>
            </tr>
        </div>
    </li>
</ul>

<ul class="list-group">
    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">
            <tr>
                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                    <td><label for="devise">devise :</label></td>
                </h6>
                <span class="text-xs">
                    <td>
                        <select id="devise" name="devise">
                            <option value="TND" <?php if ($oldpaiement['devise'] == 'TND') echo 'selected'; ?>>TND (Dinar) </option>
                          <option value="EUR" <?php if ($oldpaiement['devise'] == 'EUR') echo ' '; ?>>EUR (Euro )</option>
                          <option value="USD" <?php if ($oldpaiement['devise'] == 'USD') echo ' '; ?>>USD (Dollar )</option>

                        </select>
                    </td>
                </span>
            </tr>
        </div>
    </li>
</ul>
<ul class="list-group">
    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">
            <tr>
                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                    <td><label for="methode">methode du paiemnt  :</label></td>
                </h6>
                <span class="text-xs">
                    <td>
                        <select id="methode" name="methode">
                            <option value="Cash" <?php if ($oldpaiement['methode'] == 'Cash') echo 'selected'; ?>> Cash </option>
                          <option value="PayPal" <?php if ($oldpaiement['methode'] == 'PayPal') echo ' '; ?>> PayPal</option>
                          <option value="Virement Bancaire" <?php if ($oldpaiement['methode'] == 'Virement Bancaire') echo ' '; ?>>Virement Bancaire</option>
                          <option value="Carte Bancaire" <?php if ($oldpaiement['methode'] == 'Carte Bancaire') echo ' '; ?>>Carte Bancaire</option>

                        </select>
                    </td>
                </span>
            </tr>
        </div>
    </li>
</ul>

<ul class="list-group">
    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">
            <tr>
                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                    <td><label for="carte">carte :</label></td>
                </h6>
                <span class="text-xs">
                    <td><input type="text" id="carte" name="carte" value="<?php echo $oldpaiement['carte']; ?>" /></td>
                </span>
            </tr>
        </div>
    </li>
</ul>

<ul class="list-group">
    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">
            <tr>
                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                    <td><label for="description">description :</label></td>
                </h6>
                <span class="text-xs">
                    <td><input type="text" id="description" name="description" value="<?php echo $oldpaiement['description']; ?>" /></td>
                </span>
            </tr>
        </div>
    </li>
</ul>

 
 

                              
                             
                            
                            
                            
 
  
                                </div>
                                <ul>
                                    <input class="btn btn-outline-primary btn-sm mb-0" type="submit" value="Update">
                                    <input class="btn btn-outline-primary btn-sm mb-0" type="reset" value="Reset">

                                </ul>

                            </form>
                            <?php }                                ?>


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