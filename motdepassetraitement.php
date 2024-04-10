<?php 
session_start();
include_once 'pageprincipale.html';
?>
<?php
require('connectbdd.php');

if (isset($_POST['submit']))
 {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $req = "SELECT * FROM comptes WHERE `login` = :login";
    $smt = $bdd->prepare($req);
    $smt->bindValue(':login', $login, PDO::PARAM_STR);
    $smt->execute();

    // Si l'utilisateur existe, générer un code de confirmation aléatoire
    if ($smt->rowCount() > 0) {
        $code_confirmation = substr(md5(uniqid(rand(), true)), 0, 8);
        $code1=$code_confirmation ;
        $_SESSION['code1']=$code1;
        $_SESSION['prenom1']=$prenom;
        $_SESSION['nom1']=$nom;
        $_SESSION['email1']=$email;
        $_SESSION['login1']=$login;
        // Envoyer l'email de confirmation
        $sujet = "Récupération de mot de passe";
        $message = "Bonjour $prenom $nom,";
        $message .= "Voici votre code de confirmation : $code_confirmation";
        $message .= "Utilisez ce code pour récupérer votre mot de passe.";
        $message .= "Cordialement.";

        // Envoyer l'email
        $entete = "From: minouarim@gmail.com";
        if (mail($email, $sujet, $message, $entete)) {
            echo "<script>alert('Un email de confirmation a été envoyé à votre adresse. Veuillez vérifier votre boîte de réception.');</script>";
            echo '<div id="overlay" ></div>';
            echo '<form action="codeconfirmation.php" method="POST">';
            echo '<div id="form1" class="login-form fadeInDown">';
            echo 'Saisir le code de confirmation : <input type="text" name="code" placeholder="Code de confirmation">';
            echo '<input type="hidden" name="login" value="'.$login.'">';
            echo '<button type="submit" name="submit_code">Vérifier</button>';
            echo '</div>';
            echo '</form>';
        } else {
            echo "<script>alert('Erreur lors de l'envoi de l'email. Veuillez réessayer.');</script>";
        }
    } 
    else
     {
        echo "<script>alert('Le login spécifié n'existe pas.');</script>";
    }
}

?>




       
     