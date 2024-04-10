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
            <form action="absence.php" method="post">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom" id="nom" class="form-control" placeholder="nom" required><br>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" name="prenom" id="prenom" class="form-control" placeholder="prenom" required><br>
                </div>
                <div class="form-group">
                    <label for="datedebut">Date de début :</label>
                    <input type="date" name="datedebut" id="datedebut" class="form-control" placeholder="datedebut" required><br>
                </div>
                <div class="form-group">
                    <label for="nbrjour">Nombre de jours :</label>
                    <input type="number" name="nbrjour" id="nbrjour" class="form-control" placeholder="nbrjour" required><br>
                </div>
                <div class="form-group">
                    <label for="justifie">Justifié :</label>
                    <select name="justifie" id="justifie" class="form-control" required>
                        <option value="oui">Oui</option>
                        <option value="non">Non</option>
                    </select><br>
                </div>
                <div class="form-group">
                    <label for="motif">Motif :</label>
                    <input type="text" name="motif" id="motif" class="form-control" placeholder="motif" required><br>
                </div>
                <input type="submit" class="btn btn-primary" value="Enregistrer">
            </form>
        </div>
    </div>
</div>

<?php
// Effectuer la connexion à la base de données
require('connectbdd.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $datedebut = isset($_POST['datedebut']) ? $_POST['datedebut'] : '';
    $nbrjour = isset($_POST['nbrjour']) ? $_POST['nbrjour'] : '';
    $justifie = isset($_POST['justifie']) ? $_POST['justifie'] : '';
    $motif = isset($_POST['motif']) ? $_POST['motif'] : '';

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

        // Insertion des informations d'absence dans la table "absence"
        $req2 = "INSERT INTO absence (datedebut, nbrjour, justifie, motif, id_employe) 
                 VALUES (:datedebut, :nbrjour, :justifie, :motif, :idEmploye)";
        $stmt2 = $bdd->prepare($req2);
        $stmt2->bindParam(':datedebut', $datedebut);
        $stmt2->bindParam(':nbrjour', $nbrjour);
        $stmt2->bindParam(':justifie', $justifie);
        $stmt2->bindParam(':motif', $motif);
        $stmt2->bindParam(':idEmploye', $idEmploye);
        $stmt2->execute();

        // Vérifier si l'insertion a réussi
        if ($stmt2->rowCount() > 0) {
            echo "Les informations d'absence ont été insérées avec succès dans la base de données.";
        } else {
            echo "Une erreur s'est produite lors de l'insertion des informations d'absence.";
        }
    } else {
        echo "Aucun employé correspondant au nom $nom et au prénom $prenom n'a été trouvé.";
    }
}
?>
