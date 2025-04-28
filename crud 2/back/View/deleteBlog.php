<?php
require_once('../model/Blog.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    Blog::supprimerBlog($id);
}

header("Location: listeBlog.php");
exit();
?>
