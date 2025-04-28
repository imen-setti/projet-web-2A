<?php

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure les fichiers nécessaires
    require_once('C:\xampp\htdocs\wassim\controller\reclamationC.php');
    require_once('C:\xampp\htdocs\wassim\model\reclamation.php');

    $reclamationC = new ReclamationC();

    // Affichage des champs pour debug
    echo "Debug - Valeurs reçues :<br>";
    echo "Email: " . (isset($_POST['email']) ? $_POST['email'] : 'Non défini') . "<br>";
    echo "Sujet: " . (isset($_POST['sujet']) ? $_POST['sujet'] : 'Non défini') . "<br>";
    echo "Description: " . (isset($_POST['descrip']) ? $_POST['descrip'] : 'Non défini') . "<br>";
    echo "Date: " . (isset($_POST['daterec']) ? $_POST['daterec'] : 'Non défini') . "<br>";
    echo "Status: " . (isset($_POST['status']) ? $_POST['status'] : 'Non défini') . "<br><br>";

    // Vérifier que tous les champs requis sont définis et non vides
    if (
        isset($_POST["email"], $_POST["sujet"], $_POST["descrip"], $_POST["daterec"], $_POST["status"]) &&
        !empty($_POST["email"]) &&
        !empty($_POST["sujet"]) &&
        !empty($_POST["descrip"]) &&
        !empty($_POST["daterec"]) &&
        !empty($_POST["status"])
    ) 
    {
        // Création de l'objet réclamation avec les données du formulaire
        $reclamation = new Reclamation(
            null,   // id non passé car auto-incrémenté
            $_POST['email'],
            $_POST['sujet'],
            $_POST['descrip'],
            $_POST['daterec'],
            $_POST['status']
        );

        // Ajouter l'objet réclamation à la base de données via le contrôleur
        $reclamationC->addReclamation($reclamation);
        ?>
        <script>
             window.location.href = 'liste.php';
        </script>
        <?php
        echo "Reclamation ajoutée avec succès.";
    } else {
        // Si les champs sont invalides ou manquants
        echo "<br><strong>Erreur : Un ou plusieurs champs sont vides.</strong><br>";
        if (empty($_POST["email"])) echo "Champ email est vide.<br>";
        if (empty($_POST["sujet"])) echo "Champ sujet est vide.<br>";
        if (empty($_POST["descrip"])) echo "Champ description est vide.<br>";
        if (empty($_POST["daterec"])) echo "Champ date est vide.<br>";
        if (empty($_POST["status"])) echo "Champ status est vide.<br>";

        ?>
        <script>
            alert("Veuillez remplir tous les champs requis !");
            window.location.href = 'view/front-office/contact.html';
        </script>
        <?php
    }
} else {
    // Si la requête n'est pas de type POST
    ?>
    <script>
        alert("Accès non autorisé !");
        // window.location.href = 'view/front-office/reclamation.php';
    </script>
    <?php
}
?>
