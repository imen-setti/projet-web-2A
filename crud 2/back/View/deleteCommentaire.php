<?php
require_once('../model/Commentaire.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    Commentaire::supprimerCommentaire($id);
}

header("Location: listeCommentaire.php");
exit();
?>
