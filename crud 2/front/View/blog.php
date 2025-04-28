<?php
require_once(__DIR__ . '/../Model/Blog.php');
require_once(__DIR__ . '/../Model/Commentaire.php');

// Fonction globale pour filtrer les mots interdits
function filtrerBadWords($texte) {
    $badWords = ['impolie', 'bad', 'méchant']; // à compléter si besoin
    foreach ($badWords as $mot) {
        $pattern = '/\b' . preg_quote($mot, '/') . '\b/i';
        $texte = preg_replace($pattern, str_repeat('*', strlen($mot)), $texte);
    }
    return $texte;
}

// Recherche et tri
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sortOrder = isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'asc' : 'desc';
$blogs = Blog::listeBlogsSorted($sortOrder);

// Ajout des commentaires à chaque blog
foreach ($blogs as &$blog) {
    $blog['commentaires'] = Commentaire::getCommentairesByBlogId($blog['id_blog']);
}
unset($blog); // évite les effets de bord

// Filtrage par recherche
$filteredBlogs = [];
foreach ($blogs as $blog) {
    if (
        empty($search) ||
        stripos($blog['titre'], $search) !== false ||
        stripos($blog['contenu'], $search) !== false
    ) {
        $filteredBlogs[] = $blog;
    }
}
$blogs = $filteredBlogs;

// Traitement de l'ajout de commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['commenter'])) {
    $id_blog = $_POST['id_blog'];
    $id_user = $_SESSION['id_user'] ?? 1; // Utilisateur connecté
    $contenu = trim($_POST['contenu']);

    if (!empty($contenu)) {
        // Filtrage avant insertion
        $contenuFiltré = filtrerBadWords($contenu);
        Commentaire::ajouterCommentaire($id_blog, $id_user, $contenuFiltré);
        header("Location: blog.php");
        exit;
    }
}

// Suppression d'un commentaire
if (isset($_GET['delete_comment'])) {
    Commentaire::supprimerCommentaire($_GET['delete_comment']);
    header("Location: blog.php");
    exit;
}

// Modification d’un commentaire
if (isset($_POST['modifier_commentaire'])) {
    $id_commentaire = $_POST['id_commentaire'];
    $contenu = $_POST['nouveau_contenu'];

    if (!empty($id_commentaire) && !empty($contenu)) {
        $contenuFiltré = filtrerBadWords($contenu);
        Commentaire::modifierCommentaire($id_commentaire, $contenuFiltré);
    }

    header("Location: blog.php");
    exit;
}
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

    <style>
  .card-img-container {
    height: 180px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    background-color: #f8f9fa;
  }

  .card-img-container img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
  }

  .card-title {
    min-height: 48px;
  }

  .card-text {
    min-height: 80px;
  }

  .dropdown-menu-icon-only {
    min-width: auto;
    width: fit-content;
    padding: 0.25rem 0; /* réduit l’espace vertical */
  }

  .dropdown-menu-icon-only .dropdown-item {
    padding: 0.25rem 0.5rem; /* réduit l’espace autour des icônes */
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
  }

  .dropdown-menu-icon-only .dropdown-item i {
    font-size: 0.9rem;
  }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
  $('#commentaire-input').on('input', function() {
    var contenu = $(this).val();

    $.ajax({
      url: 'filtrer_badwords.php',
      type: 'POST',
      data: { contenu: contenu },
      success: function(response) {
        var data = JSON.parse(response);
        $('#commentaire-input').val(data.contenuFiltré);
      },
      error: function(xhr, status, error) {
        console.error('Erreur AJAX:', error);
      }
    });
  });
});
</script>

<div class="container-fluid bg-primary py-5 mb-5 page-header">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
      <style>
  .search-input {
    border-top-left-radius: 50px !important;
    border-bottom-left-radius: 50px !important;
  }

  .search-button {
    border-top-right-radius: 50px !important;
    border-bottom-right-radius: 50px !important;
  }

  .search-input,
  .search-button {
    height: 48px;
  }
</style>

<div class="d-flex justify-content-center mb-4">
  <form method="GET" class="input-group" style="max-width: 600px; width: 100%;">
    <input 
      type="text" 
      name="search" 
      class="form-control shadow-sm search-input" 
      placeholder="🔍 Rechercher un blog..." 
      value="<?= htmlspecialchars($search) ?>" 
      aria-label="Search"
    >
    <button 
      type="submit" 
      class="btn btn-primary search-button px-4 shadow-sm"
    >
      Rechercher
    </button>
  </form>
</div>


      </div>
    </div>
  </div>
</div>

<div class="container py-5">
<div class="d-flex justify-content-between mb-4">
<form method="GET" class="d-flex" style="max-width: 600px; width: 100%;">
  <select name="sort" class="form-select me-2" style="width: auto;" onchange="this.form.submit()">
  <option value="desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'desc') ? 'selected' : '' ?>>📅 Plus récent</option>
  <option value="asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'asc') ? 'selected' : '' ?>>📅 Plus ancien</option>
</select>

</form>

    <a href="addBlog.php" class="btn btn-success">Ajouter un Blog</a>
  </div>
  <div class="row">
    <?php 
      // Variable pour savoir si un commentaire est en mode édition
      $commentaire_a_modifier = null;
      if (isset($_GET['edit_comment'])) {
        $commentaire_a_modifier = $_GET['edit_comment']; // Récupère l'ID du commentaire à modifier
      }
      
      foreach ($blogs as $blog): 
    ?>
      <div class="col-lg-4 col-md-6 mb-4 d-flex">
        <div class="card shadow-lg h-100 w-100 d-flex flex-column">
          <!-- Image -->
          <div class="card-img-container">
            <?php if (!empty($blog['image']) && file_exists('../../back/uploads/' . $blog['image'])): ?>
              <img src="<?= '../../back/uploads/' . htmlspecialchars($blog['image']) ?>" alt="Image du blog" class="img-fluid">
            <?php else: ?>
              <span class="text-muted">Aucune image</span>
            <?php endif; ?>
          </div>

          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($blog['titre']) ?></h5>
            <p class="card-text"><?= htmlspecialchars(substr($blog['contenu'], 0, 150)) ?>...</p>
          </div>
<!-- Commentaires -->
<div class="px-3" style="max-height: 200px; overflow-y: auto;">
  <h6 class="text-primary">Commentaires :</h6>
  <?php if (!empty($blog['commentaires'])): ?>
    <ul class="list-unstyled">
      <?php foreach ($blog['commentaires'] as $commentaire): ?>
        <li class="mb-2 border-bottom pb-2 d-flex justify-content-between">
          <div>
            <strong>Utilisateur <?= htmlspecialchars($commentaire['id_user']) ?> :</strong><br>

            <?php if ($commentaire_a_modifier == $commentaire['id_commentaire']): ?>
              <!-- Formulaire de modification -->
              <form method="POST" action="">
                <input type="hidden" name="id_commentaire" value="<?= $commentaire['id_commentaire'] ?>">
                <textarea name="nouveau_contenu" class="form-control mb-2" required><?= htmlspecialchars($commentaire['contenu']) ?></textarea>
                <button type="submit" name="modifier_commentaire" class="btn btn-sm btn-success">💾</button>
                <a href="?delete_comment=<?= $commentaire['id_commentaire'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce commentaire ?');">🗑️</a>
              </form>
            <?php else: ?>
              <?= nl2br(htmlspecialchars(filtrerBadWords($commentaire['contenu']))) ?><br>
              <small class="text-muted"><?= htmlspecialchars($commentaire['date_creation']) ?></small><br>
            <?php endif; ?>
          </div>

          <?php if ($commentaire_a_modifier != $commentaire['id_commentaire']): ?>
            <div class="dropdown">
  <button class="btn btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    ...
  </button>
  <ul class="dropdown-menu dropdown-menu-icon-only" aria-labelledby="dropdownMenuButton">
    <li>
      <a class="dropdown-item" href="?edit_comment=<?= $commentaire['id_commentaire'] ?>">
        <i class="bi bi-pencil-square"></i>
      </a>
    </li>
    <li>
      <a class="dropdown-item text-danger" href="?delete_comment=<?= $commentaire['id_commentaire'] ?>" onclick="return confirm('Supprimer ce commentaire ?');">
        <i class="bi bi-trash3"></i>
      </a>
    </li>
  </ul>
</div>
<?php endif; ?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-muted">Aucun commentaire pour ce blog.</p>
  <?php endif; ?>
</div>


          <!-- Formulaire d'ajout -->
          <div class="px-3 pb-3">
            <form method="POST" action="">
              <div class="mb-2">
                <textarea name="contenu" class="form-control"id="commentaire-input" placeholder="Ajouter un commentaire..." required></textarea>
              </div>
              <input type="hidden" name="id_blog" value="<?= $blog['id_blog'] ?>">
              <button type="submit" name="commenter" class="btn btn-primary btn-sm">Commenter</button>
            </form>
          </div>

          <div class="card-footer mt-auto d-flex justify-content-between align-items-center">
            <small class="text-muted">
              Posté par <?= htmlspecialchars($blog['auteur']) ?><br>
              le <?= htmlspecialchars($blog['date_creation']) ?>
            </small>
            <div>
              <a href="editBlog.php?id=<?= $blog['id_blog'] ?>" class="btn btn-sm btn-outline-primary me-1">✏️</a>
              <a href="deleteBlog.php?id=<?= $blog['id_blog'] ?>" class="btn btn-sm btn-outline-danger"
                 onclick="return confirm('Supprimer ce blog ?');">🗑️</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
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
                  src="img/course-1.jpg"
                  alt=""
                />
              </div>
              <div class="col-4">
                <img
                  class="img-fluid bg-light p-1"
                  src="img/course-2.jpg"
                  alt=""
                />
              </div>
              <div class="col-4">
                <img
                  class="img-fluid bg-light p-1"
                  src="img/course-3.jpg"
                  alt=""
                />
              </div>
              <div class="col-4">
                <img
                  class="img-fluid bg-light p-1"
                  src="img/course-2.jpg"
                  alt=""
                />
              </div>
              <div class="col-4">
                <img
                  class="img-fluid bg-light p-1"
                  src="img/course-3.jpg"
                  alt=""
                />
              </div>
              <div class="col-4">
                <img
                  class="img-fluid bg-light p-1"
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
