<?php
require("../config/config.php");
require("../config/session.php"); 

require_once('../resources/tcpdf/tcpdf.php'); // Adjust the path to TCPDF library

$tahun2 = $_GET['tahun2'];

// Get the data from the database
$stmt = $db->prepare("SELECT merged.bulan, merged.tahun, COALESCE(success.data_success, 0) AS data_success, COALESCE(failed.data_failed, 0) AS data_failed, COALESCE(jual.data_jual_success, 0) AS data_jual_success, COALESCE(jual_failed.data_jual_failed, 0) AS data_jual_failed
FROM (
    SELECT MONTHNAME(tanggal) AS bulan, YEAR(tanggal) AS tahun
    FROM transaksi 
	WHERE YEAR(tanggal) = '$tahun2'
    GROUP BY MONTHNAME(tanggal), YEAR(tanggal)
) AS merged
LEFT JOIN (
    SELECT MONTHNAME(tanggal) AS bulan, YEAR(tanggal) AS tahun, COUNT(*) AS data_success
    FROM transaksi
    WHERE status = 'Datang' AND YEAR(tanggal) = '$tahun2'
    GROUP BY MONTHNAME(tanggal), YEAR(tanggal)
) AS success ON merged.bulan = success.bulan AND merged.tahun = success.tahun
LEFT JOIN (
    SELECT MONTHNAME(tanggal) AS bulan, YEAR(tanggal) AS tahun, COUNT(*) AS data_failed
    FROM transaksi
    WHERE status = 'Tidak Datang' AND YEAR(tanggal) = '$tahun2'
    GROUP BY MONTHNAME(tanggal), YEAR(tanggal)
) AS failed ON merged.bulan = failed.bulan AND merged.tahun = failed.tahun
LEFT JOIN (
    SELECT MONTHNAME(tanggal) AS bulan, YEAR(tanggal) AS tahun, SUM(h.harga) AS data_jual_success
    FROM transaksi AS tr
    JOIN list_kendaraan AS lk ON tr.kendaraan_id = lk.id
    JOIN type AS ty ON lk.type_id = ty.id
    JOIN harga AS h ON ty.id = h.type_id
    WHERE status = 'Datang' AND YEAR(tanggal) = '$tahun2'
    GROUP BY MONTHNAME(tanggal), YEAR(tanggal)
) AS jual ON merged.bulan = jual.bulan AND merged.tahun = jual.tahun
LEFT JOIN (
    SELECT MONTHNAME(tanggal) AS bulan, YEAR(tanggal) AS tahun, SUM(h.harga) AS data_jual_failed
    FROM transaksi AS tr
    JOIN list_kendaraan AS lk ON tr.kendaraan_id = lk.id
    JOIN type AS ty ON lk.type_id = ty.id
    JOIN harga AS h ON ty.id = h.type_id
    WHERE status = 'Tidak Datang' AND YEAR(tanggal) = '$tahun2'
    GROUP BY MONTHNAME(tanggal), YEAR(tanggal)
) AS jual_failed ON merged.bulan = jual_failed.bulan AND merged.tahun = jual_failed.tahun
ORDER BY merged.tahun, MONTH(STR_TO_DATE(CONCAT('2000-', merged.bulan, '-01'), '%Y-%M-%d'));");
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
$pdf->SetTitle('Laporan Booking Tahunan');
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
$pdf->Write(5, 'Laporan Booking Tahunan', '', 0, 'C', true, 0, false, false, 0);

$pdf->Ln(10); // Add a new line

// Display the fetched data in a table
$pdf->SetFont('courier', 'B', 11);
// $pdf->Cell(40, 10, 'ID', 1, 0, 'C');
$pdf->Cell(25, 10, 'Bulan', 1, 0, 'C');
$pdf->Cell(25, 10, 'Tahun', 1, 0, 'C');
$pdf->Cell(50, 10, 'Booking Berhasil', 1, 0, 'C');
$pdf->Cell(50, 10, 'Booking Gagal', 1, 0, 'C');
$pdf->Cell(55, 10, 'Total Booking Berhasil', 1, 0, 'C');
$pdf->Cell(55, 10, 'Total Booking Gagal', 1, 1, 'C');


$pdf->SetFont('courier', '', 11);
foreach ($data as $row) {
    // $pdf->Cell(40, 10, $row['id'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['bulan'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['tahun'], 1, 0, 'C');
    $pdf->Cell(50, 10, $row['data_success'], 1, 0, 'L');
    $pdf->Cell(50, 10, $row['data_failed'], 1, 0, 'L');
    $pdf->Cell(55, 10, $row['data_jual_success'], 1, 0, 'L');
    $pdf->Cell(55, 10, $row['data_jual_failed'], 1, 1, 'L');

}

// Output the PDF
$pdf->Output('custom_report.pdf', 'I');
?>