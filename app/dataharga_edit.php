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
                text: "Ubah Harga Berhasil!",
                type: "success",
                timer: 2000,
                timerProgressBar: true,
            })
            .then(function(){
                window.location.href = '../viewadmin/data-harga.php';
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
                window.location.href = '../viewadmin/data-harga.php';
            });
        }
    </script>
</header>

<?php

require("../config/config.php");
require("../config/session.php"); 

$type_id = $_POST['type_id'];
$harga = $_POST['harga'];
$harga = preg_replace('/\D/', '', $_POST['harga']);

$id = $_GET["id"];

$query = "UPDATE harga SET type_id = '$type_id', harga = '$harga' WHERE id = '$id';";

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
