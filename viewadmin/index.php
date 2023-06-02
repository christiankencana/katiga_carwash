<?php
require("../config/config.php");
require("../config/session.php");

$query1 = "SELECT MONTHNAME(tanggal) AS bulan, COALESCE(COUNT(*), 0) AS data_success
FROM (SELECT 1 AS january UNION SELECT 2 AS february UNION SELECT 3 AS march UNION SELECT 4 AS april UNION SELECT 5 AS may UNION SELECT 6 AS june UNION SELECT 7 AS july UNION SELECT 8 AS august UNION SELECT 9 AS september UNION SELECT 10 AS october UNION SELECT 11 AS november UNION SELECT 12 AS december) AS bulan_pilihan
LEFT JOIN transaksi ON MONTH(tanggal) = bulan_pilihan.january
WHERE status = 'Datang'
GROUP BY bulan
ORDER BY MONTH(tanggal);
"; 
try 
{ 
    $stmt = $db->prepare($query1); 
    $stmt->execute(); 
} 
catch(PDOException $ex) 
{ 
    die("Failed to run query: " . $ex->getMessage()); 
} 
$bulan1 = array();
$data_success = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $bulan1[] = $row['bulan'];
    $data_success[] = $row['data_success'];
}
$data_bulan1 = json_encode($bulan1);
$data_success = json_encode($data_success);


$query2 = "SELECT MONTHNAME(tanggal) AS bulan, COALESCE(COUNT(*), 0) AS data_failed
FROM (SELECT 1 AS january UNION SELECT 2 AS february UNION SELECT 3 AS march UNION SELECT 4 AS april UNION SELECT 5 AS may UNION SELECT 6 AS june UNION SELECT 7 AS july UNION SELECT 8 AS august UNION SELECT 9 AS september UNION SELECT 10 AS october UNION SELECT 11 AS november UNION SELECT 12 AS december) AS bulan_pilihan
LEFT JOIN transaksi ON MONTH(tanggal) = bulan_pilihan.january
WHERE status = 'Tidak Datang'
GROUP BY bulan
ORDER BY MONTH(tanggal);
"; 
try 
{ 
    $stmt = $db->prepare($query2); 
    $stmt->execute(); 
} 
catch(PDOException $ex) 
{ 
    die("Failed to run query: " . $ex->getMessage()); 
} 
$bulan2 = array();
$data_failed = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $bulan2[] = $row['bulan'];
    $data_failed[] = $row['data_failed'];
}
$data_bulan2 = json_encode($bulan2);
$data_failed = json_encode($data_failed);


$query3 = "SELECT MONTHNAME(tanggal) AS bulan, SUM(h.harga) AS data_jual
FROM (SELECT 1 AS january UNION SELECT 2 AS february UNION SELECT 3 AS march UNION SELECT 4 AS april UNION SELECT 5 AS may UNION SELECT 6 AS june UNION SELECT 7 AS july UNION SELECT 8 AS august UNION SELECT 9 AS september UNION SELECT 10 AS october UNION SELECT 11 AS november UNION SELECT 12 AS december) AS bulan_pilihan
LEFT JOIN transaksi AS tr ON MONTH(tanggal) = bulan_pilihan.january
JOIN list_kendaraan AS lk ON tr.kendaraan_id = lk.id
JOIN type AS ty ON lk.type_id = ty.id
JOIN harga AS h ON ty.id = h.type_id
WHERE status = 'DATANG'
GROUP BY bulan
ORDER BY MONTH(tanggal);
"; 
try 
{ 
    $stmt = $db->prepare($query3); 
    $stmt->execute(); 
} 
catch(PDOException $ex) 
{ 
    die("Failed to run query: " . $ex->getMessage()); 
} 
$bulan3 = array();
$data_jual = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $bulan3[] = $row['bulan'];
    $data_jual[] = $row['data_jual'];
}
$data_bulan3 = json_encode($bulan3);
$data_jual = json_encode($data_jual);


?>
<!DOCTYPE html>
<html lang="en">
<?php include 'page-header.php' ?>

<body>
  <title>Admin - Katiga Carwash</title>
  <div class="container-fluid">
    <div class="row">

      <?php include 'page-menu.php' ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mt-4 mb-3 border-bottom">
          <h1 class="h2">Dashboard</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
              <!-- <div class="btn-group me-2">
                <a href="" target="_blank">
                  <i class="fa-solid fa-print"></i>
                  <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
                </a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
              </div> -->
              <!-- <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
              </button> -->
            </div>
        </div>

        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Grafik Booking</h5>
                  <canvas id="book"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Grafik Penjualan</h5>
                  <canvas id="sales"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

      </main>
    </div>
  </div>

  <?php include 'page-footer.php' ?>
  <script>
    $(document).ready(function() {
      $('table.table').DataTable({
        "lengthChange": false,
        "bPaginate": false,
      });
    });
  </script>
  
<script>

  var bulan = <?php echo $data_bulan1; ?>;
  var data_success = <?php echo $data_success; ?>;
  var data_failed = <?php echo $data_failed; ?>;
  var data_jual = <?php echo $data_jual; ?>;

  // Chart 1 - Bar Chart
  var ctx1 = document.getElementById('book').getContext('2d');
  var book = new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: bulan,
      datasets: [{
        label: 'Booked',
        data: data_success,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }, {
        label: 'Failed',
        data: data_failed,
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });

  // Chart 2 - Line Chart
  var ctx2 = document.getElementById('sales').getContext('2d');
  var sales = new Chart(ctx2, {
    type: 'line',
    data: {
      labels: bulan,
      datasets: [{
        label: 'Penjualan',
        data: data_jual,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        fill: false
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>


</body>

</html>