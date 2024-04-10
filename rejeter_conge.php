<?php
// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $congeId = $_POST['congeId'];
    $justification = $_POST['justification'];

    // Connectez-vous à votre base de données
    require('connectbdd.php');

    // Préparez la requête SQL pour mettre à jour le congé
    $smt1 = $bdd->prepare("UPDATE conge SET statut=0, reponse=:justification WHERE id=:congeId");

    // Liez les paramètres à leurs valeurs respectives
    $smt1->bindValue(':justification', $justification, PDO::PARAM_STR);
    $smt1->bindValue(':congeId', $congeId, PDO::PARAM_INT);

    // Exécutez la requête
    $smt1->execute();

    // Redirigez l'utilisateur vers une nouvelle page ou affichez un message de succès
    echo "<script>alert('Le congé a été rejeté avec succès.');</script>";

}
?>
