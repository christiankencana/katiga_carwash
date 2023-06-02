<?php
require("../config/config.php");
require("../config/session.php");



?>
<!DOCTYPE html>
<html lang="en">
<?php include 'page-header.php' ?>

<body>
<title>Admin - Katiga Carwash</title>
<div class="container-fluid">
    <div class="row">

    <?php include 'page-menu.php' ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mt-4 mb-3 border-bottom">
                <h1 class="h2">Laporan</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <!-- <div class="btn-group me-2">
                        <a href="" target="_blank">
                        <i class="fa-solid fa-print"></i>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div> -->
                    <!-- <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <span data-feather="calendar"></span>
                        This week
                    </button> -->
                </div>
            </div>

            <div class="container">
                <!-- <form action="" target="_blank" method="get" enctype="multipart/form-data">
                    <div class="row g-3 mt-2">
                        <label class="col-sm-3 col-form-label text-center">Laporan Booking Bulanan</label>
                        <div class="col-sm-2">
                            <select id="bulan" name="bulan" class="form-control" placeholder="Pilih Bulan" required></select>
                        </div>
                        <div class="col-sm-2">
                            <select id="tahun" name="tahun" class="form-control"  placeholder="Pilih Tahun" required></select>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-info">Cetak</button>
                        </div>
                    </div>
                </form> -->
                <form action="../app/report_bookyear.php" target="_blank" method="get" enctype="multipart/form-data">
                    <div class="row g-3 mt-2">
                        <label class="col-sm-3 col-form-label text-center">Laporan Booking Tahunan</label>
                        <div class="col-sm-2">
                            <select id="tahun2" name="tahun2" class="form-control" placeholder="Pilih Tahun" required></select>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-info">Cetak</button>
                        </div>
                    </div>
                </form>
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

            // var selectmonth = document.getElementById("bulan");
            // var months = [
            //     "January", "February", "March", "April", "May", "June",
            //     "July", "August", "September", "October", "November", "December"
            // ];
            // var currentMonth = new Date().getMonth();
            // for (var i = 0; i < months.length; i++) {
            //     var option = document.createElement("option");
            //     option.text = months[i];
            //     option.value = i + 1;
            //     selectmonth.add(option);
            // }
            // selectmonth.value = currentMonth + 1;

            // var selectyear = document.getElementById("tahun");
            // var currentYear = new Date().getFullYear();
            // var minYear = currentYear - 5; // Change this value to set the minimum tahun
            // var maxYear = currentYear + 5; // Change this value to set the maximum tahun
            // for (var tahun = minYear; tahun <= maxYear; tahun++) {
            //     var option = document.createElement("option");
            //     option.text = tahun;
            //     option.value = tahun;
            //     selectyear.add(option);
            // }
            // selectyear.value = currentYear;

            /////////////////////////////////////////////////////////////////////////////
            var selectyear = document.getElementById("tahun2");
            var currentYear = new Date().getFullYear();
            var minYear = currentYear - 5; // Change this value to set the minimum tahun
            var maxYear = currentYear + 5; // Change this value to set the maximum tahun
            for (var tahun = minYear; tahun <= maxYear; tahun++) {
                var option = document.createElement("option");
                option.text = tahun;
                option.value = tahun;
                selectyear.add(option);
            }
            selectyear.value = currentYear;
        });
  </script>

</body>

</html>