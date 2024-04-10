<?php
session_start();
if(!isset($_SESSION['auth']))
{
    header('location:pageprincipale.php');
    exit(); // Ajout d'une instruction pour arrêter l'exécution du code après la redirection
}
$l = $_SESSION['auth'];
?>
<?php
require('connectbdd.php');
$sql = "SELECT id_employe FROM comptes WHERE login=:login"; // Utilisation de paramètres nommés pour éviter les failles d'injection SQL
$stat = $bdd->prepare($sql);
$stat->bindParam(':login', $l); // Liaison du paramètre nommé à la variable $l
$stat->execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);
$ide= $result['id_employe'];
$sql2="SELECT * FROM employe where idEmploye= $ide";
$stat2 = $bdd->query($sql2);
$result2 = $stat2->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
  <title>Mon Interface RP</title>
  <link rel="stylesheet" href="dropdown.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      background-color: #f0f8ff; /* Bleu glacé */
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    
    h1 {
      color: #000080; /* Bleu */
      text-align: center;
      padding: 20px;
    }
    
    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      background-color: #ffffff; /* Blanc */
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    label {
      color: #000080; /* Bleu */
      font-weight: bold;
    }
    
    input[type=text], textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #000080; /* Bleu */
      border-radius: 4px;
      box-sizing: border-box;
      margin-bottom: 10px;
    }
    
    input[type=submit] {
      background-color: #000080; /* Bleu */
      color: #ffffff; /* Blanc */
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    input[name=bt-pdf] {
      background-color: red; 
    }

    input[name=bt-excel]{
      background-color: green; 
    }


  </style>
</head>
<body>
  
<!DOCTYPE html>
<html>
<head>
    <title>Espace Responsable de la Paie</title>
    <style>
        /* styles.css */

/* Styles généraux */
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color:#347893 ;
}

header {
    background-color: #7ba3b4;
    color: #fff;
    padding: 20px;
}

h1 {
    font-size: 24px;
}

nav {
    background-color: #347893;
}

nav ul {
    list-style: none;
    display: flex;
    justify-content: center;
    padding: 10px 0;
    margin-left:320px;
}

nav ul li {
    margin: 0 10px;
    
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    padding: 5px 10px;
}

main {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

section {
    margin-bottom: 30px;
}

h2 {
    font-size: 20px;
    margin-bottom: 10px;
}

form {
    margin-bottom: 20px;
}

form input[type="text"],
form input[type="email"] {
    width: 100%;
    padding: 8px;
    font-size: 16px;
    border-radius: 3px;
    border: 1px solid #ccc;
}

form button {
    background-color: #333;
    color: #fff;
    padding: 8px 16px;
    border: none;
    border-radius: 3px;
    font-size: 16px;
    cursor: pointer;
}

#resultat {
    margin-top: 10px;
}
.logo {
            max-width: 95px;
            display: block;
            border-radius: 50%; /* Appliquer un arrondi de 50% */
            overflow: hidden; /* Masquer les parties dépassant du cercle */
        
        }
    </style>
</head>
<body>
    <header>
    <img class="logo" src="logo1.png" alt="Logo de votre entreprise">
        <h1>Espace Responsable de la Paie</h1>
    </header>

    <nav>
      <ul>
           <li><a href="page_paie.php" id="rubriquesLink">Acceuil</a></li>
            <li><a href="espace.php" id="rubriquesLink">Gestion de bulletin de paie</a></li>
            
            <li><a href="rubrique.php" id="bulletinLink">gestion des  régles </a></li>
               
            <?php foreach($result2 as $result2): ?>
              <div class='header-right'>
                <div class='avatar-wrapper' id='avatarWrapper'>
                      <img src="exporte.php?id=1" class="rounded-circle img-fluid"/>      
                      <svg class='avatar-dropdown-arrow' height='24' id='dropdownWrapperArrow'  width='24'>  </svg>
                      </div>
                      <div class='dropdown-wrapper' id='dropdownWrapper' style='width: 250px'>
                        <div class='dropdown-profile-details'>
                          <span class='dropdown-profile-details--name'><?= $result2['nom']?>&nbsp<?= $result2['prenom']?></span>
                          <span class='dropdown-profile-details--email'><?= $result2['e_mail']?></span>
                        </div>
                        <div class='dropdown-links'>
                          <a href='deconnexion.php?logout'>Déconnexion</a>
                        </div>
                </div>
          </div>
         <?php endforeach; ?>
      </ul>
       
    </nav>

    <main>
        <section id="rubriquesSection">
           
            <!-- Contenu de la section des rubriques -->
            <title>Gestion des Rubriques</title>
  <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    padding: 20px;
}

h1 {
    text-align: center;
    color: #333;
}

form {
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 20px;
    margin-bottom: 20px;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

input[type="text"],
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

button[type="submit"] {
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

#message {
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 20px;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

  </style>





  <div class="container">
    <h1>Bulletin de paie</h1>

    <?php
            if (isset($_GET['error']) && $_GET['error'] == 1)
             {
                $nom = isset($_GET['nom']) ? $_GET['nom'] : '';
                $prenom = isset($_GET['prenom']) ? $_GET['prenom'] : '';
                echo "<h2>Le salaire de $nom  $prenom pour ce mois est déjà calculé</h2>";
                 
              }  
        ?>
    
    <form action="traitement_paiee.php" method="POST">
      <label for="nom">Nom :</label>
      <input type="text" id="nom" name="nom" placeholder="Entrez votre nom">
      
      <label for="prenom">Prénom :</label>
      <input  type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom">

      <label for="mois">Mois :</label>
      <input type="date" id="mois" name="mois" placeholder="Entrez le mois">
      
      <input type="submit" value="Génerer bulltin"><br><br>
      
    
    </form>
  </div>

<script>

      var headerProfileAvatar = document.getElementById("avatarWrapper")
      var headerProfileDropdownArrow = document.getElementById("dropdownWrapperArrow");
      var headerProfileDropdown = document.getElementById("dropdownWrapper");

      document.addEventListener("click", function(event) {
        var headerProfileDropdownClickedWithin = headerProfileDropdown.contains(event.target);
        
        if (!headerProfileDropdownClickedWithin) {
          if (headerProfileDropdown.classList.contains("active")) {
            headerProfileDropdown.classList.remove("active");
            headerProfileDropdownArrow.classList.remove("active");
          }
        }
      });

      headerProfileAvatar.addEventListener("click", function(event) {
        headerProfileDropdown.classList.toggle("active");
        headerProfileDropdownArrow.classList.toggle("active");
        event.stopPropagation();
      });
</script>
</body>
</html>
