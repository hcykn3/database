<?php

include('../database_connection.php');
include('../inventory/error_array.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM inventory WHERE inventory_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['inventory_id'] = $n['inventory_id'];
    $_SESSION['film_id'] = $n['film_id'];
    $_SESSION['store_id'] = $n['store_id'];
 

}


$inventory_id=$_SESSION['inventory_id'];
$film_id=$_SESSION['film_id'];
$store_id=$_SESSION['store_id'];
    


if(isset($_POST["update2"])){


    $error=0;

    $id = $_POST["inventory_id"];



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


      
    if($error==0){


 			$film_id = !empty($_POST["film_id"]) ? "'".$_POST["film_id"]."'" : "NULL"; 

 			$store_id = !empty($_POST["store_id"]) ? "'".$_POST["store_id"]."'" : "NULL"; 



        $sql="UPDATE inventory SET inventory_id=$id,
    film_id=$film_id, store_id=$store_id,last_update=NOW() WHERE inventory_id=$id";

    
    try {


        if(mysqli_query($conn, $sql))
        {
          echo("<script>alert('Inventory information successfully updated.')</script>");
          echo("<script>window.location = '../inventory/index.php';</script>");

        }



    } catch (Exception $e)
            
            { echo ("<script>alert('Error updating record. Please try again.')</script>");}



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
    <title>Edit Inventory</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->

<body class=page>
<h3 align=center>Edit Inventory</h3>
<form action="../inventory/updateform.php" method="post">
    <div class="input-group">
        <input type="hidden" name="inventory_id" value="<?php echo $inventory_id; ?>">
        <label>Film ID:</label><br>
        <input type="text" name="film_id" value="<?php echo $film_id; ?>">
        <div class="red-text"><?php echo $errors['film_id_err']; ?></div> 

    </div>
    <br>
    <div class="input-group">
        <label>Store ID: </label><br>
        <input type="text" name="store_id" value="<?php echo $store_id; ?>">
        <div class="red-text"><?php echo $errors['store_id_err']; ?></div> 
    <br>
        <input type="submit" name="update2" value="update">
</form>
</body>


