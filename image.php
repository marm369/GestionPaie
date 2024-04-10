<?php
require('connectbdd.php');

$result = $bdd->query("SELECT logo FROM entreprise WHERE id = 11");
$row = $result->fetch();
$imageData = $row['logo'];
// Encoder l'image en base64
$base64Image = base64_encode($imageData);

// Afficher l'image dans la page HTML
echo '<img src="data:image/jpeg;base64,' . $base64Image . '" alt="Image">';
?>





<?php
require('connectbdd.php');
// Récupérer le chemin de l'image depuis la base de données (exemple avec MySQLi)
$result = $bdd->query("SELECT logo FROM entreprise WHERE id = 11");
$row = $result->fetch_assoc();
$imageData = $row['logo'];

// Afficher l'image dans la page HTML
echo '<img src="' . $imageData. '" alt="Image">';
?>

