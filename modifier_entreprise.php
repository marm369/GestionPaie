<?php
include_once 'espacerh.php';
if (!isset($_SESSION['auth'])) {
    header('location:pageprincipale.html');
}
?>
<?php
require('connectbdd.php');
if (!isset($_POST['chercher'])) {
    echo "<script>alert('Le formulaire n'est pas envoyé. Veuillez réessayer.');</script>";
} else {
    $nom = $_POST['nom'];
    $idf = $_POST['idf'];
    // Récupérer l'ID de l'entreprise
    $req1 = "SELECT * FROM entreprise WHERE nom = :nom AND idf = :idf";
    $smt1 = $bdd->prepare($req1);
    $smt1->bindValue(':nom', $nom, PDO::PARAM_STR);
    $smt1->bindValue(':idf', $idf, PDO::PARAM_INT);
    $smt1->execute();
    $row = $smt1->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $_SESSION['entreprise'] = $row;
        echo "<script>setTimeout(function(){window.location.href='modifier_entreprise.php';}, 0);</script>";
    } else {
        echo "<script>alert('Aucune entreprise correspondante trouvée');</script>";
    }
}
?>

<div class="container">
    <div class="card" style="width: 800px; margin: 50px auto; left:150px;">
        <div class="card-body">
            <form action="modifier_entreprise.php" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="user_last_name">Nom sous-entreprise</label>
                        <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['entreprise']['nom']); ?>"  name="nom">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="user_last_name">Secteur</label>
                        <select name="secteur" class="form-control">
                            <option disabled selected value=""><?php echo htmlspecialchars($_SESSION['entreprise']['secteur']); ?></option>
                            <option value="agriculture">Agriculture</option>
                            <option value="industrie">Industrie</option>
                            <option value="commerce">Commerce</option>
                            <option value="services">Services</option>
                            <option value="informatique">Informatique</option>
                            <option value="tourisme">Tourisme</option>
                            <option value="finance">Finance</option>
                            <option value="santé">Santé</option>
                            <!-- Ajoutez d'autres options selon vos besoins -->
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="user_last_name">Adresse</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['entreprise']['adresse']); ?>" type="text" name="adresse">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Pays</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['entreprise']['pays']); ?>" type="text" name="pays">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Identifiant Fiscal</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['entreprise']['idf']); ?>" type="number" name="idf">
                </div>
                <div class="form-group">
                    <label for="user_last_name">DateCreation</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['entreprise']['dateCreation']); ?>" type="date" name="date">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Statut</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['entreprise']['statut']); ?>" type="text" name="statut">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Email</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['entreprise']['email']); ?>" type="email" name="email">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Devise</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['entreprise']['devise']); ?>" type="text" name="devise">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Nombre employes</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['entreprise']['nbremploye']); ?>" type="number" name="nbremploye">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Code Postale</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['entreprise']['codepostal']); ?>" type="number" name="codepostal">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Identifiant Commercial</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['entreprise']['idrc']); ?>" type="number" name="idrc">
                </div>
                <div class="form-group">
                    <label for="user_last_name">Frais Professionnel</label>
                    <input class="form-control" value="<?php echo htmlspecialchars($_SESSION['entreprise']['fraisprof']); ?>" type="text" name="fraisprof">
                </div>
                <input type="submit" value="Enregistrer Modifications" name="modifier" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>

<?php
if (!isset($_POST['modifier'])) {
    echo "<script>alert('Le formulaire n'est pas envoyé. Veuillez réessayer.');</script>";
} else {
    $nom = $_POST['nom'];
    $secteur = $_POST['secteur'];
    $adresse = $_POST['adresse'];
    $pays = $_POST['pays'];
    $idf = $_POST['idf'];
    $datecreation = $_POST['date'];
    $statut = $_POST['statut'];
    $email = $_POST['email'];
    $devise = $_POST['devise'];
    $nbremploye = $_POST['nbremploye'];
    $codepostal = $_POST['codepostal'];
    $idrc = $_POST['idrc'];
    $fraisprof = $_POST['fraisprof'];
    $idee = $_SESSION['entreprise']['id'];
    $smt1 = $bdd->prepare("UPDATE entreprise SET nom=:nom ,secteur=:secteur , adresse=:adresse, pays=:pays, idf=:idf , dateCreation=:datecreation , statut=:statut , email=:email , devise=:devise , nbremploye=:nbremploye 
           ,codepostal=:codepostal,idrc=:idrc , fraisprof=:fraisprof where id=:idee ");
    $smt1->bindValue(':nom', $nom, PDO::PARAM_STR);
    $smt1->bindValue(':secteur', $secteur, PDO::PARAM_STR);
    $smt1->bindValue(':adresse', $adresse, PDO::PARAM_STR);
    $smt1->bindValue(':pays', $pays, PDO::PARAM_STR);
    $smt1->bindValue(':idf', $idf, PDO::PARAM_INT);
    $smt1->bindValue(':datecreation', $datecreation, PDO::PARAM_STR); // Utilisez PARAM_STR pour les dates
    $smt1->bindValue(':statut', $statut, PDO::PARAM_STR);
    $smt1->bindValue(':email', $email, PDO::PARAM_STR);
    $smt1->bindValue(':devise', $devise, PDO::PARAM_STR);
    $smt1->bindValue(':nbremploye', $nbremploye, PDO::PARAM_INT); // Assurez-vous de définir correctement $nbremploye
    $smt1->bindValue(':codepostal', $codepostal, PDO::PARAM_INT);
    $smt1->bindValue(':idrc', $idrc, PDO::PARAM_INT);
    $smt1->bindValue(':fraisprof', $fraisprof, PDO::PARAM_INT);
    $smt1->bindValue(':idee', $idee, PDO::PARAM_INT);
    $smt1->execute();
    if ($smt1) {
        echo "<script>setTimeout(function(){window.location.href='modifierentreprise.php';}, 0);</script>";
    }
}
?>
