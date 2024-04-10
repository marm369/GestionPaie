<?php
include_once 'espacerh.php';
?>
<?php
$idEmploye = $_POST['idEmploye'];
$objet = $_POST['objet'];
$reponse = $_POST['reponse'];

// Effectuer la connexion à la base de données

// Code de connexion à la base de données (à adapter selon votre configuration)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atelier_web";



try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

// Insérer la réclamation dans la table "reclamation" pour la ligne correspondante
$sql = "INSERT INTO reclamation (id_employe, objet, reponse) 
        VALUES (:idEmploye, :objet, :reponse)";
        
try {
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':idEmploye', $idEmploye);
    $stmt->bindParam(':objet', $objet);
    $stmt->bindParam(':reponse', $reponse);
    $stmt->execute();
    echo "Réclamation insérée avec succès.";
} catch (PDOException $e) {
    echo "Erreur lors de l'insertion de la réclamation : " . $e->getMessage();
}
?>