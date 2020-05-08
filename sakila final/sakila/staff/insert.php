<?php



include('../database_connection.php');
include('../staff/error_array.php');

session_start();

if(isset($_POST['insert'])){ //button is pressed


//---------------------end of file upload




    $error=0;

    //------------------check for errors (when button is pressed)------------------
    

    if(!empty($_POST["staff_id"])) { 

      
      $temp = $_POST["staff_id"];


      $query = "SELECT DISTINCT * FROM staff WHERE staff_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(mysqli_num_rows($result)) {
        $error=1;
        $errors['staff_id_err'] = 'Duplicate staff ID. Please leave blank or enter another one.';

      }


      else if (!preg_match('/^[1-9][0-9]*$/', $temp)){ //if address contains non digits
        
        $errors['staff_id_err'] = 'Staff ID must contain digits only';

        $error=1; }
	
  } else { 

      $error=1; 

      $errors['staff_id_err'] = 'Staff ID cannot be empty';}



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


        $errors['first_name_err'] = 'First name must contain only alphabets and - ';

        $error=1; }


    } else { 

      $error=1; 

      $errors['first_name_err'] = 'First name cannot be empty';}



    if(!empty($_POST["last_name"])) {

      $temp = $_POST["last_name"];

      if (!preg_match('/^[a-zA-Z\s-]+$/', $temp)){

        $errors['last_name_err'] = 'Last name must contain only alphabets and - ';

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


      if (!empty($_POST["username"])){

        $temp=$_POST["username"];


        $query = "SELECT DISTINCT * FROM staff WHERE username = '$temp' ";

        $result = mysqli_query($conn, $query);


        if(mysqli_num_rows($result)) {
        $error=1;
        $errors['username_err'] = 'Duplicate username. Please pick another one.';

      }

        else if(strlen($temp)>4){


          $error=1; 

          $errors['username_err'] = 'Username must only have a maximum of 4 characters';}


        } else {

          $error=1; 

          $errors['username_err'] = 'Username column cannot be empty';}
        

      if (empty($_POST["password"])){


        $error=1; 

        $errors['password_err'] = 'Password cannot be empty';



      }

      

//-----------------------end error check-----------------------
     


    	if($error==0){


		    $staff_id = "'".$_POST["staff_id"]."'"; 

		    $store_id = "'".$_POST["store_id"]."'" ; 

		    $first_name =  "'".$_POST["first_name"]."'" ;  
		     
		    $last_name = "'".$_POST["last_name"]."'" ; 


		    $email = "'".$_POST["email"]."'" ; 

		    $address_id = "'".$_POST["address_id"]."'" ; 

		    $active = "'".$_POST["active"]."'"; 

        $_SESSION['id'] = $staff_id;

        $username = "'".$_POST["username"]."'"; 

        $password = "'".$_POST["password"]."'"; 

		    $sql="INSERT INTO staff (staff_id,first_name,last_name,address_id, email,store_id,active,username,password,last_update) 

					VALUES ($staff_id, $first_name, $last_name,  $address_id, $email, $store_id, $active, $username, $password,NOW())";



		  
		    try{


		    	if(mysqli_query($conn, $sql))
		        {

		          echo("<script>alert('Staff information successfully added.')</script>");
		          echo("<script>window.location = 'image_upload.php';</script>");

		        }

		    } catch (Exception $e)
		    
		    { echo ("<script>alert('Staff ID value too large. Please try again.')</script>");
         echo("<script>window.location = '../staff/index.php';</script>");
      }
		        


     } //---------------------------------------end of insert--------------------------------------

      

}



?>

<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
    <title>New Staff</title>
    <meta charset="utf-8">
</head>

<!-- Insert -->

<body class=page>
<h3 align=center> New Staff </h3>

<form action="../staff/insert.php" method="post" >
	<p>
    <label for="staff_id">Staff ID:</label><br>
    <input type="text" name="staff_id" id="staff_id" >
    <div class="red-text"><?php echo $errors['staff_id_err']; ?></div>


   </p>
   
   <p>
    <label for="first_name">First Name:</label><br>
    <input type="text" name="first_name" id="first_name">
    <div class="red-text"><?php echo $errors['first_name_err']; ?></div>


   </p>
   <p>
    <label for="last_name">Last Name:</label><br>
    <input type="text" name="last_name" id="last_name" >
    <div class="red-text"><?php echo $errors['last_name_err']; ?></div>

    <p>
    <label for="address_id">Address ID:</label><br>
    <input type="text" name="address_id" id="address_id">
    <div class="red-text"><?php echo $errors['address_id_err']; ?></div>


   </p>


   <p>
    <label for="email">Email:</label><br>
    <input type="text" name="email" id="email" >
    <div class="red-text"><?php echo $errors['email_err']; ?></div>

    <p>
    <label for="store_id">Store ID:</label><br>
    <input type="text" name="store_id" id="store_id" >
    <div class="red-text"><?php echo $errors['store_id_err']; ?></div>


   </p>
   </p>
  
   <p>
    <label for="active">Active:</label><br>
    <input type="text" name="active" id="active">
    <div class="red-text"><?php echo $errors['active_err']; ?></div>


   </p>


   <p>
    <label for="username">Username:</label><br>
    <input type="text" name="username" id="username">
    <div class="red-text"><?php echo $errors['username_err']; ?></div>


   </p>


    <p>
    <label for="password">Password:</label><br>
    <input type="text" name="password" id="password">
    <div class="red-text"><?php echo $errors['password_err']; ?>


   </p>

        <input type="submit" name="insert">

</form>

</body>
