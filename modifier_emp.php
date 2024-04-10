<?php
include_once 'espacerh.php';
if(!isset($_SESSION['auth']))
{
   header('location:pageprincipale.html');
}
// Vérifier si le formulaire a été soumis
if (isset($_POST['chercher'])) {
  require('connectbdd.php');
  // Récupérer l'ID de l'entreprise sélectionnée
  $entreprise = $_POST['ssentreprise'];
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
  echo '<div class="table-responsive"   style="width: 700px; margin: 80px auto; margin-left: 500px;">';
  echo '<table class="table table-striped" style="width=400px; height:500px;">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>Nom</th>';
  echo '<th>Prénom</th>';
  echo '<th>Modifier</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nom = $row['nom'];
    $prenom = $row['prenom'];

    echo '<tr>';
    echo '<td>' . $nom . '</td>';
    echo '<td>' . $prenom . '</td>';
    echo '<form method="POST" action="modifier_employe.php">';
    echo '<input type="hidden" name="nom" value="' . $nom . '">';
    echo '<input type="hidden" name="prenom" value="' . $prenom . '">';
    echo '<td><button type="submit" class="btn btn-primary" name="chercher">Modifier</button></td>';
    echo '</form>';
    echo '</tr>';
  }
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
}
?>
