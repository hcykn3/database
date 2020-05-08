<?php

include('../database_connection.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM city WHERE city_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['city_id'] = $n['city_id'];
    $_SESSION['city'] = $n['city'];
    $_SESSION['country_id'] = $n['country_id'];
   
}


$city_id=$_SESSION['city_id'];
$city=$_SESSION['city'];
$country_id=$_SESSION['country_id'];

  


$city_err = $country_id_err = '';
$errors = array('city_err'=>'', 'country_id_err'=>'');

if(isset($_POST["update2"])){


    $error=0;
    $id = $_SESSION["city_id"];


    if(!empty($_POST["city"])) {

      $temp = $_POST["city"];

      if (!preg_match('/^[a-zA-Z\s()-.\' ]+$/', $temp)){

        $errors['city_err'] = 'Invalid city name';

        $error=1;}


      } 




    if(!empty($_POST["country_id"])) {

      $temp = $_POST["country_id"];


      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['country_id_err'] = 'Country ID must only contain digits';

        $error=1; }
        

      $query = "SELECT DISTINCT * FROM country WHERE country_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $errors['country_id_err'] = 'Invalid country ID. No record found in country table'; }


    } 

         
      
    if($error==0){


		$city = !empty($_POST["city"]) ? "'".$_POST["city"]."'" : "NULL"; 

		$country_id = !empty($_POST["country_id"]) ? "'".$_POST["country_id"]."'" : "NULL";  


        $sql="UPDATE city SET city_id=$id,
    city=$city, country_id=$country_id, last_update=NOW() WHERE city_id=$id";


      


    try {


        if(mysqli_query($conn, $sql))
        {
          echo("<script>alert('City information successfully updated.')</script>");
          echo("<script>window.location = '../city/index.php';</script>");

        }


    } catch (Exception $e) { echo ("<script>alert('Error updating record. Please try again.')</script>");}

    




    

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
    <title>Edit City Data</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->

<body class=page>
<h3 align=center>Edit City Data</h3>
<form action="../city/updateform.php" method="post">
    <div class="input-group">
        <input type="hidden" name="city_id" value="<?php echo $city_id; ?>">
        <label>City Name:</label><br>
        <input type="text" name="city" value="<?php echo $city; ?>"> 
        <div class="red-text"><?php echo $errors['city_err']; ?></div>

    </div>
</br>
    <div class="input-group">
        <label>Country ID: </label><br>
        <input type="text" name="country_id" value="<?php echo $country_id; ?>">
        <div class="red-text"><?php echo $errors['country_id_err']; ?></div>
    </div>
    <br>
        <input type="submit" name="update2" value="update">
    </body>
    


