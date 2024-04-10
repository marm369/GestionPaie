<?php
include_once 'hsup.php';
// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $justification = $_POST['justification'];

    // Récupérez l'ID des heures supplémentaires à partir de l'URL
    $idHeuresSupp = $_GET['id'];

    // Connectez-vous à votre base de données
    require('connectbdd.php');

    // Préparez la requête SQL pour mettre à jour les heures supplémentaires
    $smt1 = $bdd->prepare("UPDATE heure_supp SET statut=0, reponse=:justification WHERE idheuressup=:id");

    // Liez les paramètres à leurs valeurs respectives
    $smt1->bindValue(':justification', $justification, PDO::PARAM_STR);
    $smt1->bindValue(':id', $idHeuresSupp, PDO::PARAM_INT);

    // Exécutez la requête
    $smt1->execute();

    // Redirigez l'utilisateur vers une nouvelle page ou affichez un message de succès
    echo "<script>alert('Les heures supplémentaires ont été rejetées avec succès.');</script>";
   
}
?>
