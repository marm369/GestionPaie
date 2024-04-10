
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
$sql2="SELECT * FROM employe where idEmploye= $ide";
$stat2 = $bdd->query($sql2);
$result2 = $stat2->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>espac_RP</title>
  <link rel="stylesheet" href="styles/dropdownprofile.css">
  <link rel ="stylesheet" href="styles/style_espace.css">
  <link rel="stylesheet" href="styles/notification.css">
  <link rel="stylesheet" href="styles/dropdownsetting.css">
  <link rel="stylesheet" href="styles/statistique.css">
  <link rel="stylesheet" href="styles/chart_rh.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>


#menu {
 
 background-color: #d3000b;
 }
 #menu ul li {
 border-bottom: 1px solid   #d3000b;
}

#menu > ul > li > a {
 border-left: 4px solid   #d3000b;
}
#menu ul li ul li a:hover {
 background-color:  #d3000b;
}
#menu ul a:hover,
#menu ul a.active {
 background-color:   #d3000b;
 border-left-color: #F9F5E7;
 color: #F9F5E7;
}
#menu ul li ul li a:hover {
 background-color:   #d3000b;
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
      background-color:  #d3000b;
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
   #chartContainer6 {
      position:absolute;
      width: 300px;
      height: 145px;
      background-color: #f2f2f2;
      padding: 10px;
      left:1030px;
      top:70px;
      border-radius:5px;
    }
  </style>
  </head>
  <body>

  <!-- Barre de navigation -->
 <div class="navbar">

 <div class="custom-control custom-switch" style="position:relative; bottom:8px; right:170px;">
    <input type="checkbox" class="custom-control-input" id="customSwitch">
    <label class="custom-control-label " style="color:white;" for="customSwitch">Employe</label>
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
          <li><a href="changermotrp.php" class="linki grayeffect"><i class="fa fa-lock "></i>Changer motdepasse</a></li>
          <li><a href="espace_rp_dashboard.php" class="linki grayeffect" ><i class="fa fa-chart-line"></i>Dashboard</a></li>
          <li><a href="aide_rp.php" class="linki grayeffect" ><i class="fas fa-question-circle "></i>Aide</a></li>
      
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
                        $req = "SELECT COUNT(*) FROM reclamation where statut=0 AND destinataire=2";
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
                        $req2 = "SELECT * FROM reclamation where statut=0 AND destinataire=2";
                        $smt2 = $bdd->query($req2); 
                        $rows = $smt2->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($rows as $V) {
                            $req1 = "SELECT * FROM employe WHERE idEmploye = " . $V['id_employe'];
                            $smt1 = $bdd->query($req1);
                            $ro = $smt1->fetch(PDO::FETCH_ASSOC); 
                            echo "
                                <div class='sec new'>
                                <div class = 'profCont'>
                                <img class='profile' src='photo.php?id=" . $V['id_employe'] . "' >
                                <h4 style=' postion:relative ; bottom:40px; padding-top:10px; margin-left:50px;'>" . $ro['nom'] . " " . $ro['prenom'] . "</h4>
                                </div>
                                    <div class='txt' style='padding-left:0px;'>Objet: ". $V['objet'] . "</div>
                                    <div class='txt' style='padding-left:0px;  font-size: 0.9rem;'>" . $V['recla'] . "</div>
                                    <div class='txt sub' style='padding-left:0px;'>" . $V['daterecla'] . "</div>
                                    <form action='repondre.php?' method='post'>
                                        <input type='hidden' name='idEmploye' value='" . $V['id_employe'] . "'>
                                        <input type='hidden' name='objet' value='" . $V['objet'] . "'>
                                        <div>
                                            <input type='text' name='reponse' placeholder='Saisissez votre réponse' style='border: 1px solid #ccc;
                                            border-radius: 4px;
                                            outline: none;'>
                                            <button type='submit' value='Envoyer' style='
                                            background-color: #FF0000; /* Rouge */
                                            color: #FFFFFF; /* Blanc */
                                            border: none;
                                            border-radius: 4px;
                                            cursor: pointer;'>Envoyer</button>
                                        </div>
                                    </form>
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
  

  <?php
    // Connexion à la base de données
    // Remplacez les informations de connexion par les vôtres
    require('connectbdd.php');

    // Requête pour obtenir les statistiques des employés par entreprise
    $reqStatistiquesEntreprise = "SELECT nom,nbremploye FROM entreprise";
    $resultat = $bdd->query($reqStatistiquesEntreprise);

    // Tableaux pour stocker les données du diagramme
    $labels = array();
    $data = array();

    // Extraction des données de la requête
    while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
      $labels[] = $row['nom'];
      $data[] = $row['nbremploye'];
    }
  ?>

  <div id="chartContainer6">
    <canvas id="barChart"></canvas>
  </div>



 <nav id="menu" class="left show">
    <ul>
    <li>
    <a href="#entreprise"><i class="fas fa-file-invoice"></i>Gestion du bulletin de paie <i class="fas fa-caret-down"></i></a>
    <ul>
        <li><a href="genererbulletin.php"><i class="fas fa-print"></i>Generer Bulletin </a></li>
        <li><a href="exporter.php"><i class="fas fa-download"></i>Exporter Bulletin</a></li>
    </ul>
</li>
<li>
    <a href="#employe"><i class="fas fa-list"></i>Gestion des rubriques<i class="fas fa-caret-down"></i></a>
    <ul>
        <li><a href="afficher_rubrique.php"><i class="fas fa-eye"></i>Afficher les rubriques</a></li>
        <li><a href="ajouter_rubrique.php"><i class="fas fa-plus"></i>Ajouter rubrique</a></li>
        <li><a href="supprimer_rubrique.php"><i class="fas fa-trash-alt"></i>Supprimer rubrique</a></li>
    </ul>
</li>
<li>
    <a href="#employe"><i class="fas fa-cogs"></i>Gestion des règles<i class="fas fa-caret-down"></i></a>
    <ul>
        <li><a href="modifier_regle.php"><i class="fas fa-pen"></i>Modifier règle</a></li>
    </ul>
</li>
    </ul>
    <a href="#" id="showmenu">
        <i class="fas fa-align-justify"></i>
    </a>
</nav>



<main role="main" class="col-md-9 ml-sm-auto col-lg-10 my-3" style="position:absolute; left:400px; bottom:450px;">
         <div class="card-list">
            <div class="row">
               <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                  <div class="card green">
                     <div class="title">Nombre de bulletin generé ce mois</div>
                     <i class="zmdi zmdi-upload"></i>
                     <div class="value" id="conge-value">
                        <?php
                           $reqConge = "SELECT COUNT(*) FROM conge ";
                           $countConge = $bdd->query($reqConge)->fetchColumn();
                           echo $countConge;
                        ?>
                     </div>
                     <div class="stat" style="height:30px;">
                
                     </div>
                  </div>
               </div>
          
               <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                  <div class="card azul" style=" background-color: #FFCE56;">
                     <div class="title">Reclamation</div>
                     <i class="zmdi zmdi-download"></i>
                     <div class="value" id="reclamation-value">
                        <?php
                           $reqReclamation = "SELECT COUNT(*) FROM reclamation ";
                           $countReclamation = $bdd->query($reqReclamation)->fetchColumn();
                           echo $countReclamation;
                        ?>
                     </div>
                     <div class="stat">
                     <i class="fas fa-check-circle" style="color: #25832b;"></i>  <b>
                           <?php
                              $reqReclamationTraite = "SELECT COUNT(*) FROM reclamation where statut=1 ";
                              $countReclamationTraite = $bdd->query($reqReclamationTraite)->fetchColumn();
                              echo $countReclamationTraite;
                           ?>
                        </b>
                        traite &nbsp;&nbsp;
                        <i class="fas fa-times-circle" style="color: #e3230d;"></i>
                        <b>
                           <?php
                              $reqReclamationNonTraite = "SELECT COUNT(*) FROM reclamation where statut=0 ";
                              $countReclamationNonTraite = $bdd->query($reqReclamationNonTraite)->fetchColumn();
                              echo $countReclamationNonTraite;
                           ?>
                        </b> non traite
                     </div>
                  </div>
               </div>
            </div>
         </div>
                      </main>
                                  
                     

<div   style="position:absolute; left :1020px; top:300px; width:300px;">
<canvas style="position:relative; " id="doughnutChart"></canvas>
</div>
<div style="position:absolute; left :370px; bottom:100px; width:600px;"> 
 <canvas id="areaChart"></canvas>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    // Données du diagramme à barres
    var data = {
      labels: <?php echo json_encode($labels); ?>,
      datasets: [{
        label: 'Nombre d\'employés',
        data: <?php echo json_encode($data); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.8)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    };

    // Options du diagramme à barres
    var options = {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        }
      },
      plugins: {
        title: {
          display: true,
          text: 'Statistiques des employés par entreprise',
          font: {
            size: 12
          }
        }
      }
    };

    // Création du diagramme à barres
    var barChartElement = document.getElementById('barChart');
    var barChart = new Chart(barChartElement, {
      type: 'bar',
      data: data,
      options: options
    });
    var dataset = barChart.data.datasets[0];
    dataset.barPercentage = 0.1; // Réduire la largeur des barres à 80% de l'espace disponible
    barChart.update();
  </script>
  
  <script>
    // Données du diagramme
    var data = {
      labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
      datasets: [{
        label: 'Salaire Net a Payer',
        data: [6500, 8000, 7000, 7500, 8000, 7800],
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 2,
        fill: true
      }]
    };

    // Options du diagramme
   
 var options = {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'Moyenne de Salaire Net a Payer chaque Mois',
          position: 'bottom' // Déplace le titre en bas
        }
      },
      scales: {
        x: {
          grid: {
            display: false
          }
        },
        y: {
          beginAtZero: true
        }
      }
    };

    // Création du diagramme
    var areaChart = new Chart(document.getElementById('areaChart'), {
      type: 'line',
      data: data,
      options: options
    });




  

  </script>
  <script>
         // Fonction pour animer l'augmentation progressive des nombres
         function animateValue(element, start, end, duration) {
            var range = end - start;
            var current = start;
            var increment = end > start ? 1 : -1;
            var stepTime = Math.abs(Math.floor(duration / range));
            var timer = setInterval(function() {
               current += increment;
               element.innerHTML = current;
               if (current == end) {
                  clearInterval(timer);
               }
            }, stepTime);
         }

         // Récupérer les éléments contenant les nombres
         var congeValue = document.getElementById('conge-value');
         var heureSupValue = document.getElementById('heure-sup-value');
         var reclamationValue = document.getElementById('reclamation-value');

         // Animer les nombres avec les valeurs finales
         animateValue(congeValue, 0, <?php echo $countConge; ?>, 1500);
         animateValue(heureSupValue, 0, <?php echo $countHeureSup; ?>, 1500);
         animateValue(reclamationValue, 0, <?php echo $countReclamation; ?>, 1500);
      </script>
 <script>
  // Données du diagramme
  var data = {
    labels: ['Gpaie', 'Apex', 'Stellar', 'Vivid', 'Compa'],
    datasets: [{
      data: [15, 18, 20, 19, 17],
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40'],
      hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40']
    }]
  };

  // Options du diagramme
  var options = {
    responsive: true,
    plugins: {
      title: {
        display: true,
        text: 'nombre de rubrique par entreprise',
        position: 'bottom'
      }
    }
  };

  // Création du diagramme
  var doughnutChart = new Chart(document.getElementById('doughnutChart'), {
    type: 'polarArea',
    data: data,
    options: options
  });
</script>




  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var switchElement = document.getElementById('customSwitch');
      switchElement.addEventListener('change', function() {
        if (switchElement.checked) {
          // Le commutateur est en ligne (activé)
          window.location.href = 'profile.php'; // Remplacez par l'URL de la nouvelle page
        } else {
          // Le commutateur est hors ligne (désactivé)
          // Vous pouvez ajouter un comportement supplémentaire ici si nécessaire
        }
      });
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

