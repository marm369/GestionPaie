

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
 ?>
<div class="container">
    <div class="card" style="width: 500px; margin: 50px auto; left: 150px;">
        <div class="card-body">
            <form action="supprimeremploye.php" method="POST">
            
                <div class="form-group">
                    <label for="prenom">Nom de sous_entreprise :</label>
                    <select id="entreprise" name="ssentreprise" class="form-control" required style="width: 100%; height: 40px; padding: 8px; margin-bottom: 10px;">
            <?php
            // Parcours du tableau des entreprises pour créer les options de la liste déroulante
            foreach ($entreprises as $entreprise) {
              echo '<option value="' . $entreprise . '">' . $entreprise . '</option>';
            }
            ?>
          </select>
                </div>
                <input type="submit" value="Chercher" name="supprimer" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['supprimer'])) {
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
  echo '<div class="table-responsive"   style="width: 700px; margin: 80px auto; margin-left: 550px;">';
  echo '<table class="table table-striped" >';
  echo '<thead>';
  echo '<tr>';
  echo '<th>Nom</th>';
  echo '<th>Prénom</th>';
  echo '<th>Supprimer</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nom = $row['nom'];
    $prenom = $row['prenom'];

    echo '<tr>';
    echo '<td>' . $nom . '</td>';
    echo '<td>' . $prenom . '</td>';
    echo '<form method="POST" action="supprimer_employe.php">';
    echo '<input type="hidden" name="nom" value="' . $nom . '">';
    echo '<input type="hidden" name="prenom" value="' . $prenom . '">';
    echo '<td><button type="submit" class="btn btn-primary" name="supprimer">Supprimer</button></td>';
    echo '</form>';
    echo '</tr>';
  }
  echo '</tbody>';
  echo '</table>';
  echo '</div>';
}
?>






<?php
/*
require('connectbdd.php');
if (!isset($_POST['supprimer'])) 
{
    echo "<script>alert('le formulaire n'est pas envoye essaye de nouveau');</script>";
}
else
{
   $nom=$_POST['nom'];
   $prenom=$_POST['prenom'];
   // Récupérer l'ID de l'entreprise
    $req1 = "SELECT idEmploye FROM employe WHERE nom = :nom AND prenom = :prenom";
    $smt1 = $bdd->prepare($req1);
    $smt1->bindValue(':nom', $nom, PDO::PARAM_STR);
    $smt1->bindValue(':prenom', $prenom, PDO::PARAM_INT);
    $smt1->execute();
    $row = $smt1->fetch(PDO::FETCH_ASSOC);
    $idEmploye = $row['idEmploye'];
    if ($idEmploye) 
    {
        // Supprimer l'entreprise de la table
        $req2 = "DELETE FROM employe WHERE idEmploye = :idEmploye";
        $smt2 = $bdd->prepare($req2);
        $smt2->bindValue(':idEmploye', $idEmploye, PDO::PARAM_INT);
        $smt2->execute();
        if ($smt2) 
        {
            echo "<script>alert('L'employe a été supprimée avec succès.');</script>";
        } 
        else 
        {
            echo "<script>alert('Une erreur s'est produite lors de la suppression de l'employe.');</script>";
        }
    } 
    else 
    {
        echo "<script>alert('L'employe spécifiés n'existe pas.');</script>";
    }
}*/
    ?>