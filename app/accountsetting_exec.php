<head>
<link rel = "icon" href="../resources/img/logoACJ.png" type="image/x-icon">
</head>
<header>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.5/sweetalert2.all.min.js" integrity="sha512-TxryOYMwWBRIlZoSkKW+jZvJ834vF3u8mE0jDeTLEDdPplOVNNZfWm9VFtEuW365BFPLK5CEIF/vaHqmAey8XA==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script type="text/javascript">
        function accountsetting_change(){
            swal.fire({ 
                icon: "success",
                text: "Perubahan Data Akun Berhasil!",
                type: "success",
            })
            .then(function(){
                window.location.href = '../config/logout.php';
            });
        }
        function accountsetting_error(){
            swal.fire({ 
                icon: "error",
                text: "Data Error !",
                type: "error",
                timer: 5000,
                timerProgressBar: true
            })
            .then(function(){
                window.location.href = '../viewadmin/index.php';
            });
        }
    </script>
</header>

<?php

error_reporting(0);
require("../config/config.php");
require("../config/session.php"); 

$id = $_SESSION['id'];

$email = $_POST['email'];
$password = $_POST['password'];
$nama_lengkap = $_POST['nama_lengkap'];
$no_telp = $_POST['no_telp'];

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$nama_lengkap = filter_input(INPUT_POST, 'nama_lengkap', FILTER_SANITIZE_STRING);

$password = password_hash($password, PASSWORD_DEFAULT);

$query = "UPDATE accounts SET email = '$email', password = '$password', nama_lengkap = '$nama_lengkap', no_telp = '$no_telp'
WHERE id = '$id'; ";

try
{ 
    $stmt = $db->prepare($query); 
    $result = $stmt->execute();
    
    echo "<script>
    accountsetting_change();
    </script>";
}
catch(PDOException $ex)
{
    die("Failed to run query: " . $ex->getMessage());

    // echo "<script>
    // accountsetting_error();
    // </script>";
}

?>
