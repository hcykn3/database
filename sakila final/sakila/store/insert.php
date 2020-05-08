<?php



include('../database_connection.php');
include('../store/error_array.php');




  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    

    if(!empty($_POST["store_id"])) { 

      $temp = $_POST["store_id"];

      if (!preg_match('/^[0-9-\s]+$/', $temp)){ 
        
        $errors['store_id_err'] = 'Store ID must contain only digits';

        $error=1; }


      $query = "SELECT DISTINCT * FROM store WHERE store_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(mysqli_num_rows($result)) {
        $error=1;
        $errors['store_id_err'] = 'Duplicate store ID. Please leave blank or enter another one.';

      }
    }







      if(!empty($_POST["manager_staff_id"])) { 

        $temp = $_POST["manager_staff_id"];

        if (!preg_match('/^[0-9-\s]+$/', $temp)){ 
          
          $errors['manager_staff_id_err'] = 'Staff ID must contain only digits';

          $error=1; }


        $query = "SELECT DISTINCT * FROM staff WHERE staff_id = '$temp' ";

        $result = mysqli_query($conn, $query);

        if(!mysqli_num_rows($result)) {
          $error=1;
          $errors['manager_staff_id_err'] = 'Invalid staff ID. No record found in staff table';

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




//-----------------------end error check-----------------------
     


    	if($error==0){


		    $store_id = !empty($_POST["store_id"]) ? "'".$_POST["store_id"]."'" : "NULL"; 

		    $manager_staff_id = "'".$_POST["manager_staff_id"]."'" ;

        $address_id = !empty($_POST["address_id"]) ? "'".$_POST["address_id"]."'" : "NULL"; 



		    $sql="INSERT INTO store (store_id,manager_staff_id, address_id, last_update) 
					VALUES ($store_id, $manager_staff_id, $address_id, NOW())";



		

		    	if(mysqli_query($conn, $sql))
		        {

		          echo("<script>alert('Store information successfully added.')</script>");
		          echo("<script>window.location = '../store/index.php';</script>");

		        }

		        else {
		          echo "Error inserting record";
		        }


     } //---------------------------------------end of insert--------------------------------------

      

}



?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
    <title>New Store</title>
    <meta charset="utf-8">
</head>

<!-- Insert -->

<body class=page>
<h3> New Store </h3>
<form action="../store/insert.php" method="post">
	<p>
    <label for="store_id">Store ID:</label><br>
    <input type="text" name="store_id" id="store_id" >
    <div class="red-text"><?php echo $errors['store_id_err']; ?></div>


   </p>
   <p>
    <label for="manager_staff_id">Manager Staff ID:</label><br>
    <input type="text" name="manager_staff_id" id="manager_staff_id" > 
    <div class="red-text"><?php echo $errors['manager_staff_id_err']; ?></div>
    </p>

    <p>
    <label for="address_id">Address ID:</label><br>
    <input type="text" name="address_id" id="address_id" > 
    <div class="red-text"><?php echo $errors['address_id_err']; ?></div>
    </p>

   
        <input type="submit" name="insert">
</form>
</body>

