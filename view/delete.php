<?php

 require_once('C:\xampp\htdocs\wassim\controller\reclamationC.php');
 $reclamationC= new reclamationC();
$reclamationC->deleteReclamation($_GET['id'] );
header('Location: liste.php');
?>