<?php
include_once 'espacerh.php';
/*$id = $_SESSION['identificateur'];*/
?>
<?php
require('connectbdd.php');
$req = "SELECT absence.datedebut, absence.nbrjour, absence.justifie, absence.motif, employe.nom, employe.prenom
        FROM absence
        INNER JOIN employe ON absence.id_employe = employe.idEmploye";
$smt = $bdd->query($req);
$donnees = $smt->fetchAll(PDO::FETCH_ASSOC);
if (!empty($donnees)) {
    // Afficher les données dans une liste horizontale avec le style Bootstrap
    echo '<div class="container" style="margin-top: 60px; margin-left: 300px;">';
    echo '<div class="card" style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);">';
    echo '<div class="card-header" style="background-color: #f8f9fa; color: #212529; font-weight: bold; font-size: 24px;">Les absences</div>';
    echo '<div class="card-body">';

    echo '<table class="table table-bordered">';
    echo '<thead class="thead-light">';
    echo '<tr>';
    echo '<th>Nom</th>';
    echo '<th>Prénom</th>';
    echo '<th>Date début</th>';
    echo '<th>Nombre jours</th>';
    echo '<th>Justifié</th>';
    echo '<th>Motif</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($donnees as $ligne) {
        echo '<tr>';
        echo '<td>' . $ligne['nom'] . '</td>';
        echo '<td>' . $ligne['prenom'] . '</td>';
        echo '<td>' . $ligne['datedebut'] . '</td>';
        echo '<td>' . $ligne['nbrjour'] . '</td>';
        echo '<td>' . $ligne['justifie'] . '</td>';
        echo '<td>' . $ligne['motif'] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

    echo '</div>';
    echo '</div>';
    echo '</div>';
} else {
    echo "<script>alert('Aucune absence n'a été enregistrée.');</script>";
}
?>
