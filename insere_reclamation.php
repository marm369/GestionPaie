<?php
include_once 'reclamer.php';

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['auth'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}

// Récupérez la valeur de la variable de session 'auth'
$login = $_SESSION['auth'];
// Connectez-vous à votre base de données
require('connectbdd.php');

// Préparez la requête SQL pour récupérer l'ID de l'employé
$smt1 = $bdd->prepare("SELECT id_employe FROM comptes WHERE login = :login");

// Liez le paramètre à sa valeur
$smt1->bindValue(':login', $login, PDO::PARAM_STR);

// Exécutez la requête
$smt1->execute();

// Récupérez l'ID de l'employé
$row = $smt1->fetch(PDO::FETCH_ASSOC);
$idEmploye = $row['id_employe'];
// Assurez-vous que l'utilisateur est connecté et obtenez l'identificateur de session

// Vérifiez si le formulaire a été soumis
if (isset($_POST['envoyer'])) {
    // Récupérez les valeurs du formulaire
    $datereclamation = $_POST['datereclamation'];
    $objet = $_POST['objet'];
    $reclamationText = $_POST['reclamation-text'];

    // Effectuez l'insertion dans la base de données
    $sql = "INSERT INTO reclamation (daterecla, objet, recla,id_employe) VALUES (:daterecla, :objet, :recla,:id_employe)";
    // Remplacez "reclamation" par le nom réel de votre table

    // Préparez la requête SQL
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':daterecla', $datereclamation);
    $stmt->bindParam(':objet', $objet);
    $stmt->bindParam(':recla', $reclamationText);
    $stmt->bindParam(':id_employe',$idEmploye);
    // Exécutez la requête SQL
    $result = $stmt->execute();

    // Vérifiez si l'insertion a réussi
    if ($result) {
        echo "La réclamation a été soumise avec succès.";
    } else {
        echo "Une erreur s'est produite lors de la soumission de la réclamation.";
    }
}
?>
