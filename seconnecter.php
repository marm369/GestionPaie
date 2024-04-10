<?php
        session_start();
        include_once 'pageprincipale.html';
        if(isset($_SESSION['error'])) {
            $error_message = $_SESSION['error'];
            unset($_SESSION['error']); // Supprime la variable de session après l'affichage
        }
        ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Titre</title>
  
</head>
<body>
    <header>
      
    </header>
    <div id="main-content">
   
        <div id="overlay"></div>
        <form action="connexion.php" method="POST">
            <div id="form1" class="login-form fadeInDown">
                <!-- Tabs Titles -->
                <h2 id="loginTab" class="active">Se connecter</h2>
                <!-- Login Form -->
                <input type="text" class="fadeIn second" name="login" placeholder="Nom d'utilisateur">
                <input type="password" class="fadeIn third" name="password" placeholder="Mot de Passe">
                <input type="submit" class="fadeIn fourth" name="submit_login" value="Se Connecter">
                <label style="color:red;" class="fadeIn fifth">
                    <?php if(isset($error_message)) { ?>
                        <p><?php echo "Nom d'utilisateur ou mot de passe incorrect."; ?></p>
                    <?php } ?>
                </label>
                <div id="formFooter">
                    <a class="underlineHover" href="motdepasse.php">Forgot Password?</a>
                </div>
            </div>
        </form>
    </div>
    <footer>
        
    </footer>
    
    <script>
        document.addEventListener("click", function(event) {
            var divFormulaire = document.getElementById("form1");
            if (!divFormulaire.contains(event.target)) {
                window.location.href = "pageprincipale.html";
            }
        });
    </script>
</body>
</html>
