<?php
include_once 'espacerp.php';

// Vérifier si le formulaire a été soumis
if (isset($_POST['envoyer'])) {
  require('connectbdd.php');

  $date = $_POST['date'];
  // Récupérer l'ID de l'entreprise sélectionnée
  $entreprise = $_POST['entreprise'];
  $sql1 = "SELECT id FROM entreprise WHERE nom = :nomentreprise";
  $stmt1 = $bdd->prepare($sql1);
  $stmt1->bindParam(':nomentreprise', $entreprise);
  $stmt1->execute();
  $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
  $entrepriseId = $row1['id'];

  // Effectuer la requête pour récupérer les employés de cette entreprise
  // Remplacez les informations de connexion par les vôtres
  $query = "SELECT * FROM employe WHERE id_entreprise = :entrepriseId";
  $stmt = $bdd->prepare($query);
  $stmt->bindParam(':entrepriseId', $entrepriseId);
  $stmt->execute();

  // Afficher les employés dans un tableau avec le style de Bootstrap
  echo '<div class="table-responsive" style="width: 700px; margin: 80px auto; margin-left: 500px;">';
  echo '<table class="table table-striped" style="width=400px; height:500px;">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>Nom</th>';
  echo '<th>Prénom</th>';
  echo '<th>Generer</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nom = $row['nom'];
    $prenom = $row['prenom'];

    echo '<tr>';
    echo '<td>' . $nom . '</td>';
    echo '<td>' . $prenom . '</td>';
    echo '<td>';
    echo '<form method="POST" action="traitement_paie.php">';
    echo '<input type="hidden" name="nom" value="' . $nom . '">';
    echo '<input type="hidden" name="prenom" value="' . $prenom . '">';
    echo '<input type="hidden" name="date" value="' . $date . '">';
    echo '<button type="submit" class="btn btn-danger">Générer</button>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
  }
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
}
?>
