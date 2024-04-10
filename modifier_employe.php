
<?php
include_once 'espacerh.php';
 if(!isset($_SESSION['auth']))
 {
    header('location:pageprincipale.hmtl');
 }
 ?>
 <?php
require('connectbdd.php');
if (!isset($_POST['chercher'])) 
{
    echo "<script>alert('le formulaire n'est pas envoye essaye de nouveau');</script>";
}
else
{
   $nom=$_POST['nom'];
   $prenom=$_POST['prenom'];
   // Récupérer l'ID de l'entreprise
    $req1 = "SELECT * FROM employe WHERE nom = :nom AND prenom = :prenom";
    $smt1 = $bdd->prepare($req1);
    $smt1->bindValue(':nom', $nom, PDO::PARAM_STR);
    $smt1->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $smt1->execute();
    $row = $smt1->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $_SESSION['employe'] = $row;
        echo "<script>setTimeout(function(){window.location.href='modifier_employe.php';}, 0);</script>";
       
    } else {
        echo "<script>alert('Aucune employe correspondante trouvée');</script>";
    }

}
    ?>
<div class="container" >
    <div class="card" style="width: 600px; margin: 50px auto; left:150px;" >
        <div class="card-body">
            <form action="modifier_employe.php" method="POST">
              
                    <label for="user_last_name">Nom :</label>
                    <input class="form-control" value="<?php echo $_SESSION['employe']['nom']; ?>" type="text" name="nom">
                    <label for="user_last_name">Prenom :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['prenom']); ?>" type="text" name="prenom">
                    <label for="user_last_name">Situation :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['situation']); ?>" type="text" name="situation">
                    <label for="user_last_name">Date_Naissance :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['date_naissance']); ?>" type="date" name="date_naissance">
                    <label for="user_last_name">Genre :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['genre']); ?>" type="text" name="genre">
                    <label for="user_last_name">Adresse :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['adresse']); ?>" type="text" name="adresse">
                    <label for="user_last_name">Numero_Tel :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['numero_tel']); ?>" type="text" name="numero_tel">
                    <label for="user_last_name">Email :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['e_mail']); ?>" type="email" name="email">
                    <label for="user_last_name">Poste :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['poste']); ?>" type="text" name="poste">
                    <label for="user_last_name">Date d'Embauche :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['date_embauche']); ?>" type="date" name="date_embauche">
                    <label for="user_last_name">Salaire de base :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['salaire_base']); ?>" type="nombre" name="salaire_base">
                    <label for="user_last_name">Id AMO :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['idAmo']); ?>" type="nombre" name="idAmo">
                    <label for="user_last_name">Id CIMR :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['idCimr']); ?>" type="nombre" name="idCimr">
                    <label for="user_last_name">Nombre Enfant :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['nbrEnfant']); ?>" type="nombre" name="nbrEnfant">
                    <label for="user_last_name">Taux CIMR :</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['employe']['taux_cimr']); ?>" type="nombre" name="taux_cimr">
             
                <input type="submit" value="Enregistrer Modifications" name="modifier" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>

   <?php

if (!isset($_POST['modifier'])) 
{
    echo "<script>alert('le formulaire n'est pas envoye essaye de nouveau');</script>";
}
else
{
   $nom=$_POST['nom'];
   $prenom=$_POST['prenom'];
   $situation=$_POST['situation'];
   $datenaissance=$_POST['date_naissance'];
   $genre=$_POST['genre'];
   $adresse=$_POST['adresse'];
   $numero_tel=$_POST['numero_tel'];
   $email=$_POST['email'];
   $poste=$_POST['poste'];
   $dateembauche = $_POST['date_embauche'];
   $salaire_base=$_POST['salaire_base'];
   $idAmo=$_POST['idAmo'];
   $idCimr=$_POST['idCimr'];
   $nbrEnfant=$_POST['nbrEnfant'];
   $taux_cimr=$_POST['taux_cimr'];
   $ideg=$_SESSION['employe']['idEmploye'] ;
   $smt1=$bdd->prepare("UPDATE employe SET nom=:nom ,prenom=:prenom , situation=:situation, date_naissance=:date_naissance, genre=:genre ,
    date_embauche=:date_embauche , adresse=:adresse , e_mail=:email , numero_tel=:numero_tel ,salaire_base=:salaire_base ,poste=:poste,
           idAmo=:idAmo,idCimr=:idCimr ,nbrEnfant=:nbrEnfant , taux_cimr=:taux_cimr  where idEmploye=:ideg");
    $smt1->bindValue(':nom', $nom, PDO::PARAM_STR);
    $smt1->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $smt1->bindValue(':situation', $situation, PDO::PARAM_STR);
    $smt1->bindValue(':date_naissance', $datenaissance, PDO::PARAM_STR);
    $smt1->bindValue(':genre', $genre, PDO::PARAM_STR);
    $smt1->bindValue(':date_embauche', $dateembauche, PDO::PARAM_STR);
    $smt1->bindValue(':adresse', $adresse, PDO::PARAM_STR); // Utilisez PARAM_STR pour les dates
    $smt1->bindValue(':email', $email, PDO::PARAM_STR);
    $smt1->bindValue(':numero_tel', $numero_tel, PDO::PARAM_STR);
    $smt1->bindValue(':salaire_base', $salaire_base, PDO::PARAM_INT);
    $smt1->bindValue(':poste', $poste, PDO::PARAM_STR);
    $smt1->bindValue(':idAmo', $idAmo, PDO::PARAM_INT);
    $smt1->bindValue(':idCimr', $idCimr, PDO::PARAM_INT); // Assurez-vous de définir correctement $nbremploye
    $smt1->bindValue(':nbrEnfant', $nbrEnfant, PDO::PARAM_INT);
    $smt1->bindValue(':taux_cimr', $taux_cimr, PDO::PARAM_INT);
    $smt1->bindValue(':ideg', $ideg, PDO::PARAM_INT);
    $smt1->execute();
    if ($smt1) 
    {
        echo "<script>setTimeout(function(){window.location.href='modifieremploye.php';}, 0);</script>";
    } 
   
    }

    $sql1 = "SELECT * FROM bulletin WHERE id_employe = :id";
        
    $stmt1= $bdd->prepare($sql1);
    $stmt1->bindParam(':id', $id);
    $stmt1->execute();
    $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
?>
