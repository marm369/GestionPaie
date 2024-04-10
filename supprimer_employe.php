<?php
include_once 'espacerh.php';
if(!isset($_SESSION['auth']))
{
   header('location:pageprincipale.html');
}
// Vérifier si le formulaire a été soumis
require('connectbdd.php');

if (isset($_POST['supprimer'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom']; // Supposons que vous ayez un champ pour l'ID de l'employé

    $smt1 = $bdd->prepare("DELETE FROM employe WHERE nom=:nom AND prenom=:prenom");
    $smt1->bindValue(':nom', $nom, PDO::PARAM_INT);
    $smt1->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $smt1->execute();

    echo "<script>alert('L'employé a été supprimé avec succès.');</script>";
}

?>




