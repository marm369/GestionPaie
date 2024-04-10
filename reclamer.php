<?php
include_once 'espaceemp.php';
?>

<!-- Votre formulaire HTML -->

<div class="container">
    <div class="card" style="width: 500px; margin: 50px auto; left: 150px;">
        <div class="card-body">
            <form method="POST" action="insere_reclamation.php">
                <div class="form-group">
                    <label for="datereclamation">Date de réclamation :</label>
                    <input type="date" id="datereclamation" name="datereclamation" class="form-control" required style="width: 100%; height: 40px; padding: 8px; margin-bottom: 10px;">
                </div>
                <div class="form-group">
                    <label for="objet">Objet de la réclamation :</label>
                    <input type="text" id="objet" name="objet" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="reclamation-text">Texte de la réclamation :</label><br>
                    <textarea id="reclamation-text" name="reclamation-text" style="width:360px; height:80px;" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="destinataire">Envoyé au :</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="destinataire" id="destinataireRH" value="RH" required>
                        <label class="form-check-label" for="destinataireRH">RH</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="destinataire" id="destinataireRP" value="RP" required>
                        <label class="form-check-label" for="destinataireRP">RP</label>
                    </div>
                </div>
                <br>  <br>
                <input type="submit" class="btn btn-success" name="envoyer" value="Envoyer">
                <input type="reset" class="btn btn-success" value="Annuler">
            </form>
        </div>
    </div>
</div>
