<?php
include_once 'espacerh.php';
if (!isset($_SESSION['auth'])) {
    header('location:pageprincipale.html');
}


// Requête pour obtenir tous les noms des entreprises
$reqEntreprises = "SELECT nom FROM entreprise";
$resultat = $bdd->query($reqEntreprises);

// Tableau pour stocker les noms des entreprises
$entreprises = array();

// Extraction des noms des entreprises de la requête
while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
  $entreprises[] = $row['nom'];
}
?>
<div class="container">
    <div class="card" style="width: 500px; margin: 50px auto;  left:150px;">
        <div class="card-body">
            <form action="supprimerentreprise.php" method="POST">
                <div class="form-group">
                    <label for="user_last_name">Nom sous_entreprise</label>
                  

                    <select id="entreprise" name="nom" class="form-control" required style="width: 100%; height: 40px; padding: 8px; margin-bottom: 10px;">
            <?php
            // Parcours du tableau des entreprises pour créer les options de la liste déroulante
            foreach ($entreprises as $entreprise) {
              echo '<option value="' . $entreprise . '">' . $entreprise . '</option>';
            }
            ?>
          </select>
                </div>
                <div class="form-group">
                    <label for="user_last_name">Identifiant Fiscal</label>
                    <input class="form-control" type="nombre" name="idf">
                </div>
                <input type="submit" value="Supprimer" name="supprimer" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<?php
require('connectbdd.php');
if (!isset($_POST['supprimer'])) {
    echo "<script>alert('Le formulaire n'est pas envoyé. Veuillez essayer de nouveau.');</script>";
} else {
    $nom = $_POST['nom'];
    $idf = $_POST['idf'];
    // Récupérer l'ID de l'entreprise
    $req1 = "SELECT id FROM entreprise WHERE nom = :nom AND idf = :idf";
    $smt1 = $bdd->prepare($req1);
    $smt1->bindValue(':nom', $nom, PDO::PARAM_STR);
    $smt1->bindValue(':idf', $idf, PDO::PARAM_INT);
    $smt1->execute();
    $row = $smt1->fetch(PDO::FETCH_ASSOC);
    $idEntreprise = $row['id'];
    if ($idEntreprise) {
        // Supprimer l'entreprise de la table
        $req2 = "DELETE FROM entreprise WHERE id = :idEntreprise";
        $smt2 = $bdd->prepare($req2);
        $smt2->bindValue(':idEntreprise', $idEntreprise, PDO::PARAM_INT);
        $smt2->execute();
        if ($smt2) {
            echo "<script>alert('L'entreprise a été supprimée avec succès.');</script>";
        } else {
            echo "<script>alert('Une erreur s'est produite lors de la suppression de l'entreprise.');</script>";
        }
    } else {
        echo "<script>alert('L'entreprise avec le nom et l'identifiant fiscal spécifiés n'existe pas.');</script>";
    }
}
?>
