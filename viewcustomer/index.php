<?php 
require("../config/config.php");
require("../config/session.php");

// error_reporting(0);

$customers_id = $_SESSION['id'];

$query = "SELECT tr.id, tr.tanggal, tr.jam, lk.nama_kendaraan,  tr.status FROM transaksi AS tr 
JOIN list_kendaraan AS lk ON tr.kendaraan_id = lk.id WHERE tr.customers_id = '$customers_id' ;"; 
try 
{ 
    $stmt = $db->prepare($query); 
    $stmt->execute(); 
} 
catch(PDOException $ex) 
{ 
    die("Failed to run query: " . $ex->getMessage()); 
} 
$rows = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'page-header.php'?>

<body class="bg-light">
  <title>Halaman Utama - Katiga Carwash</title>
  <main class="container">
    <div class="p-3 my-3 bg-body rounded shadow-sm">
      <div class="text-center mb-4">
          <img class="mb-1" src="../resources/img/logo2.png" alt="100" height="100" width="100" role="img">
          <h1 class="h3 mb-1 font-weight-normal">Katiga Carwash</h1>
          <!-- <p>Build form controls with floating labels via the <code>:placeholder-shown</code> pseudo-element. <a href="https://caniuse.com/#feat=css-placeholder-shown">Works in latest Chrome, Safari, and Firefox.</a></p> -->
      </div>

      <button type="button" class="btn btn-dark my-3" data-bs-toggle="modal" data-bs-target="#main_add"><i class="fa-solid fa-plus"></i>
        Isi Booking
      </button>
      <?php include('./component/main_add.php'); ?>
      
      <div class="table-responsive">
        <table class="table stripe row-border text-center table-bordered caption-top" id="" width="100%" cellspacing="0">
          <caption>History Booking Carwash</caption>
          <thead>
            <tr>
              <th class="text-center">Tanggal Booking</th>
              <th class="text-center">Jam Booking</th>
              <th class="text-center">Nama Kendaraan</th>
              <th class="text-center">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; foreach($rows as $row): ?> 
                <tr>
                    <td><?php echo $row['tanggal']; ?></td>
                    <td><?php echo $row['jam']; ?></td>
                    <td><?php echo $row['nama_kendaraan']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <small class="text-muted fst-italic d-flex justify-content-end">Hubungi nomor Admin jika terjadi perubahan pada pemesanan </small>
      </div>
    </div>
  </main>

  <?php include 'page-footer.php' ?>
  <script>
    $(document).ready(function() {
            $('table.table').DataTable({
              "lengthChange": false,
              "bPaginate": false,
            });

            const fpDatepicker = flatpickr("#datepicker", {
              enableTime: false,
              altInput: false,
              altFormat: "j F Y",
              dateFormat: "Y-m-d",
              minDate: "today",
              maxDate: new Date().fp_incr(14)
            });

            const fpTimepicker = flatpickr("#timepicker", {
              enableTime: true,
              noCalendar: true,
              dateFormat: "H:i",
              time_24hr: true,
              minTime: "08:00",
              maxTime: "18:00",
              minuteIncrement: 30
            });

            const now = new Date();
            fpDatepicker.setDate(now, true, "Y-m-d");
            fpTimepicker.setDate(now, true, "H:i");
        });
  </script>
</body>

</html>