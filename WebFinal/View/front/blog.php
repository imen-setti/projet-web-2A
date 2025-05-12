<?php
session_start();

require_once(__DIR__ . '/../../model/Blog.php');
require_once(__DIR__ . '/../../model/Commentaire.php');

$id_blog = $_GET['id_blog'] ?? null;
if ($id_blog) {
    $blog = Blog::getBlogById($id_blog);
    $commentaires = Commentaire::getCommentairesByBlogId($id_blog);
}
// Handle AJAX request for fetching blog details
if (isset($_GET['action']) && $_GET['action'] === 'getBlogDetails' && isset($_GET['id'])) {
  $id_blog = $_GET['id'];
  $blog = Blog::getBlogById($id_blog);
  if ($blog) {
      echo json_encode(['success' => true, 'blog' => $blog]);
  } else {
      echo json_encode(['success' => false, 'message' => 'Blog not found.']);
  }
  exit;
}

// Fonction globale pour filtrer les mots interdits
function filtrerBadWords($texte) {
    $badWords = ['impolie', 'bad', 'méchant']; // à compléter si besoin
    foreach ($badWords as $mot) {
        $pattern = '/\b' . preg_quote($mot, '/') . '\b/i';
        $texte = preg_replace($pattern, str_repeat('*', strlen($mot)), $texte);
    }
    return $texte;
}

if (isset($_POST['clear_notifications'])) {
  unset($_SESSION['notifications']);
  // Optionnel : rediriger pour éviter la resoumission du formulaire
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_comment'])) {
  header('Content-Type: application/json');

  // Check if the user is logged in
  if (!isset($_SESSION['user'])) {
      echo json_encode([
          'success' => false,
          'message' => 'Vous devez être connecté pour ajouter un commentaire.'
      ]);
      header("Refresh:0");
      exit;
  }

  $id_blog = $_POST['id_blog'] ?? null;
  $id_user = $_SESSION['user']['id']; // Use the user_id from the session
  $contenu = trim($_POST['contenu'] ?? '');

  if ($id_blog && !empty($contenu)) {
      $contenuFiltré = filtrerBadWords($contenu);
      Commentaire::ajouterCommentaire($id_blog, $id_user, $contenuFiltré);

      // Récupération du nom de l'utilisateur depuis la BDD
      $utilisateurData = Commentaire::getNomParId($id_user);
      $utilisateurNom = $utilisateurData['prenom'] ?? 'Utilisateur';

      $message = "Commentaire ajouté : \"$contenuFiltré\" par $utilisateurNom";

      // Stocker dans la session
      $_SESSION['notifications'][] = $message;

      echo json_encode([
          'success' => true,
          'message' => $message
      ]);
  } else {
      $message = "Le commentaire ne peut pas être vide.";
      $_SESSION['notifications'][] = $message;

      echo json_encode([
          'success' => false,
          'message' => $message
      ]);
  }
  exit;
}





// Suppression d'un commentaire
if (isset($_GET['delete_comment'])) {
    Commentaire::supprimerCommentaire($_GET['delete_comment']);
    header("Location: blog.php");
    exit;
}

// Modification d'un commentaire
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
        rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet" />
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../front/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet" />
    <!-- CSS de Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- JS de Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-10">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-briefcase me-3"></i>StartHUb</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="#" class="nav-item nav-link">About</a>
                <a href="evenement.php" class="nav-item nav-link">Evènement</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="#" class="dropdown-item">Our Team</a>
                        <a href="#" class="dropdown-item">Testimonial</a>
                        <a href="#" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="#" class="nav-item nav-link">Contact</a>

                <?php if (isset($_SESSION['user'])): ?>
                <div class="nav-item nav-link d-flex align-items-center">

                    <div class="avatar me-2 d-flex justify-content-center align-items-center"
                        style="width: 30px; height: 30px; border-radius: 50%; background-color: #007bff; color: white; font-weight: bold;">
                        <?= strtoupper(substr($_SESSION['user']['prenom'], 0, 1)) . strtoupper(substr($_SESSION['user']['nom'], 0, 1)) ?>
                    </div>
                    <span><strong><?= htmlspecialchars($_SESSION['user']['prenom']) . ' ' . htmlspecialchars($_SESSION['user']['nom']) ?></strong></span>
                </div>
                <a href="logout.php" class="nav-item nav-link">Déconnexion</a>
                <?php else: ?>
                <a href="login.php" class="nav-item nav-link">Connexion</a>
                <?php endif; ?>


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
        padding: 0.25rem 0;
        /* réduit l'espace vertical */
    }

    .dropdown-menu-icon-only .dropdown-item {
        padding: 0.25rem 0.5rem;
        /* réduit l'espace autour des icônes */
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
                data: {
                    contenu: contenu
                },
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

    <div class="container-fluid  py-5 mb-5 page-header"
        style="background-image: url('img/b156f209-01c3-4135-a5bd-153bc4accb33.jpeg'); background-size: cover; background-position: center;">
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
                        <form method="GET" class="input-group" id="search-form" style="max-width: 600px; width: 100%;">
                            <input type="text" name="search" class="form-control shadow-sm search-input"
                                placeholder="🔍 Rechercher un blog..." value="<?= htmlspecialchars($search) ?>"
                                aria-label="Search" id="search-input">
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
                    <option value="desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'desc') ? 'selected' : '' ?>>📅
                        Plus récent</option>
                    <option value="asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'asc') ? 'selected' : '' ?>>📅
                        Plus ancien</option>
                </select>

            </form>

            <a href="addBlog.php" class="btn btn-success">Ajouter un Blog</a>
        </div>
        <div class="row" id="blog-list">
            <?php foreach ($blogs as $blog): ?>
            <?php 
      // Variable pour savoir si un commentaire est en mode édition
      $commentaire_a_modifier = null;
      if (isset($_GET['edit_comment'])) {
        $commentaire_a_modifier = $_GET['edit_comment']; // Récupère l'ID du commentaire à modifier
      }
      
    ?>
            <div class="col-lg-4 col-md-6 mb-4 d-flex">
                <div class="card shadow-lg h-100 w-100 d-flex flex-column blog-card " style="overflow-y: auto;
    cursor: pointer;
" data-id="<?= $blog['id_blog'] ?>">
                    <!-- Image -->
                    <div class="card-img-container">
                        <?php if (!empty($blog['image']) && file_exists('../../uploads/' . $blog['image'])): ?>
                        <img src="<?= '../../uploads/' . htmlspecialchars($blog['image']) ?>" alt="Image du blog"
                            class="img-fluid">
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
                                    <strong><?= htmlspecialchars($commentaire['user_name']) ?>:</strong>
                                    <p><?= htmlspecialchars($commentaire['contenu']) ?></p>
                                    <small><?= htmlspecialchars($commentaire['date_creation']) ?></small>
                                    <!-- Formulaire de modification -->
                                    <?php if ($commentaire_a_modifier == $commentaire['id_commentaire']): ?>
                                    <form method="POST" id="commentForm" action="">
                                        <input type="hidden" name="id_commentaire"
                                            value="<?= $commentaire['id_commentaire'] ?>">
                                        <textarea name="nouveau_contenu" class="form-control mb-2"
                                            required><?= htmlspecialchars($commentaire['contenu']) ?></textarea>
                                        <button type="submit" name="modifier_commentaire"
                                            class="btn btn-sm btn-success">💾</button>
                                        <a href="?delete_comment=<?= $commentaire['id_commentaire'] ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Supprimer ce commentaire ?');">🗑️</a>
                                    </form>
                                    <?php else: ?>
                                    <?= nl2br(htmlspecialchars(filtrerBadWords($commentaire['contenu']))) ?><br>
                                    <small
                                        class="text-muted"><?= htmlspecialchars($commentaire['date_creation']) ?></small><br>
                                    <?php endif; ?>
                                </div>

                                <?php if ($commentaire_a_modifier != $commentaire['id_commentaire']): ?>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        ...
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-icon-only"
                                        aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item"
                                                href="?edit_comment=<?= $commentaire['id_commentaire'] ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger"
                                                href="?delete_comment=<?= $commentaire['id_commentaire'] ?>"
                                                onclick="return confirm('Supprimer ce commentaire ?');">
                                                <i class="bi bi-trash3"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <?php endif; ?>
                                <link
                                    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
                                    rel="stylesheet">

                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php else: ?>
                        <p class="text-muted">Aucun commentaire pour ce blog.</p>
                        <?php endif; ?>
                    </div>


                    <!-- Formulaire d'ajout -->
                    <div class="px-3 pb-3">
                        <form class="comment-form" data-id="<?= $blog['id_blog'] ?>">
                            <div class="mb-2">
                                <textarea name="contenu" class="form-control" placeholder="Ajouter un commentaire..."
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Commenter</button>
                        </form>

                        <!-- Notification spécifique à ce blog -->
                        <div class="alert d-none mt-2" id="notification-<?= $blog['id_blog'] ?>"></div>
                    </div>


                    <div class="card-footer mt-auto d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Posté par <?= htmlspecialchars($blog['auteur']) ?><br>
                            le <?= htmlspecialchars($blog['date_creation']) ?>
                        </small>
                        <div>
                            <a href="editBlog.php?id=<?= $blog['id_blog'] ?>"
                                class="btn btn-sm btn-outline-primary me-1">✏️</a>
                            <a href="deleteBlog.php?id=<?= $blog['id_blog'] ?>" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Supprimer ce blog ?');">🗑️</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <button id="toggle-notifications" class="btn btn-secondary">🔔</button>

            <form method="post" action="" style="display:inline;">
                <button type="submit" name="clear_notifications" class="btn btn-danger ml-2">🔄</button>
            </form>
        </div>


        <div id="notifications-list" class="container mt-3 d-none">
            <h5>Notifications</h5>
            <ul class="list-group">
                <?php if (!empty($_SESSION['notifications'])): ?>
                <?php foreach (array_reverse($_SESSION['notifications']) as $note): ?>
                <li class="list-group-item"><?= htmlspecialchars($note) ?></li>
                <?php endforeach; ?>
                <?php else: ?>
                <li class="list-group-item">Aucune notification enregistrée.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>


    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("search-input");

        input.addEventListener("input", function() {
            const query = input.value; // Récupère la valeur de la recherche

            const xhr = new XMLHttpRequest();
            xhr.open("GET", "search_blog_ajax.php?search=" + encodeURIComponent(query),
                true); // Envoie la requête AJAX

            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById("blog-list").innerHTML = xhr
                        .responseText; // Met à jour la liste des blogs
                }
            };

            xhr.send();
        });
    });
    </script>
    <script>
    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const blogId = form.getAttribute('data-id');
            const formData = new FormData(form);
            formData.append('id_blog', blogId);
            formData.append('ajax_comment', 'true');

            fetch('blog.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    const notif = document.getElementById('global-notification');
                    notif.classList.remove('d-none', 'alert-success', 'alert-danger');

                    notif.classList.add(data.success ? 'alert-success' : 'alert-danger');
                    notif.textContent = data.message;

                    // Affiche la notification pendant 3 secondes
                    setTimeout(() => {
                        notif.classList.add('d-none');
                    }, 3000);

                    if (data.success) {
                        form.reset();
                    }
                })
                .catch(err => {
                    console.error("Erreur AJAX :", err);
                });
        });
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Hide the spinner once the page is fully loaded
        const spinner = document.getElementById('spinner');
        if (spinner) {
            spinner.classList.remove('show');
            spinner.classList.add('d-none');
        }
    });
    </script>
    <div id="global-notification" class="alert d-none position-fixed bottom-0 end-0 m-4"
        style="z-index: 9999; min-width: 300px;"></div>

    <script>
    document.getElementById('toggle-notifications').addEventListener('click', () => {
        const notifList = document.getElementById('notifications-list');
        notifList.classList.toggle('d-none');
    });
    </script>


    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

    <!-- Blog Details Modal -->
    <div class="modal fade" id="blogDetailsModal" tabindex="-1" aria-labelledby="blogDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blogDetailsModalLabel">Blog Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id="blogModalImage" src="" alt="Blog Image" class="img-fluid mb-3"
                            style="max-height: 300px;">
                    </div>

                    <h4 id="blogModalTitle" class="text-center"></h4>
                    <p id="blogModalAuthor" class="text-muted text-center"></p>
                    <p id="blogModalDate" class="text-muted text-center"></p>
                    <p id="blogModalContent" class="mt-3"
                        style="word-wrap: break-word; overflow-wrap: break-word; white-space: pre-wrap;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Add click event listeners to all blog cards
        document.querySelectorAll('.blog-card').forEach(card => {
            card.addEventListener('click', function(event) {
                const blogId = this.getAttribute('data-id');
                fetchBlogDetails(blogId);
            });
        });

        // Stop propagation for elements inside the blog card
        document.querySelectorAll('.blog-card .comment-form, .blog-card .btn, .blog-card textarea').forEach(
            element => {
                element.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            });

        // Function to fetch blog details and populate the modal
        function fetchBlogDetails(blogId) {
            fetch(`blog.php?action=getBlogDetails&id=${blogId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const blog = data.blog;
                        document.getElementById('blogModalTitle').textContent = blog.titre;
                        document.getElementById('blogModalAuthor').textContent = `By ${blog.auteur}`;
                        document.getElementById('blogModalDate').textContent =
                            `Posted on ${blog.date_creation}`;
                        document.getElementById('blogModalContent').textContent = blog.contenu;
                        const blogImage = document.getElementById('blogModalImage');
                        if (blog.image && blog.image.trim() !== '') {
                            blogImage.src = `../../uploads/${blog.image}`;
                            blogImage.style.display = 'block';
                        } else {
                            blogImage.style.display = 'none';
                        }
                        // Show the modal
                        const modal = new bootstrap.Modal(document.getElementById('blogDetailsModal'));
                        modal.show();
                    } else {
                        alert('Failed to fetch blog details.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching blog details:', error);
                });
        }
    });
    </script>
</body>

</html>