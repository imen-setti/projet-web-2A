<?php
require_once(__DIR__ . '/../Model/Blog.php');
require_once(__DIR__ . '/../Model/Commentaire.php');

function filtrerBadWords($texte) {
    $badWords = ['merde', 'con', 'impolie','mechant','bad','vulgaire'];
    foreach ($badWords as $mot) {
        $pattern = '/\b' . preg_quote($mot, '/') . '\b/i';
        $texte = preg_replace($pattern, str_repeat('*', strlen($mot)), $texte);
    }
    return $texte;
}

if (isset($_POST['contenu'])) {
    $contenu = trim($_POST['contenu']);
    $contenuFiltré = filtrerBadWords($contenu);
    echo json_encode(['contenuFiltré' => $contenuFiltré]);
}
?>