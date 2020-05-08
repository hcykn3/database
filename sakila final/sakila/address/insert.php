<?php



include('https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/address/database_connection.php');




$address_id_err = $city_id_err = $postal_code_err = $phone_err = '';
$errors = array('address_id_err' => '', 'city_id_err'=>'', 'postal_code_err'=>'', 'phone_err'=>'');


  
  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    

    if(!empty($_POST["address_id"])) { //------PK

      $temp = $_POST["address_id"];
      
      $query = "SELECT DISTINCT * FROM address WHERE address_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(mysqli_num_rows($result)) {
        $error=1;
        $errors['address_id_err'] = 'Duplicate address ID. Please leave blank or enter another one.';

      }

      

      else if (!preg_match('/^[1-9][0-9]*$/', $temp)){ //if address contains non digits
        
        $errors['address_id_err'] = 'Address ID must only contain digits ';

        $error=1; }
	} 



    if(!empty($_POST["city_id"])) { //----------FK

      $temp = $_POST["city_id"];

      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['city_id_err'] = 'City ID must only contain digits';

        $error=1; }

      $query = "SELECT DISTINCT * FROM city WHERE city_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $errors['city_id_err'] = 'Invalid city ID'; }


    } 


    if(!empty($_POST["postal_code"])) {

      $temp = $_POST["postal_code"];

      if (!preg_match('/^[0-9-]+$/', $temp)){


        $errors['postal_code_err'] = 'Postal code must only contain digits and - ';

        $error=1; }


    } 



    if(!empty($_POST["phone"])) {

      $temp = $_POST["phone"];

      if (!preg_match('/^[0-9-]+$/', $temp)){

        $errors['phone_err'] = 'Phone number must only contain digits and - ';

        $error=1; }


    }

//-----------------------end error check-----------------------
     


    	if($error==0){


		    $address_id = !empty($_POST["address_id"]) ? "'".$_POST["address_id"]."'" : "NULL"; 

		    $address = !empty($_POST["address"]) ? "'".$_POST["address"]."'" : "NULL"; 

		    $address2 = !empty($_POST["address2"]) ? "'".$_POST["address2"]."'" : "NULL";  
		     
		    $district = !empty($_POST["district"]) ? "'".$_POST["district"]."'" : "NULL"; 


		    $city_id = !empty($_POST["city_id"]) ? "'".$_POST["city_id"]."'" : "NULL"; 

		    $postal_code = !empty($_POST["postal_code"]) ? "'".$_POST["postal_code"]."'" : "NULL"; 

		    $phone = !empty($_POST["phone"]) ? "'".$_POST["phone"]."'" : "NULL"; 

		    $sql="INSERT INTO address (address_id,address,address2,district,city_id,postal_code,phone,last_update) 
		      VALUES ($address_id, $address, $address2, $district, $city_id, $postal_code, $phone, NOW())";


		  
		    try{


		    	if(mysqli_query($conn, $sql))
		        {

		          echo("<script>alert('Address information successfully added.')</script>");
		          echo("<script>window.location = 'https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/address/index.php';</script>");

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
    <title>New Address</title>
    <meta charset="utf-8">
</head>

<!-- Insert -->

<body class=page>
<h3 align=center> New Address </h3>
<form action="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/address/insert.php" method="post">
   <p>
    <label for="address_id">Address ID:</label><br>
    <input type="text" name="address_id" id="address_id" >
    <div class="red-text"><?php echo $errors['address_id_err']; ?></div>
   </p>
   <p>
    <label for="address">Address:</label><br>
    <input type="text" name="address" id="address" >
   </p>
   <p>
    <label for="address2">Address 2:</label><br>
    <input type="text" name="address2" id="address2">
   </p>


   <p>
    <label for="district">District:</label><br>
    <input type="text" name="district" id="district">
   </p>


   <p>
    <label for="city_id">City ID:</label><br>
    <input type="text" name="city_id" id="city_id">
    <div class="red-text"><?php echo $errors['city_id_err']; ?></div>
   </p>



   <p>
    <label for="postal_code">Postal code:</label><br>
    <input type="text" name="postal_code" id="postal_code">
    <div class="red-text"><?php echo $errors['postal_code_err']; ?></div>
   </p>


   <p>
    <label for="phone">Phone number:</label><br>
    <input type="text" name="phone" id="phone">
    <div class="red-text"><?php echo $errors['phone_err']; ?></div>
   </p>

    <input type="submit" name="insert"><br>

</form>
</body>



