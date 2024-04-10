<?php
include_once 'espacerp.php';

if(!isset($_SESSION['auth']))
{
    header('location:pageprincipale.html');
}

require('connectbdd.php');

$Login = $_SESSION['auth'];
$req = "SELECT * FROM comptes WHERE login = :Login";
$stmt = $bdd->prepare($req);
$stmt->bindParam(':Login', $Login);
$stmt->execute();
$compte = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Vérifier si les mots de passe correspondent
    if ($newPassword === $confirmPassword) {
        // Mettre à jour le mot de passe du compte
        $updateQuery = "UPDATE comptes SET password = :newPassword WHERE login = :Login";
        $updateStmt = $bdd->prepare($updateQuery);
        $updateStmt->bindParam(':newPassword', $newPassword);
        $updateStmt->bindParam(':Login', $Login);
        $updateStmt->execute();
    } else {
        echo "Les mots de passe ne correspondent pas. Veuillez les saisir à nouveau.";
    }
}
?>

<div class="container">
    <div class="card" style="width: 500px; margin: 50px auto;">
        <div class="card-body">
            <h5 class="card-title">Changer le mot de passe</h5>
            <form action="" method="post">
                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe :</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required><br>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe :</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required><br>
                </div>
                <input type="submit" class="btn btn-danger" value="Enregistrer">
            </form>
        </div>
    </div>
</div>
