<?php



include('../database_connection.php');
include('../payment/error_array.php');



  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    

    if(!empty($_POST["payment_id"])) { 

      $temp = $_POST["payment_id"];


      $query = "SELECT DISTINCT * FROM payment WHERE payment_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(mysqli_num_rows($result)) {
        $error=1;
        $errors['payment_id_err'] = 'Duplicate payment ID. Please leave blank or enter another one.';

      }


      else if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
        
        $errors['payment_id_err'] = 'Payment ID must only contain digits';

        $error=1; }


     else if ($temp>2147483647){
        $errors['payment_id_err'] = 'Payment ID value is too large';

        $error=1;


     }
	} 



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



//-----------------------end error check-----------------------
     


    	if($error==0){


		    $payment_id = "'".$_POST["payment_id"]."'"; 

		    
		    $customer_id = "'".$_POST["customer_id"]."'"; 

		    
		    $staff_id = "'".$_POST["staff_id"]."'";


		    $rental_id = "'".$_POST["rental_id"]."'";


		    $amount = "'".$_POST["amount"]."'";
	

		    $payment_date = $_POST["payment_date"];




$payment_date_timestamp = strtotime($payment_date);
$new_date = date('d/m/Y H:i', $payment_date_timestamp); 




		    $sql="INSERT INTO payment (payment_id,customer_id, staff_id, rental_id, amount, payment_date, last_update) 
					VALUES ($payment_id, $customer_id, $staff_id, $rental_id, $amount, '$new_date', NOW())";



		  
	 try {


              if(mysqli_query($conn, $sql))
            {

              echo("<script>alert('Payment information successfully added.')</script>");
  
              echo("<script>window.location = '../payment/index.php';</script>");


            }

    } catch (Exception $e){

      echo("<script>alert('Error adding payment information. Exceeded payment ID limit.')</script>");

        }


      $conn -> close(); 

      } //insert

		  
		   
	


     } //---------------------------------------end of button--------------------------------------




?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
    <title>New Payment</title>
    <meta charset="utf-8">
</head>

<!-- Insert -->

<body class=page>
<h3 align=center> New Payment</h3>
<form action="../payment/insert.php" method="post">
	<p>
    <label for="payment_id">Payment ID:</label><br>
    <input type="text" name="payment_id" id="payment_id" >
    <div class="red-text"><?php echo $errors['payment_id_err']; ?></div>


   </p>
   <p>
    <label for="customer_id">Customer ID:</label><br>
    <input type="text" name="customer_id" id="customer_id" >
    <div class="red-text"><?php echo $errors['customer_id_err']; ?></div>


   </p>


   <p>
    <label for="staff_id">Staff ID:</label><br>
    <input type="text" name="staff_id" id="staff_id" >
    <div class="red-text"><?php echo $errors['staff_id_err']; ?></div>


   </p>


   <p>
    <label for="rental_id">Rental ID:</label><br>
    <input type="text" name="rental_id" id="rental_id" >
    <div class="red-text"><?php echo $errors['rental_id_err']; ?></div>


   </p>

   <p>
    <label for="amount">Amount:</label><br>
    <input type="text" name="amount" id="amount" >
    <div class="red-text"><?php echo $errors['amount_err']; ?></div>
   </p>

    <p>
    <label for="payment_date">Payment date:</label><br>
    <input type="datetime-local" name="payment_date" value="2020-04-01T13:00">
    </br>
    </br>
   
        <input type="submit" name="insert">
</form>

</body>