<?php
include_once 'espaceemp.php';
$id = $_SESSION['identificateur'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bulletin de paie</title>
    <style>
        #cadreGlobal {
            border: 1px solid #000;
            padding: 20px;
            width: 70%;
            margin: 0 auto;
            position:absolute;
            margin-top: 60px;
            margin-left:25%;
        }
        #cadre {
            border: 1px solid #000;
            padding: 10px;
         
        }
        #bulletin {
            border-collapse: collapse;
            width: 100%;
        }
        #bulletin th,
        #bulletin td {
            border: 1px solid #000;
            padding: 8px;
        }
        #bulletin th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
      
    </style>
</head>
<body>
    <div id="cadreGlobal">
        <?php
   require('connectbdd.php');

        $sql = "SELECT * FROM employe WHERE idEmploye = :id";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) 
        {
            // Affichage du cadre avec les informations personnelles de l'employé
            echo '<div id="cadre">';
            echo '<h1>Informations personnelles</h1>';
            echo '<p><strong>Nom :</strong> ' . $result['nom'] . '</p>';
            echo '<p><strong>Prénom :</strong> ' . $result['prenom'] . '</p>';
            echo '<p><strong>Téléphone :</strong> ' . $result['numero_tel'] . '</p>';
            echo '<p><strong>Adresse :</strong> ' . $result['adresse'] .'</p>';
            echo '<p><strong>Date d\'embauche :</strong> ' . $result['date_embauche'] . '</p>';
            echo '<p><strong>Poste :</strong> ' . $result['poste'] . '</p>';
            // Ajoutez ici d'autres informations personnelles de l'employé
            echo '</div>';

            // Requête pour récupérer le bulletin de paie de l'employé
            $sql1 = "SELECT * FROM bulletin WHERE id_employe = :id";
        
        $stmt1= $bdd->prepare($sql1);
        $stmt1->bindParam(':id', $id);
        $stmt1->execute();
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

            if ($result1) {
                // Bulletin de paie trouvé, affichage de la table

                // Affichage de la table pour le bulletin de paie
                echo '<table id="bulletin">';
                echo '<tr>';
                echo '<th>Designation</th>';
                echo '<th>Valeur</th>';
                echo '</tr>';

                // Parcourir les lignes du bulletin de paie
                foreach ($result1 as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['designation'] . '</td>';
                    echo '<td>' . $row['valeur'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';

                // Affichage du cadre avec le salaire final et la date
                $salaireFinal = 0; // Remplacez par le calcul du salaire final
                $dateBulletin = date("Y-m-d"); // Date actuelle

                echo '<div id="cadre">';
                echo '<p><strong>Salaire final :</strong> ' . $row['valeur']. '</p>';
                echo '<p><strong>Date :</strong> ' . $dateBulletin . '</p>';
                echo '</div>';
            } else {
                echo "Aucun bulletin de paie trouvé pour cet employé.";
            }
        } else {
            echo "Employé non trouvé.";
        }

     
        ?>
    </div>
</body>
</html>
