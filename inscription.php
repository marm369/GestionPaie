<?php
require('connectbdd.php');
if (!isset($_POST['submit_inscription'])) 
{
    echo "<script>alert('le formulaire n'est pas envoye essaye de nouveau');</script>";
}
else
{
   $nom=$_POST['nomentreprise'];
   $secteur=$_POST['secteur'];
   $datecreation=$_POST['datecreation'];
   $pays=$_POST['pays'];
   $adresse=$_POST['adresse'];
   $email=$_POST['email'];
   $codepostal=$_POST['codepostal'];
   $statut=$_POST['statut'];
   $devise=$_POST['devise'];
   $idf=$_POST['idf'];
   $idrc=$_POST['idrc'];
   $fraisprof=$_POST['fraisprof'];
   $rh=$_POST['rh'];
   $rp=$_POST['rp'];
   $motpasserh = $_POST['motpasserh'];
   $emailrh = $_POST['emailrh'];
   $motpasserp= $_POST['motpasserp'];
   $nbremploye = $_POST['nbremploye'];
   $emailrp = $_POST['emailrp'];
   $sous_entreprise=0;
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
    $req2="INSERT INTO comptes(`login`,`password`,`id_employe`,`poste`) values (:rh,:motpasserh,'','RH'),(:rp,:motpasserp,'','RP')";
    $smt2=$bdd->prepare($req2);
    $smt2->bindValue(':rh', $rh, PDO::PARAM_STR);
    $smt2->bindValue(':motpasserh', $motpasserh, PDO::PARAM_STR);
    $smt2->bindValue(':rp', $rp, PDO::PARAM_STR);
    $smt2->bindValue(':motpasserp', $motpasserp, PDO::PARAM_STR);
    $smt2->execute();
     // Envoyer l'e-mail avec le login et le mot de passe au RH et RP
     $subject1 = "compte RH";
     $message1 = "Votre login : $rh\nVotre mot de passe : $motpasserh";
     $headers = "From:minouarim@gmail.com";
     if(!mail($emailrh, $subject1, $message1, $headers))  
     {
        echo "<script>alert('echec lors de l'envoi de l'email au RH');</script>";
     }
     $subject1 = "compte RP";
     $message2 = "Votre login : $rp\nVotre mot de passe : $motpasserp";
     if(!mail($emailrp, $subject2, $message2, $headers)) 
     {
         
         echo "<script>alert('echec lors de l'envoi de l'email au RP');</script>";
     }
   header("Location: pageprincipale.php");
    }
    ?>