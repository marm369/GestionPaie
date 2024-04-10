<!DOCTYPE html>
<html>
<head>
    <title>Conges</title>
    <style>
           .overlay {
           top: 0;
           left: 0;
           width: 100%;
           height: 100%;
           background-color: rgba(0, 0, 0, 0.5);
           display: flex;
           justify-content: center;
           align-items: center;
           z-index: 999;
           position: fixed;
           display: none;
       }

       .form-container {
           z-index: 9999;
           background-color: white;
           padding: 20px;
           border-radius: 5px;
           box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
           position: relative;
       }

       .close-button {
           position: absolute;
           top: 10px;
           right: 10px;
           cursor: pointer;
       }

       .submit-button {
           margin-top: 10px;
           cursor: pointer;
       }
    </style>
</head>
<body>
    <?php
    include_once 'espacerh.php';
    require('connectbdd.php');
    // Requête pour récupérer les congés avec un statut de 0
    $sql = "SELECT * FROM conge WHERE statut = 0 AND reponse = ''";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container" style="width: 700px; margin: 80px auto; margin-left: 500px;">
        <h1>Conge</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>typeconge</th>
                    <th>datdebut</th>
                    <th>datefin</th>
                    <th>Employé</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?php echo $row['typeconge']; ?></td>
                        <td><?php echo $row['datedebut']; ?></td>
                        <td><?php echo $row['datefin']; ?></td>
                        <td>
                            <?php
                            $idEmploye = $row['id_employe'];
                            $sqlEmploye = "SELECT * FROM employe WHERE idEmploye = :idEmploye";
                            $stmtEmploye = $bdd->prepare($sqlEmploye);
                            $stmtEmploye->bindParam(':idEmploye', $idEmploye);
                            $stmtEmploye->execute();
                            $rowEmploye = $stmtEmploye->fetch(PDO::FETCH_ASSOC);
                            echo $rowEmploye['nom'] . ' ' . $rowEmploye['prenom'];
                            ?>
                        </td>
                        <td>
                            <a class="btn btn-success" href="update_conge.php?id=<?php echo $row['idconge']; ?>">Valider</a>
                            <a class="btn btn-danger" href="#rejeter" onclick="showDeleteForm(event, <?php echo $row['idconge']; ?>)">Rejeter</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="overlay" id="overlay">
        <div class="form-container" >
            <span class="close-button" onclick="hideDeleteForm()">&times;</span>
            <form action="rejeter_conge.php" method="POST">
                <input type="hidden" id="congeId" name="congeId" value="">
                <label for="justification">Justification :</label><br>
                <textarea id="justification" name="justification" rows="4" cols="30"></textarea><br><br>
                <button class="btn btn-primary" type="submit">Envoyer</button>
            </form>
        </div>
    </div>





    <script>
        function showDeleteForm(id) {
            document.getElementById('overlay').style.display = 'flex';
        }

        function hideDeleteForm() {
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</body>
</html>
