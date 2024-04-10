
<?php
session_start();

$code1=$_SESSION['code1'];
$prenom=$_SESSION['prenom1'];
$nom=$_SESSION['nom1'];
$email=$_SESSION['email1'];
$login=$_SESSION['login1'];
require('connectbdd.php');
if (isset($_POST['submit_code'])) 
{
    echo "le code confirmation".$code1;
    $code = $_POST['code'];
    $req1 = "SELECT password FROM comptes WHERE `login` = :login";
    $smt1 = $bdd->prepare($req1);
    $smt1->bindValue(':login', $login, PDO::PARAM_STR);
    $smt1->execute();
    $rows = $smt1->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($rows))
    {
        $row = $rows[0];
        $password = $row['password'];
        echo "le code envoye par email est ".$code;
        echo "le code confirmation".$code1;
        echo "l'email".$email;
        echo "l'email".$password;
        if ($code === $code1) 
        {
            $sujet2 = "Envoi de mot de passe";
            $entete2 = "From: minouarim@gmail.com";
            $message2 = "Bonjour $prenom $nom,";
            $message2 .= "Votre mot de passe est : $password";
            $message2 .= "Veuillez le changer dès que possible.";
            $message2 .= "Cordialement.";
            mail($email, $sujet2, $message2, $entete2);
            echo "<script>alert('Le code de confirmation est correct.le code a été envoyer a votre boite email .');</script>";
        } 
    }
    else 
    {
        echo "<script>alert('Le code de confirmation est incorrect. Veuillez réessayer.');</script>";
    }
   
}
?>