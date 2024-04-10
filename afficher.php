
<?php
include_once 'espacerp.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Informations de l'employé</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 0 auto;
            width: 70%;
            color: #000000;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #FFFFFF;
            color: #000000;
        }

        tr:last-child {
            background-color: #D6EAF8;
        }

        .export-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .export-buttons button {
            background-color: #87CEFA;
            color: #FFFFFF;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            margin: 0 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
    // Établir une connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "atelier_web";

    $nom = $_GET['nom'];
    $prenom = $_GET['prenom'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    // Rechercher l'employé dans la table "employe"
    $sql_employe = "SELECT * FROM employe WHERE nom='$nom' AND prenom='$prenom'";
    $result_employe = $conn->query($sql_employe);

    if ($result_employe->num_rows > 0) {
        // Employé trouvé, récupérer ses informations
        $row_employe = $result_employe->fetch_assoc();

        // Sélectionner les champs de la table "bulletin" pour l'employé spécifique
        $sql_bulletin = "SELECT designation, valeur FROM bulletin WHERE id_employe=" . $row_employe["idEmploye"];
        $result_bulletin = $conn->query($sql_bulletin);

        // Afficher les informations de l'employé
        echo "<br>";
        echo "<table style=' margin-left: 300px ;'>";
        echo "<tr>";
        echo "<th colspan='2'>Informations de l'employé</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Situation</strong></td>";
        echo "<td>{$row_employe['situation']}</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Nom</strong></td>";
        echo "<td>{$row_employe['nom']}</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><strong>Prénom</strong></td>";
        echo "<td>{$row_employe['prenom']}</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Date de naissance</td>";
        echo "<td>{$row_employe['date_naissance']}</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Genre</td>";
        echo "<td>";
        
        // Vérifier la valeur du genre
        if ($row_employe['genre'] == 'M') {
            echo "Masculin";
        } elseif ($row_employe['genre'] == 'F') {
            echo "Féminin";
        }
        
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Adresse</td>";
        echo "<td>{$row_employe['adresse']}</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Numéro de téléphone</td>";
        echo "<td>{$row_employe['numero_tel']}</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>E-mail</td>";
        echo "<td>{$row_employe['e_mail']}</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Poste</td>";
        echo "<td>{$row_employe['poste']}</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Date d'embauche</td>";
        echo "<td>{$row_employe['date_embauche']}</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td style='font-weight: bold;'>Salaire de base</td>";
        echo "<td>{$row_employe['salaire_base']}</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Nombre d'enfants</td>";
        echo "<td>{$row_employe['nbrEnfant']}</td>";
        echo "</tr>";
        echo "</table>";

        echo "<br>"; // Espacement entre les informations de l'employé et le tableau des bulletins de paie

        // Afficher le tableau des bulletins de paie
        echo "<table style='margin-left: 300px  '>";
        echo "<tr>";
        echo "<th>Designation</th>";
        echo "<th>Valeur</th>";
        echo "</tr>";

        if ($result_bulletin->num_rows > 0) {
            $row_count = 0; // Compteur de lignes

            while ($row_bulletin = $result_bulletin->fetch_assoc()) {
                $designation = $row_bulletin["designation"];
                $valeur = $row_bulletin["valeur"];

                $row_count++; // Incrémenter le compteur de lignes

                echo "<tr>";
                echo "<td><strong>$designation</strong></td>";
                echo "<td>$valeur</td>";
                echo "</tr>";

                // Vérifier si c'est la dernière ligne
                if ($row_count == $result_bulletin->num_rows) {
                    echo "<tr>";
                    echo "<td><strong>Salaire Final</strong></td>";
                    echo "<td>$valeur</td>";
                    echo "</tr>";
                }
            }
        } else {
            echo "<tr>";
            echo "<td colspan='2'>Aucun résultat trouvé.</td>";
            echo "</tr>";
        }

        echo "</table>";

        // Boutons d'exportation
        echo "<div class='export-buttons'>";
        echo "<form action='exportD_pdf.php?nom=$nom&prenom=$prenom' method='post'>";
        echo "<button type='submit'>Exporter en PDF</button>";
        echo "</form>";

        echo "<form action='exportD_excel.php?nom=$nom&prenom=$prenom' method='post'>";
        echo "<button type='submit'>Exporter en Excel</button>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "Aucun employé trouvé avec ce nom et prénom.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>
</body>
</html>
