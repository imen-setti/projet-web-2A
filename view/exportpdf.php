<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once('C:\xampp\htdocs\nada\controller\config.php');

// Définir les constantes TCPDF si elles ne sont pas déjà définies
if (!defined('K_TCPDF_EXTERNAL_CONFIG')) {
    define('K_TCPDF_EXTERNAL_CONFIG', true);
    define('K_PATH_IMAGES', ''); // Répertoire des images
    define('PDF_HEADER_LOGO', ''); // Logo par défaut
    define('PDF_HEADER_LOGO_WIDTH', 30); // Largeur du logo
    define('PDF_UNIT', 'mm'); // Unité de mesure
    define('PDF_PAGE_FORMAT', 'A4'); // Format de page
}

// Vérifie que les paramètres existent
if (!isset($_GET['id']) || !isset($_GET['paiement_id'])) {
    die('ID ou paiement_id manquant.');
}

$id = intval($_GET['id']);
$paiement_id = intval($_GET['paiement_id']);

// Connexion DB
$conn = config::getConnexion();

// Récupération des données de la facture
$stmt = $conn->prepare("SELECT * FROM facture WHERE id = ?");
$stmt->execute([$id]);
$facture = $stmt->fetch();

if (!$facture) {
    die('Facture non trouvée.');
}

// Récupération des données du paiement
$stmt = $conn->prepare("SELECT * FROM paiement WHERE id = ?");
$stmt->execute([$paiement_id]);
$paiement = $stmt->fetch();

// Vérifier la disponibilité des extensions d'image
$has_gd = extension_loaded('gd') && function_exists('gd_info');
$has_imagick = extension_loaded('imagick');

// Création d'une classe personnalisée pour le PDF
class MYPDF extends TCPDF {
    protected $has_image_support = false;
    
    public function setImageSupport($has_support) {
        $this->has_image_support = $has_support;
    }
    
    public function Header() {
        // Titre de l'entreprise (pas besoin d'extension d'image)
        $this->SetFont('helvetica', 'B', 20);
        $this->SetY(15);
        $this->SetX(20);
        $this->Cell(0, 10, 'ESPRIT', 0, false, 'L');
        
        // Logo uniquement si support d'image disponible
        if ($this->has_image_support) {
            $image_file = 'back-office/assets/img/logo-ct-dark.png';
            if (file_exists($image_file)) {
                $this->Image($image_file, 170, 15, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            }
        }
        
        // Information de l'entreprise
        $this->SetFont('helvetica', '', 10);
        $this->SetY(25);
        $this->SetX(20);
        $this->Cell(0, 5, 'Adresse: 123 Esprit, Ariana, Tunis', 0, false, 'L');
        $this->SetY(30);
        $this->SetX(20);
        $this->Cell(0, 5, 'Tél: +216 00 000 000 | Email: nada@esprit.tn', 0, false, 'L');
        
        // Ligne de séparation
        $this->SetY(40);
        $this->SetDrawColor(200, 200, 200);
        $this->Line(20, 40, $this->getPageWidth()-20, 40);
    }
    
    public function Footer() {
        // Position à 15 mm du bas
        $this->SetY(-15);
        // Police
        $this->SetFont('helvetica', 'I', 8);
        // Texte du footer
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C');
        $this->SetY(-10);
        $this->Cell(0, 10, 'Merci de faire affaire avec nous!', 0, false, 'C');
    }
}

// Création du PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// Définir si le PDF peut utiliser des images
$pdf->setImageSupport($has_gd || $has_imagick);

// Configuration de base du PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Votre Entreprise');
$pdf->SetTitle('Facture #' . $facture['numero_facture']);
$pdf->SetSubject('Facture PDF');
$pdf->SetMargins(20, 45, 20);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->AddPage();

// Date et référence de facture
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 15, 'FACTURE N° ' . $facture['numero_facture'], 0, 1, 'R');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 5, 'Date: ' . date('d/m/Y', strtotime($facture['date_facture'])), 0, 1, 'R');
$pdf->Ln(10);

// Informations client
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'INFORMATIONS CLIENT', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->SetFillColor(245, 245, 245);

$html = '
<table cellspacing="0" cellpadding="5" border="0">
    <tr>
        <td width="25%" style="font-weight: bold; background-color: #f5f5f5;">Client:</td>
        <td width="75%">' . $facture['client_nom'] . '</td>
    </tr>
 
</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(5);

// Détails du paiement
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'DÉTAILS DU PAIEMENT', 0, 1, 'L');

if ($paiement) {
    $html = '
    <style>
        table.payment {
            width: 100%;
            border-collapse: collapse;
        }
        table.payment th {
            background-color: #333;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 7px;
        }
        table.payment td {
            padding: 7px;
            border-bottom: 1px solid #ddd;
        }
        table.payment tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
    
    <table class="payment" cellspacing="0" cellpadding="5">
        <tr>
            <th width="25%">Méthode</th>
            <th width="25%">Montant</th>
            <th width="25%">Devise</th>
            <th width="25%">N° Carte</th>
        </tr>
        <tr>
            <td align="center">' . $paiement['methode'] . '</td>
            <td align="center">' . $paiement['montant'] . '</td>
            <td align="center">' . $paiement['devise'] . '</td>
            <td align="center">' . $paiement['carte'] . '</td>
        </tr>
    </table>';
} else {
    $html = '<p>Aucune information de paiement disponible.</p>';
}

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(5);

// Récapitulatif de la facture
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'RÉCAPITULATIF', 0, 1, 'L');

$html = '
<style>
    table.recap {
        width: 100%;
        border-collapse: collapse;
    }
    table.recap td.label {
        width: 70%;
        text-align: right;
        padding: 5px;
        border-bottom: 1px solid #ddd;
    }
    table.recap td.value {
        width: 30%;
        text-align: right;
        padding: 5px 15px 5px 5px;
        border-bottom: 1px solid #ddd;
    }
    table.recap tr.total {
        background-color: #f5f5f5;
        font-weight: bold;
    }
</style>

<table class="recap" cellspacing="0" cellpadding="5">
    <tr>
        <td class="label">Sous-total:</td>
        <td class="value">' . $facture['montant_total'] . ' ' . ($paiement ? $paiement['devise'] : 'TND') . '</td>
    </tr>
    <tr>
        <td class="label">TVA (19%):</td>
        <td class="value">' . number_format($facture['montant_total'] * 0.19, 2) . ' ' . ($paiement ? $paiement['devise'] : 'TND') . '</td>
    </tr>
    <tr class="total">
        <td class="label">TOTAL:</td>
        <td class="value">' . number_format($facture['montant_total'] * 1.19, 2) . ' ' . ($paiement ? $paiement['devise'] : 'TND') . '</td>
    </tr>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(10);

// Statut et notes
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(30, 5, 'Statut: ', 0, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 5, $facture['statut'], 0, 1, 'L');

if (!empty($facture['description'])) {
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(30, 10, 'Notes: ', 0, 0, 'L');
    $pdf->SetFont('helvetica', '', 10);
    $pdf->MultiCell(0, 5, $facture['description'], 0, 'L');
}

// Lien vers la facture en ligne
$pdf->Ln(10);
$link = 'http://localhost/nada/view/facture_show.php?id=' . $facture['id'] . '&paiement_id=' . $paiement_id;
$pdf->SetTextColor(0, 0, 255);
$pdf->SetFont('helvetica', 'U', 9);
$pdf->Cell(0, 5, 'Voir la facture dans le système', 0, 1, 'C', false, $link);

// QR Code seulement si GD est disponible
if ($has_gd) {
    $style = array(
        'border' => false,
        'padding' => 0,
        'fgcolor' => array(0,0,0),
        'bgcolor' => false
    );
    $pdf->write2DBarcode($link, 'QRCODE,L', 155, 240, 30, 30, $style, 'N');
}

// Sortie du PDF
$pdf->Output('facture_' . $facture['numero_facture'] . '.pdf', 'I');
?>
