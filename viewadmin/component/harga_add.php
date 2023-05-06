<?php
    // require("../config/config.php");
    // require("../config/session.php"); 

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
    $types = $stmt->fetchAll();

?>
<div class="modal fade" id="harga_add" tabindex="-1" role="dialog" aria-labelledby="harga_add" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Harga Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                <form action="../app/dataharga_add.php" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3 row">
                        <label class="col-sm-3 col-form-label">Type</label>
                        <div class="col-sm-9">
                        <select name="type_id" class="form-control" style="width: 100%" data-placeholder="-- Pilih Type --" required>
                            <option value="" disabled selected>-- Pilih Type --</option>
                                <?php foreach($types as $row): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_type']; ?></option>
                                <?php endforeach; ?>
                        </select>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="col-sm-3 col-form-label">Harga</label>
                        <div class="col-sm-9">
                            <input type="text" id="harga" name="harga" class="form-control" maxlength="10" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-9">
                            <input type="submit" name="Save" value="Save" class="btn btn-dark">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</div>

