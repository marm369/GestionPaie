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

if ($result_employe->num_rows > 0) 
{
    // Employé trouvé, récupérer ses informations
    $row_employe = $result_employe->fetch_assoc();

    // Sélectionner les champs de la table "bulletin" pour l'employé spécifique
    $sql_bulletin = "SELECT designation, valeur FROM bulletin WHERE id_employe=" . $row_employe["idEmploye"];
    $result_bulletin = $conn->query($sql_bulletin);

    if ($result_bulletin->num_rows > 0) {
        // Définir les entêtes de réponse pour le téléchargement du fichier Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="bulletin.xls"');

        // Créer le contenu HTML de la page Excel
        $content = '<table>';
        $content .= '<tr><th>Designation</th><th>Valeur</th></tr>';

        while ($row_bulletin = $result_bulletin->fetch_assoc()) {
            $content .= '<tr>';
            $content .= '<td>' . $row_bulletin["designation"] . '</td>';
            $content .= '<td>' . $row_bulletin["valeur"] . '</td>';
            $content .= '</tr>';
        }

        $content .= '</table>';

        // Afficher le contenu HTML
        echo $content;
    } else {
        echo "Aucun résultat trouvé pour le bulletin de paie.";
    }
} else {
    echo "Aucun employé trouvé avec ce nom et prénom.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
