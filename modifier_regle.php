<?php
include_once 'espacerp.php';

// Connexion à la base de données
  require('connectbdd.php');

// Requête pour obtenir tous les noms des entreprises
$reqEntreprises = "SELECT nom FROM entreprise";
$resultat = $bdd->query($reqEntreprises);

// Tableau pour stocker les noms des entreprises
$entreprises = array();

// Extraction des noms des entreprises de la requête
while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
  $entreprises[] = $row['nom'];
}

$reqRubriques = "SELECT libelle FROM rubrique ";
$resultat = $bdd->query($reqRubriques);

// Tableau pour stocker les noms des entreprises
$rubriques = array();

// Extraction des noms des entreprises de la requête
while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
  $rubriques[] = $row['libelle'];
}
?>


<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <style>
    .btn-chercher {
      background-color: #FF0000;
      color: #FFFFFF;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card" style="width: 500px; margin: 50px auto;">
      <div class="card-body">
        <form method="POST" action="modifierregle.php">
          <div class="form-group">
          <label for="entreprise">Choisir Entreprise:</label>
          <select id="entreprise" name="entreprise" class="form-control" required style="width: 100%; height: 40px; padding: 8px; margin-bottom: 10px;">
            <?php
            // Parcours du tableau des entreprises pour créer les options de la liste déroulante
            foreach ($entreprises as $entreprise) {
              echo '<option value="' . $entreprise . '">' . $entreprise . '</option>';
            }
            ?>
          </select>
          
          </div>

          <div class="form-group">
          <label for="rubrique">Choisir Rubrique:</label>
          <select id="rubrique" name="rubrique" class="form-control" required style="width: 100%; height: 40px; padding: 8px; margin-bottom: 10px;">
          <?php
              foreach ($rubriques as $rubrique) {
              echo '<option value="' . $rubrique . '">' . $rubrique . '</option>';
            }
            ?>
          </select>
          
          </div>
          <div class="form-group">
          <label for="regle">Nouvelle Regle:</label>
          <input type="text" id="regle" name="regle" class="form-control" />
          </div>
          <br>
          <input type="submit" class="btn btn-chercher" name="envoyer" value="Modifier">
        </form>
      </div>
    </div>
  </div>

</body>
</html>
