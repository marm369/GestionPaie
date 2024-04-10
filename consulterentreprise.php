<?php
include_once 'espacerh.php';
if (!isset($_SESSION['auth'])) {
    header('location:pageprincipale.html');
}
?>

<?php

echo "<div style='margin-left: 280px;  bottom: 1100px'>
<table class='table table-bordered' style='background-color: #f2f2f2; font-size: 14px; width: 600px'>
<tr style='background-color: #add8e6'>
  <th>Nom entreprise</th>
  <th>Secteur</th>
  <th>Adresse</th>
  <th>Pays</th>
  <th>Identifiant Fiscal</th>
  <th>Date Creation</th>
  <th>Statut</th>
  <th>Email</th>
  <th>Devise</th>
  <th>Nombre Employes</th>
  <th>Code Postal</th>
  <th>Identifiant Commercial</th>
  <th>Frais Professionnels</th>
</tr>";
require('connectbdd.php');
$req = "SELECT * FROM entreprise";
if (!empty($req)) {
    $smt = $bdd->query($req);
    $rows = $smt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $V) :
        echo "<tr>
                <td>" . $V['nom'] . "</td>
                <td>" . $V['secteur'] . "</td>
                <td>" . $V['adresse'] . "</td>
                <td>" . $V['pays'] . "</td>
                <td>" . $V['idf'] . "</td>
                <td>" . $V['dateCreation'] . "</td>
                <td>" . $V['statut'] . "</td>
                <td>" . $V['email'] . "</td>
                <td>" . $V['devise'] . "</td>
                <td>" . $V['nbremploye'] . "</td>
                <td>" . $V['codepostal'] . "</td>
                <td>" . $V['idrc'] . "</td>
                <td>" . $V['fraisprof'] . "</td>
              </tr>";
    endforeach;
}
echo "</table></div>";
?>
