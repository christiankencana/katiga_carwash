<?php

    // url directory diganti

    //options
    // || (preg_match('/app\//', dirname($_SERVER['PHP_SELF'])))
    if ((!isset($_SESSION['role']) || $_SESSION['role'] != "Admin")  && preg_match('/viewadmin\//', $_SERVER['REQUEST_URI'])) {
        
        session_destroy();
        header("Location: ../index.php");
        die("Redirecting to: ../index.php");
      } 
    else if ((!isset($_SESSION['role']) || $_SESSION['role'] != "Customer")  && preg_match('/viewuser\//', $_SERVER['REQUEST_URI'])) {
        
        session_destroy();
        header("Location: ../index.php");
        die("Redirecting to: ../index.php");
        
    } else if (preg_match('/config\//', $_SERVER['REQUEST_URI'])){
        
        // session_destroy();
        // header("Location: ../index.php");
        // die("Redirecting to: ../index.php");

    } else if (preg_match('/app\//', $_SERVER['REQUEST_URI']) ){
        
        // session_destroy();
        // header("Location: ../index.php");
        // die("Redirecting to: ../index.php");
    }

    // redirect ke halaman depan
    if(isset($_SESSION['logged_on']))
    {
        header("location: ../index.php"); 
    }

    else if(time()-$_SESSION["logintime"] >14400) 
    {
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

        session_unset();
        session_destroy();
        header("location: ../index.php"); 
    }
?>