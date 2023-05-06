<?php

// require("../config/config.php");
// require("../config/session.php"); 

// $email = $_POST['email']; 
// $password = $_POST['password']; 
// $query = "SELECT * FROM accounts WHERE email = '$email'";
// try 
// { 
// 	$sql = $db->prepare($query); 
// 	$sql->execute(); 
// } 
// catch(PDOException $ex) 
// { 
// 	die("Failed to run query: " . $ex->getMessage()); 
// } 
// // $rows = $sql->fetchAll();
// $rows = $sql->fetchObject();
// $data_user = $rows->email;
// $data_pass = $rows->password;


// include "config.php";
// $email = $_POST['email']; 
// $password = $_POST['password'];
// $sql = $db->prepare("SELECT * FROM accounts WHERE email=:a AND password=:b ");
// $sql->bindParam(':a', $email);
// $sql->bindParam(':b', $password);
// $sql->execute(); // Eksekusi querynya
// $password = password_verify($password, $data['password']);
// $message="";

include "config.php";

$email = $_POST['email']; 
$password = $_POST['password'];

$query = "SELECT * FROM accounts WHERE email = '$email' ";

$message="";

	try 
	{ 
		$sql = $db->prepare($query); 
		$sql->execute(); 
	} 
	catch(PDOException $ex) 
	{ 
		setcookie("message", "Maaf, Username atau Password salah", time()+3600);
		// die("Failed to run query: " . $ex->getMessage()); 
		header("location: ../index.php?error_login=failed");
	} 

$data = $sql->fetch(PDO::FETCH_ASSOC);

  if (password_verify($password, $data['password']))
  {
	if ($sql->rowCount()>0){
		$login_status=1;
		// $data=$sql->fetch();
		if($data['role']=="Admin"){
			$_SESSION['id']=$data['id'];
			$_SESSION['email']=$data['email'];
			$_SESSION['role']=$data['role'];
			$_SESSION['nama_lengkap'] = $data['nama_lengkap'];

			// waktu sesi
			$_SESSION["logintime"] = time(); 

				// status login ---> ON
				$query = "UPDATE accounts SET status = 'Online' WHERE email = '$email' ";
					try 
					{ 
						$sql = $db->prepare($query); 
						$sql->execute(); 
					} 
					catch(PDOException $ex) 
					{ 
						die("Failed to run query: " . $ex->getMessage()); 
					} 
				$_SESSION['loginstatus'] = $data['status'];

			  session_name("Admin");
			  header('location:../viewadmin/index.php');
			  exit();
		}
		else if($data['role']=="Customer"){
			$_SESSION['id']=$data['id'];
			$_SESSION['email']=$data['email'];
			$_SESSION['role']=$data['role'];
			$_SESSION['nama_lengkap'] = $data['nama_lengkap'];

			// waktu sesi
			$_SESSION["logintime"] = time(); 

				// status login ---> ON
				$query = "UPDATE accounts SET status = 'Online' WHERE email = '$email' ";
					try 
					{ 
						$sql = $db->prepare($query); 
						$sql->execute(); 
					} 
					catch(PDOException $ex) 
					{ 
						die("Failed to run query: " . $ex->getMessage()); 
					} 
				$_SESSION['loginstatus'] = $data['status'];

			session_name("Customer");
			header('location:../viewcustomer/index.php');
			$login_status = false;
			exit();
		}
		setcookie("message","delete",time()-1); 
	}
	else{
		// login error
		$login_status=0;
		setcookie("message", "Maaf, Username atau Password salah", time()+3600);
		header("location: ../index.php?error_login=failed");
		exit();
	}
	
		if(!empty($_POST["remember"])) {
			setcookie ("email",$_POST["email"],time()+ 3600);
			setcookie ("password",$_POST["password"],time()+ 3600);
			echo "Cookies Set Successfuly";
		} else {
			setcookie("email","");
			setcookie("password","");
			echo "Cookies Not Set";
		}
	
  } else {
	// login error
	$login_status=0;
	setcookie("message", "Maaf, Username atau Password salah", time()+3600);
	header("location: ../index.php?error_login=failed");
	exit();
  }

?>