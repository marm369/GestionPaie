<?php
include_once 'espaceemp.php';

if(!isset($_SESSION['auth']))
{
    header('location:pageprincipale.php');
}

require('connectbdd.php');

$idEmploye = $_SESSION['auth'];

// Récupérer les informations du compte de l'employé
$req = "SELECT * FROM comptes WHERE id_employe = :idEmploye";
$stmt = $bdd->prepare($req);
$stmt->bindParam(':idEmploye', $idEmploye);
$stmt->execute();
$compte = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newLogin = $_POST['new_login'];
    $newPassword = $_POST['new_password'];

    // Vérifier si le nouveau login est déjà utilisé par un autre compte
    $checkLoginQuery = "SELECT id_employe FROM comptes WHERE login = :newLogin";
    $checkLoginStmt = $bdd->prepare($checkLoginQuery);
    $checkLoginStmt->bindParam(':newLogin', $newLogin);
    $checkLoginStmt->execute();

    if ($checkLoginStmt->rowCount() > 0) {
        echo "Le nouveau login est déjà utilisé par un autre compte. Veuillez en choisir un autre.";
    } else {
        // Mettre à jour le login et le mot de passe du compte
        $updateQuery = "UPDATE comptes SET login = :newLogin, password = :newPassword WHERE id_employe = :idEmploye";
        $updateStmt = $bdd->prepare($updateQuery);
        $updateStmt->bindParam(':newLogin', $newLogin);
        $updateStmt->bindParam(':newPassword', $newPassword);
        $updateStmt->bindParam(':idEmploye', $idEmploye);
        $updateStmt->execute();

        
    }
}
?>

<div class="container">
    <div class="card" style="width: 500px; margin: 50px auto;">
        <div class="card-body">
            <h5 class="card-title">Changer le mot de passe et le login</h5>
            <form action="" method="post">
                <div class="form-group">
                    <label for="new_login">Nouveau login :</label>
                    <input type="text" name="new_login" id="new_login" class="form-control" required><br>
                </div>
                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe :</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required><br>
                </div>
                <input type="submit" class="btn btn-success" value="Enregistrer">
            </form>
        </div>
    </div>
</div>
