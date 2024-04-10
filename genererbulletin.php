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
?>


<!DOCTYPE html>
<html>
<head>
  <title>Calendrier Mois et Année</title>
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
        <form method="POST" action="generer.php">
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
            <label for="moisAnnee">Mois et Année:</label>
            <div id="datepicker" class="input-group date" data-date-format="mm/yyyy">
              <input class="form-control" type="text" name="date" readonly />
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
          </div>
          <br>
          <input type="submit" class="btn btn-chercher" name="envoyer" value="Chercher">
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.fr.min.js"></script>
  <script>
    // Initialisation du calendrier Mois et Année
    $(document).ready(function() {
      $('#datepicker').datepicker({
        format: 'mm/yyyy',
        startView: 'months',
        minViewMode: 'months',
        language: 'fr',
        autoclose: true
      });
    });
  </script>
</body>
</html>
