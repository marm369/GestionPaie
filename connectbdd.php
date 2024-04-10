<?php
try {
    $bdd = new PDO("mysql:host=localhost;dbname=atelier_web", 'root', '', array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Activer les rapports d'erreurs
        PDO::ATTR_EMULATE_PREPARES => false // Désactiver le mode d'émulation de requête
    ));
} catch (PDOException $exc) {
    echo "erreur de connexion : " . $exc->getMessage();
}

