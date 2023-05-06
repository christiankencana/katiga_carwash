<head>
<link rel = "icon" href="../resources/img/logoACJ.png" type="image/x-icon">
</head>
<header>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.5/sweetalert2.all.min.js" integrity="sha512-TxryOYMwWBRIlZoSkKW+jZvJ834vF3u8mE0jDeTLEDdPplOVNNZfWm9VFtEuW365BFPLK5CEIF/vaHqmAey8XA==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script type="text/javascript">
        function info_success(){
            swal.fire({ 
                icon: "success",
                text: "Ubah Kendaraan Berhasil!",
                type: "success",
                timer: 2000,
                timerProgressBar: true,
            })
            .then(function(){
                window.location.href = '../viewcustomer/kendaraan.php';
            });
        }
        function info_failed(){
            swal.fire({
                icon: "error",
                text: "Data Error!",
                type: "error",
                timer: 5000,
                timerProgressBar: true,
            })
            .then(function(){
                window.location.href = '../viewcustomer/kendaraan.php';
            });
        }
    </script>
</header>

<?php

require("../config/config.php");
require("../config/session.php"); 

$customers_id = $_SESSION['id'];
$type_id = $_POST['type_id'];
$nama_kendaraan = $_POST['nama_kendaraan'];

$id = $_GET["id"];

$query = "UPDATE list_kendaraan SET nama_kendaraan = '$nama_kendaraan', type_id = '$type_id', customers_id = '$customers_id' WHERE id = '$id' ";

try
{ 
    $stmt = $db->prepare($query); 
    $result = $stmt->execute();
    
    echo "<script>
    info_success();
    </script>";
}
catch(PDOException $ex)
{
    // die("Failed to run query: " . $ex->getMessage());

    echo "<script>
    info_failed();
    </script>";
}

?>
