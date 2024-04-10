
<?php 
include_once 'espaceemp.php';  
$id=$_SESSION['identificateur'];
?>
<div class="container">
    <div class="card" style="width: 500px; margin: 50px auto;">
        <div class="card-body">
            <form action="demande-conge.php" method="POST">
                <label for="type-conge">Type de congé :</label>
                <div class="form-group">
                <select id="type-conge" name="type-conge" class="form-control">
                    <option value="maternite">Congé de maternité</option>
                    <option value="paye">Congé payé</option>
                    <option value="paternite">Congé de paternité</option>
                    <option value="maladie">Congé de maladie</option>
                </select>
                </div>
                <div class="form-group">
                <label for="date-debut">Date de début :</label>
                <input type="date" id="date-debut" name="date-debut" class="form-control" required style="width: 100%; height: 40px; padding: 8px; margin-bottom: 10px;">
                </div>
                <div class="form-group">
                <label for="date-fin">Date de fin :</label>
                <input type="date" id="date-fin" name="date-fin" class="form-control" required style="width: 100%; height: 40px; padding: 8px; margin-bottom: 10px;">
                </div>
                <input type="submit" name="envoyer"  class="btn btn-success" value="Envoyer">
                <input type="reset"  class="btn btn-success" value="Annuler">
            </form>
        </div>
    </div>
    </div>
<?php
if (!isset($_POST['envoyer'])) 
{
    echo "<script>alert('le formulaire n'est pas envoye essaye de nouveau');</script>";
}
else
{
// Se connecter à la base de données (assurez-vous de configurer les informations de connexion appropriées)
require('connectbdd.php');
// Récupérer les données soumises par le formulaire
$typeConge = $_POST['type-conge'];
$dateDebut = $_POST['date-debut'];
$dateFin = $_POST['date-fin'];
// Effectuer l'insertion dans la table "conge"
$stmt = $bdd->prepare("INSERT INTO conge (typeconge, datedebut, datefin, reponse, id_employe, statut) VALUES (?, ?, ?, '', ?, 0)");
$stmt->execute([$typeConge, $dateDebut,$dateFin,$id]);
// Rediriger vers la page de visualisation des congés (ou toute autre page souhaitée)

}
exit();
?>
