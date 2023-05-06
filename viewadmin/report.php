<?php
require("../config/config.php");
require("../config/session.php");

$query = "SELECT tr.id, tr.tanggal, tr.jam, lk.nama_kendaraan, ty.nama_type, h.harga, acc.id AS customers_id, acc.nama_lengkap, tr.status FROM transaksi AS tr
JOIN list_kendaraan AS lk ON tr.kendaraan_id = lk.id
JOIN type AS ty ON lk.type_id = ty.id
JOIN harga AS h ON ty.id = h.type_id
JOIN accounts AS acc ON lk.customers_id = acc.id 
WHERE tr.status = 'DATANG';";
try {
    $stmt = $db->prepare($query);
    $stmt->execute();
} catch (PDOException $ex) {
    die("Failed to run query: " . $ex->getMessage());
}
$rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel = "icon" href="../resources/img/logo2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <style>
        .report-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .report-header h1 {
            margin-top: 0;
            font-size: 48px;
        }

        .report-header p {
            font-size: 24px;
        }

        .fa-chart-bar {
            font-size: 64px;
            color: #007bff;
            margin-right: 20px;
        }

        @media only screen and (max-width: 768px) {
            table {
                width: 100%;
            }
        }
    </style>
</head>

<body onload="printReport()">
    <div class="container">
        <div class="report-header">
            <h3>
                <img src="../resources/img/logo2.png" alt="Logo" width="100" height="100">
                Laporan Booking
            </h3>
            <!-- <p>Ini adalah laporan contoh menggunakan HTML dan Bootstrap 5.</p> -->
        </div>
        <div class="table-responsive">
            <table class="table stripe row-border text-center table-bordered" id="" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Tanggal Booking</th>
                        <th class="text-center">Jam Booking</th>
                        <th class="text-center">Nama Kendaraan</th>
                        <th class="text-center">Type Kendaraan</th>
                        <th class="text-center">Nama Customer</th>
                        <!-- <th class="text-center">Status</th> -->
                        <th class="text-center">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($rows as $row) : ?>
                        <tr>
                            <td><?php echo $row['tanggal']; ?></td>
                            <td><?php echo $row['jam']; ?></td>
                            <td><?php echo $row['nama_kendaraan']; ?></td>
                            <td><?php echo $row['nama_type']; ?></td>
                            <td><?php echo $row['nama_lengkap']; ?></td>
                            <!-- <td><?php echo $row['status']; ?></td> -->
                            <td><?php echo "Rp. " . number_format($row['harga'],0,',','.');?></td>
                        </tr>
                        <?php include('./component/main_edit.php'); ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function printReport() {
            window.print();
        }
    </script>
</body>

</html>