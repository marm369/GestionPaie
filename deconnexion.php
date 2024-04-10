<?php
 session_start();
 if(!isset($_SESSION['auth']))
 {
    header('location:pageprincipale.html');
 }
 if(isset($_GET['logout']))
{
    unset($_SESSION['auth']);
    session_destroy();
    header("Location: pageprincipale.html");
}
 ?>