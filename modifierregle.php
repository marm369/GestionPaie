<?php
include_once 'modifier_regle.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs envoyées depuis le formulaire
    $nomEntreprise = $_POST['entreprise'];
    $nomRubrique = $_POST['rubrique'];
    $nouvelleRegle = $_POST['regle'];

    // Connexion à la base de données
    require('connectbdd.php');

    // Récupérer l'ID de l'entreprise à partir du nom sélectionné
    $queryIdEntreprise = "SELECT id FROM entreprise WHERE nom = :nomEntreprise";
    $stmtIdEntreprise = $bdd->prepare($queryIdEntreprise);
    $stmtIdEntreprise->bindParam(':nomEntreprise', $nomEntreprise);
    $stmtIdEntreprise->execute();
    $idEntreprise = $stmtIdEntreprise->fetchColumn();

    // Mettre à jour la règle dans la table regle pour la rubrique et l'entreprise données
    $updateQueryRegle = "UPDATE regle SET formule = :nouvelleRegle where designation = :nomRubrique";
    $stmtRegle = $bdd->prepare($updateQueryRegle);
    $stmtRegle->bindParam(':nouvelleRegle', $nouvelleRegle);
    $stmtRegle->bindParam(':nomRubrique', $nomRubrique);
    $stmtRegle->execute();

    echo "La règle a été modifiée avec succès.";
}
?>
