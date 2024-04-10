<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    private $row_employe;
    private $firstPageHeader;

    public function setEmployeData($row_employe)
    {
        $this->row_employe = $row_employe;
        $this->firstPageHeader = true; // Initialiser le drapeau à true pour afficher les informations de l'employé dans la première page
    }

    // En-tête du PDF
    function Header()
    {
        // Vérifier si c'est la première page
        if ($this->firstPageHeader) {
            // Titre
            $this->SetFont('Arial', 'B', 15);
            $this->SetFillColor(0, 51, 102); // Bleu foncé
            $this->Cell(0, 15, "BULLETIN DE PAIE", 0, 1, 'C', true, 'B');
            $this->Ln(10);

            // Tableau pour les informations de contact et personnelles
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(95, 10, 'Contact', 1, 0, 'C', true, '', 176, 224, 230);
            $this->Cell(95, 10, 'Informations personnelles', 1, 1, 'C', true, '', 176, 224, 230);

            $this->SetFont('Arial', '', 12);
            $this->Cell(95, 10, 'Adresse', 1, 0, 'C');
            $this->Cell(95, 10, $this->row_employe['adresse'], 1, 1, 'C');
            $this->Cell(95, 10, 'Numero de telephone', 1, 0, 'C');
            $this->Cell(95, 10, $this->row_employe['numero_tel'], 1, 1, 'C');
            $this->Cell(95, 10, 'E-mail', 1, 0, 'C');
            $this->Cell(95, 10, $this->row_employe['e_mail'], 1, 1, 'C');
            $this->Cell(95, 10, 'Nom', 1, 0, 'C');
            $this->Cell(95, 10, $this->row_employe['nom'], 1, 1, 'C');
            $this->Cell(95, 10, 'Prenom', 1, 0, 'C');
            $this->Cell(95, 10, $this->row_employe['prenom'], 1, 1, 'C');
            $this->Cell(95, 10, 'Date de naissance', 1, 0, 'C');
            $this->Cell(95, 10, $this->row_employe['date_naissance'], 1, 1, 'C');
            $this->Cell(95, 10, 'Genre', 1, 0, 'C');
            $this->Cell(95, 10, ($this->row_employe['genre'] == 'm' ? 'Masculin' : 'Féminin'), 1, 1, 'C');

            $this->Ln(10);

            $this->firstPageHeader = false; // Mettre le drapeau à false pour ne pas répéter les informations de l'employé dans les pages suivantes
        }
    }

    // Pied de page du PDF
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        // Numéro de page
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Le reste du code reste inchangé...

// Le reste du code reste inchangé...

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

    // Créer une instance de PDF
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->setEmployeData($row_employe);
    $pdf->AddPage();

    // Ajouter le tableau des bulletins de paie
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(140, 10, 'Designation', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Valeur', 1, 1, 'C');

    if ($result_bulletin->num_rows > 0) {
        $salaire_final = ""; // Variable pour stocker la valeur du salaire final

        while ($row_bulletin = $result_bulletin->fetch_assoc()) {
            $designation = $row_bulletin["designation"];
            $valeur = $row_bulletin["valeur"];

            $pdf->Cell(140, 10, $designation, 1, 0, 'C');
            $pdf->Cell(50, 10, $valeur, 1, 1, 'C');

            if ($designation == "Salaire finale") {
                $salaire_final = $valeur;
            }
        }

        $pdf->Ln(10);

        // Ajouter la ligne du salaire final
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(140, 10, 'Salaire Final', 1, 0, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetFillColor(176, 224, 230);
        $pdf->Cell(50, 10, $salaire_final, 1, 1, 'C', true);

        // Générer le PDF
        $pdf->Output('I', 'informations_employe.pdf');
    } else {
        echo "Aucun bulletin de paie trouvé pour cet employé.";
    }
} else {
    echo "Aucun employé trouvé avec ce nom et prénom.";
}

$conn->close();
?>