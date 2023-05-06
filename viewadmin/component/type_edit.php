<?php

    // require("../config/config.php");
    // require("../config/session.php"); 

    $id=$row["id"];
    // $_SESSION["user_id_edit"] = $id;

    $query = "SELECT * FROM type WHERE id='$id'"; 
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

    $id = $rows->id;
    $nama_type = $rows->nama_type;
?>
<div class="modal fade" id="type_edit<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="type_edit" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                <form action="../app/datatype_edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3 row">
                        <label class="col-sm-3 col-form-label">Type</label>
                        <div class="col-sm-9">
                            <input type="text" name="type" class="form-control" maxlength="30" value="<?php echo $nama_type; ?>" required>
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