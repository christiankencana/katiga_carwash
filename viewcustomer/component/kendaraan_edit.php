<?php

    // require("../config/config.php");
    // require("../config/session.php"); 

    $id=$row["id"];

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

    $query = "SELECT * FROM list_kendaraan WHERE id='$id'"; 
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
    $nama_kendaraan = $rows->nama_kendaraan;
?>
<div class="modal fade" id="kendaraan_edit<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="kendaraan_edit" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Kendaraan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                <form action="../app/listkendaraan_edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3 row">
                        <label class="col-sm-3 col-form-label">Kendaraan</label>
                        <div class="col-sm-9">
                            <input type="text" id="nama_kendaraan" name="nama_kendaraan" class="form-control" value="<?php echo $nama_kendaraan; ?>" required>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="col-sm-3 col-form-label">Type</label>
                        <div class="col-sm-9">
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