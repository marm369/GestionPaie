<?php
include_once 'espacerh.php';
if (!isset($_SESSION['auth'])) {
    header('location:pageprincipale.html');
}
?>
<div class="container">
    <div class="card" style="width: 500px; margin: 50px auto;  left:150px;">
        <div class="card-body">
            <form action="ajouterentreprise.php" method="POST">
                <div class="form-group">
                    <label for="user_last_name">Nom sous_entreprise</label>
                    <input class="form-control" type="text" name="nom">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Secteur</label>
                    <select name="secteur" class="form-control">
                        <option value="Agriculture">Agriculture</option>
                        <option value="Industrie">Industrie</option>
                        <option value="Commerce">Commerce</option>
                        <option value="Services">Services</option>
                        <option value="Informatique">Informatique</option>
                        <option value="Tourisme">Tourisme</option>
                        <option value="Finance">Finance</option>
                        <option value="Santé">Santé</option>
                        <!-- Ajoutez d'autres options selon vos besoins -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="user_last_name">Adresse</label>
                    <input class="form-control" type="text" name="adresse">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Pays</label>
                    <input class="form-control" type="text" name="pays">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Identifiant Fiscal</label>
                    <input class="form-control" type="nombre" name="idf">
                </div>
                <div class="form-group">
                    <label for="user_last_name">DateCreation</label>
                    <input class="form-control" type="date" name="date">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Statut</label>
                    <input class="form-control" type="text" name="statut">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Email</label>
                    <input class="form-control" type="email" name="email">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Devise</label>
                    <input class="form-control" type="text" name="devise">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Nombre employes</label>
                    <input class="form-control" type="nombre" name="nbremploye">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Code Postale</label>
                    <input class="form-control" type="nombre" name="codepostal">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Identifiant Commercial</label>
                    <input class="form-control" type="nombre" name="idrc">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Frais Professionnel</label>
                    <input class="form-control" type="text" name="fraisprof">
                </div>
                <input type="submit" value="Enregistrer" name="enregistrer" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<?php
require('connectbdd.php');
if (!isset($_POST['enregistrer'])) 
{
    echo "<script>alert('le formulaire n'est pas envoye essaye de nouveau');</script>";
}
else
{
   $nom=$_POST['nom'];
   $secteur=$_POST['secteur'];
   $adresse=$_POST['adresse'];
   $pays=$_POST['pays'];
   $idf=$_POST['idf'];
   $datecreation=$_POST['date'];
   $statut=$_POST['statut'];
   $email=$_POST['email'];
   $devise=$_POST['devise'];
   $nbremploye = $_POST['nbremploye'];
   $codepostal=$_POST['codepostal'];
   $idrc=$_POST['idrc'];
   $fraisprof=$_POST['fraisprof'];
   $sous_entreprise=1;
   $req1="INSERT INTO entreprise(`nom`,`secteur`,`adresse`,`pays`,`idf`,`dateCreation`,`statut`,`email`,`devise`,`sous_entreprise`,`nbremploye`,`codepostal`,`idrc`,`fraisprof`) 
   values(:nom,:secteur,:adresse,:pays,:idf,:datecreation,:statut,:email,:devise,$sous_entreprise,:nbremploye,:codepostal,:idrc,:fraisprof)";
    $smt1 = $bdd->prepare($req1);
    $smt1->bindValue(':nom', $nom, PDO::PARAM_STR);
    $smt1->bindValue(':secteur', $secteur, PDO::PARAM_STR);
    $smt1->bindValue(':adresse', $adresse, PDO::PARAM_STR);
    $smt1->bindValue(':pays', $pays, PDO::PARAM_STR);
    $smt1->bindValue(':idf', $idf, PDO::PARAM_INT);
    $smt1->bindValue(':datecreation', $datecreation, PDO::PARAM_STR); // Utilisez PARAM_STR pour les dates
    $smt1->bindValue(':statut', $statut, PDO::PARAM_STR);
    $smt1->bindValue(':email', $email, PDO::PARAM_STR);
    $smt1->bindValue(':devise', $devise, PDO::PARAM_STR);
    $smt1->bindValue(':nbremploye', $nbremploye, PDO::PARAM_INT); // Assurez-vous de définir correctement $nbremploye
    $smt1->bindValue(':codepostal', $codepostal, PDO::PARAM_INT);
    $smt1->bindValue(':idrc', $idrc, PDO::PARAM_INT);
    $smt1->bindValue(':fraisprof', $fraisprof, PDO::PARAM_INT);
    $smt1->execute();
}
?>
