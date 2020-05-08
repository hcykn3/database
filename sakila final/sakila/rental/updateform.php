<?php

include('../database_connection.php');
include('../rental/error_array.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM rental WHERE rental_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['rental_id'] = $n['rental_id'];
    $_SESSION['rental_date'] = $n['rental_date'];
    $_SESSION['inventory_id'] = $n['inventory_id'];
    $_SESSION['customer_id'] = $n['customer_id'];
    $_SESSION['return_date'] = $n['return_date'];
    $_SESSION['staff_id'] = $n['staff_id'];

 

}


$rental_id=$_SESSION['rental_id'];
$rental_date=$_SESSION['rental_date'];
$inventory_id=$_SESSION['inventory_id'];
$customer_id=$_SESSION['customer_id'];
$rental_id=$_SESSION['rental_id'];
$return_date=$_SESSION['return_date'];
$staff_id=$_SESSION['staff_id'];





if(isset($_POST["update2"])){


    $error=0;

    $id = $_SESSION["rental_id"];

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
    

    if(!empty($_POST["inventory_id"])) {

      $temp = $_POST["inventory_id"];


      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['inventory_id_err'] = 'Staff ID must only contain digits';

        $error=1; }      


      $query = "SELECT DISTINCT * FROM inventory WHERE inventory_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $errors['inventory_id_err'] = 'Invalid inventory ID. No record found in inventory table'; }



    } else { 

        $errors['inventory_id_err'] = 'Inventory ID cannot be empty'; 
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


        $errors['staff_id_err'] = 'Invalid staff ID. No record found in staff table.'; }



    }  else { 

        $errors['staff_id_err'] = 'Staff ID cannot be empty'; 
        $error=1; }      

    

    if(!empty($_POST["return_date"]) && !empty($_POST["rental_date"])) {

      if($_POST["return_date"] <= $_POST["rental_date"]){

      $errors['return_date_err'] = 'Return date cannot be identical to or earlier than rental date'; 
        
      $error=1;


      } else { //check that rental duration is not exceeded 

        $return_date = $_POST["return_date"]; 


        $rental_date = $_POST["rental_date"]; 


        $payment_date_timestamp = strtotime($return_date);
        $return_date = date('d', $payment_date_timestamp);

        $payment_date_timestamp = strtotime($rental_date); 
        $rental_date = date('d', $payment_date_timestamp);

        $inventory_id=$_POST["inventory_id"];


        $query = mysqli_query($conn, "SELECT film.rental_duration AS rental_duration FROM inventory INNER JOIN film ON inventory.film_id=film.film_id");

        if($query){

        echo "successfully";
        $result=mysqli_fetch_assoc($query);
        $rental_duration=$result['rental_duration'];

        }


        if($return_date>($rental_date+$rental_duration)){

          $errors['return_date_err'] = 'Exceeded rental duration for this film'; 
        
          $error=1;

        }



    }



    } //end date check


    //----------------------end error check
    

      
    if($error==0){


        $inventory_id = "'".$_POST["inventory_id"]."'"; 

        
        $customer_id = "'".$_POST["customer_id"]."'"; 

        $staff_id = "'".$_POST["staff_id"]."'"; 


        $return_date = $_POST["return_date"]; 


        $rental_date = $_POST["rental_date"]; 




        $payment_date_timestamp = strtotime($return_date);
        $return_date = date('d/m/Y H:i', $payment_date_timestamp);

        $payment_date_timestamp = strtotime($rental_date); 
        $rental_date = date('d/m/Y H:i', $payment_date_timestamp);




        $sql="UPDATE rental SET rental_id=$id, rental_date='$rental_date', 
    inventory_id=$inventory_id, customer_id=$customer_id, return_date='$return_date', staff_id=$staff_id, last_update=NOW() WHERE rental_id=$id";

    


        if(mysqli_query($conn, $sql))
        {
          echo("<script>alert('Rental information successfully updated.')</script>");
          echo("<script>window.location = '../rental/index.php';</script>");

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
    <title>Edit Rental</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->

<body class=page>
<h3 align=center>Edit Rental</h3>
<form action="../rental/updateform.php" method="post">
    <div class="input-group">
        <input type="hidden" name="rental_id" value="<?php echo $rental_id; ?>">
    
    <p>
    <label for="rental_date">Rental date:</label><br>
    <input type="datetime-local" name="rental_date" ></p>

    

    <p>
    <label for="inventory_id">Inventory ID:</label><br>
    <input type="text" name="inventory_id" id="inventory_id" value="<?php echo $inventory_id; ?>">
    <div class="red-text"><?php echo $errors['inventory_id_err']; ?></div>


   </p>

   <p>
    <label for="customer_id">Customer ID:</label><br>
    <input type="text" name="customer_id" id="customer_id" value="<?php echo $customer_id; ?>">
    <div class="red-text"><?php echo $errors['customer_id_err']; ?></div>


   </p>

    <p>
    <label for="return_date">Return date:</label><br>
    <input type="datetime-local" name="return_date" value="2020-04-01T13:00" >
    <div class="red-text"><?php echo $errors['return_date_err']; ?></div></p>

   <p>
    <label for="staff_id">Staff ID:</label><br>
    <input type="text" name="staff_id" id="staff_id" value="<?php echo $staff_id; ?>">
    <div class="red-text"><?php echo $errors['staff_id_err']; ?></div>


   </p>

    <p>
        <input type="submit" name="update2" value="update">
    </p>
    
</form>
</body>
    


