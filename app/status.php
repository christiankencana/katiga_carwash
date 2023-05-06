<?php 
  
require("../config/config.php");
require("../config/session.php"); 
  
foreach ($_POST['status'] as $id => $status) {
    $stmt = $db->prepare("UPDATE transaksi SET status = :status WHERE id = :id");
    $stmt->execute(['status' => $status, 'id' => $id]);
}

?>