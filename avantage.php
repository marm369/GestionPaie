
<?php
include_once 'espacerh.php';
 if(!isset($_SESSION['auth']))
 {
    header('location:pageprincipale.html');
 }
 ?>

<div class="container">
    <div class="card" style="width: 500px; margin: 50px auto;  left:150px;">
        <div class="card-body">   
        <h2>Saisir Avantages</h2>
<form action="avantage.php" method="post">
<div class="form-group">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" placeholder="nom" class="form-control" required><br>
</div>
        <div class="form-group">
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" placeholder="prenom" class="form-control" required><br>
        </div>
        <div class="form-group">
        <label for="datedebut">Date :</label>
        <input type="date" name="date" id="datedebut" placeholder="date" class="form-control" required><br>
        </div>
        <div class="form-group">
        <label for="nbrjour">Montant :</label>
        <input type="number" name="montant" id="nbrjour" placeholder="montant" class="form-control" required><br>
        </div>
        <div class="form-group">
        <label for="justifie">Type Avantage :</label>
        <select name="type" id="justifie" class="form-control"  required>
            <option value="nature">nature</option>
            <option value="argent">argent </option>    
        </select><br>
        </div>
        <input type="submit" name="enregistrer"  class="btn btn-primary" value="Enregistrer">
   
   
    </form>
   
  </div>
</div>
</div>
<?php
if(isset($_POST['enregistrer']))
{
// Récupérer le nom et le prénom de l'employé (supposons que vous les ayez reçus via un formulaire)
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$date = $_POST['date'];
$montant = $_POST['montant'];
$type = $_POST['type'];

// Effectuer la connexion à la base de données
require('connectbdd.php');

// Recherche de l'idEmploye à partir du nom et du prénom
$req1 = "SELECT idEmploye FROM employe WHERE nom = :nom AND prenom = :prenom LIMIT 1";
$stmt1 = $bdd->prepare($req1);
$stmt1->bindParam(':nom', $nom);
$stmt1->bindParam(':prenom', $prenom);
$stmt1->execute();

// Vérifier si la recherche a renvoyé un résultat
if ($stmt1->rowCount() > 0) {
    $row = $stmt1->fetch(PDO::FETCH_ASSOC);
    $idEmploye = $row['idEmploye'];

    // Insertion des informations d'absence dans la table "absence"
    $req2 = "INSERT INTO avantage (typeavantage, montant, date, id_employe) 
             VALUES (:type, :montant, :date,:idEmploye)";
    $stmt2 = $bdd->prepare($req2);
    $stmt2->bindParam(':type', $type);
    $stmt2->bindParam(':montant', $montant);
    $stmt2->bindParam(':idEmploye', $idEmploye);
    $stmt2->bindParam(':date', $date);
    $stmt2->execute();

    // Vérifier si l'insertion a réussi
    if ($stmt2->rowCount() > 0) {
        echo "Les informations d'absence ont été insérées avec succès dans la base de données.";
    } else {
        echo "Une erreur s'est produite lors de l'insertion des informations d'absence.";
    }
} else {
    echo "Aucun employé correspondant au nom $nom et au prénom $prenom n'a été trouvé.";
}
}
?>