<?php 
require("../config/config.php");
require("../config/session.php");

$query = "SELECT tr.id, tr.tanggal, tr.jam, lk.nama_kendaraan, ty.nama_type, h.harga, acc.id AS customers_id, acc.nama_lengkap, tr.status FROM transaksi AS tr
JOIN list_kendaraan AS lk ON tr.kendaraan_id = lk.id
JOIN type AS ty ON lk.type_id = ty.id
JOIN harga AS h ON ty.id = h.type_id
JOIN accounts AS acc ON lk.customers_id = acc.id ;"; 
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
            <h1 class="h2">Booking Orders</h1>
            <!-- <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
              </div>
              <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
              </button>
            </div> -->
          </div>

          <div class="table-responsive">
            <table class="table stripe row-border text-center table-bordered caption-top" id="" width="100%" cellspacing="0">
              <caption>History Customer Booking</caption>
              <!-- <input class="btn btn-light" type="submit" name="validasi" value="Validasi"> -->
              <thead>
                <tr>
                  <th class="text-center">Tanggal Booking</th>
                  <th class="text-center">Jam Booking</th>
                  <th class="text-center">Nama Kendaraan</th>
                  <th class="text-center">Type Kendaraan</th>
                  <th class="text-center">Nama Customer</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; foreach($rows as $row): ?> 
                    <tr>
                        <td><?php echo $row['tanggal']; ?></td>
                        <td><?php echo $row['jam']; ?></td>
                        <td><?php echo $row['nama_kendaraan']; ?></td>
                        <td><?php echo $row['nama_type']; ?></td>
                        <td><?php echo $row['nama_lengkap']; ?></td>
                        <td>
                          <div class="form-check">
                            <input type="radio" class="form-check-input" name="status[<?= $row['id'] ?>]" value="Belum Datang" <?php if ($row['status'] == 'Belum Datang') { ?> checked <?php } ?> >
                            <label class="form-check-label">
                              Belum Datang
                            </label>
                          </div>
                          <div class="form-check">
                            <input type="radio" class="form-check-input" name="status[<?= $row['id'] ?>]" value="Datang" <?php if ($row['status'] == 'Datang') { ?> checked <?php } ?> >
                            <label class="form-check-label">
                              Datang
                            </label>
                          </div>
                          <div class="form-check">
                            <input type="radio" class="form-check-input" name="status[<?= $row['id'] ?>]" value="Tidak Datang" <?php if ($row['status'] == 'Tidak Datang') { ?> checked <?php } ?> > 
                            <label class="form-check-label">
                              Tidak Datang
                            </label>
                          </div>
                        </td>
                        <td>
                          <div class="d-inline">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#main_edit<?php echo $row['customers_id'];?>" class="btn btn-info btn-sm text-white"><i class="fas fa-edit"></i></button>
                            <a href="../app/maindata_delete.php?id=<?php echo $row['id']; ?>"><button type="button row my-2" class="btn btn-danger btn-sm text-white"><i class="fa-solid fa-minus"></i></button></a>
                          </div>
                        </td>
                    </tr>
                    <?php include('./component/main_edit.php'); ?>
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

            $('input[type=radio]').change(function() {
                var data = {};
                data[$(this).attr('name')] = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: '../app/status.php',
                    data: data,
                    // success: function() {
                    //     alert('Status berhasil diubah');
                    // }
                });
            });

            const fpDatepicker = flatpickr("#datepicker", {
              enableTime: false,
              altInput: false,
              altFormat: "j F Y",
              dateFormat: "Y-m-d",
              minDate: "today",
              maxDate: new Date().fp_incr(14)
            });

            const fpTimepicker = flatpickr("#timepicker", {
              enableTime: true,
              noCalendar: true,
              dateFormat: "H:i",
              time_24hr: true,
              minTime: "08:00",
              maxTime: "18:00",
              minuteIncrement: 30
            });

            const now = new Date();
            fpDatepicker.setDate(now, true, "Y-m-d");
            fpTimepicker.setDate(now, true, "H:i");
        });
      </script>
    </body>
</html>