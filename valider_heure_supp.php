<?php
include_once 'hsup.php';
// Connexion à la base de données
require('connectbdd.php');


// Vérification de la présence de l'ID de l'heure supplémentaire à valider
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mise à jour du statut de l'heure supplémentaire à 1
    $sql = "UPDATE heure_supp SET statut = 1 WHERE idheuressup= :id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}


?>
