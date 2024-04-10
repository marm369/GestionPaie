<?php include_once 'pageprincipale.html';?>

      <div id="overlay" ></div>
      <form action="inscription.php" method="POST">
      <div id="form2" class="login-form fadeInDown">
      <h2 id="inscriptionTab" class="active" >S'inscrire</h2>
        <!-- les infos personnelles -->

        <div id="perso">
          <input type="text" class="fadeIn first" name="nomentreprise" placeholder="Nom d'entreprise" required>
          <input type="number" class="fadeIn second" min="1" name="nbremploye" oninvalid="this.setCustomValidity('Veuillez entrer un nombre positif.')" placeholder="Nombre d'employé(e)s" required>
          <select name="secteur" class="fadeIn third" required>
            <option value="Secteur">Secteur</option>
            <option value="agriculture">Agriculture</option>
            <option value="industrie">Industrie</option>
            <option value="commerce">Commerce</option>
            <option value="services">Services</option>
            <option value="informatique">Informatique</option>
            <option value="tourisme">Tourisme</option>
            <option value="finance">Finance</option>
            <option value="santé">Santé</option>
            <!-- Ajoutez d'autres options selon vos besoins -->
          </select>

          <input type="file" class="fadeIn fifth" name="logo" placeholder="Importer logo" >
          <input  type="date"   class="fadeIn fourth" name="datecreation"  required>
          <button class="underlineHover fadeIn sixth"  onclick="showcontact()">Suivant</button>
        </div>
    
        <!-- contact-->
        <div id="contact"style="display: none;">
        <input type="text" class="fadeIn first" name="pays" placeholder="Pays" required>
        <input type="text" class="fadeIn second" name="devise" placeholder="Devise" required>
        <input type="text" class="fadeIn third" name="fraisprof" placeholder="FraisProfessionnel" required>
        <input type="text" class="fadeIn fourth" name="adresse" placeholder="Adresse" required>
        <input type="text" id="email" class="fadeIn fifth" name="email" placeholder="Email" required>
        <input type="number" class="fadeIn sixth" name="codepostal" placeholder="Code postal" required>
        <button class="underlineHover  fadeIn seventh"  onclick="showperso()">Retour</button>
        <button class="underlineHover fadeIn seventh"  onclick="validateEmailAndProceed(event)" >Suivant</button>
  
      </div>
  
      <!-- les infos juridiques -->
      <div id="jurid" style="display: none;">
        <input type="text" class="fadeIn first" name="statut" placeholder="Statut" required>
        <input type="text" class="fadeIn second"  name="cnss" placeholder="CNSS" required>
        <input type="number" class="fadeIn third"  name="idf" placeholder="N Identifiant Fiscal" required>
        <input type="number" class="fadeIn fourth" name="idrc" placeholder="N Registre Commercial" required>
        <button class="underlineHover fadeIn fifth"  onclick="showcontact1()">Retour</button>
        <button class="underlineHover fadeIn fifth"  onclick="showrh_rp()" >Suivant</button>
      </div>
      <!-- les infos RH RP -->
      <div id="rh_rp" style="display: none;">
        <input type="text" class="fadeIn first" name="rh" placeholder="login RH " required>
        <input type="password" class="fadeIn second" name="motpasserh" placeholder="mot de passe RH" required>
        <input type="text" class="fadeIn third"  id="emailrh" name="emailrh" placeholder="Email RH" required>
        <input type="text" class="fadeIn fourth"  name="rp" placeholder="login RP" required>
        <input type="password" class="fadeIn fifth" name="motpasserp" placeholder="mot de passe RP" required>
        <input type="text" class="fadeIn sixth" id="emailrp"  name="emailrp" placeholder="Email RP" required>
        <button class="underlineHover fadeIn seventh"  w onclick="showjurid1()">Retour</button>
        <button type="submit" class="underlineHover fadeIn seventh" name="submit_inscription"  value="S'inscrire">S'inscrire</button>
      </div>
  
    </div>
  </form>

 <script>
    
    function showcontact() {
      document.getElementById("perso").style.display = "none";
      document.getElementById("contact").style.display = "block";
    }
  
    function showperso(){
      document.getElementById("perso").style.display = "block";
      document.getElementById("contact").style.display = "none";
    }
     
    function showjurid() {
      document.getElementById("contact").style.display = "none";
      document.getElementById("jurid").style.display = "block";
    } 
    function showcontact1()
    {
      document.getElementById("contact").style.display = "block";
      document.getElementById("jurid").style.display = "none";
    }
    function showrh_rp() {
      document.getElementById("jurid").style.display = "none";
      document.getElementById("rh_rp").style.display = "block";
    }
    function showjurid1() {
      document.getElementById("rh_rp").style.display = "none";
      document.getElementById("jurid").style.display = "block";
    } 
    function showseconnecter()
    {
      document.getElementById("rh_rp").style.display = "none";
      document.getElementById("loginForm").style.display = "block";
    }
    </script>
    
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
      $(document).ready(function() {
          $("#datepicker").datepicker({
              dateFormat: "dd/mm/yy",
              changeMonth: true,
              changeYear: true,
              yearRange: "1900:2030"
          });
          
          // Modifier le placeholder après l'initialisation du DatePicker
          $("#datepicker").attr("placeholder", "Date de création");
      });
  </script>
  <script>
    function validateEmail(email) {
    // Expression régulière pour valider le format de l'e-mail
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
  function validateEmailAndProceed(event) {
    event.preventDefault();
  
    var emailInput = document.getElementById('email');
    var email = emailInput.value;
  
    if (!validateEmail(email)) {
        // Mettre en évidence le champ email en rouge
        emailInput.classList.add('error-input');
        
        // Afficher une alerte avec le message d'erreur
        alert('Veuillez entrer une adresse e-mail valide.'); 
    }
   else
     // Si l'e-mail est valide, passer à l'étape suivante
     showjurid();
  }
  function emailvalider(event)
  {
    event.preventDefault();
    var email1=document.getElementById('emailrh').value;
    var email2=document.getElementById('emailrp').value;
    if(!validateEmail(email1) || !validateEmail(email2))
    {
        // Afficher une alerte avec le message d'erreur
        alert('Veuillez entrer une adresse e-mail valide.');
    }
   
  }
  </script> 
<script>
document.addEventListener("click", function(event) {
        var divFormulaire = document.getElementById("form2");
        if (!divFormulaire.contains(event.target)) {
          window.location.href = "pageprincipale.html";
        }
      });
</script>
 