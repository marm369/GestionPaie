<?php
include_once 'espacerh.php';
if (!isset($_SESSION['auth'])) {
    header('location:pageprincipale.html');
}
?>
<div class="container">
    <div class="card" style="width: 500px; margin: 50px auto;  left:150px;">
        <div class="card-body">
      <form action="ajouteremploye.php" method="post" style="font-size: 14px;">
      <h2>Informations personnelles</h2>
      <div class="form-group">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" class="form-control">
      </div>
      <div class="form-group">
        <label for="prenom">Prenom :</label>
        <input type="text" name="prenom" class="form-control">
      </div>
      <div class="form-group">
        <label for="sexe">Sexe :</label>
        <input type="text" name="sexe" class="form-control">
      </div>
      <div class="form-group">
        <label for="situation">Situation :</label>
        <input type="text" name="situation" class="form-control">
      </div>
      <div class="form-group">
        <label for="date-naissance">Date de naissance :</label>
        <input type="date" name="date-naissance" class="form-control">
      </div>
      <div class="form-group">
        <label for="nombre-enfant">Nombre d'enfants :</label>
        <input type="number" name="nombre-enfant" class="form-control">
      </div>
      <div class="form-group">
        <label for="poste">Poste :</label>
        <input type="text" name="poste" class="form-control">
      </div>
      <div class="form-group">
        <label for="amo">AMO :</label>
        <input type="number" name="amo" class="form-control">
      </div>
      <div class="form-group">
        <label for="cimr">CIMR :</label>
        <input type="number" name="cimr" class="form-control">
      </div>
      <div class="form-group">
        <label for="taux_cimr">TAUX_CIMR :</label>
        <input type="number" name="taux_cimr" class="form-control">
      </div>

      <h2>Contact</h2>
      <div class="form-group">
        <label for="adresse">Adresse:</label>
        <input type="text" name="adresse" class="form-control">
      </div>
      <div class="form-group">
        <label for="tel">Téléphone :</label>
        <input type="text" name="tel" class="form-control">
      </div>
      <div class="form-group">
        <label for="email">Email :</label>
        <input type="email" name="email" class="form-control">
      </div>
      <div class="form-group">
        <label for="banque">Nom Banque :</label>
        <input type="text" name="banque" class="form-control">
      </div>
      <div class="form-group">
        <label for="date-embauche">Date-embauche </label>
        <input type="date" name="date-embauche" class="form-control">
      </div>
      <div class="form-group">
        <label for="entreprise">Nom sous-entreprise:</label>
        <input type="text" name="entreprise" class="form-control">
      </div>
      <div class="form-group">
        <label for="salaire">Salaire:</label>
        <input type="number" name="salaire" class="form-control">
      </div>
      <h2>Contrat</h2>
      <div class="form-group">
        <label for="contrat">Type Contrat:</label>

        <select class="form-control">
    
             <option value="CDI">CDI</option>
             <option value="CDD">CDD</option>
             <option value="CTT">CTT</option>
          </select>

 
      </div>
      <div class="form-group">
        <label for="date-debut">Date-Debut: </label>
        <input type="date" name="date-debut" class="form-control">
      </div>
      <div class="form-group">
        <label for="date-fin">Date-Fin: </label>
        <input type="date" name="date-fin" class="form-control">
      </div>
    
      <h2>Compte</h2>
      <div class="form-group">
        <label for="login">Login:</label>
        <input type="text" name="login" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">Password :</label>
        <input type="password" name="password" class="form-control">
      </div>
      <div class="form-group">
        <label for="espace">Espace :</label>
        <input type="text" name="espace" class="form-control">
      </div>
      <button type="submit" name="enregistrer" class="btn btn-primary">Enregistrer</button>
    </form>
  </div>
</div>
</div>
<?php
// Connexion à la base de données
if (isset($_POST['enregistrer'])) {
  require('connectbdd.php');
  // Vérifier si le formulaire d'informations personnelles a été soumis
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $sexe = $_POST['sexe'];
  $dateNaissance = $_POST['date-naissance'];
  $nombreEnfant = $_POST['nombre-enfant'];
  $adr = $_POST['adresse'];
  $tel = $_POST['tel'];
  $email = $_POST['email'];
  $entreprise = $_POST['entreprise'];
  $salaire = $_POST['salaire'];
  $situation = $_POST['situation'];
  $poste = $_POST['poste'];
  $dateEmbauche = $_POST['date-embauche'];
  $bq = $_POST['banque'];
  $amo = $_POST['amo'];
  $cimr = $_POST['cimr'];
  $taux = $_POST['taux_cimr'];
  $login = $_POST['login'];
  $password = $_POST['password'];
  $espace = $_POST['espace'];
  $sql4 = "SELECT id FROM entreprise WHERE nom=:entreprise";
  $stmt4 = $bdd->prepare($sql4);
  $stmt4->bindParam(':entreprise', $entreprise);
  $stmt4->execute();
  $rows4 = $stmt4->fetch(PDO::FETCH_ASSOC);
  $monid4 = $rows4['id'];
  // Préparer la requête d'insertion
  $stmt = $bdd->prepare("INSERT INTO employe (situation, nom, prenom, date_naissance, genre, adresse, numero_tel, e_mail, poste, date_embauche, salaire_base, nom_banque, idAmo, idCimr, nbrEnfant, id_entreprise,taux_cimr) VALUES (:situation, :nom, :prenom, :date_naissance, :genre, :adresse, :numero_tel, :e_mail, :poste, :date_embauche, :salaire_base, :nom_banque, :idAmo, :idCimr, :nbrEnfant, :id_entreprise,:taux)");
  $stmt->bindParam(':situation', $situation);
  $stmt->bindParam(':nom', $nom);
  $stmt->bindParam(':prenom', $prenom);
  $stmt->bindParam(':date_naissance', $dateNaissance);
  $stmt->bindParam(':genre', $sexe);
  $stmt->bindParam(':adresse', $adr);
  $stmt->bindParam(':numero_tel', $tel);
  $stmt->bindParam(':e_mail', $email);
  $stmt->bindParam(':poste', $poste);
  $stmt->bindParam(':date_embauche', $dateEmbauche);
  $stmt->bindParam(':salaire_base', $salaire);
  $stmt->bindParam(':nom_banque', $bq);
  $stmt->bindParam(':idAmo', $amo);
  $stmt->bindParam(':idCimr', $cimr);
  $stmt->bindParam(':nbrEnfant', $nombreEnfant);
  $stmt->bindParam(':id_entreprise', $monid4);
  $stmt->bindParam(':taux', $taux);
  // Exécuter la requête
  $stmt->execute();
  $sql1 = "SELECT idEmploye FROM employe WHERE nom = :nom AND prenom = :prenom";
  $stmt1 = $bdd->prepare($sql1);
  $stmt1->bindParam(':nom', $nom);
  $stmt1->bindParam(':prenom', $prenom);
  $stmt1->execute();

  //tous les enregistrements
  $rows = $stmt1->fetch(PDO::FETCH_ASSOC);
  $monid = $rows['idEmploye'];
  $stmt2 = $bdd->prepare("INSERT INTO comptes (login, password, id_employe, poste) VALUES (:login, :password, :id_employe, :poste)");
  $stmt2->bindParam(':login', $login);
  $stmt2->bindParam(':password', $password);
  $stmt2->bindParam(':id_employe', $monid);
  $stmt2->bindParam(':poste', $espace);
  $stmt2->execute();
}
?>
