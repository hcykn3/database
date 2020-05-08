<?php

include('../database_connection.php');
include('../store/error_array.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM store WHERE store_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['store_id'] = $n['store_id'];
    $_SESSION['manager_staff_id'] = $n['manager_staff_id'];
    $_SESSION['address_id'] = $n['address_id'];



}


$store_id=$_SESSION['store_id'];
$manager_staff_id=$_SESSION['manager_staff_id'];
$address_id=$_SESSION['address_id'];
    


if(isset($_POST["update2"])){


    $id = $_SESSION["store_id"];


      if(!empty($_POST["manager_staff_id"])) { 

        $temp = $_POST["manager_staff_id"];

        if (!preg_match('/^[0-9-\s]+$/', $temp)){ 
          
          $errors['manager_staff_id_err'] = 'Staff ID must contain only digits';

          $error=1; }


        $query = "SELECT DISTINCT * FROM staff WHERE staff_id = '$temp' ";

        $result = mysqli_query($conn, $query);

        if(!mysqli_num_rows($result)) {
          $error=1;
          $errors['manager_staff_id_err'] = 'Invalid staff ID. No record found in staff table.';

        }
      } else { 

        $error=1; 

        $errors['manager_staff_id_err'] = 'Manager ID cannot be empty';} 


    


    if(!empty($_POST["address_id"])) { 

        $temp = $_POST["address_id"];

        if (!preg_match('/^[0-9-\s]+$/', $temp)){ 
          
          $errors['address_id_err'] = 'Address ID must contain only digits';

          $error=1; }


        $query = "SELECT DISTINCT * FROM address WHERE address_id = '$temp' ";

        $result = mysqli_query($conn, $query);

        if(!mysqli_num_rows($result)) {
          $error=1;
          $errors['address_id_err'] = 'Invalid address ID. No record found in address table.';

        }
      }
      //end error checks 


    $manager_staff_id = "'".$_POST["manager_staff_id"]."'" ;

    $address_id = !empty($_POST["address_id"]) ? "'".$_POST["address_id"]."'" : "NULL"; 


    $sql="UPDATE store SET manager_staff_id=$manager_staff_id, address_id=$address_id,
    last_update=NOW() WHERE store_id=$id";


      
    if(mysqli_query($conn, $sql))
    {
      echo("<script>alert('Store information successfully updated.')</script>");
      echo("<script>window.location = '../store/index.php';</script>");

    }

    else {
        echo "Error updating record";
    }


    $conn -> close(); 
    $_SESSION=array();
    if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();




}




?>


<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
    <title>Edit Store Information</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->

<body class=page>
<h3>Edit Store Information</h3>
<form action="../store/updateform.php" method="post">
	<div class="input-group">
        <input type="hidden" name="store_id" value="<?php echo $store_id; ?>">
        <label>Manager Staff ID:</label><br>
        <input type="text" name="manager_staff_id" value="<?php echo $manager_staff_id; ?>">
    </div>

    <p>
    <label for="address_id">Address ID:</label><br>
    <input type="text" name="address_id" id="address_id" > 
    <div class="red-text"><?php echo $errors['address_id_err']; ?></div>
    </p>
   
    <p>
        <input type="submit" name="update2" value="edit"><br>
    </p>

</form>
</body>
   


