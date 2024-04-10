<?php
include_once 'espacerh.php';
if (!isset($_SESSION['auth'])) {
    header('location:pageprincipale.html');
    exit();
}
?>
<div class="container">
    <div class="card" style="width: 500px; margin: 50px auto;  left:150px;">
        <div class="card-body">
        <h2>Saisir Allocation </h2>
            <form action="allocation.php" method="post">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom" id="nom" placeholder="nom" class="form-control" required><br>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" name="prenom" id="prenom" placeholder="prenom" class="form-control" required><br>
                </div>
                <div class="form-group">
                    <label for="datedebut">Montant d'allocation :</label>
                    <input type="number" name="montant" id="datedebut" placeholder="montant" class="form-control" required><br>
                </div>
                <input type="submit" class="btn btn-primary" value="Enregistrer">
            </form>
        </div>
    </div>
</div>

<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer le nom et le prénom de l'employé
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $montant = isset($_POST['montant']) ? $_POST['montant'] : '';

    // Effectuer la connexion à la base de données
    require('connectbdd.php');

    // Recherche de l'idEmploye à partir du nom et du prénom
    $req1 = "SELECT idEmploye FROM employe WHERE nom = :nom AND prenom = :prenom LIMIT 1";
    $stmt1 = $bdd->prepare($req1);
    $stmt1->bindParam(':nom', $nom);
    $stmt1->bindParam(':prenom', $prenom);
    $stmt1->execute();

    // Vérifier si la recherche a renvoyé un résultat
    if ($stmt1->rowCount() > 0) {
        $row = $stmt1->fetch(PDO::FETCH_ASSOC);
        $idEmploye = $row['idEmploye'];

        // Insertion des informations d'allocation dans la table "allocationfamiliale"
        $req2 = "INSERT INTO allocationfamiliale (id_employe, montant) 
                 VALUES (:idEmploye, :montant)";
        $stmt2 = $bdd->prepare($req2);
        $stmt2->bindParam(':idEmploye', $idEmploye);
        $stmt2->bindParam(':montant', $montant);
        $stmt2->execute();

        // Vérifier si l'insertion a réussi
        if ($stmt2->rowCount() > 0) {
            echo "Les informations d'allocation ont été insérées avec succès dans la base de données.";
        } else {
            echo "Une erreur s'est produite lors de l'insertion des informations d'allocation.";
        }
    } else {
        echo "Aucun employé correspondant au nom $nom et au prénom $prenom n'a été trouvé.";
    }
}
?>
