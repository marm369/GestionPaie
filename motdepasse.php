<?php include_once 'pageprincipale.html';?>
    <div id="overlay" ></div>
      <form action="motdepassetraitement.php" method="POST">
    <div id="form1" class="login-form fadeInDown">
        <!-- Tabs Titles -->
        <h2 id="loginTab" class="active">Récupération de mot de passe</h2>
   
        <!-- les infos personnelles -->
        <input type="text" class="fadeIn first" name="nom" placeholder="Nom" required>
          <input type="text" class="fadeIn second" name="prenom" placeholder="Prenom" required>
          <input type="text" class="fadeIn third" name="email" placeholder="Email" required>
          <input type="text" class="fadeIn fourth" name="login" placeholder="Login" required>
          <button type="submit" name="submit" class="underlineHover fadeIn fifth" > Envoyer </button>
       
        
      </div>  
  </form>
  <script>
document.addEventListener("click", function(event) {
        var divFormulaire = document.getElementById("form1");
        if (!divFormulaire.contains(event.target)) {
          window.location.href = "pageprincipale.html";
        }
      });
</script>
 


 