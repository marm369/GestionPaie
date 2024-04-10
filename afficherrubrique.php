<?php
include_once 'espacerp.php';

// Vérifier si le formulaire a été soumis
if (isset($_POST['envoyer'])) {
  require('connectbdd.php');
  // Récupérer l'ID de l'entreprise sélectionnée
  $entreprise = $_POST['entreprise'];
  $sql1 = "SELECT id FROM entreprise WHERE nom = :nomentreprise";
  $stmt1 = $bdd->prepare($sql1);
  $stmt1->bindParam(':nomentreprise', $entreprise);
  $stmt1->execute();
  $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
  $entrepriseId = $row1['id'];

  // Effectuer la requête pour récupérer les rubriques de cette entreprise
  // Remplacez les informations de connexion par les vôtres

  $query = "SELECT * FROM rubrique WHERE id_entreprise = :entrepriseId";
  $stmt = $bdd->prepare($query);
  $stmt->bindParam(':entrepriseId', $entrepriseId);
  $stmt->execute();

  // Afficher les rubriques dans un tableau avec le style de Bootstrap
  echo '<div class="table-responsive" style="width: 700px; margin: 80px auto; margin-left: 500px;">';
  echo '<table class="table table-striped" style="width: 400px; height: 500px;">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>Rubriques</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nom = $row['libelle'];

    echo '<tr>';
    echo '<td>' . $nom . '</td>';
    echo '</tr>';
  }
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
}
?>