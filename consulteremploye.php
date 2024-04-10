
<?php
include_once 'espacerh.php';
 if(!isset($_SESSION['auth']))
 {
    header('location:pageprincipale.html');
 }

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

<div class="container">
    <div class="card" style="width: 500px; margin: 50px auto; left:150px;">
        <div class="card-body">
            <form action="consulter_employe.php" method="POST">
                <div class="form-group">
                    <label for="prenom">Nom sous entreprise :</label>
               




                    <select id="entreprise" name="ssentreprise" class="form-control" required style="width: 100%; height: 40px; padding: 8px; margin-bottom: 10px;">
            <?php
            // Parcours du tableau des entreprises pour créer les options de la liste déroulante
            foreach ($entreprises as $entreprise) {
              echo '<option value="' . $entreprise . '">' . $entreprise . '</option>';
            }
            ?>
          </select>
                </div>
                <input type="submit" value="Chercher" name="chercher" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
