<?php
// Démarrer la mise en tampon de la sortie pour éviter les erreurs de redirection
ob_start();


require_once(__DIR__ . '/../../model/Blog.php');


if (!isset($_GET['id'])) {
    header("Location: blog.php?error=ID du blog manquant.");
    exit();
}

$id_blog = $_GET['id']; 
$blog = Blog::getBlogById($id_blog);

if (!$blog) {
    header("Location: blog.php?error=Blog introuvable.");
    exit();
}

// Initialisation du tableau d'erreurs
$errors = [];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des valeurs du formulaire
    $id_user = $_POST['id_user'];
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $date_creation = $_POST['date_creation'];
    $contenu = $_POST['contenu'];

    // Validation de l'id_user
    if (!preg_match('/^\d+$/', $id_user)) {
        $errors['id_user'] = "L'identifiant utilisateur doit être un nombre.";
    }

    // Validation du titre
    if (empty($titre)) {
        $errors['titre'] = "Le titre est requis.";
    } elseif (strlen($titre) < 3) {
        $errors['titre'] = "Le titre doit contenir au moins 3 caractères.";
    }

    // Validation de l'auteur
    if (empty($auteur)) {
        $errors['auteur'] = "Le nom de l'auteur est requis.";
    } elseif (strlen($auteur) < 3) {
        $errors['auteur'] = "Le nom de l'auteur doit contenir au moins 3 caractères.";
    }

    // Validation de la date de création
    if (empty($date_creation)) {
        $errors['date_creation'] = "La date de création est requise.";
    }

    // Validation du contenu
    if (empty($contenu)) {
        $errors['contenu'] = "Le contenu est requis.";
    } elseif (strlen($contenu) < 50) {
        $errors['contenu'] = "Le contenu doit contenir au moins 50 caractères.";
    }

    // Vérifie si une image a été téléchargée
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target = "../../back/uploads/" . basename($image);
        
        // Vérification de la taille et du type d'image
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowed_types)) {
            $errors['image'] = "L'image doit être un fichier de type JPEG, PNG ou GIF.";
        }
        
        // Vérification de la taille de l'image (maximum 5 Mo)
        if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
            $errors['image'] = "L'image ne doit pas dépasser 5 Mo.";
        }

        if (!$errors['image']) {
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
        }
    } else {
        // Si aucune image n'a été téléchargée, conserve l'image existante
        $image = $blog['image'];
    }

    // Si aucune erreur, procéder à la modification
    if (empty($errors)) {
        Blog::modifierBlog($id_blog, $id_user, $titre, $auteur, $date_creation, $image, $contenu);
        header("Location: ./blog.php");
        exit();
    }
}

// Fin de la mise en tampon de la sortie
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>eLEARNING - eLearning HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
      rel="stylesheet"
    />

    <!-- Icon Font Stylesheet -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet" />
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet" />
  </head>

  <body>
    <!-- Spinner Start -->
    <div
      id="spinner"
      class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
    >
      <div
        class="spinner-border text-primary"
        style="width: 3rem; height: 3rem"
        role="status"
      >
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav
      class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0"
    >
      <a
        href="index.html"
        class="navbar-brand d-flex align-items-center px-4 px-lg-5"
      >
        <h2 class="m-0 text-primary">
          <i class="fa fa-book me-3"></i>starthub
        </h2>
      </a>
      <button
        type="button"
        class="navbar-toggler me-4"
        data-bs-toggle="collapse"
        data-bs-target="#navbarCollapse"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
          <a href="index.html" class="nav-item nav-link">Home</a>
          <a href="blog.php" class="nav-item nav-link active">Blog</a>
          <a href="courses.html" class="nav-item nav-link">Courses</a>
          <div class="nav-item dropdown">
            <a
              href="#"
              class="nav-link dropdown-toggle"
              data-bs-toggle="dropdown"
              >Pages</a
            >
            <div class="dropdown-menu fade-down m-0">
              <a href="team.html" class="dropdown-item">Our Team</a>
              <a href="testimonial.html" class="dropdown-item">Testimonial</a>
              <a href="404.html" class="dropdown-item">404 Page</a>
            </div>
          </div>
          <a href="contact.html" class="nav-item nav-link">Contact</a>
        </div>
        <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block"
          >Join Now<i class="fa fa-arrow-right ms-3"></i
        ></a>
      </div>
    </nav>
    <!-- Navbar End -->

    <!-- Header Start -->




<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier le Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <div class="card shadow-lg">
    <div class="card-header bg-gradient-dark text-white d-flex justify-content-between align-items-center">
      <h5 class="text-black text-capitalize m-0">Modifier le Blog</h5>
      <a href="blog.php" class="btn btn-sm btn-light text-dark font-weight-bold">← Retour</a>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        
        <!-- ID User -->
        <div class="mb-3">
          <label class="form-label">ID User :</label>
          <input type="text" name="id_user" value="<?= htmlspecialchars($blog['id_user']) ?>">
          <?php if (!empty($errors['id_user'])): ?>
            <div class="text-danger"><?= $errors['id_user'] ?></div>
          <?php endif; ?>
        </div>

        <!-- Titre -->
        <div class="mb-3">
          <label class="form-label">Titre :</label>
          <input type="text" name="titre" value="<?= htmlspecialchars($blog['titre']) ?>">
          <?php if (!empty($errors['titre'])): ?>
            <div class="text-danger"><?= $errors['titre'] ?></div>
          <?php endif; ?>
        </div>

        <!-- Auteur -->
        <div class="mb-3">
          <label class="form-label">Auteur :</label>
          <input type="text" name="auteur" value="<?= htmlspecialchars($blog['auteur']) ?>">
          <?php if (!empty($errors['auteur'])): ?>
            <div class="text-danger"><?= $errors['auteur'] ?></div>
          <?php endif; ?>
        </div>

        <!-- Date de création -->
        <div class="mb-3">
          <label class="form-label">Date de création :</label>
          <input type="date" name="date_creation" value="<?= htmlspecialchars($blog['date_creation']) ?>">
          <?php if (!empty($errors['date_creation'])): ?>
            <div class="text-danger"><?= $errors['date_creation'] ?></div>
          <?php endif; ?>
        </div>

        <!-- Image -->
        <div class="mb-3">
          <label class="form-label">Image :</label>
          <input type="file" name="image" accept="image/*">
          <?php if (!empty($errors['image'])): ?>
            <div class="text-danger"><?= $errors['image'] ?></div>
          <?php endif; ?>
        </div>

        <!-- Contenu -->
        <div class="mb-3">
          <label class="form-label">Contenu :</label>
          <textarea name="contenu" rows="5"><?= htmlspecialchars($blog['contenu']) ?></textarea>
          <?php if (!empty($errors['contenu'])): ?>
            <div class="text-danger"><?= $errors['contenu'] ?></div>
          <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-dark">💾 Enregistrer les modifications</button>
      </form>
    </div>
  </div>
</div>



    <!-- Header End -->

    <!-- Footer Start -->
    <div
      class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn"
      data-wow-delay="0.1s"
    >
      <div class="container py-5">
        <div class="row g-5">
          <div class="col-lg-3 col-md-6">
            <h4 class="text-white mb-3">Quick Link</h4>
            <a class="btn btn-link" href="">blog </a>
            <a class="btn btn-link" href="">Contact Us</a>
            <a class="btn btn-link" href="">Privacy Policy</a>
            <a class="btn btn-link" href="">Terms & Condition</a>
            <a class="btn btn-link" href="">FAQs & Help</a>
          </div>
          <div class="col-lg-3 col-md-6">
            <h4 class="text-white mb-3">Contact</h4>
            <p class="mb-2">
              <i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA
            </p>
            <p class="mb-2">
              <i class="fa fa-phone-alt me-3"></i>+012 345 67890
            </p>
            <p class="mb-2">
              <i class="fa fa-envelope me-3"></i>info@example.com
            </p>
            <div class="d-flex pt-2">
              <a class="btn btn-outline-light btn-social" href=""
                ><i class="fab fa-twitter"></i
              ></a>
              <a class="btn btn-outline-light btn-social" href=""
                ><i class="fab fa-facebook-f"></i
              ></a>
              <a class="btn btn-outline-light btn-social" href=""
                ><i class="fab fa-youtube"></i
              ></a>
              <a class="btn btn-outline-light btn-social" href=""
                ><i class="fab fa-linkedin-in"></i
              ></a>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <h4 class="text-white mb-3">Gallery</h4>
            <div class="row g-2 pt-2">
              <div class="col-4">
                <img
                  class="img-fluid bg-light p-1"
                  src="../img/course-1.jpg"
                  alt=""
                />
              </div>
              <div class="col-4">
                <img
                  class="img-fluid bg-light p-1"
                  src="../img/course-2.jpg"
                  alt=""
                />
              </div>
              <div class="col-4">
                <img
                  class="img-fluid bg-light p-1"
                  src="../img/course-3.jpg"
                  alt=""
                />
              </div>
              <div class="col-4">
                <img
                  class="img-fluid bg-light p-1"
                  src="../img/course-2.jpg"
                  alt=""
                />
              </div>
              <div class="col-4">
                <img
                  class="../img-fluid bg-light p-1"
                  src="img/course-3.jpg"
                  alt=""
                />
              </div>
              <div class="col-4">
                <img
                  class="../img-fluid bg-light p-1"
                  src="img/course-1.jpg"
                  alt=""
                />
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <h4 class="text-white mb-3">Newsletter</h4>
            <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
            <div class="position-relative mx-auto" style="max-width: 400px">
              <input
                class="form-control border-0 w-100 py-3 ps-4 pe-5"
                type="text"
                placeholder="Your email"
              />
              <button
                type="button"
                class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2"
              >
                SignUp
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="copyright">
          <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
              &copy; <a class="border-bottom" href="#">Your Site Name</a>, All
              Right Reserved.

              <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
              Designed By
              <a class="border-bottom" href="https://htmlcodex.com"
                >HTML Codex</a
              ><br /><br />
              Distributed By
              <a class="border-bottom" href="https://themewagon.com"
                >ThemeWagon</a
              >
            </div>
            <div class="col-md-6 text-center text-md-end">
              <div class="footer-menu">
                <a href="">Home</a>
                <a href="">Cookies</a>
                <a href="">Help</a>
                <a href="">FQAs</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"
      ><i class="bi bi-arrow-up"></i
    ></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
  </body>
</html>
