<?php
    require("../config/config.php");

    $email = $_SESSION['email'];
    // status login ---> OFF
    $query = "UPDATE accounts SET status = 'Offline' WHERE email = '$email' ";
        try 
        { 
            $sql = $db->prepare($query); 
            $sql->execute(); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
    unset($_SESSION['logged_on']);

    session_destroy();
    header("Location: ../index.php");
    die("Redirecting to: ../index.php");
?>