<?php

    require("../config/config.php");
    require("../config/session.php"); 

    $id=$_GET["id"];
    $_SESSION["user_id_edit"] = $id;

    // error_reporting(0);
    $query = "SELECT * FROM type"; 
    try 
    { 
        $stmt = $db->prepare($query); 
        $stmt->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        die("Failed to run query: " . $ex->getMessage()); 
    } 
    $type = $stmt->fetchAll();

    $query = "SELECT * FROM harga WHERE id='$id'"; 
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

    $type_id = $rows->type_id;
    $harga = $rows->harga;
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
            <h4 class="mb-3">Edit Harga</h4>
          </div>

        <form action="../app/dataharga_edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group mb-3 row">
                <label class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-6">
                    <select name="type_id" class="form-control" style="width: 100%" >
                        <?php foreach($type as $row):?>
                                <option value="<?php echo $row['id']; ?>" 
                                <?php if ($row['id'] == $type_id )
                                    { echo 'selected="selected"'; } ?>>
                                <?php echo $row['nama_type']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group mb-3 row">
                <label class="col-sm-2 col-form-label">Harga</label>
                <div class="col-sm-6">
                    <input type="text" id="harga" name="harga" class="form-control" maxlength="10" value="<?php echo $harga; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-6">
                    <input type="submit" name="Save" value="Save" class="btn btn-dark">
                    <a href="data-harga.php"><button type="button" class="btn btn-dark">Cancel</button></a>
                </div>
            </div>
        </form>

        </main>
      </div>
    </div>

    <?php include 'page-footer.php' ?>

    <script>
        $(function() {
            $('#harga').maskMoney({
                prefix: 'Rp ',
                thousands: '.',
                decimal: ',',
                precision: 0
            });
            var nilai_uang = $('#harga').val();
            $('#harga').maskMoney('mask', nilai_uang);
        });
    </script>

    </body>
</html>