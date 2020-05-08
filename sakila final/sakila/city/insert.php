<?php



include('../database_connection.php');



//------------------array to store errors------------------

$city_id_err = $city_err = $country_id_err = '';
$errors = array('city_id_err' => '', 'city_err'=>'', 'country_id_err'=>'');


  
  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    

    if(!empty($_POST["city_id"])) { 

      $temp = $_POST["city_id"]; //---------PK

      $query = "SELECT DISTINCT * FROM city WHERE city_id = '$temp' ";

      $result = mysqli_query($conn, $query);

      if(mysqli_num_rows($result)) {
        $error=1;
        $errors['city_id_err'] = 'Duplicate city ID. Please leave blank or enter another one.';

      }
	   

 
      else if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
        
        $errors['city_id_err'] = 'City ID must only contain digits';

        $error=1; }
    } 




    if(!empty($_POST["city"])) {

      $temp = $_POST["city"];

      if (!preg_match('/^[a-zA-Z\s()-.\' ]+$/', $temp)){

        
        $errors['city_err'] = 'Invalid city name';

        $error=1;}


    } 


    if(!empty($_POST["country_id"])) { //---------FK

      $temp = $_POST["country_id"];
      

      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['country_id_err'] = 'Country ID must only contain digits';

        $error=1; }
        

      $query = "SELECT DISTINCT * FROM country WHERE country_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) { // if does not match parent table


        $error=1;


        $errors['country_id_err'] = 'Invalid country ID. No record found in country table'; }


    } 



  

//-----------------------end error check-----------------------
     


    	if($error==0){


		    $city_id = !empty($_POST["city_id"]) ? "'".$_POST["city_id"]."'" : "NULL"; 

		    $city = !empty($_POST["city"]) ? "'".$_POST["city"]."'" : "NULL"; 

		    $country_id = !empty($_POST["country_id"]) ? "'".$_POST["country_id"]."'" : "NULL";  
		     
		    

		    $sql="INSERT INTO city (city_id,city,country_id,last_update) 
		      VALUES ($city_id, $city, $country_id, NOW())";


		  
		    try{


		    	if(mysqli_query($conn, $sql))
		        {

		          echo("<script>alert('City information successfully added.')</script>");
		          echo("<script>window.location = '../city/index.php';</script>");

		        }


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
		<link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
    <title>New City</title>
    <meta charset="utf-8">

</head>

<!-- Insert -->
<body class=page>
<h3 align=centre> New City </h3>
<form action="../city/insert.php" method="post">
   <p>
    <label for="address_id">City ID:</label><br>
    <input type="text" name="city_id" id="city_id" >
    <div class="red-text"> <?php echo $errors['city_id_err']; ?></div>
   </p>
   <p>
    <label for="address">City name:</label><br>
    <input type="text" name="city" id="city" >
    <div class="red-text"> <?php echo $errors['city_err']; ?></div>
   </p>
   <p>
    <label for="address2">Country ID:</label><br>
    <input type="text" name="country_id" id="country_id">
    <div class="red-text"> <?php echo $errors['country_id_err']; ?></div>
   </p>

    <input type="submit" name="insert"><br>
</form>

</body>