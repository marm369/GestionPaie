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
            <h2>Saisir Prime</h2>
            <form action="prime.php" method="post">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom" id="nom" placeholder="nom" class="form-control" required><br>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" name="prenom" id="prenom" placeholder="prenom" class="form-control" required><br>
                </div>
                <div class="form-group">
                    <label for="datedebut">Date de Prime :</label>
                    <input type="date" name="date" id="datedebut" placeholder="date" class="form-control" required><br>
                </div>
                <div class="form-group">
                    <label for="nbrjour">Montant :</label>
                    <input type="number" name="montant" id="nbrjour" placeholder="montant" class="form-control" required><br>
                </div>
                <div class="form-group">
                    <label for="justifie">Type de prime :</label>
                    <select name="type" id="justifie"  class="form-control" required>
                        <option value="Prime de performance">Prime de performance</option>
                        <option value="Prime d'ancienneté">Prime d'ancienneté </option>
                        <option value="Prime de rendement">Prime de rendement</option>
                        <option value="Prime de signature">Prime de signature</option>
                        <option value="Prime d'objectif">Prime d'objectif</option>
                        <option value="Prime de fidélité">Prime de fidélité</option>
                        <option value="Prime d'assiduité">Prime d'assiduité</option>
                        <option value="Prime de vacances">Prime de vacances </option>
                        <option value="Prime de fin d'année">Prime de fin d'année</option>
                        <option value="Prime d'intéressement">Prime d'intéressement</option>
                    </select><br>
                </div>
                <input type="submit"  class="btn btn-primary" value="Enregistrer">
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
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $montant = isset($_POST['montant']) ? $_POST['montant'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';

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

        // Insertion des informations de prime dans la table "prime"
        $req2 = "INSERT INTO prime (typrime, montant, id_employe, date) 
                 VALUES (:type, :montant, :idEmploye, :date)";
        $stmt2 = $bdd->prepare($req2);
        $stmt2->bindParam(':type', $type);
        $stmt2->bindParam(':montant', $montant);
        $stmt2->bindParam(':idEmploye', $idEmploye);
        $stmt2->bindParam(':date', $date);
        $stmt2->execute();

        // Vérifier si l'insertion a réussi
        if ($stmt2->rowCount() > 0) {
            echo "Les informations de prime ont été insérées avec succès dans la base de données.";
        } else {
            echo "Une erreur s'est produite lors de l'insertion des informations de prime.";
        }
    } else {
        echo "Aucun employé correspondant au nom $nom et au prénom $prenom n'a été trouvé.";
    }
}
?>
