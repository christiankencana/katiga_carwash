<?php 
require("../config/config.php");
require("../config/session.php");

error_reporting(0);

// $user_lokasi = $_SESSION['lokasi'];

// $query = "SELECT * FROM accounts WHERE lokasi = '$user_lokasi' ";

$query = "SELECT * FROM type;";
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
            <h1 class="h2">Type Kendaraan</h1>
          </div>

          <a href="data-type-add.php"><button type="button" class="btn btn-dark my-3"><i class="fa-solid fa-plus"></i> Tambah Data</button></a>

          <div class="table-responsive">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th scope="col">Type</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                
                <?php $i = 1; foreach($rows as $row): ?> 
                    <tr>
                        <td><?php echo $row['nama_type']; ?></td>
                        <td>
                            <a href="data-type-edit.php?id=<?php echo $row['id'];?>"><button type="button" class="btn btn-info btn-sm text-white">Edit</button></a>
                            <a href="../app/datatype_delete.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-danger btn-sm text-white">Delete</button></a>
                        </td>
                    </tr>
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