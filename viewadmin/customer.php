<?php 
require("../config/config.php");
require("../config/session.php");

error_reporting(0);

// $user_lokasi = $_SESSION['lokasi'];

// $query = "SELECT * FROM accounts WHERE lokasi = '$user_lokasi' ";

$query = "SELECT * FROM accounts WHERE role = 'Customer' ";
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
  <body>
    <title>Admin - Katiga Carwash</title>
    <div class="container-fluid">
      <div class="row">

      <?php include 'page-menu.php'?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mt-4 mb-3 border-bottom">
            <h1 class="h2">Customers</h1>
          </div>

          <div class="table-responsive">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th scope="col">Nama</th>
                  <th scope="col">Email</th>
                  <th scope="col">Nomor Telepon</th>
                  <th scope="col">Kendaraan</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; foreach($rows as $row): ?> 
                  <tr>
                      <td><?php echo $row['nama_lengkap']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td><?php echo $row['no_telp']; ?></td>
                      <td>
                      <button type="button" data-bs-toggle="modal" data-bs-target="#customer_detail<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm text-white">Detail</button>
                      </td>
                  </tr>
                  <?php include('./component/customer_detail.php'); ?>
                <?php endforeach; ?>
              </tbody>
            </table>
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
        } );
    </script>
    </body>
</html>