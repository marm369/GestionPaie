<?php
 include_once 'espaceemp.php'; 
 $id=$_SESSION['identificateur'];
 ?>
 <?php
require('connectbdd.php');
$sql="SELECT * FROM employe WHERE idEmploye=$id";
$stat=$bdd->prepare($sql);
$stat->execute();
$result2=$stat->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="style1.css">
  <link rel="stylesheet" href="dropdownprofile.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<section style="position:relative; z-index:-10; background-color: #eee; width:70%;  bottom:90px; margin-left:340px;  margin-top:50px;">
<?php
  foreach($result2 as $result2):
 ?>
  <div class="container py-5">
    <div class="row" >
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
          <img src="photo.php?id=<?php echo $_SESSION['identificateur']; ?>" class="rounded-circle img-fluid" style="width: 150px;" />
            <h5 class="my-3"><?= $result2['nom']?>&nbsp<?= $result2['prenom']?></h5>
            <p class="text-muted mb-1"><?= $result2['poste']?></p>
            <p class="text-muted mb-4"><?= $result2['adresse']?></p>
          </div>
        </div>
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
            <div class="col-sm-9 d-flex align-items-center"> 
              <p class="text-dark mb-0 mr-3">Date d'embauche</p> 
              <p class="text-muted mb-0"><?= $result2['date_embauche']?></p>
            </div>
            </div>
            <hr>
            <div class="row">
            <div class="col-sm-9 d-flex align-items-center"> 
                 <p class="text-dark mb-0 mr-3">Salaire de base</p> 
                 <p class="text-muted mb-0"><?= $result2['salaire_base']?></p>
            </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-sm-9 d-flex align-items-center"> 
                   <p class="text-dark mb-0 mr-3">Nom banque</p> 
                   <p class="text-muted mb-0"><?= $result2['nom_banque']?></p>
               </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-9 d-flex align-items-center"> 
                 <p class="text-dark mb-0 mr-3">Identifiant AMO</p> 
                 <p class="text-muted mb-0"><?= $result2['idAmo']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-9 d-flex align-items-center"> 
                 <p class="text-dark mb-0 mr-3">Identifiant CIMR</p> 
                 <p class="text-muted mb-0"><?= $result2['idCimr']?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Nom complet</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?= $result2['nom']?>&nbsp<?= $result2['prenom']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?= $result2['e_mail']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Numéro téléphone</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?= $result2['numero_tel']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Date Naissance</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?= $result2['date_naissance']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Adresse</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?= $result2['adresse']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Situation familiale</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?= $result2['situation']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Nombre d'enfants</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?= $result2['nbrEnfant']?></p>
              </div>
            </div>
          </div>
          <?php  endforeach ;?>
         
        </div>
        <div class="row">
                   <div class="col-md-6">
                     <div class="card mb-4 mb-md-0">
                       <div class="card-body">
                         <p class="mb-4"><span class="text-primary font-italic me-1"> Heurs Supplémentaires </p>
                          <canvas id="myChart1" class="chart1"></canvas>
                        
                  <?php
                        $bd1 = new PDO("mysql:host=localhost;dbname=atelier_web;charset=UTF8", "root", "");
                        if (!$bd1) {
                            echo "Connexion échouée";
                        }


                        // Récupérer les mois et le total des heures supplémentaires dans la nuit pour l'employé connecté
                        $sqlNuit = "SELECT MONTH(date) AS mois, SUM(nbrHeures) AS total_heures_nuit
                                    FROM heure_supp
                                    WHERE journuit = 'nuit' AND id_employe = :employeId
                                    GROUP BY mois
                                    ORDER BY mois";
                        $queryNuit = $bd1->prepare($sqlNuit);
                        $queryNuit->bindParam(':employeId',  $id);
                        $queryNuit->execute();

                        // Récupérer les mois et le total des heures supplémentaires dans le jour pour l'employé connecté
                        $sqlJour = "SELECT MONTH(date) AS mois, SUM(nbrHeures) AS total_heures_jour
                                    FROM heure_supp
                                    WHERE journuit = 'jour' AND id_employe = :employeId
                                    GROUP BY mois
                                    ORDER BY mois";
                        $queryJour = $bd1->prepare($sqlJour);
                        $queryJour->bindParam(':employeId',  $id);
                        $queryJour->execute();

                        // Créer un tableau avec les mois et les heures supplémentaires dans la nuit correspondantes
                        $moisNuit = array();
                        $heuresNuit = array();
                        $heuresJour = array();

                        // Remplir le tableau avec les résultats de la requête pour les heures supplémentaires dans la nuit
                        while ($dataNuit = $queryNuit->fetch(PDO::FETCH_ASSOC)) {
                            $moisNuit[] = $dataNuit['mois'];
                            $heuresNuit[] = $dataNuit['total_heures_nuit'];
                        }

                        // Remplir le tableau avec les résultats de la requête pour les heures supplémentaires dans le jour
                        while ($dataJour = $queryJour->fetch(PDO::FETCH_ASSOC)) {
                            $heuresJour[] = $dataJour['total_heures_jour'];
                        }

                        // Définir les noms des mois dans l'ordre correct
                        $labels = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');


                        // Créer un tableau pour les heures supplémentaires dans la nuit et dans le jour correspondant à chaque mois
                        $dataByMonthNuit = array_fill(0, count($labels), 0);
                        $dataByMonthJour = array_fill(0, count($labels), 0);

                        foreach ($moisNuit as $index => $month) {
                          $monthIndex = $month - 1;
                          if (isset($labels[$monthIndex]) && isset($heuresNuit[$index]) && isset($heuresJour[$index])) {
                              $dataByMonthNuit[$monthIndex] = $heuresNuit[$index];
                              $dataByMonthJour[$monthIndex] = $heuresJour[$index];
                          } else {
                              // Indices non définis, initialiser avec une valeur par défaut
                              $dataByMonthNuit[$monthIndex] = 0;
                              $dataByMonthJour[$monthIndex] = 0;
                          }
                      }
                      
                      
                  ?>

                          <script>
                            const ctx1 = document.getElementById('myChart1');
                            new Chart(ctx1, {
                                type: 'line',
                                data: {
                                    labels: <?php echo json_encode($labels) ?>,
                                    datasets: [{
                                        label: 'Heures supplémentaires dans la nuit',
                                        backgroundColor: 'rgba(255,99,132,0.2)',
                                        borderColor: 'rgba(255,99,132,1)',
                                        data: <?php echo json_encode($dataByMonthNuit) ?>,
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Heures supplémentaires dans le jour',
                                        backgroundColor: 'rgba(54,162,235,0.2)',
                                        borderColor: 'rgba(54,162,235,1)',
                                        data: <?php echo json_encode($dataByMonthJour) ?>,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                          </script>
                      
                        </div>
                      </div>
                    </div>

                <div class="col-md-6">
                  <div class="card mb-4 mb-md-0">
                    <div class="card-body">
                        <p class="mb-4"><span class="text-primary font-italic me-1">Absence</span> </p>
                        <canvas id="myChart" class="chart"></canvas>
            <?php
                $bd = new PDO("mysql:host=localhost;dbname=atelier_web;charset=UTF8", "root", "");
                if (!$bd) {
                    echo "Connexion échouée";
                }
              
                // Récupérer les mois et le total des jours d'absence pour l'employé connecté
                $sql = "SELECT MONTH(datedebut) AS mois, SUM(nbrjour) AS total_jours_absence
                        FROM absence
                        WHERE id_employe = :idEmploye
                        GROUP BY mois
                        ORDER BY mois";
                $query = $bd->prepare($sql);
                $query->bindParam(':idEmploye',  $id, PDO::PARAM_INT);
                $query->execute();

                // Créer un tableau avec les mois et les jours d'absence correspondants
                $mois = array();
                $dure = array();

                // Remplir le tableau avec les résultats de la requête
                while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
                    $mois[] = $data['mois'];
                    $dure[] = $data['total_jours_absence'];
                }

                // Définir les noms des mois dans l'ordre correct
                $labels = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

                // Créer un tableau pour les jours d'absence correspondant à chaque mois
                $dataByMonth = array_fill(0, count($labels), 0);

                // Remplir le tableau avec les jours d'absence en fonction du mois
                foreach ($mois as $index => $month) {
                    $dataByMonth[$month - 1] = $dure[$index];
                }
              ?>
<script>
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($labels) ?>,
            datasets: [{
                label: 'Nombre absence',
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.4)',
                    'rgba(54, 162, 235, 0.4)',
                    'rgba(255, 206, 86, 0.4)',
                    'rgba(75, 192, 192, 0.4)',
                    'rgba(153, 102, 255, 0.4)',
                    'rgba(255, 159, 64, 0.4)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                data: <?php echo json_encode($dataByMonth) ?>,
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

  
                    </div>
                  </div>
                </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
        const reclamationLink = document.getElementById('reclamation-link');
        const reclamationForm = document.getElementById('reclamation-form');
        const closeReclamationButton = document.getElementById('close-button-reclamation');

        const heuresSuppLink = document.getElementById('heures-supp-link');
        const heuresSuppForm = document.getElementById('heures-supp-form');
        const closeHeuresSuppButton = document.getElementById('close-button-heures-supp');

        const demandeCongeLink = document.getElementById('demande-conge-link');
        const demandeCongeForm = document.getElementById('demande-conge-form');
        const closeDemandeCongeButton = document.getElementById('close-button-demande-conge');

        reclamationLink.addEventListener('click', () => {
            reclamationForm.classList.add('active');
        });

        closeReclamationButton.addEventListener('click', () => {
            reclamationForm.classList.remove('active');
        });

        heuresSuppLink.addEventListener('click', () => {
            heuresSuppForm.classList.add('active');
        });

        closeHeuresSuppButton.addEventListener('click', () => {
            heuresSuppForm.classList.remove('active');
        });

        demandeCongeLink.addEventListener('click', () => {
            demandeCongeForm.classList.add('active');
        });

        closeDemandeCongeButton.addEventListener('click', () => {
            demandeCongeForm.classList.remove('active');
        });
                  
</script>

