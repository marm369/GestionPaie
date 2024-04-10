
<?php
 include_once 'espaceemp.php'; 
$id=$_SESSION['identificateur'];
 ?>
<?php
require('connectbdd.php');

$req = "SELECT typejour, journuit, date, nbrHeures,reponse FROM heure_supp WHERE id_employe = $id";
$smt=$bdd->query($req);
$donnees=$smt->fetchAll(PDO::FETCH_ASSOC);

if(!empty($req))
{
    // Afficher les données dans un fieldset avec le style
    echo '<table style="width:800px; border-collapse: collapse; margin-top: 80px;  margin-left:400px;font-size: 16px;">';
    
    echo '<tr style="background-color: #f2f2f2;">';
    echo '<th style="padding: 10px; border: 1px solid #ddd;">Type de jour</th>';
    echo '<th style="padding: 10px; border: 1px solid #ddd;">Jour</th>';
    echo '<th style="padding: 10px; border: 1px solid #ddd;">Date </th>';
    echo '<th style="padding: 10px; border: 1px solid #ddd;">Nombre d\'heures</th>';
    echo '<th style="padding: 10px; border: 1px solid #ddd;">Reponse</th>';
    echo '</tr>';

    // Parcourir les données avec une boucle foreach et afficher les valeurs
    foreach ($donnees as $ligne) {
        echo '<tr>';
        echo '<td style="padding: 10px;  border: 1px solid #ddd;">' . $ligne['typejour'] . '</td>';
        echo '<td style=" padding: 10px; border: 1px solid #ddd;">' . $ligne['journuit'] . '</td>';
        echo '<td style="padding: 10px; border: 1px solid #ddd;">' . $ligne['date'] . '</td>';
        echo '<td style="padding: 10px; border: 1px solid #ddd;">' . $ligne['nbrHeures'] . '</td>';
        echo '<td style="padding: 10px; border: 1px solid #ddd;">' . $ligne['reponse'] . '</td>';
        echo '</tr>';
    }
    echo "</table>";
   
} 
else 
{
    echo "<script>alert('Aucun heures supplementaires n'est pris');</script>";
}
?>




