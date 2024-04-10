<?php
$bd = new PDO("mysql:host=localhost;dbname=atelier_web;charset=UTF8", "root", "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEntreprise = $_POST['idEntreprise'];
    $libelleRubrique = $_POST['libelleRubrique'];
    $sql = "INSERT INTO rubrique (id_entreprise, libelle) VALUES (?, ?)";
    $stmt = $bd->prepare($sql);
    $stmt->execute([$idEntreprise, $libelleRubrique]);

    if ($stmt->rowCount() > 0) {
        echo "Rubrique ajoutée avec succès.";
    } else {
        echo "Erreur lors de l'ajout de la rubrique.";
    }
}
header('location:page_paie.php');
?>
