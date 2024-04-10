<?php
include_once 'supprimer_rubrique.php';
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    require('connectbdd.php');

    // Récupérer l'ID de l'entreprise à partir du nom sélectionné
    $nomEntreprise = $_POST['entreprise'];
    $queryIdEntreprise = "SELECT id FROM entreprise WHERE nom = :nomEntreprise";
    $stmtIdEntreprise = $bdd->prepare($queryIdEntreprise);
    $stmtIdEntreprise->bindParam(':nomEntreprise', $nomEntreprise);
    $stmtIdEntreprise->execute();
    $idEntreprise = $stmtIdEntreprise->fetchColumn();

    // Récupérer le libellé de la rubrique sélectionnée
    $nomRubrique = $_POST['rubrique'];

    // Supprimer la rubrique de la table rubrique pour l'entreprise donnée
    $deleteQueryRubrique = "DELETE FROM rubrique WHERE libelle = :nomRubrique AND id_entreprise = :idEntreprise";
    $stmtRubrique = $bdd->prepare($deleteQueryRubrique);
    $stmtRubrique->bindParam(':nomRubrique', $nomRubrique);
    $stmtRubrique->bindParam(':idEntreprise', $idEntreprise);
    $stmtRubrique->execute();

    // Supprimer les règles associées à cette rubrique dans la table regle
    $deleteQueryRegle = "DELETE FROM regle WHERE designation= :nomRubrique ";
    $stmtRegle = $bdd->prepare($deleteQueryRegle);
    $stmtRegle->bindParam(':nomRubrique', $nomRubrique);
    $stmtRegle->execute();

   
}
?>
