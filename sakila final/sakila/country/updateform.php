<?php

include('../database_connection.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM country WHERE country_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['country_id'] = $n['country_id'];
    $_SESSION['country'] = $n['country'];

}

$country_id=$_SESSION['country_id'];
$country=$_SESSION['country'];

    

$country_err = '';
$errors = array('country_err'=>'');

if(isset($_POST['update2'])){


    $error=0;
    $id = $_POST['country_id'];



    if(!empty($_POST["country"])) {

      $temp = $_POST["country"];

      if (!preg_match('/^[a-zA-Z\s]+$/', $temp)){

        $errors['country_err'] = 'Country name must contain only alphabets';

        $error=1;}

      } else { 

        $errors['country_err'] = 'Country name cannot be empty'; 
        $error=1; }


    if($error==0){



        $country = "'".$_POST["country"]."'"; 


   

        $sql="UPDATE country SET country_id=$id,
    country=$country, last_update=NOW() WHERE country_id=$id";


    try {


        if(mysqli_query($conn, $sql))
        {
          echo("<script>alert('Country information successfully updated.')</script>");
          echo("<script>window.location = 'index.php';</script>");

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
	<link rel="stylesheet" href="../test.css" />
	</head> 
    <title>Edit Country Data</title>
    <meta charset="utf-8">

</head>
    
<!-- Update -->

<body class=page>
<h3>Edit Country Data</h3>
<form action="updateform.php" method="post">
    <div class="input-group">
        <input type="hidden" name="country_id" value="<?php echo $country_id; ?>">
        <label>Country name:</label><br>
        <input type="text" name="country" value=" <?php echo $country; ?>">
        <div class="red-text"><?php echo $errors['country_err']; ?></div> 

    </div>
    <br>
        <input type="submit" name="update2" value="update">
    
<body>

