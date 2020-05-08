<?php



include('../database_connection.php');
include('../inventory/error_array.php');



  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    

    if(!empty($_POST["inventory_id"])) { 

      $temp = $_POST["inventory_id"];


      $query = "SELECT DISTINCT * FROM inventory WHERE inventory_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(mysqli_num_rows($result)) {
        $error=1;
        $errors['inventory_id_err'] = 'Duplicate inventory ID. Please leave blank or enter another one.';

      }


      else if (!preg_match('/^[1-9][0-9]*$/', $temp)){ //if address contains non digits
        
        $errors['inventory_id_err'] = 'Inventory ID must only contain digits';

        $error=1; }
	} 



    if(!empty($_POST["film_id"])) {

      $temp = $_POST["film_id"];


      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['film_id_err'] = 'Film ID must only contain digits';

        $error=1; }


      $query = "SELECT DISTINCT * FROM film WHERE film_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $errors['film_id_err'] = 'Invalid film ID'; }



    } 
    

    if(!empty($_POST["store_id"])) {

      $temp = $_POST["store_id"];


      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['store_id_err'] = 'Store ID must only contain digits';

        $error=1; }      


      $query = "SELECT DISTINCT * FROM store WHERE store_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $errors['store_id_err'] = 'Invalid store ID'; }



    }     



//-----------------------end error check-----------------------
     


    	if($error==0){


		    $inventory_id = !empty($_POST["inventory_id"]) ? "'".$_POST["inventory_id"]."'" : "NULL"; 

		    $film_id = !empty($_POST["film_id"]) ? "'".$_POST["film_id"]."'" : "NULL"; 

		    $store_id = !empty($_POST["store_id"]) ? "'".$_POST["store_id"]."'" : "NULL"; 



		    $sql="INSERT INTO inventory (inventory_id,film_id,store_id, last_update) 
					VALUES ($inventory_id, $film_id, $store_id, NOW())";



		  
		    try{


		    	if(mysqli_query($conn, $sql))
		        {

		          echo("<script>alert('Inventory information successfully added.')</script>");
		          echo("<script>window.location = '../inventory/index.php';</script>");

		        }

		        else {
		          echo "Error inserting record";
		        }
		    } catch (Exception $e)
		    
		    { echo ("<script>alert('Duplicate inventory ID. Please leave blank or try again')</script>");}
		        

			$conn -> close(); 

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
    <title>New Inventory</title>
    <meta charset="utf-8">
</head>

<!-- Insert -->

<body class=page>
<h3 align=center> New Inventory </h3>
<form action="../inventory/insert.php" method="post">
	<p>
    <label for="inventory_id">Inventory ID:</label><br>
    <input type="text" name="inventory_id" id="inventory_id" >
    <div class="red-text"><?php echo $errors['inventory_id_err']; ?></div>


   </p>
   <p>
    <label for="film_id">Film ID:</label><br>
    <input type="text" name="film_id" id="film_id" >
    <div class="red-text"><?php echo $errors['film_id_err']; ?></div>


   </p>


   <p>
    <label for="store_id">Store ID:</label><br>
    <input type="text" name="store_id" id="store_id" >
    <div class="red-text"><?php echo $errors['store_id_err']; ?></div>


   </p>
    </br>   
        <input type="submit" name="insert">
</form>
</body>
