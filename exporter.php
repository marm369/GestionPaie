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

  // Effectuer la requête pour récupérer les employés de cette entreprise
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
  echo '<th>Exporter</th>';
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
    echo "<form action='exportD_pdf.php?nom=$nom&prenom=$prenom' method='post'>";
    echo '<button class="btn btn-danger"><i class="bi bi-file-pdf"></i> PDF</button>';
    echo '</form>';
    echo '</td>';

    echo '<td>';
    echo "<form action='exportD_excel.php?nom=$nom&prenom=$prenom' method='post'>";
    echo '<button class="btn btn-danger"><i class="bi bi-file-excel"></i> Excel</button>';
    echo '</form>';
    echo '</td>';
    
    echo '</tr>';
  }
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
}
?>
