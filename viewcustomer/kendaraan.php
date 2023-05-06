<?php 
require("../config/config.php");
require("../config/session.php");

error_reporting(0);

$customers_id = $_SESSION['id'];

$query = "SELECT lk.id,t.nama_type, lk.nama_kendaraan
FROM list_kendaraan AS lk 
INNER JOIN type AS t 
ON lk.type_id = t.id
WHERE customers_id = '$customers_id'"; 
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
  <title>Kendaraan - Katiga Carwash</title>
  <main class="container">
    <div class="p-3 my-3 bg-body rounded shadow-sm">

      <button type="button" class="btn btn-secondary my-3" data-bs-toggle="modal" data-bs-target="#kendaraan_add"><i class="fa-solid fa-plus"></i>
        Tambah Kendaraan
      </button>
      <?php include('./component/kendaraan_add.php'); ?>

      <div class="table-responsive">
        <table class="table stripe row-border text-center table-bordered " id="" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">Nama Kendaraan</th>
              <th class="text-center">Jenis Kendaraan</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; foreach($rows as $row): ?> 
                <tr>
                    <td><?php echo $row['nama_kendaraan']; ?></td>
                    <td><?php echo $row['nama_type']; ?></td>
                    <td>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#kendaraan_edit<?php echo $row['id']; ?>" class="btn btn-info btn-sm text-white">Edit</button>
                        <a href="../app/listkendaraan_delete.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-danger btn-sm text-white">Delete</button></a>
                    </td>
                </tr>
                <?php include('./component/kendaraan_edit.php'); ?>
            <?php endforeach; ?>
          </tbody>
        </table>
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
      } );
  </script>
</body>

</html>