<?php 
// require("../config/config.php");
// require("../config/session.php");

// error_reporting(0);

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
$kendaraans = $stmt->fetchAll();

?>
<div class="modal fade" id="main_add" tabindex="-1" role="dialog" aria-labelledby="main_add" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Booking Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                <form action="../app/maindata_add.php" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3 row">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-7">
                            
                            <input type="text" class="form-control datepicker" id="datepicker" name="tanggal" placeholder="Pilih Tanggal" data-enable-time="false" data-no-calendar="false" data-date-format="Y-m-d H:i" required>
                            
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="col-sm-3 col-form-label">Jam</label>
                        <div class="col-sm-7">
                            
                            <input type="text" class="form-control timepicker" id="timepicker" name="jam" placeholder="Pilih Jam" data-enable-time="true" data-no-calendar="true" data-date-format="H:i" required>
                            
                        </div>
                    </div>
                    <!-- <div class="form-group mb-3 row">
                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_lengkap" class="form-control" maxlength="30" value="" required>
                        </div>
                    </div> -->
                    <div class="form-group mb-3 row">
                        <label class="col-sm-3 col-form-label">Kendaraan</label>
                        <div class="col-sm-9">
                        <select name="kendaraan_id" class="form-control" style="width: 100%" data-placeholder="-- Pilih Kendaraan --" required>
                            <option value="" disabled selected>-- Pilih Kendaraan --</option>
                                <?php foreach($kendaraans as $row): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_kendaraan']; ?></option>
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