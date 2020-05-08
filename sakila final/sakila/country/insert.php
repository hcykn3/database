<?php

include('../database_connection.php');



//------------------array to store errors------------------

$country_id_err = $country_err = '';
$errors = array('country_id_err' => '', 'country_err' => '');


  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    

 	if(!empty($_POST["country_id"])) {

      $temp = $_POST["country_id"];


      $query = "SELECT DISTINCT * FROM address WHERE address_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if (mysqli_num_rows($result)) {
        $error=1;
        $errors['country_id_err'] = 'Duplicate country ID. Please leave blank or enter another one.';

      }

      else if (!preg_match('/^[1-9][0-9]*$/', $temp)){

        
        $errors['country_id_err'] = 'Country ID must contain only digits';

        $error=1;}


    } else { 

      $error=1; 

      $errors['country_id_err'] = 'Country ID cannot be empty';}


    
    if(!empty($_POST["country"])) {

      $temp = $_POST["country"];

      if (!preg_match('/^[a-zA-Z\s]+$/', $temp)){

        $errors['country_err'] = 'Country name must contain only alphabets';

        $error=1;}

      } else { 

        $errors['country_err'] = 'Country name cannot be empty'; 
        $error=1; }

//-----------------------end error check-----------------------
     


    	if($error==0){


		    $country_id = "'".$_POST["country_id"]."'"; 

		   	$country = "'".$_POST["country"]."'"; 


		    $sql="INSERT INTO country (country_id,country,last_update) 
		      VALUES ($country_id, $country, NOW())";


		  
		    try{


		    	if(mysqli_query($conn, $sql))
		        {

		          echo("<script>alert('Country information successfully added.')</script>");
		          echo("<script>window.location = 'index.php';</script>");}

		    
        } catch (Exception $e)
		    
		    { echo ("<script>alert('Error inserting record. Please try again.')</script>");}
		        

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
		<link rel="stylesheet" href="../test.css" />
	</head> 
    <title>New Country</title>
    <meta charset="utf-8">

</head>

<!-- Insert -->
<body class=page>
<h3 align=centre> New Country </h3>
<form action="insert.php" method="post">
   
   <p>
    <label for="country_id">Country ID:</label><br>
    <input type="text" name="country_id" id="country_id" >
    <div class="red-text"><?php echo $errors['country_id_err']; ?></div>
   </p>
   <p>
    <label for="country">Country name:</label><br>
    <input type="text" name="country" id="country" >
    <div class="red-text"><?php echo $errors['country_err']; ?></div>
   </p>
   
    <input type="submit" name="insert"><br>
</form>

</body>