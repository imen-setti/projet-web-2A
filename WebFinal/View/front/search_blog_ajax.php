<?php
require_once(__DIR__ . '/../../model/Blog.php');
require_once(__DIR__ . '/../../model/Commentaire.php');

// Récupère la recherche et le tri
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sortOrder = isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'asc' : 'desc';

// Récupérer la liste des blogs triée
$blogs = Blog::listeBlogsSorted($sortOrder);

// Ajouter les commentaires à chaque blog
foreach ($blogs as &$blog) {
    $blog['commentaires'] = Commentaire::getCommentairesByBlogId($blog['id_blog']);
}
unset($blog); // Évite les effets de bord

// Filtrer les blogs en fonction de la recherche
$filteredBlogs = [];
foreach ($blogs as $blog) {
    if (
        empty($search) || // Si aucune recherche, on affiche tous les blogs
        stripos($blog['titre'], $search) !== false || // Recherche dans le titre
        stripos($blog['contenu'], $search) !== false   // Recherche dans le contenu
    ) {
        $filteredBlogs[] = $blog;
    }
}

// Générer la sortie HTML pour les blogs filtrés
foreach ($filteredBlogs as $blog) {
    echo '<div class="col-lg-4 col-md-6 mb-4 d-flex">';
    echo '<div class="card shadow-lg h-100 w-100 d-flex flex-column">';
    echo '<div class="card-img-container">';
    if (!empty($blog['image']) && file_exists('../../back/uploads/' . $blog['image'])) {
        echo '<img src="../../back/uploads/' . htmlspecialchars($blog['image']) . '" alt="Image du blog" class="img-fluid">';
    } else {
        echo '<span class="text-muted">Aucune image</span>';
    }
    echo '</div>';
    echo '<div class="card-body d-flex flex-column">';
    echo '<h5 class="card-title">' . htmlspecialchars($blog['titre']) . '</h5>';
    echo '<p class="card-text">' . htmlspecialchars(substr($blog['contenu'], 0, 150)) . '...</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>
