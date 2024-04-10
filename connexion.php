<?php
 session_start();
if (isset($_POST['submit_login']))
{
   $p = $_POST['password'];
   $l = $_POST['login'];
   require('connectbdd.php');
   $req="SELECT*FROM comptes WHERE `login`=:l AND `password`=:p";
   $smt=$bdd->prepare($req);
    //On injecte les valeurs "bindvalue"
    $smt->bindValue('l',$l,PDO::PARAM_STR);
    $smt->bindValue('p',$p,PDO::PARAM_STR);
    $smt->execute();
    $rows=$smt->fetchAll(PDO::FETCH_ASSOC);
    $row=$rows[0];
    $_SESSION['auth']=$l;
   if(!empty($row))
   {
      
         if ($row['poste'] == 'RH') 
         {
            header("location:espace_rh_dashboard.php");
         }
         else if($row['poste'] == 'RP') 
         {
            header("location:espace_rp_dashboard.php");
         }
         else
         {
            header("location: profile.php");
         }
     
   }
   else
   {
   $_SESSION['error'] = "Nom d'utilisateur ou mot de passe incorrect.";
      header("location:seconnecter.php");
   }
} 

?>


