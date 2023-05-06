<?php

    // require("../config/config.php");
    // require("../config/session.php"); 

    $customers_id=$row["customers_id"];

    // error_reporting(0);
    $query = "SELECT * FROM list_kendaraan WHERE customers_id = '$customers_id' "; 
    try 
    { 
        $stmt = $db->prepare($query); 
        $stmt->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        die("Failed to run query: " . $ex->getMessage()); 
    } 
    $kendaraans = $stmt->fetchAll();

    $query = "SELECT * FROM transaksi WHERE customers_id = '$customers_id' "; 
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

    $tanggal = $rows->tanggal;
    $jam = $rows->jam;
    $kendaraan_id = $rows->kendaraan_id;
?>
<div class="modal fade" id="main_edit<?php echo $row['customers_id'];?>" tabindex="-1" role="dialog" aria-labelledby="main_edit" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                <form action="../app/maindata_edit.php?customers_id=<?php echo $customers_id; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3 row">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control datepicker" id="datepicker" name="tanggal" value="<?php echo $tanggal; ?>" placeholder="Pilih Tanggal" data-enable-time="false" data-no-calendar="false" data-date-format="Y-m-d H:i" required>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="col-sm-3 col-form-label">Jam</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control timepicker" id="timepicker" name="jam" value="<?php echo $jam; ?>" placeholder="Pilih Jam" data-enable-time="true" data-no-calendar="true" data-date-format="H:i" required>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="col-sm-3 col-form-label">Kendaraan</label>
                        <div class="col-sm-9">
                            <select name="kendaraan_id" class="form-control" style="width: 100%" >
                                <?php foreach($kendaraans as $row):?>
                                        <option value="<?php echo $row['id']; ?>" 
                                        <?php if ($row['id'] == $kendaraan_id )
                                            { echo 'selected="selected"'; } ?>>
                                        <?php echo $row['nama_kendaraan']; ?></option>
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