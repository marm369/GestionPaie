

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
  <title>espac_RH</title>
  <link rel="stylesheet" href="styles\dropdownprofile.css">
  <link rel ="stylesheet" href="styles\style_espace.css">
  <link rel="stylesheet" href="styles\notification.css">
  <link rel="stylesheet" href="styles\dropdownsetting.css">
  <link rel="stylesheet" href="styles\statistique.css">
  <link rel="stylesheet" href="styles\chart_rh.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
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
      background-color: #19376D;
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
          <li><a href="changermotrh.php" class="linki grayeffect"><i class="fa fa-lock "></i>Changer motdepasse</a></li>
          <li><a href="espace_rh_dashboard.php" class="linki grayeffect"><i class="fa fa-chart-line"></i>Dashboard</a></li>
          <li><a href="aide_rh.php" class="linki grayeffect" ><i class="fas fa-question-circle "></i>Aide</a></li>
      
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
                        $req = "SELECT COUNT(*) FROM reclamation where statut=0";
                        $count = $bdd->query($req)->fetchColumn();
                        echo $count;
                        ?>
    </div>

    <i class="fas fa-bell tas" style="color:white;"></i>
      <div class = "box"> 
        <div class = "display">
          <div class = "cont" style="    position: relative; z-index: 9999;">
                    <?php
                        require('connectbdd.php');
                        $req2 = "SELECT * FROM reclamation";
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
                                <h4 style=' postion:relatif ; bottom:40px; padding-top:10px; margin-left:50px;'>" . $ro['nom'] . " " . $ro['prenom'] . "</h4>
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




 <nav id="menu" class="left show">
    <ul>
    <li>
            <a href="#entreprise"><i class="fas fa-building "></i>Gestion d'entreprise <i class="fas fa-caret-down"></i></a>
            <ul>
                <li><a href="ajouterentreprise.php"><i class="fas fa-plus"></i>Ajouter sous entreprise</a></li>
                <li><a href="supprimerentreprise.php"><i class="fas fa-minus"></i>Supprimer sous entreprise</a></li>
                <li><a href="modifierentreprise.php"><i class="fas fa-edit"></i>Modifier sous entreprise</a></li>
                <li><a href="consulterentreprise.php"><i class="fas fa-eye"></i>Consulter sous entreprises</a></li>
            </ul>
    </li>
    <li>
            <a href="#employe"><i class="fas fa-user-alt"></i>Gestion des employes<i class="fas fa-caret-down"></i></a>
            <ul>
                <li><a href="ajouteremploye.php"><i class="fas fa-plus"></i>Ajouter Employe</a></li>
                <li><a href="supprimeremploye.php"><i class="fas fa-minus"></i>Supprimer Employe</a></li>
                <li><a href="modifieremploye.php"><i class="fas fa-edit"></i>Modifier Employe</a></li>
                <li><a href="consulteremploye.php"><i class="fas fa-eye"></i>Consulter Employe</a></li>
                <li><a href="conge.php"><i class="fas fa-check"></i>Valider Congés</a></li>
                <li><a href="hsup.php"><i class="fas fa-check"></i>Valider Heures Supplementaires</a></li>
                <li><a href="absence.php"><i class="fas fa-plus"></i>Saisir Absence</a></li>
                <li><a href="prime.php"><i class="fas fa-plus"></i>Saisir Primes</a></li>
                <li><a href="avantage.php"><i class="fas fa-plus"></i>Saisir Avantages</a></li>
                <li><a href="allocation.php"><i class="fas fa-plus"></i>Saisir Allocations</a></li>
                <li><a href="reclamer.php"><i class="fas fa-exclamation-triangle"></i>Repondre Reclamation</a></li>
                <li> <a href="visualiserabs.php"><i class="fas fa-eye"></i>Visualiser Absence</a></li>
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
                     <div class="title">Congé</div>
                     <i class="zmdi zmdi-upload"></i>
                     <div class="value" id="conge-value">
                        <?php
                           $reqConge = "SELECT COUNT(*) FROM conge ";
                           $countConge = $bdd->query($reqConge)->fetchColumn();
                           echo $countConge;
                        ?>
                     </div>
                     <div class="stat">
                     <i class="fas fa-check-circle" style="color: #25832b;"></i><b>
                           <?php
                              $reqCongeTraite = "SELECT COUNT(*) FROM conge where statut=1 ";
                              $countCongeTraite = $bdd->query($reqCongeTraite)->fetchColumn();
                              echo $countCongeTraite;
                           ?>
                        </b>
                        traite &nbsp;&nbsp;
                        <i class="fas fa-times-circle" style="color: #e3230d;"></i>
                        <b>
                           <?php
                              $reqCongeNonTraite = "SELECT COUNT(*) FROM conge where statut=0 ";
                              $countCongeNonTraite = $bdd->query($reqCongeNonTraite)->fetchColumn();
                              echo $countCongeNonTraite;
                           ?>
                        </b> non traite
                     </div>
                  </div>
               </div>
               <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                  <div class="card orange">
                     <div class="title">Heures Supplementaires</div>
                     <i class="zmdi zmdi-download"></i>
                     <div class="value" id="heure-sup-value">
                        <?php
                           $reqHeureSup = "SELECT COUNT(*) FROM heure_supp ";
                           $countHeureSup = $bdd->query($reqHeureSup)->fetchColumn();
                           echo $countHeureSup;
                        ?>
                     </div>
                     <div class="stat">
                     <i class="fas fa-check-circle" style="color: #25832b;"></i>   <b>
                           <?php
                              $reqHeureSupTraite = "SELECT COUNT(*) FROM heure_supp where statut=1 ";
                              $countHeureSupTraite = $bdd->query($reqHeureSupTraite)->fetchColumn();
                              echo $countHeureSupTraite;
                           ?>
                        </b>
                        traite &nbsp;&nbsp;
                        <i class="fas fa-times-circle" style="color: #e3230d;"></i>
                        <b>
                           <?php
                              $reqHeureSupNonTraite = "SELECT COUNT(*) FROM heure_supp where statut=0 ";
                              $countHeureSupNonTraite = $bdd->query($reqHeureSupNonTraite)->fetchColumn();
                              echo $countHeureSupNonTraite;
                           ?>
                        </b> non traite
                     </div>
                  </div>
               </div>
               <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                  <div class="card red">
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
    <div id="chartContainer1" style="position:absolute; left :415px; bottom:120px;">
        <canvas id="employeeChart"></canvas>
    </div>
    <div id="chartContainer2"  style="position:absolute; left :980px; bottom:290px;">
        <canvas id="genderChart"></canvas>
    </div>
    <div id="chartContainer3"  style="position:absolute; left :980px; bottom:120px;">
        <canvas id="contractChart"></canvas>
    </div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <script>
        // Récupération des données depuis la base de données
        <?php
        require('connectbdd.php');

        // Requête SQL préparée pour récupérer les données des types de contrat
        $sql = "SELECT typecontrat, COUNT(*) AS count FROM contrat GROUP BY typecontrat";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();

        // Création des tableaux pour stocker les données des types de contrat
        $labels = array();
        $data = array();

        // Parcours des données des types de contrat
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $labels[] = $row['typecontrat'];
            $data[] = $row['count'];
        }
        ?>

        // Création du graphique circulaire - Répartition des types de contrat
        var ctxContract = document.getElementById('contractChart').getContext('2d');
        new Chart(ctxContract, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Répartition des types de contrat',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: [
                        'rgba(255, 165, 0, 0.2)', // Couleur pour CDI (orange)
                        'rgba(255, 255, 0, 0.2)', // Couleur pour CDD (jaune)
                        'rgba(54, 162, 235, 0.2)' // Couleur pour CTT (bleu)
                    ],
                    borderColor: [
                        'rgba(255, 165, 0, 1)', // Couleur de la bordure pour CDI (orange)
                        'rgba(255, 255, 0, 1)', // Couleur de la bordure pour CDD (jaune)
                        'rgba(54, 162, 235, 1)' // Couleur de la bordure pour CTT (bleu)
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

  <script>
    // Récupération des données depuis la base de données
    <?php
    require('connectbdd.php');

    // Requête SQL préparée pour récupérer les données d'employés par genre
    $sql = "SELECT genre, COUNT(*) AS count FROM employe GROUP BY genre";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();

    // Création des tableaux pour stocker les données de genre
    $labels = array();
    $data = array();

    // Parcours des données de genre
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $labels[] = $row['genre'];
        $data[] = $row['count'];
    }
    ?>

    // Création du graphique circulaire - Répartition des employés par genre
    var ctxGender = document.getElementById('genderChart').getContext('2d');
    new Chart(ctxGender, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Répartition des employés par genre',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)' , // Couleur pour le genre féminin
                  'rgba(54, 162, 235, 0.2)'// Couleur pour le genre masculin
                ],
                borderColor: [
                  'rgba(255, 99, 132, 1)' , // Couleur de la bordure pour le genre féminin
                  'rgba(54, 162, 235, 1)' // Couleur de la bordure pour le genre masculin
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Distribution des sexes',
                    font: {
                        size: 8
                    }
                }
            }
        }
    });
</script>


  <script>
        // Récupération des données depuis la base de données
        <?php
        require('connectbdd.php');

        // Requête SQL préparée pour récupérer les données d'entreprise
        $sql = "SELECT nom, nbremploye FROM entreprise";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();

        // Création des tableaux pour stocker les données d'entreprise
        $entreprises = array();
        $employes = array();

        // Parcours des données d'entreprise
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $entreprises[] = $row['nom'];
            $employes[] = $row['nbremploye'];
        }

        // Fermeture de la connexion à la base de données
        $bdd = null;
        ?>

        // Préparation des données pour le graphique
        var labels = <?php echo json_encode($entreprises); ?>;
        var counts = <?php echo json_encode($employes); ?>;

        // Création du graphique d'entreprise - Nombre d'employés
        var ctxEmployee = document.getElementById('employeeChart').getContext('2d');
        new Chart(ctxEmployee, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nombre d\'employés',
                    data: counts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1,
                        title: {
                            display: true,
                            text: 'Nombre d\'employés'
                        }
                    }
                }
            }
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

