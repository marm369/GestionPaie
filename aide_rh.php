


<?php
include_once 'espacerh.php';
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
  <title>Aide - Ressources Humaines</title>
  <!-- Inclure les fichiers CSS de Bootstrap -->
 
</head>
<body>
  <div class="container" style="position:absolute; left:350px; top:40px;">
    <h2 class="mt-4">Aide - Ressources Humaines</h2>
    <h3 class="mt-4">Gestion des Entreprises</h3>
    <p>
      Pour gérer les sous entreprises, vous pouvez utiliser les fonctionnalités suivantes :
    </p>
    <ul>
      <li>Ajouter une sous entreprise : Cliquez sur le bouton "Ajouter sous entreprise" dans le menu et remplissez le formulaire avec les informations requises.</li>
      <li>Supprimer une sous entreprise : Cliquez sur le bouton "Supprimer sous entreprise" dans le menu et  choisissez l'entreprise a supprimer.</li>
      <li>Modifier les informations d'une sous entreprise: Cliquez sur le bouton "Modifier sous entreprise" dans le menu et choisissez l'entreprise que voulez modifier.</li>
      <li>Consulter sous entreprise : Cliquez sur le bouton "Modifier sous entreprise" dans le menu et vous pouvez visulaiser tous les sous entreprises .</li>
    </ul>
    
    <h3 class="mt-4">Gestion des Employés</h3>
    <p>
      Pour gérer les employés, vous pouvez utiliser les fonctionnalités suivantes :
    </p>
    <ul>
      <li>Ajouter un nouvel employé : Cliquez sur le bouton "Ajouter employé" dans le menu et remplissez le formulaire avec les informations requises.</li>
      <li>Supprimer un employé : Cliquez sur le bouton "Supprimer employé" dans le menu et choisissez l'entreprise puis la liste des employes va s'afficher avec l'option "Supprimer".</li>
      <li>Modifier un employé : Cliquez sur le bouton "Modifier employé" dans le menu et choisissez l'entreprise puis la liste des employes va s'afficher avec l'option "Modifier".</li>
      <li>Consulter un employé : Cliquez sur le bouton "Consulter employé" dans le menu et choisissez l'entreprise puis la liste des employes avec les informations va s'afficher .</li>
      <li>Valider Conge : Cliquez sur le bouton "Valider Congés" dans le menu pour valider ou refuser un conge.</li>
      <li>Valider les heures Supplementaires : Cliquez sur le bouton "Valider les heures supplementaires" dans le menu pour valider ou refuser les heures supp.</li>
      <li>Saisir Absence : Cliquez sur le bouton "Saisir Absence" dans le menu pour saisir les absences d'un employe.</li>
      <li>Rechercher un employé : Utilisez la barre de recherche en haut de la liste des employés pour trouver rapidement un employé en saisissant son nom.</li>
    </ul>
    
    <h2 class="mt-4">Gestion des Congés</h2>
    <p>
      La gestion des congés comprend les fonctionnalités suivantes :
    </p>
    <ul>
      <li>Demande de congé : Les employés peuvent soumettre une demande de congé en utilisant le formulaire disponible sur la page des congés.</li>
      <li>Approuver ou rejeter les demandes de congé : En tant que responsable RH, vous pouvez accéder à la liste des demandes de congé en attente et prendre des décisions d'approbation ou de rejet.</li>
      <li>Consultation du calendrier des congés : Vous pouvez consulter le calendrier des congés pour connaître les périodes d'absence des employés et planifier en conséquence.</li>
    </ul>
    
    <!-- Inclure le fichier JavaScript de Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </div>
</body>
</html>
