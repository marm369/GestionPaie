<?php
include_once 'espaceemp.php';
$id = $_SESSION['identificateur'];
?>

<?php
require('connectbdd.php');
$req = "SELECT idconge, typeconge, datedebut, datefin, reponse FROM conge WHERE id_employe = $id";
$smt = $bdd->query($req);
$donnees = $smt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($donnees)) {
    echo '<table style="width:800px; border-collapse: collapse; margin-top: 80px;  margin-left:400px;font-size: 16px;">';
    echo '<tr style="background-color: #f2f2f2;">';
    echo '<th style="padding: 10px; border: 1px solid #ddd;">Type congé</th>';
    echo '<th style="padding: 10px; border: 1px solid #ddd;">Jour</th>';
    echo '<th style="padding: 10px; border: 1px solid #ddd;">Date début</th>';
    echo '<th style="padding: 10px; border: 1px solid #ddd;">Date fin</th>';
    echo '<th style="padding: 10px; border: 1px solid #ddd;">Réponse</th>';
    echo '</tr>';

    foreach ($donnees as $ligne) {
        echo '<tr>';
        echo '<td style="padding: 10px;  border: 1px solid #ddd;">' . $ligne['typeconge'] . '</td>';
        echo '<td style=" padding: 10px; border: 1px solid #ddd;">' . $ligne['idconge'] . '</td>';
        echo '<td style="padding: 10px; border: 1px solid #ddd;">' . $ligne['datedebut'] . '</td>';
        echo '<td style="padding: 10px; border: 1px solid #ddd;">' . $ligne['datefin'] . '</td>';
        echo '<td style="padding: 10px; border: 1px solid #ddd;">' . $ligne['reponse'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo "<p>Aucun congé n'est pris.</p>";
}
?>
