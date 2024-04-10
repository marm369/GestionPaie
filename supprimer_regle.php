<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atelier_web";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Vérification si l'ID de la règle est passé en paramètre
if (isset($_GET['id'])) {
    $regleId = $_GET['id'];

    // Effectuer les opérations pour supprimer la règle (vous pouvez ajouter votre propre logique ici)
    // Exemple : exécuter une requête SQL pour supprimer la règle de la base de données

    $sql = "DELETE FROM regle WHERE idregle = $regleId";

    if ($conn->query($sql) === TRUE) {
        echo "Règle supprimée avec succès.";
    } else {
        echo "Erreur lors de la suppression de la règle : " . $conn->error;
    }

} else {
    echo "ID de règle manquant.";
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
