<?php
require("../config/config.php");
require("../config/session.php"); 

require_once('../resources/tcpdf/tcpdf.php'); // Adjust the path to TCPDF library

// Get the data from the database
$stmt = $db->prepare("SELECT tr.id, tr.tanggal, tr.jam, lk.nama_kendaraan, ty.nama_type, h.harga, acc.id AS customers_id, acc.nama_lengkap, tr.status FROM transaksi AS tr
JOIN list_kendaraan AS lk ON tr.kendaraan_id = lk.id
JOIN type AS ty ON lk.type_id = ty.id
JOIN harga AS h ON ty.id = h.type_id
JOIN accounts AS acc ON lk.customers_id = acc.id");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        // $image_file = K_PATH_IMAGES.'logo_example.jpg';

        $image_file = '../resources/img/logo2.jpg';
        $this->Image($image_file, 10, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $headerText = 'KATIGA CARWASH';
        $this->SetFont('courier', 'B', 20);
        $this->SetXY(115, 10);
        $this->Cell(0, 10, $headerText, 0, false, 'L', 0, '', 0, false, 'T', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('courier', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Create PDF object
// $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
// $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8');

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Katiga Carwash');
$pdf->SetTitle('Log Booking');
$pdf->SetSubject('Report');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('courier', '', 12);

// Write content
$pdf->Write(5, 'Log Booking', '', 0, 'C', true, 0, false, false, 0);

$pdf->Ln(10); // Add a new line

// Display the fetched data in a table
$pdf->SetFont('courier', 'B', 11);
// $pdf->Cell(40, 10, 'ID', 1, 0, 'C');
$pdf->Cell(30, 10, 'Tanggal', 1, 0, 'C');
$pdf->Cell(25, 10, 'Jam', 1, 0, 'C');
$pdf->Cell(50, 10, 'Nama Kendaraan', 1, 0, 'C');
$pdf->Cell(50, 10, 'Tipe Kendaraan', 1, 0, 'C');
$pdf->Cell(75, 10, 'Customer', 1, 0, 'C');
$pdf->Cell(50, 10, 'Status', 1, 1, 'C');


$pdf->SetFont('courier', '', 11);
foreach ($data as $row) {
    // $pdf->Cell(40, 10, $row['id'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['tanggal'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['jam'], 1, 0, 'C');
    $pdf->Cell(50, 10, $row['nama_kendaraan'], 1, 0, 'L');
    $pdf->Cell(50, 10, $row['nama_type'], 1, 0, 'L');
    $pdf->Cell(75, 10, $row['nama_lengkap'], 1, 0, 'L');
    $pdf->Cell(50, 10, $row['status'], 1, 1, 'L');

}

// Output the PDF
$pdf->Output('custom_report.pdf', 'I');
?>