<?php
    require('connectbdd.php');

try {
    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Vérification de la présence de l'ID de l'heure supplémentaire à valider
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mise à jour du statut de l'heure supplémentaire à 1
    $sql = "UPDATE conge SET statut = 1 WHERE idconge= :id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Redirection vers la page précédente
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>
