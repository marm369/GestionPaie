

<?php include_once 'espaceemp.php';  
$id=$_SESSION['identificateur'];
?>
<div class="container">
    <div class="card" style="width: 500px; margin: 50px auto;">
        <div class="card-body">
  <form method="POST" >
  <div class="form-group">
    <label for="hours-worked">Nombre d'heures travaillées :</label>
    <input type="text" id="hours-worked" name="hours-worked" class="form-control" required>
</div>
<div class="form-group">
    <label for="shift-type">Type de shift :</label>
    <select id="shift-type" name="shift-type" class="form-control">
      <option value="jour">Jour</option>
      <option value="nuit">Nuit</option>
    </select>
</div>
<div class="form-group">
    <label for="date">Date :</label>
    <input type="date" id="date" name="date" class="form-control" required style="width: 100%; height: 40px; padding: 8px; margin-bottom: 10px;">
</div>
<div class="form-group">
    <label for="day-status">Statut du jour :</label>
    <select id="day-status" name="day-status"  class="form-control">
      <option value="ouvrable">Ouvrable</option>
      <option value="non-ouvrable">Non-ouvrable</option>
    </select>
</div>
    <input type="submit" name="enregistrer" class="btn btn-success" value="Enregistrer">
    <input type="reset" class="btn btn-success" value="Annuler">
  </form>
</div>
</div>
</div>

<?php

if (!isset($_POST['enregistrer'])) 
{
    echo "<script>alert('le formulaire n'est pas envoye essaye de nouveau');</script>";
}
else
{
    require('connectbdd.php');
    // Récupérer les données soumises par le formulaire
    $nbrheures = $_POST['hours-worked'];
    $journuit = $_POST['shift-type'];
    $date = $_POST['date'];
    $statu = $_POST['day-status'];
    // Effectuer l'insertion dans la table "heure_supp"
    $stmt = $bdd->prepare("INSERT INTO heure_supp (typejour, journuit, nbrHeures, id_employe, statut, reponse, date) VALUES (?, ?, ?,?, 0, 0, ?)");
    $stmt->execute([$statu, $journuit, $nbrheures,$id, $date]);
    exit();
  }
?>
