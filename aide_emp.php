


<?php
include_once 'espaceemp.php';
 if(!isset($_SESSION['auth']))
 {
    header('location:pageprincipale.php');
 }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aide - Employe</title>
  <!-- Inclure les fichiers CSS de Bootstrap -->
 
</head>
<body>
  <div class="container" style="position:absolute; left:350px; top:40px;">
    <h2 class="mt-4">Aide - Employe</h2>
    <h4 class="mt-4">Gestion de Congé</h4>
  
    <ul>
      <li>Demander Congé : Cliquez sur le bouton "Demander Congé" dans le menu et remplissez le formulaire avec les informations requises.</li>
      <li>Visualiser Congé : Cliquez sur le bouton "Visualiser Congé" dans le menu pour voir la reponse de responsable RH au demande de Conge.</li>
    </ul>
    
    <h4 class="mt-4">Gestion des Heures Supplementaires</h4>
  
    <ul>
      <li>Demander Heures Supplémentaires: Cliquez sur le bouton "Demander Heures Supplémentaires" dans le menu et remplissez le formulaire avec les informations requises.</li>
      <li>Visualiser Heures Supplémentaires  : Cliquez sur le bouton "Visualiser Heures Supplémentaires" dans le menu pour voir la reponse de responsable RH au demande des heures Supp.</li>
    </ul>
    
    <h4 class="mt-4">Gestion des Reclamation</h4>
    <ul>
      <li>Reclamaer: Cliquez sur le bouton "Reclamer" dans le menu pour envoyer une reclamation soit au RP ou au RH.</li>
    </ul>
    


    <h4 class="mt-4">Visualiser Bulletin</h4>
    <ul>
      <li>Visualiser Bulletin: Cliquez sur le bouton "Visualiser Bulletin" dans le menu pour voir le bulletin de mois courant .</li>
    </ul>
    <!-- Inclure le fichier JavaScript de Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </div>
</body>
</html>
