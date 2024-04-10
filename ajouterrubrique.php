<?php
include_once 'ajouter_rubrique.php';
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    require('connectbdd.php');

    // Récupérer l'ID de l'entreprise à partir de la table entreprise en fonction du nom sélectionné
    $nomEntreprise = $_POST['entreprise'];
    $queryIdEntreprise = "SELECT id FROM entreprise WHERE nom = :nomEntreprise";
    $stmtIdEntreprise = $bdd->prepare($queryIdEntreprise);
    $stmtIdEntreprise->bindParam(':nomEntreprise', $nomEntreprise);
    $stmtIdEntreprise->execute();
    $idEntreprise = $stmtIdEntreprise->fetchColumn();

    // Récupérer les données du formulaire
    $nomRubrique = $_POST['rubrique']; // Notez que vous utilisez le même nom pour l'ID et le nom du champ, c'est mieux de les séparer
    $formuleRegle = $_POST['formule']; // Même remarque que ci-dessus

    // Insérer la nouvelle rubrique dans la table rubrique avec l'ID de l'entreprise récupéré
    $insertQueryRubrique = "INSERT INTO rubrique (libelle, id_entreprise) VALUES (:nomRubrique, :idEntreprise)";
    $stmtRubrique = $bdd->prepare($insertQueryRubrique);
    $stmtRubrique->bindParam(':nomRubrique', $nomRubrique);
    $stmtRubrique->bindParam(':idEntreprise', $idEntreprise);
    $stmtRubrique->execute();

    // Récupérer l'ID de la rubrique nouvellement insérée
    $idRubrique = $bdd->lastInsertId();

    // Insérer la nouvelle règle dans la table regle avec l'ID de l'entreprise et l'ID de la rubrique
    $insertQueryRegle = "INSERT INTO regle (id_entreprise, id_rubrique, formule,designation) VALUES (:idEntreprise, :idRubrique, :formuleRegle , :nomRubrique)";
    $stmtRegle = $bdd->prepare($insertQueryRegle);
    $stmtRegle->bindParam(':idEntreprise', $idEntreprise);
    $stmtRegle->bindParam(':idRubrique', $idRubrique);
    $stmtRegle->bindParam(':formuleRegle', $formuleRegle);
    $stmtRegle->bindParam(':nomRubrique', $nomRubrique);
    $stmtRegle->execute();
}
?>
