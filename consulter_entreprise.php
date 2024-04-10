<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; /* Ajout de la propriété flex-direction */
            height: 100vh;
            background-color: #f1f1f1;
        }

        h1 {
            color: blue;
            text-align: left;
        }

        h2 {
            margin-top: 20px;
            color: blue;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            margin-bottom: 20px; /* Ajout de la marge inférieure */
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="text"], input[type="submit"] {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: none;
        }

        input[type="submit"] {
            background-color: #87ceeb;
            color: #fff;
            cursor: pointer;
        }

        .add-rubrique-btn {
            background-color: #00008B;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-bottom: 20px; /* Ajout de la marge inférieure */
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
    $bd = new PDO("mysql:host=localhost;dbname=atelier_web;charset=UTF8", "root", "");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nomEntreprise = $_POST['nomEntreprise'];
        echo "<h1 style='color: #00008B;'>Rubrique de l'entreprise  $nomEntreprise</h1>";

        $sql = "SELECT id FROM entreprise WHERE nom = ?";
        $stmt = $bd->prepare($sql);
        $stmt->execute([$nomEntreprise]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $idEntreprise = $result['id'];

            $sqlRubriques = "SELECT * FROM rubrique WHERE identreprise = ?";
            $stmtRubriques = $bd->prepare($sqlRubriques);
            $stmtRubriques->execute([$idEntreprise]);
            $rubriques = $stmtRubriques->fetchAll(PDO::FETCH_ASSOC);

            if ($rubriques) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Nom</th></tr>";
                foreach ($rubriques as $rubrique) {
                    $idRubrique = $rubrique['idrubrique'];
                    $nomRubrique = $rubrique['libelle'];
                    echo "<tr><td>$idRubrique</td><td>$nomRubrique</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h1 style='color: #00008B;'>Rubrique de l'entreprise</h1>";
                echo "Aucune rubrique trouvée pour l'entreprise \"$nomEntreprise\"";
            }
        } else {
            echo "<h1 style='color: #00008B;'>Rubrique de l'entreprise</h1>";
            echo "Aucune entreprise trouvée avec le nom \"$nomEntreprise\"";
        }
    }
    ?>

    <button class="add-rubrique-btn" onclick="showForm()">Ajouter Rubrique</button>

    <div id="rubrique-form" style="display: none;">
        <h2>Ajouter une rubrique</h2>
        <form action="insert_rubrique.php" method="POST">
            <input type="hidden" name="idEntreprise" value="<?php echo $idEntreprise; ?>">
            <input type="text" name="libelleRubrique" placeholder="Libellé de la rubrique" required>
            <input type="submit" value="Envoyer">
        </form>
    </div>

    <script>
        function showForm() {
            var form = document.getElementById("rubrique-form");
            form.style.display = "block";
        }
    </script>
</body>
</html>
