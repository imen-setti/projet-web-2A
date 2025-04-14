<?php
require_once(__DIR__ . '/Model/Blog.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    Blog::supprimerBlog($id);
}

header("Location: Blog.php");
exit();
?>
