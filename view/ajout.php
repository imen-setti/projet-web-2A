<?php

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure les fichiers nécessaires
    require_once('C:\xampp\htdocs\nada\controller\paiementC.php');
    require_once('C:\xampp\htdocs\nada\model\paiement.php');

    $paiementC = new PaiementC();

    // Vérifier que tous les champs requis sont définis et non vides
    if (
        isset($_POST["montant"], $_POST["devise"], $_POST["methode"], $_POST["carte"], $_POST["description"]) &&
        !empty($_POST["montant"]) &&
        !empty($_POST["devise"]) &&
        !empty($_POST["methode"]) &&
        !empty($_POST["carte"]) &&
        !empty($_POST["description"])
    ) {
        // Création de l'objet Paiement avec les données du formulaire
        $paiement = new Paiement(
            null,   // id auto-incrémenté
            $_POST['montant'],
            $_POST['devise'],
            $_POST['methode'],
            $_POST['carte'],
            $_POST['description']
        );

        // Ajouter le paiement via le contrôleur
        $paiementC->addPaiement($paiement);

        ?>
        <script>
            window.location.href = 'liste.php'; // Redirection vers la liste des paiements
        </script>
        <?php
        echo "Paiement ajouté avec succès.";
    } else {
        echo "<br><strong>Erreur : Un ou plusieurs champs sont vides.</strong><br>";
        if (empty($_POST["montant"])) echo "Champ montant est vide.<br>";
        if (empty($_POST["devise"])) echo "Champ devise est vide.<br>";
        if (empty($_POST["methode"])) echo "Champ méthode est vide.<br>";
        if (empty($_POST["carte"])) echo "Champ carte est vide.<br>";
        if (empty($_POST["description"])) echo "Champ description est vide.<br>";
        ?>
        <script>
            // alert("Veuillez remplir tous les champs requis !");
            window.location.href = 'front-office/paiement.html'; // Redirection vers le formulaire
        </script>
        <?php
    }
} else {
    ?>
    <script>
        alert("Accès non autorisé !");
        // window.location.href = 'front-office/paiement.php';
    </script>
    <?php
}
?>
