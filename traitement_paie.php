<?php
$bd = new PDO("mysql:host=localhost;dbname=atelier_web;charset=UTF8", "root", "");

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$date = $_POST['date']; 
$mois = date('m', strtotime($date));

$sql = "SELECT * FROM employe WHERE nom=? and prenom=?";
$stat = $bd->prepare($sql);
$stat->bindValue(1, $nom, PDO::PARAM_STR);
$stat->bindValue(2, $prenom, PDO::PARAM_STR);
$stat->execute();
$result = $stat->fetchAll(PDO::FETCH_ASSOC);

// récupération des données utilisées pour le calcul de salaire
if (count($result) > 0)
 {
    $id = $result[0]['idEmploye'];
    $tauscimr = $result[0]['taux_cimr'];
    $salaireBase = $result[0]['salaire_base'];
} else 
{
    echo "Pas d'enregistrement à manipuler.";
}


$sql_check_entry = "SELECT COUNT(*) AS count FROM bulletin WHERE id_employe = ? AND MONTH(date) = ?";
$stmt_check_entry = $bd->prepare($sql_check_entry);
$stmt_check_entry->bindValue(1, $id, PDO::PARAM_INT);
$stmt_check_entry->bindValue(2, $mois, PDO::PARAM_STR);
$stmt_check_entry->execute();
$result_check_entry = $stmt_check_entry->fetch(PDO::FETCH_ASSOC);

if ($result_check_entry['count'] > 0){

    header("Location: espace.php?error=1&nom=" . urlencode($nom) . "&prenom=" . urlencode($prenom));
    exit();
} 
else 
{

/********************acces au table HS pour recuperer les heures supp *****************************/
$sql1 = "SELECT * FROM heure_supp WHERE id_employe=? AND MONTH(date) = ?";
$stat1 = $bd->prepare($sql1);
$stat1->bindValue(1, $id, PDO::PARAM_INT);
$stat1->bindValue(2, $mois, PDO::PARAM_INT);
$stat1->execute();
$result1 = $stat1->fetchAll(PDO::FETCH_ASSOC);
$somme_HS = 0;

if (count($result1) > 0) {
    foreach ($result1 as $row) {
        $nbrheur = $row['nbrHeures'];
        $jour_nuit = $row['journuit'];
        $ouvrable_non = $row['typejour'];
        $salaire_horaire= $salaireBase/(44*4);
        if ($ouvrable_non == "ouvrable" && $jour_nuit == "jour") {
            $HS =   $salaire_horaire*$nbrheur * 0.25;
        } else if ($ouvrable_non == "ouvrable" && $jour_nuit == "nuit") {
            $HS =  $salaire_horaire*$nbrheur * 0.50;
        } else if ($ouvrable_non == "ferie" && $jour_nuit == "jour") {
            $HS =  $salaire_horaire*$nbrheur * 0.50;
        } else if ($ouvrable_non == "ferie" && $jour_nuit == "nuit") {
            $HS =  $salaire_horaire*$nbrheur * 1;
        }

        $somme_HS += $HS;
    }
} else {
    echo "Pas d'enregistrement pour cet employé ce mois dans HS.";
}

// Insertion du HS dans la table bulletin
$designation = "HS";
$valeur = $somme_HS;

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();
echo"< br >";
echo "Résultat HS pour cette ligne : $somme_HS <br>";
echo"< br >";
/*********************************calcul de SBG***********************************************/

// Récupérer la règle depuis la table "regle"
$sql_regle = "SELECT formule FROM regle WHERE designation = 'SBG'";
$stmt_regle = $bd->prepare($sql_regle);
$stmt_regle->execute();
$result_regle = $stmt_regle->fetch(PDO::FETCH_ASSOC);

if ($result_regle) {
    $regle = $result_regle['formule'];

    // Récupérer la valeur de prime depuis la table "prime"
    $sql_prime = "SELECT montant FROM prime WHERE id_employe = ? and MONTH(date) = ?";
    $stmt_prime = $bd->prepare($sql_prime);
    $stmt_prime->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_prime->bindValue(2, $mois, PDO::PARAM_INT);
    $stmt_prime->execute();
    $result_prime = $stmt_prime->fetchAll(PDO::FETCH_ASSOC);

    if ($result_prime) {
        $valeur_prime = 0;
        foreach ($result_prime as $row) {
            $valeur_prime += $row['montant'];
        }
        echo "Valeur de prime pour employé $nom $prenom : $valeur_prime";
    } else {
        $valeur_prime = 0; // Valeur par défaut si aucune prime n'est trouvée
    }

    // Récupérer la valeur des heures supp depuis la table "bulletin"
    $sql_hs = "SELECT valeur FROM bulletin WHERE id_employe = ? and designation = ?";
    $stmt_hs = $bd->prepare($sql_hs);
    $stmt_hs->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_hs->bindValue(2, 'HS', PDO::PARAM_STR);
    $stmt_hs->execute();
    $result_hs = $stmt_hs->fetch(PDO::FETCH_ASSOC);

    if ($result_hs) {
        $total_hs = $result_hs['valeur'];
        echo "Valeur de HS pour employé $nom $prenom : $total_hs";
    } else {
        $total_hs = 0; // Valeur par défaut si aucune prime n'est trouvée
    }

    // Récupérer la valeur de l'indemnité depuis la table "indemnite"
    $sql_indemnite = "SELECT montant FROM indemnite WHERE id_employe = ? and MONTH(date) = ?";
    $stmt_indemnite = $bd->prepare($sql_indemnite);
    $stmt_indemnite->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_indemnite->bindValue(2, $mois, PDO::PARAM_INT);
    $stmt_indemnite->execute();
    $result_indemnite = $stmt_indemnite->fetchAll(PDO::FETCH_ASSOC);

    if ($result_indemnite) {
        $valeur_indemnite = 0;
        foreach ($result_indemnite as $row) {
            $valeur_indemnite += $row['montant'];
        }
        echo "Valeur de indemnite pour employé $nom $prenom : $valeur_indemnite";
    } else {
        $valeur_indemnite = 0; // Valeur par défaut si aucune indemnité n'est trouvée
    }

    // Récupérer la valeur de l'avantage depuis la table "avantage"
    $sql_avantage = "SELECT montant FROM avantage WHERE id_employe = ? and MONTH(date) = ?";
    $stmt_avantage = $bd->prepare($sql_avantage);
    $stmt_avantage->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_avantage->bindValue(2, $mois, PDO::PARAM_INT);
    $stmt_avantage->execute();
    $result_avantage = $stmt_avantage->fetchAll(PDO::FETCH_ASSOC);

    if ($result_avantage) {
        $valeur_avantage = 0;
        foreach ($result_avantage as $row) {
            $valeur_avantage += $row['montant'];
        }
        
    } else {
        $valeur_avantage = 0; // Valeur par défaut si aucun avantage n'est trouvé
    }

    // Remplacer les champs dans la règle par leurs valeurs correspondantes
    $regle = str_replace('SB', $salaireBase, $regle);
    $regle = str_replace('HS', $total_hs, $regle);
    $regle = str_replace('prime', $valeur_prime, $regle);
    $regle = str_replace('indemnite', $valeur_indemnite, $regle);
    $regle = str_replace('avantage', $valeur_avantage, $regle);

    // Évaluer la formule pour obtenir le résultat de SBG
    eval("\$SBG = $regle;");

    // Afficher le résultat de SBG
    echo"< br >";
    echo "Le montant de SBG pour l'employé $nom $prenom d'identifiant $id est : SBG = $SBG";
    echo"< br >";
}
//insertion de SBG dans bulltin
$designation = "SBG";
$valeur = $SBG;

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();
/************************************************************************************* */
/*******************calcule de SBI(salaire brute imposable) *************************/
 

// Récupérer la règle depuis la table "regle"
$sql_SBI = "SELECT formule FROM regle WHERE designation = 'SBI'";
$stmt_SBI = $bd->prepare($sql_SBI);
$stmt_SBI->execute();
$result_SBI = $stmt_SBI->fetch(PDO::FETCH_ASSOC);

if ($result_SBI) {
    $SBI = $result_SBI['formule'];


    // Récupérer la valeur de SBG depuis la table "bulletin"
    $sql_sbg = "SELECT valeur FROM bulletin WHERE id_employe = ? and designation = ?";
    $stmt_sbg = $bd->prepare($sql_sbg);
    $stmt_sbg->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_sbg->bindValue(2, 'SBG', PDO::PARAM_STR);
    $stmt_sbg->execute();
    $result_sbg = $stmt_sbg->fetch(PDO::FETCH_ASSOC);

    if ($result_sbg) {
        $sbg = $result_sbg['valeur'];
        
      
    } else {
        $sbg = 0; // Valeur par défaut si aucun SBG n'est trouvé
    }

    // Récupérer la valeur de l'allocation familiale depuis la table "allocationfamiliale"
    $sql_allocation = "SELECT montant FROM allocationfamiliale WHERE id_employe = ? and MONTH(date) = ?";
    $stmt_allocation = $bd->prepare($sql_allocation);
    $stmt_allocation->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_allocation->bindValue(2, $mois, PDO::PARAM_INT);
    $stmt_allocation->execute();
    $result_allocation = $stmt_allocation->fetchAll(PDO::FETCH_ASSOC);

    if ($result_allocation) {
        $allocation = 0;
        foreach ($result_allocation as $row) {
            $allocation += $row['montant'];
        }
        echo"< br >";
        echo "Valeur de l'allocation familiale pour employé $nom $prenom : $allocation";
        echo"< br >";
    } else {
        $allocation = 0; // Valeur par défaut si aucune allocation n'est trouvée
    }

    // Remplacer les champs dans la règle par leurs valeurs correspondantes
    $SBI = str_replace('SBG', $sbg, $SBI);
    $SBI = str_replace('allocation famille', $allocation, $SBI);

    // Évaluer la formule pour obtenir le résultat final
    eval("\$SBI = $SBI;");

    // Afficher le résultat final
    echo"< br >";
    echo "Le résultat de SBI l'employé $nom $prenom d'identifiant $id est : $SBI";
    echo"< br >";
}

//insertion de SBI dans la tble bulltin

$designation = "SBI";
$valeur = $SBI;

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();
 /*************************************************************************************/

 /*****************************calcule de CNSS**************************************** */
 // Récupérer la règle CNSS depuis la table "regle"
$sql_CNSS = "SELECT formule FROM regle WHERE designation = 'CNSS'";
$stmt_CNSS = $bd->prepare($sql_CNSS);
$stmt_CNSS->execute();
$result_CNSS = $stmt_CNSS->fetch(PDO::FETCH_ASSOC);

if ($result_CNSS) {
    $regle_cnss = $result_CNSS['formule'];

    // Récupérer la valeur de SBI depuis la table "bulletin"
    $sql_sbi = "SELECT valeur FROM bulletin WHERE id_employe = ? AND designation = ?";
    $stmt_sbi = $bd->prepare($sql_sbi);
    $stmt_sbi->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_sbi->bindValue(2, 'SBI', PDO::PARAM_STR);
    $stmt_sbi->execute();
    $result_sbi = $stmt_sbi->fetch(PDO::FETCH_ASSOC);

    if ($result_sbi) {
        $sbi = $result_sbi['valeur'];
        echo "Valeur de SBI pour employé $nom $prenom : $sbi";
    } else {
        $sbi = 0; // Valeur par défaut si aucun SBI n'est trouvé
    }

    // Remplacer le champ SBI dans la règle par sa valeur correspondante
    $regle_cnss = str_replace('SBI', $sbi, $regle_cnss);

    // Évaluer la formule pour obtenir le résultat final
    eval("\$cnss = $regle_cnss;");

    // Afficher le résultat final
    echo"< br >";
    echo "La valeur de CNSS pour l'employé $nom $prenom d'identifiant $id est : $cnss";
    echo"< br >";
}
//insertion dans la table bulltin 
$designation="CNSS";
$valeur=$cnss;

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();

/*************************************************************************************/
 /*****************************calcule de AMO**************************************** */
 // Récupérer la règle AMO depuis la table "regle"
 $sql_AMO = "SELECT formule FROM regle WHERE designation = 'AMO'";
 $stmt_AMO = $bd->prepare($sql_AMO);
 $stmt_AMO->execute();
 $result_AMO= $stmt_AMO->fetch(PDO::FETCH_ASSOC);
 
 if ($result_AMO) {
     $regle_amo = $result_AMO['formule'];
 
     // Récupérer la valeur de SBI depuis la table "bulletin"
     $sql_sbi = "SELECT valeur FROM bulletin WHERE id_employe = ? AND designation = ?";
     $stmt_sbi = $bd->prepare($sql_sbi);
     $stmt_sbi->bindValue(1, $id, PDO::PARAM_INT);
     $stmt_sbi->bindValue(2, 'SBI', PDO::PARAM_STR);
     $stmt_sbi->execute();
     $result_sbi = $stmt_sbi->fetch(PDO::FETCH_ASSOC);
 
     if ($result_sbi) {
         $sbi = $result_sbi['valeur'];
         echo "Valeur de SBI pour employé $nom $prenom : $sbi";
     } else {
         $sbi = 0; // Valeur par défaut si aucun SBI n'est trouvé
     }
 
     // Remplacer le champ SBI dans la règle par sa valeur correspondante
     $regle_amo = str_replace('SBI', $sbi, $regle_amo);
 
     // Évaluer la formule pour obtenir le résultat final
     eval("\$amo = $regle_amo;");
 
     // Afficher le résultat final
     echo"< br >";
     echo "La valeur de  AMO pour l'employé $nom $prenom d'identifiant $id est : $amo";
     echo"< br >";
 }
 
 //insertion dans la table bulltin 
$designation="AMO";
$valeur=$amo;

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();
 /*************************************************************************************/

 /*************************Calcule de frais pofessionnels ***************************/
// Récupérer la règle depuis la table "regle"
$sql_frais = "SELECT formule FROM regle WHERE designation = 'frais professionnels'";
$stmt_frais = $bd->prepare($sql_frais);
$stmt_frais->execute();
$result_frais = $stmt_frais->fetch(PDO::FETCH_ASSOC);

$frais_professionnels = 0; // Initialisation de la variable

if ($result_frais) {
    $frais = $result_frais['formule'];

    // Récupérer l'avantage de type "nature" depuis la table "avantage"
    $sql_avantage = "SELECT montant FROM avantage WHERE id_employe = ? AND typeavantage = 'nature' AND MONTH(date) = ?";
    $stmt_avantage = $bd->prepare($sql_avantage);
    $stmt_avantage->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_avantage->bindValue(2, $mois, PDO::PARAM_INT);
    $stmt_avantage->execute();
    $result_avantage = $stmt_avantage->fetchAll(PDO::FETCH_ASSOC);

    $avantage_nature = 0; // Variable initialisée à 0

    if ($result_avantage) {
        foreach ($result_avantage as $row) {
            $avantage_nature += $row['montant'];
        }

        // Récupérer la valeur de SBI depuis la table "bulletin"
        $sql_sbi = "SELECT valeur FROM bulletin WHERE id_employe = ? AND designation = 'SBI'";
        $stmt_sbi = $bd->prepare($sql_sbi);
        $stmt_sbi->bindValue(1, $id, PDO::PARAM_INT);
        $stmt_sbi->execute();
        $result_sbi = $stmt_sbi->fetch(PDO::FETCH_ASSOC);

        if ($result_sbi) {
            $sbi = $result_sbi['valeur'];

            // Remplacer les champs dans la règle par leurs valeurs correspondantes
            $frais = str_replace('avantages nature', $avantage_nature, $frais);
            $frais = str_replace('SBI', $sbi, $frais);

            // Évaluer la formule pour obtenir le résultat final
            eval("\$frais_professionnels = $frais;");
            echo "<br>";
            echo "Le résultat de frais professionnels pour l'employé $nom $prenom d'identifiant $id est : $frais_professionnels";
            echo "<br>";
        }
    }
}

//insertion dans la table bulletin
$designation = "frais professionnels";
$valeur = $frais_professionnels;

 $sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
 $stmt2 = $bd->prepare($sql2);
 $stmt2->bindValue(1, $id, PDO::PARAM_INT);
 $stmt2->bindValue(2, $designation, PDO::PARAM_STR);
 $stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
 $stmt2->bindValue(4, $date, PDO::PARAM_STR);
 $stmt2->execute();
 //insertion de taux 
 $designation3="taux frais profess ";
 $valeur3='20%';

 $sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
 $stmt2 = $bd->prepare($sql2);
 $stmt2->bindValue(1, $id, PDO::PARAM_INT);
 $stmt2->bindValue(2, $designation3, PDO::PARAM_STR);
 $stmt2->bindValue(3, $valeur3, PDO::PARAM_STR);
 $stmt2->bindValue(4, $date, PDO::PARAM_STR);
 $stmt2->execute();

 /***********************************************************************************/

 /*******************************Calcule CIMR************************************** */

// Récupérer la règle pour la désignation "CIMR" depuis la table "regle"
$sql_cimr = "SELECT formule FROM regle WHERE designation = 'CIMR'";
$stmt_cimr = $bd->prepare($sql_cimr);
$stmt_cimr->execute();
$result_cimr = $stmt_cimr->fetch(PDO::FETCH_ASSOC);

if ($result_cimr) {
    $cimr = $result_cimr['formule'];

    // Récupérer le taux_cimr depuis la table "employe"
    $sql_taux_cimr = "SELECT taux_cimr FROM employe WHERE idEmploye = ?";
    $stmt_taux_cimr = $bd->prepare($sql_taux_cimr);
    $stmt_taux_cimr->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_taux_cimr->execute();
    $result_taux_cimr = $stmt_taux_cimr->fetch(PDO::FETCH_ASSOC);

    if ($result_taux_cimr) {
        $taux_cimr = $result_taux_cimr['taux_cimr'];

        // Remplacer le champ dans la règle par sa valeur correspondante
        $cimr = str_replace('taux_cimr', $taux_cimr, $cimr);
        $cimr = str_replace('SBI', $sbi, $cimr);
        // Évaluer la formule pour obtenir le résultat final
        eval("\$cimr_result = $cimr;");
        echo"< br >";
        echo "Le résultat de CIMR pour l'employé $nom $prenom d'identifiant $id est : $cimr_result";
        echo"< br >";
    }
}

//insertion dans la table bulltin 
$designation="CIMR";
$valeur=$cimr_result;

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();

 /**********************************************************************************/
 /************************calcule de CIMR******************************************/
// Récupérer la règle pour la désignation "Elements deductibles" depuis la table "regle"
$sql_deductibles = "SELECT formule FROM regle WHERE designation = 'elements deductibles'";
$stmt_deductibles = $bd->prepare($sql_deductibles);
$stmt_deductibles->execute();
$result_deductibles = $stmt_deductibles->fetch(PDO::FETCH_ASSOC);

if ($result_deductibles) {
    $deductibles = $result_deductibles['formule'];
    // Remplacer les champs dans la règle par leurs valeurs correspondantes
    $deductibles = str_replace('CNSS', $cnss, $deductibles);
    $deductibles = str_replace('AMO', $amo, $deductibles);
    $deductibles = str_replace('CIMR', $cimr_result , $deductibles);
    $deductibles = str_replace('frais profession', $frais_professionnels, $deductibles);
    
    // Évaluer la formule pour obtenir le résultat final
    eval("\$deductibles_result = $deductibles;");
    echo"< br >";
    echo "Le résultat de element déductibles  pour l'employé $nom $prenom d'identifiant $id est : $deductibles_result";
    echo"< br >";
}
 
 //insertion dans la table bulltin 
$designation="Elements deductibles";
$valeur=$deductibles_result;

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();


 /*********************************************************************************/

 /*********************calcule de SNI salaire net imposable************************/
  // Récupérer la règle pour la désignation "SNI" depuis la table "regle"
$sql_sni = "SELECT formule FROM regle WHERE designation = 'SNI'";
$stmt_sni = $bd->prepare($sql_sni);
$stmt_sni->execute();
$result_sni = $stmt_sni->fetch(PDO::FETCH_ASSOC);

if ($result_sni) {
    $sni = $result_sni['formule'];

    // Récupérer les valeurs de SBI et les éléments déductibles depuis le bulletin
    
    // Remplacer les champs dans la règle par leurs valeurs correspondantes
    $sni = str_replace('SBI', $sbi, $sni);
    $sni = str_replace('elements deductibles', $deductibles_result, $sni);

    // Évaluer la formule pour obtenir le résultat final
    eval("\$sni_result = $sni;");
    echo"< br >";
    echo "Le résultat de SNI pour l'employé $nom $prenom d'identifiant $id est : $sni_result";
    echo"< br >";
}
 //insertion dans la table bulltin 
 $designation="SNI";
 $valeur=$sni_result;
 
 $sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
 $stmt2 = $bd->prepare($sql2);
 $stmt2->bindValue(1, $id, PDO::PARAM_INT);
 $stmt2->bindValue(2, $designation, PDO::PARAM_STR);
 $stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
 $stmt2->bindValue(4, $date, PDO::PARAM_STR);
 $stmt2->execute();

 /*********************************************************************************/

 /**********************************calcule de IR brut impot sur rvenu brut************************/
   // Récupérer la règle pour la désignation "IR brut" depuis la table "regle"
$sql_ir = "SELECT formule FROM regle WHERE designation = 'IR brut'";
$stmt_ir = $bd->prepare($sql_ir);
$stmt_ir->execute();
$result_ir = $stmt_ir->fetch(PDO::FETCH_ASSOC);
  
if ($result_ir) {
    $ir_brut = $result_ir['formule'];
  
    // Récupérer la valeur de SBI depuis la table "bulltin"
    $sql_sbi = "SELECT valeur FROM bulletin WHERE id_employe = ? AND designation = 'SBI'";
    $stmt_sbi = $bd->prepare($sql_sbi);
    $stmt_sbi->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_sbi->execute();
    $result_sbi = $stmt_sbi->fetch(PDO::FETCH_ASSOC);

    if ($result_sbi) {
        $sbi = $result_sbi['valeur'];

        // Affecter la valeur du taux_IR et de la somme en fonction de la valeur de SBI
        $taux_ir = 0;
        $somme = 0;

        if ($sbi <= 2500) {
            $taux_ir = 0;
            $somme = 0;
        } elseif ($sbi <= 4166.66) {
            $taux_ir = 0.10;
            $somme = 250;
        } elseif ($sbi <= 5000) {
            $taux_ir = 0.20;
            $somme = 666.67;
        } elseif ($sbi <= 6666.66) {
            $taux_ir = 0.30;
            $somme = 1166.67;
        } elseif ($sbi <= 15000) {
            $taux_ir = 0.34;
            $somme = 1433.33;
        } else {
            $taux_ir = 0.38;
            $somme = 2033.33;
        }

        // Remplacer les champs dans la règle par leurs valeurs correspondantes
        $ir_brut = str_replace('SNI',  $sni_result, $ir_brut);
        $ir_brut = str_replace('taux_IR', $taux_ir, $ir_brut);
        $ir_brut = str_replace('somme', $somme, $ir_brut);

        // Évaluer la formule pour obtenir le résultat final
        eval("\$ir_brut_result = $ir_brut;");
        echo"< br >";
        echo "Le résultat de IR_brut pour l'employé $nom $prenom d'identifiant $id est : $ir_brut_result";
        echo"< br >";
    }
}

 //insertion dans la table bulltin 
 $designation="IR brut";
 $valeur=$ir_brut_result;
 
 $sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
 $stmt2 = $bd->prepare($sql2);
 $stmt2->bindValue(1, $id, PDO::PARAM_INT);
 $stmt2->bindValue(2, $designation, PDO::PARAM_STR);
 $stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
 $stmt2->bindValue(4, $date, PDO::PARAM_STR);
 $stmt2->execute();

 /*************************************************************************************************/

 /***********************************************Calcule de IR net**************************************************/
   
 // Récupérer la règle pour la désignation "IR net" depuis la table "regle"
$sql_ir_net = "SELECT formule FROM regle WHERE designation = 'IR net'";
$stmt_ir_net = $bd->prepare($sql_ir_net);
$stmt_ir_net->execute();
$result_ir_net = $stmt_ir_net->fetch(PDO::FETCH_ASSOC);

if ($result_ir_net) {
    $ir_net = $result_ir_net['formule'];

    // Récupérer le nombre d'enfants depuis la table "employe"
    $sql_enfants = "SELECT nbrEnfant FROM employe WHERE idEmploye = ?";
    $stmt_enfants = $bd->prepare($sql_enfants);
    $stmt_enfants->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_enfants->execute();
    $result_enfants = $stmt_enfants->fetch(PDO::FETCH_ASSOC);

    if ($result_enfants) {
        $nb_enfants = $result_enfants['nbrEnfant'];
        
        // Calculer le montant des charges de famille
        $charges_famille = ($nb_enfants + 1) * 30;
        $charges_famille = min($charges_famille, 180); // Limiter le montant à 180 Dhs

        // Remplacer les champs dans la règle par leurs valeurs correspondantes
        $ir_net = str_replace('IR brut', $ir_brut_result, $ir_net);
        $ir_net = str_replace('charges famille', $charges_famille, $ir_net);

        // Évaluer la formule pour obtenir le résultat final
        eval("\$ir_net_result = $ir_net;");
        echo"< br >";
        echo "Le résultat de IR_net pour l'employé $nom $prenom d'identifiant $id est : $ir_net_result";
        echo"< br >";
    }
}

//insertion dans la table bulltin 
$designation="IR net";
$valeur=$ir_net_result;

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();

 /************************************************************************************************************** */

 /*****************************Retnu CNSS **********************************************************************/

  // Récupérer la formule de la règle "Retenu CNSS" depuis la table "regle"
$sql_regle_cnss = "SELECT formule FROM regle WHERE designation = 'Retenu CNSS'";
$stmt_regle_cnss = $bd->prepare($sql_regle_cnss);
$stmt_regle_cnss->execute();
$result_regle_cnss = $stmt_regle_cnss->fetch(PDO::FETCH_ASSOC);

if ($result_regle_cnss){
    $formule_cnss = $result_regle_cnss['formule'];

    // Récupérer la valeur de SBI depuis la table "bulletin"
    $sql_sbi = "SELECT valeur FROM bulletin WHERE id_employe = ? AND designation = 'SBI'";
    $stmt_sbi = $bd->prepare($sql_sbi);
    $stmt_sbi->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_sbi->execute();
    $result_sbi = $stmt_sbi->fetch(PDO::FETCH_ASSOC);

    if ($result_sbi){
        $sbi = $result_sbi['valeur'];

        // Remplacer le champ dans la formule par la valeur correspondante
        $formule_cnss = str_replace('SBI', $sbi, $formule_cnss);
        
        // Évaluer la formule pour obtenir le résultat final
        eval("\$retenue_cnss = $formule_cnss;");
        echo"< br >";
        echo "La retenue CNSS pour l'employé $nom $prenom d'identifiant $id est : $retenue_cnss";
        echo"< br >";
    }
}
//insertion dans la table bulltin 
$designation="Retenu CNSS";
$valeur=$retenue_cnss;

$designation1="taux CNSS";
$valeur1='4.48%';

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation1, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur1, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();

 /*************************************************************************************************************/

 /*******************Calcule Retenu AMO**********************************************************************/
  // Récupérer la formule de la règle "Retenu AMO" depuis la table "regle"
$sql_regle_amo = "SELECT formule FROM regle WHERE designation = 'Retenu AMO'";
$stmt_regle_amo = $bd->prepare($sql_regle_amo);
$stmt_regle_amo->execute();
$result_regle_amo = $stmt_regle_amo->fetch(PDO::FETCH_ASSOC);

if ($result_regle_amo) {
    $formule_amo = $result_regle_amo['formule'];

    // Récupérer la valeur de SBI depuis la table "bulletin"
    $sql_sbi = "SELECT valeur FROM bulletin WHERE id_employe = ? AND designation = 'SBI'";
    $stmt_sbi = $bd->prepare($sql_sbi);
    $stmt_sbi->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_sbi->execute();
    $result_sbi = $stmt_sbi->fetch(PDO::FETCH_ASSOC);

    if ($result_sbi) {
        $sbi = $result_sbi['valeur'];

        // Remplacer le champ dans la formule par la valeur correspondante
        $formule_amo = str_replace('SBI', $sbi, $formule_amo);

        // Évaluer la formule pour obtenir le résultat final
        eval("\$retenue_amo = $formule_amo;");
        echo"< br >";
        echo "La retenue AMO pour l'employé $nom $prenom d'identifiant $id est : $retenue_amo";
        echo"< br >";
    }
}

$designation="Retenu AMO";
$valeur= $retenue_amo;

$designation2="taux AMO";
$valeur2= '2.26%';

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation2, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur2, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();
 /***********************************************************************************************************/

 /************************************Calcule Salaire à payé ***********************************************/
// Récupérer la formule de la règle "Salaire Final" depuis la table "regle"
$sql_regle_salaire_final = "SELECT formule FROM regle WHERE designation = 'Salaire Final'";
$stmt_regle_salaire_final = $bd->prepare($sql_regle_salaire_final);
$stmt_regle_salaire_final->execute();
$result_regle_salaire_final = $stmt_regle_salaire_final->fetch(PDO::FETCH_ASSOC);

if ($result_regle_salaire_final) {
    $formule_salaire_final = $result_regle_salaire_final['formule'];
    $formule_salaire_final = str_replace('SBG', $sbg, $formule_salaire_final);
    $formule_salaire_final = str_replace('CNSS', $cnss, $formule_salaire_final);
    $formule_salaire_final = str_replace('AMO', $amo, $formule_salaire_final);
    $formule_salaire_final = str_replace('CIMR', $cimr_result, $formule_salaire_final);
    $formule_salaire_final = str_replace('IR net',$ir_net_result, $formule_salaire_final);

    // Évaluer la formule pour obtenir le résultat final
    eval("\$salaire_final = $formule_salaire_final;");
    echo"< br >";
    echo "Le salaire final pour l'employé $nom $prenom d'identifiant $id est : $salaire_final";
    echo"< br >";
}

$designation="Salaire finale";
$valeur= $salaire_final;

$sql2 = "INSERT INTO bulletin (id_employe, designation, valeur,date) VALUES (?, ?, ?,?)";
$stmt2 = $bd->prepare($sql2);
$stmt2->bindValue(1, $id, PDO::PARAM_INT);
$stmt2->bindValue(2, $designation, PDO::PARAM_STR);
$stmt2->bindValue(3, $valeur, PDO::PARAM_STR);
$stmt2->bindValue(4, $date, PDO::PARAM_STR);
$stmt2->execute();
header('Location: afficher.php?nom=' . urlencode($nom) . '&prenom=' . urlencode($prenom) . '&date=' . urlencode($dateForm));

}

 /*********************************************************************************************************/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    
</body>

</html>
