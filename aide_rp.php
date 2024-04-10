
<?php
include_once 'espacerp.php';
 if(!isset($_SESSION['auth']))
 {
    header('location:pageprincipale.html');
 }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aide - RP</title>
  <!-- Inclure les fichiers CSS de Bootstrap -->
 
</head>
<body>
  <div class="container" style="position:absolute; left:350px; top:40px;">
    <h2 class="mt-4">Aide - Responsable de Paie</h2>
    <h4 class="mt-4">Gestion du Bulletin de paie</h4>
  
    <ul>
      <li>Generer Bulletin : Cliquez sur le bouton "Generer Bulletin" dans le menu et entrer l'entreprise et le mois pour afficher la liste des employes correspondant avec l'option "Generer".</li>
      <li>Exporter Bulletin : Cliquez sur le bouton "Exporter Congé" dans le menu et entrer l'entreprise et le mois pour afficher la liste des employes correspondant avec l'option "Exporter PDF/WORD".</li>
    </ul>
    
    <h4 class="mt-4">Gestion des Rubriques</h4>
  
    <ul>
      <li>Afficher les rubriques: Cliquez sur le bouton "Afficher les rubriques" dans le menu et entrer l'entreprise pour afficher ces rubriques.</li>
      <li>Ajouter rubrique  : Cliquez sur le bouton "Ajouter rubrique" dans le menu puis selectionnez l'entreprise et entrz le nom de la rubrique et sa regle.</li>
      <li>Supprimer rubrique  : Cliquez sur le bouton "Supprimer rubrique" dans le menu puis selectionnez l'entreprise et entrz le nom de la rubrique a supprimer.</li>
    </ul>
    
    <h4 class="mt-4">Gestion des regles</h4>
    <ul>
      <li>Modifier regle: Cliquez sur le bouton "Modifier regle" dans le menu puis selcetionnez l'entreprise et la rubrique et vous pouvez modifier la regle.</li>
    </ul>
    


  
    <!-- Inclure le fichier JavaScript de Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </div>
</body>
</html>
