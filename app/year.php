<?php 
  
require("../config/config.php");
require("../config/session.php"); 
  
if(isset($_POST['year'])) {
    $selectedYear = $_POST['year'];
    
    $stmt = $pdo->prepare('SELECT MONTHNAME(tanggal) AS bulan, SUM(h.harga) AS data_jual
    FROM (SELECT 1 AS january UNION SELECT 2 AS february UNION SELECT 3 AS march UNION SELECT 4 AS april UNION SELECT 5 AS may UNION SELECT 6 AS june UNION SELECT 7 AS july UNION SELECT 8 AS august UNION SELECT 9 AS september UNION SELECT 10 AS october UNION SELECT 11 AS november UNION SELECT 12 AS december) AS bulan_pilihan
    LEFT JOIN transaksi AS tr ON MONTH(tanggal) = bulan_pilihan.january
    JOIN list_kendaraan AS lk ON tr.kendaraan_id = lk.id
    JOIN type AS ty ON lk.type_id = ty.id
    JOIN harga AS h ON ty.id = h.type_id
    WHERE status = 'DATANG' AND year = :year GROUP BY bulan ORDER BY MONTH(tanggal)');
    $stmt->bindParam(':year', $selectedYear);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    // Prepare the chart data as JSON
    $chartData = array(
      'labels' => array(),
      'data' => array(),
      'colors' => array(),
    );
  
    foreach($results as $row) {
      $chartData['labels'][] = $row['month'];
      $chartData['data'][] = $row['total_sales'];
      $chartData['colors'][] = '#' . substr(md5(rand()), 0, 6);
    }
  
    echo json_encode($chartData);
  }

?>