<?php

include('../database_connection.php');
include('../payment/error_array.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM payment WHERE payment_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['payment_id'] = $n['payment_id'];
    $_SESSION['customer_id'] = $n['customer_id'];
    $_SESSION['staff_id'] = $n['staff_id'];
    $_SESSION['rental_id'] = $n['rental_id'];
    $_SESSION['amount'] = $n['amount'];

 

}


$payment_id=$_SESSION['payment_id'];
$customer_id=$_SESSION['customer_id'];
$staff_id=$_SESSION['staff_id'];
$rental_id=$_SESSION['rental_id'];
$amount=$_SESSION['amount'];


if(isset($_POST["update2"])){


    $error=0;

    $id = $_SESSION["payment_id"];



    if(!empty($_POST["customer_id"])) {

      $temp = $_POST["customer_id"];


      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['customer_id_err'] = 'Customer ID must only contain digits';

        $error=1; }


      $query = "SELECT DISTINCT * FROM customer WHERE customer_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $errors['customer_id_err'] = 'Invalid customer ID'; }



    } else { 

        $errors['customer_id_err'] = 'Customer ID cannot be empty'; 
        $error=1; }
    

    if(!empty($_POST["staff_id"])) {

      $temp = $_POST["staff_id"];


      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['staff_id_err'] = 'Staff ID must only contain digits';

        $error=1; }      


      $query = "SELECT DISTINCT * FROM staff WHERE staff_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $errors['staff_id_err'] = 'Invalid staff ID'; }



    } else { 

        $errors['staff_id_err'] = 'Staff ID cannot be empty'; 
        $error=1; }

    

    if(!empty($_POST["rental_id"])) {

      $temp = $_POST["rental_id"];


      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['rental_id_err'] = 'Rental ID must only contain digits';

        $error=1; }      


      $query = "SELECT DISTINCT * FROM rental WHERE rental_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $errors['rental_id_err'] = 'Invalid rental ID'; }



    }  else { 

        $errors['rental_id_err'] = 'Rental ID cannot be empty'; 
        $error=1; }      

    

    if(!empty($_POST["amount"])) {

      $temp = $_POST["amount"];


      if (!preg_match('/^[0-9]{1,4}(\.[0-9]{2})?$/', $temp)){ 
          
        $errors['amount_err'] = 'Invalid amount. Only numbers between 0 and 9999.99 allowed with a maximum of 2 decimal places';

        $error=1; }     


    }  else { 

        $errors['amount_err'] = 'Amount cannot be empty'; 
        $error=1; } 

   


      
    if($error==0){

		    
		    $customer_id = "'".$_POST["customer_id"]."'"; 

		    
		    $staff_id = "'".$_POST["staff_id"]."'";


		    $rental_id = "'".$_POST["rental_id"]."'";


		    $amount = "'".$_POST["amount"]."'";
	

		    $payment_date = $_POST["payment_date"];


			$payment_date_timestamp = strtotime($payment_date);
			$new_date = date('d/m/Y H:i', $payment_date_timestamp); 



        $sql="UPDATE payment SET payment_id=$id,
    customer_id=$customer_id, staff_id=$staff_id, rental_id=$rental_id, amount=$amount, payment_date='$new_date', last_update=NOW() WHERE payment_id=$id";

    


        if(mysqli_query($conn, $sql))
        {
          echo("<script>alert('Payment information successfully updated.')</script>");
          echo("<script>window.location = '../payment/index.php';</script>");

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



    } //insert if 


}




?>


<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
    <title>Edit Payment</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->

<body class=page>
<h3 align=center>Edit Payment</h3>
<form action="../payment/updateform.php" method="post">
    <div class="input-group">
        <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
    

   </p>
   <p>
    <label for="customer_id">Customer ID:</label><br>
    <input type="text" name="customer_id" id="customer_id" value="<?php echo $customer_id; ?>">
    <div class="red-text"><?php echo $errors['customer_id_err']; ?></div>


   </p>


   <p>
    <label for="staff_id">Staff ID:</label><br>
    <input type="text" name="staff_id" id="staff_id" value="<?php echo $staff_id; ?>">
    <div class="red-text"><?php echo $errors['staff_id_err']; ?></div>


   </p>


   <p>
    <label for="rental_id">Rental ID:</label><br>
    <input type="text" name="rental_id" id="rental_id" value="<?php echo $rental_id; ?>">
    <div class="red-text"><?php echo $errors['rental_id_err']; ?></div>


   </p>

   <p>
    <label for="amount">Amount:</label><br>
    <input type="text" name="amount" id="amount" value="<?php echo $amount; ?>">
    <div class="red-text"><?php echo $errors['amount_err']; ?></div>


   </p>


    <p>
    <label for="payment_date">Payment date:</label><br>
    <input type="datetime-local" name="payment_date" id="payment_date">
    

    <p>
        <input type="submit" name="update2" value="update">
    </p>
</form>
</body>

