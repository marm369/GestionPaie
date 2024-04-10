<?php
include_once 'espacerh.php';
if (!isset($_SESSION['auth'])) {
    header('location:pageprincipale.html');
    exit;
}
?>

<?php
require('connectbdd.php');
if (!isset($_POST['chercher'])) {
    echo "<script>alert('Le formulaire n\'est pas envoyé. Veuillez réessayer.');</script>";
} else {
    $ssentreprise = $_POST['ssentreprise'];
    // Récupérer l'ID de l'entreprise
    $req1 = "SELECT id FROM entreprise WHERE nom = :nom";
    $smt1 = $bdd->prepare($req1);
    $smt1->bindValue(':nom', $ssentreprise, PDO::PARAM_STR);
    $smt1->execute();
    $row = $smt1->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "<div style='margin-left: 280px;  bottom: 1100px'>
        <table class='table table-bordered' style='background-color: #f2f2f2; font-size: 14px; width: 400px'>
        <tr style='background-color: #add8e6'>
            <td>Nom</td> 
            <td>Prenom</td> 
            <td>Situation</td> 
            <td>Date_Naissance</td> 
            <td>Genre</td> 
            <td>Adresse</td> 
            <td>Numero Tel</td> 
            <td>Email</td> 
            <td>Poste</td> 
            <td>Date d'Embauche</td> 
            <td>Salaire de Base</td> 
            <td>Nom Banque</td> 
            <td>Id Amo</td> 
            <td>Id Cimr</td> 
            <td>Nombre Enfants</td> 
            <td>Taux Cimr</td> 
        </tr>";

        $req = "SELECT * FROM employe WHERE id_entreprise = :id GROUP BY idEmploye";
        $smt = $bdd->prepare($req);
        $smt->bindValue(':id', $row['id'], PDO::PARAM_INT);
        $smt->execute();
        $rows = $smt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $V) {
            echo "<tr>
                <td>".$V['nom']."</td>
                <td>".$V['prenom']."</td>
                <td>".$V['situation']."</td>
                <td>".$V['date_naissance']."</td>
                <td>".$V['genre']."</td>
                <td>".$V['adresse']."</td>
                <td>".$V['numero_tel']."</td>
                <td>".$V['e_mail']."</td>
                <td>".$V['poste']."</td>
                <td>".$V['date_embauche']."</td>
                <td>".$V['salaire_base']."</td>
                <td>".$V['nom_banque']."</td>
                <td>".$V['idAmo']."</td>
                <td>".$V['idCimr']."</td>
                <td>".$V['nbrEnfant']."</td>
                <td>".$V['taux_cimr']."</td>
            </tr>";
        }
        echo "</table></div>";
    } else {
        echo "<script>alert('Aucun employé correspondant trouvé.');</script>";
    }
}
?>
