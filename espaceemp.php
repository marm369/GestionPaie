

<?php
session_start();
if(!isset($_SESSION['auth']))
{
    header('location:pageprincipale.html');
    exit(); // Ajout d'une instruction pour arrêter l'exécution du code après la redirection
}
$l = $_SESSION['auth'];
require('connectbdd.php');
$sql = "SELECT id_employe FROM comptes WHERE login=:login"; // Utilisation de paramètres nommés pour éviter les failles d'injection SQL
$stat = $bdd->prepare($sql);
$stat->bindParam(':login', $l); // Liaison du paramètre nommé à la variable $l
$stat->execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);
$ide= $result['id_employe'];
$_SESSION['identificateur']=$ide;
$sql2="SELECT * FROM employe where idEmploye= $ide";
$stat2 = $bdd->query($sql2);
$result2 = $stat2->fetchAll(PDO::FETCH_ASSOC);

$sql3 = "SELECT poste FROM comptes WHERE login = :login";
$stat3 = $bdd->prepare($sql3);
$stat3->bindParam(':login', $l);
$stat3->execute();
$result3 = $stat3->fetch(PDO::FETCH_ASSOC);

// Récupération du poste
$poste = $result3['poste'];

?>
<!DOCTYPE html>
<html>
<head>
  <title>espac_RH</title>
  <link rel="stylesheet" href="styles/dropdownprofile.css">
  <link rel ="stylesheet" href="styles/style_espace.css">
  <link rel="stylesheet" href="styles/notification.css">
  <link rel="stylesheet" href="styles/dropdownsetting.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    #menu {
 
    background-color: #014421;
    }
    #menu ul li {
    border-bottom: 1px solid #014421;
}

#menu > ul > li > a {
    border-left: 4px solid #014421;
}
#menu ul li ul li a:hover {
    background-color: #014421;
}
#menu ul a:hover,
#menu ul a.active {
    background-color: #014421;
    border-left-color: #F9F5E7;
    color: #F9F5E7;
}
#menu ul li ul li a:hover {
    background-color: #014421;
}
    body 
    {
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .navbar 
    {
      background-color: #014421;
      height: 40px;
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }
    .img-nav 
    {
      margin-right: 1120px;
      transition: margin-right 0.3s ease;
    }
    .navbar.collapsed .img-nav 
    {
      margin-right: 1395px;
    }
    .navbar div{
      
      font-size: 14px;
   /*   margin-left: 10px;*/
      cursor: pointer;
    }
   
   .image-navbarre
   {

    width:33px;
    height:33px;
    border-radius:50%;
   }
  </style>
  </head>
  <body>

  <!-- Barre de navigation -->
 <div class="navbar">
 <div  id="toggle" class="custom-control custom-switch" style="position:relative; bottom:8px; right:170px;">
    <input type="checkbox" class="custom-control-input" id="customSwitch" <?php echo ($poste === 'RH' || $poste === 'RP') ? 'checked' : ''; ?> <?php echo ($poste === 'Employe') ? 'style="display:none;"' : ''; ?>>
    <label class="custom-control-label" style="color:white;" for="customSwitch">
        <?php
        if ($poste === 'RH') {
            echo 'RH';
        } elseif ($poste === 'RP') {
            echo 'RP';
        }
        ?>
    </label>
</div>







    <img src="public/gpaie.png" class="img-nav  image-navbarre " alt="Logo" style="position:absolute;  margin-bottom:3px;" ><!--  Image du logo -->
    <div>
          <!-- drop down -->
          <?php foreach ($result2 as $result2): ?>
            <div class='header-right'>
              <div class='avatar-wrapper' id='avatarWrapper'>
                <img src="photo.php?id=<?php echo $result2['idEmploye']; ?>" class="image-navbarre" style="position:absolute; margin-bottom:30px;" />
                <svg class='avatar-dropdown-arrow' height='24' id='dropdownWrapperArrow' viewbox='0 0 24 24' width='24'></svg>
              </div>
              <div class='dropdown-wrapper' id='dropdownWrapper' style='width: 250px'>
                <div class='dropdown-profile-details'>
                  <span class='dropdown-profile-details--name'><?= $result2['nom']?>&nbsp<?= $result2['prenom']?></span>
                  <span class='dropdown-profile-details--name'><?= $result2['poste']?></span>
                  <span class='dropdown-profile-details--name'><?php
                            $date_naissance = $result2['date_naissance'];
                            $age = date_diff(date_create($date_naissance), date_create('today'))->y;
                            echo $age;
                        ?> ans</span>
                  <span class='dropdown-profile-details--email'><?= $result2['e_mail']?></span>
                  <span class='dropdown-profile-details--email'><?= $result2['numero_tel']?></span>
                </div>
                <div class='dropdown-links'>
                  <a href='deconnexion.php?logout'>Déconnexion</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          <!-- *************** -->
 </div>   
 <div class="novo"  style=" position:absolute;  margin-bottom :-27px; right:110px;" >
    <ul>
      <li class="dropdown">
        <a href="#">
          <i class="fa fa-gear " style="color:white;  font-size: 2.8em; margin-bottom:16px;  "></i>
        </a>
        <ul >
          <li><a href="changermotemp.php" class="linki grayeffect"><i class="fa fa-lock "></i>Changer motdepasse/login</a></li>
          <li><a href="profile.php" class="linki grayeffect" ><i class="fa fa-user"></i>Profile</a></li>
          <li><a href="aide_emp.php" class="linki grayeffect" ><i class="fas fa-question-circle "></i>Aide</a></li>
      
        </ul>
      </li>
    </ul>
  </div>

 <div class = "icons" style="position:absolute; margin-bottom:18px; margin-right:40px" >
<div class = "notification">
  <div class = "notBtn" href = "#" >
 
    <!--Number supports double digets and automaticly hides itself when there is nothing between divs -->
    <div class = "number"> <?php  
                        require('connectbdd.php');
                        $req = "SELECT COUNT(*) FROM reclamation where statut=1 AND id_employe=$ide";
                        $count = $bdd->query($req)->fetchColumn();
                        echo $count;
                        ?>
    </div>

    <i class="fas fa-bell tas" style="color:white;"></i>
      <div class = "box"> 
        <div class = "display" >
          <div class = "cont" style="position:absolute; z-index:3;">
                    <?php
                        require('connectbdd.php');
                        $req2 = "SELECT * FROM reclamation where statut=1 AND id_employe=$ide";
                        $smt2 = $bdd->query($req2); 
                        $rows = $smt2->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($rows as $V) {
                            $req1 = "SELECT * FROM employe WHERE idEmploye = " . $ide;
                            $smt1 = $bdd->query($req1);
                            $ro = $smt1->fetch(PDO::FETCH_ASSOC); 
                            echo "
                                <div class='sec new'>
                                <div class = 'profCont'>
                                </div>
                                    <div class='txt' style='padding-left:0px;'>Objet: ". $V['objet'] . "</div>
                                    <div class='txt' style='padding-left:0px;  font-size: 0.9rem;'>" . $V['reponse'] . "</div>
                                    <div class='txt sub' style='padding-left:0px;'>" . $V['daterecla'] . "</div>
                                    <div>
                                    <button type='submit' value='Supprimer' style='
                                    background-color: #FF0000; /* Rouge */
                                    color: #FFFFFF; /* Blanc */
                                    border: none;
                                    border-radius: 4px;
                                    cursor: pointer;'>Supprimer</button>
                                </div>
                                </div>
                            ";
                        }
                        ?>
         </div>   <!-- fin de div cont -->
        </div>  <!-- fin de div display -->
     </div>  <!-- fin de div box -->
  </div>    <!-- fin de div notBtn -->

</div>    <!-- fin de div notification -->

</div>   <!-- fin de div icons -->
  </div>




  <nav id="menu" class="left show">
    <ul>
        <li>
            <a href="#entreprise"><i class="fas fa-building"></i>Gestion de Congé <i class="fas fa-caret-down"></i></a>
            <ul>
                <li><a href="demande-conge.php"><i class="fas fa-calendar-plus"></i>Demander Congé</a></li>
                <li><a href="visualiser-conge.php"><i class="fas fa-calendar-minus"></i>Visualiser Congé</a></li>
            </ul>
        </li>
        <li>
            <a href="#employe"><i class="fas fa-user-alt"></i>Gestion des Heures Supplémentaires <i class="fas fa-caret-down"></i></a>
            <ul>
                <li><a href="demander-hsupp.php"><i class="fas fa-plus"></i>Demander Heures Supplémentaires</a></li>
                <li><a href="visualiser-hsupp.php"><i class="fas fa-eye"></i>Visualiser Heures Supplémentaires</a></li>
            </ul>
        </li>
        <li>
            <a href="reclamer.php"><i class="fas fa-bullhorn"></i>Reclamer <i class="fas fa-caret-down"></i></a>
        </li>
        <li>
            <a href="visualiser-bulletin.php"><i class="fas fa-file-alt"></i>Visualiser Bulletin <i class="fas fa-caret-down"></i></a>
        </li>
    </ul>
    <a href="#" id="showmenu">
        <i class="fas fa-bars"></i>
    </a>
</nav>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



  <script>
    <?php if ($poste === 'EMP') { ?>
    document.getElementById("toggle").style.display = "none";
    <?php } ?>
</script>


  <script>
    // Écouteur d'événement lorsque le toggle est activé ou désactivé
    document.getElementById('customSwitch').addEventListener('change', function() {
        if (this.checked) {
            <?php
            if ($poste === 'RH') {
                echo 'window.location.href = "espace_rh_dashboard.php";';
            } elseif ($poste === 'RP') {
                echo 'window.location.href = "espacerp.php";';
            }
            ?>
        }
    });
</script>

<script>
    $(document).ready(function () {
      var navbar = $(".navbar");
      var imgNav = $(".img-nav");
      var showMenu = $("#showmenu");

      // Ajoute la classe "show" au menu au chargement de la page
      $("#menu").addClass("show");

      showMenu.click(function (e) {
        e.preventDefault();
        $("#menu").toggleClass("show");
        navbar.toggleClass("collapsed");
        imgNav.toggleClass("collapsed");
      });
      $("#menu a").click(function (event) {
        if ($(this).next('ul').length) {
          event.preventDefault();
          $(this).next().toggle('fast');
          $(this).children('i:last-child').toggleClass('fa-caret-down fa-caret-left');
        }
      });
      // Vérifie l'état initial du menu pour inverser le margin-right de l'image
      if (!$("#menu").hasClass("show")) {
        navbar.addClass("collapsed");
        imgNav.addClass("collapsed");
      }
    });
  </script>
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
  
  
  <script>
    // Navigation toggle 
    $("div .dropdown").click(function () {
      $(this).toggleClass("show");
    });

   // Fermer le dropdown en cliquant à l'extérieur
   $(document).on("click", function (event) {
      if (!$(event.target).closest(".dropdown").length) {
        $(".dropdown").removeClass("show");
      }
    });
  </script>
 </body>
  </html>

