<?php

include('../database_connection.php');
include('../staff/error_array.php');
session_start();



if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM staff WHERE staff_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['staff_id'] = $n['staff_id'];
    $_SESSION['store_id'] = $n['store_id'];
    $_SESSION['first_name'] = $n['first_name'];
    $_SESSION['last_name'] = $n['last_name'];
    $_SESSION['email'] = $n['email'];
    $_SESSION['address_id'] = $n['address_id'];
    $_SESSION['active'] = $n['active'];
    $_SESSION['password'] = $n['password'];



}


$staff_id=$_SESSION['staff_id'];
$store_id=$_SESSION['store_id'];
$first_name=$_SESSION['first_name'];
$last_name=$_SESSION['last_name'];
$email=$_SESSION['email'];
$address_id=$_SESSION['address_id'];
$active=$_SESSION['active'];

$password=$_SESSION['password'];
    




if(isset($_POST["update2"])){


    $error=0;

    $id = $_SESSION['staff_id'];


    if(!empty($_POST["store_id"])) { //----------FK

      $temp = $_POST["store_id"];


      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['store_id_err'] = 'Store ID must only contain digits';

        $error=1; }
        

      $query = "SELECT DISTINCT * FROM store WHERE store_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $errors['store_id_err'] = 'Invalid store ID'; }

 
    } else { 

      $error=1; 

      $errors['store_id_err'] = 'Store ID cannot be empty';}




    if(!empty($_POST["first_name"])) {

      $temp = $_POST["first_name"];

      if (!preg_match('/^[a-zA-Z\s-]+$/', $temp)){


        $errors['first_name_err'] = 'First name must only contain alphabets and - ';

        $error=1; }


    } else { 

      $error=1; 

      $errors['first_name_err'] = 'First name cannot be empty';}



    if(!empty($_POST["last_name"])) {

      $temp = $_POST["last_name"];

      if (!preg_match('/^[a-zA-Z\s-]+$/', $temp)){

        $errors['last_name_err'] = 'Last name must only contain alphabets and - ';

        $error=1; }


    } else { 

      $error=1; 

      $errors['last_name_err'] = 'Last name cannot be empty';}


    if(!empty($_POST["email"])) {

      $temp = $_POST["email"];

      if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $temp)){

        $errors['email_err'] = 'Please enter a valid email';

        $error=1; }


    } else { 

      $error=1; 

      $errors['email_err'] = 'Email cannot be empty';}

    

    if(!empty($_POST["address_id"])) { //----------FK

      $temp = $_POST["address_id"];


      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['address_id_err'] = 'Address ID must only contain digits';

        $error=1; }
        

      $query = "SELECT DISTINCT * FROM address WHERE address_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $errors['address_id_err'] = 'Invalid address ID'; }


    } else { 

      $error=1; 

      $errors['address_id_err'] = 'Address ID cannot be empty';}




    if(!empty($_POST["active"])) {

      $temp = $_POST["active"];

      if (!preg_match('/^[0-1]+$/', $temp)){

        $errors['active_err'] = 'You are only allowed to select between 0 for not active and 1 for active';

        $error=1; }


    } else { 

      $error=1; 

      $errors['active_err'] = 'Active column cannot be empty';}


      


      if (empty($_POST["password"])){


        $error=1; 

        $errors['password_err'] = 'Password cannot be empty';}



      



      
    if($error==0){

        $store_id = "'".$_POST["store_id"]."'" ; 

        $first_name =  "'".$_POST["first_name"]."'" ;  
         
        $last_name = "'".$_POST["last_name"]."'" ; 


        $email = "'".$_POST["email"]."'" ; 

        $address_id = "'".$_POST["address_id"]."'" ; 

        $active = "'".$_POST["active"]."'"; 


        $password = "'".$_POST["password"]."'";  



        $sql="UPDATE staff SET
    first_name=$first_name, last_name=$last_name, address_id=$address_id, email=$email,  store_id=$store_id, active=$active,password=$password,last_update=NOW() WHERE staff_id=$id";


      
    if(mysqli_query($conn, $sql))
    {
      echo("<script>alert('Customer information successfully updated.')</script>");
      echo("<script>window.location = '../staff/index.php';</script>");

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
    <title>Edit Customer Data</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->

<body class=page>
<h3 align=center>Edit Staff Data</h3>
<form action="../staff/updateform.php" method="post">
    <div class="input-group">
        <input type="hidden" name="staff_id" value="<?php echo $staff_id; ?>">

   
   <p>
    <label for="first_name">First Name:</label><br>
    <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>">
    <div class="red-text"><?php echo $errors['first_name_err']; ?></div>


   </p>
   <p>
    <label for="last_name">Last Name:</label><br>
    <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>">
    <div class="red-text"><?php echo $errors['last_name_err']; ?></div>

    <p>
    <label for="address_id">Address ID:</label><br>
    <input type="text" name="address_id" id="address_id" value="<?php echo $last_name; ?>">
    <div class="red-text"><?php echo $errors['address_id_err']; ?></div>


   </p>


   <p>
    <label for="email">Email:</label><br>
    <input type="text" name="email" id="email" value="<?php echo $email; ?>">
    <div class="red-text"><?php echo $errors['email_err']; ?></div>

    <p>
    <label for="store_id">Store ID:</label><br>
    <input type="text" name="store_id" id="store_id" value="<?php echo $store_id; ?>">
    <div class="red-text"><?php echo $errors['store_id_err']; ?></div>


   </p>
   </p>
  
   <p>
    <label for="active">Active:</label><br>
    <input type="text" name="active" id="active" value="<?php echo $active; ?>">
    <div class="red-text"><?php echo $errors['active_err']; ?></div>


   </p>




    <p>
    <label for="password">Password:</label><br>
    <input type="text" name="password" id="password" value="<?php echo $password; ?>">
    <div class="red-text"><?php echo $errors['password_err']; ?>


   </p>

    <p>
        <input type="submit" name="update2" value="update">
    </p>
</form>
</body>    


