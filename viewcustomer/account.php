<?php 
    require("../config/config.php");
    require("../config/session.php"); 

    $id = $_SESSION['id'];

    $query = "SELECT * FROM accounts WHERE id='$id'";
    try 
    { 
        $stmt = $db->prepare($query); 
        $stmt->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        die("Failed to run query: " . $ex->getMessage()); 
    } 
    $rows = $stmt->fetchObject();
    
    $email = $rows->email;
    $password = $rows->password;
    $nama_lengkap = $rows->nama_lengkap;
    $no_telp = $rows->no_telp;
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'page-header.php'?>

<body class="bg-light">
  <title>Kendaraan - Katiga Carwash</title>
  
  <main class="container">
    <div class="p-3 my-3 bg-body rounded shadow-sm">
    <h4 class="mb-3">Account</h4>
      <form action="../app/accountsetting_exec.php" method="post" enctype="multipart/form-data">
          <div class="form-group mb-3">
            <label for="name">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $nama_lengkap; ?>" placeholder="Masukan Nama Lengkap" required>
          </div>
          <div class="form-group mb-3">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?php echo $email; ?>" placeholder="Masukan Email" required>
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
          </div>
          <div class="form-group mb-3">
            <label for="email">Nomor Telepon</label>
            <input type="tel" class="form-control" id="no_telp" name="no_telp" value="<?php echo $no_telp; ?>" placeholder="Masukan Nomor Telepon" required>
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
          </div>
          <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password">
          </div>
          <button type="submit" class="btn btn-dark">Ubah Akun</button>
        </form>
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