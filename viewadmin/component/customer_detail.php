<?php

    // require("../config/config.php");
    // require("../config/session.php"); 

    $id=$row["id"];
    // $_SESSION["user_id_edit"] = $id;

    $query = "SELECT lk.id,t.nama_type, lk.nama_kendaraan
    FROM list_kendaraan AS lk 
    INNER JOIN type AS t 
    ON lk.type_id = t.id
    WHERE customers_id = '$id'"; 
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
<div class="modal fade" id="customer_detail<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="customer_detail" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kendaraan Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                <?php foreach($rows as $row): ?> 
                    <div class="row g-5">
                        <div class="col-md-5 col-lg-12 order-md-last">
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0"><?php echo $row['nama_kendaraan']; ?></h6>
                                        <small class="text-muted"><?php echo $row['nama_type']; ?></small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div> 
</div>