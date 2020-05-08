<?php

include('../database_connection.php');
include('../film_category/error_array.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM film_category WHERE film_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['film_id'] = $n['film_id'];
    $_SESSION['category_id'] = $n['category_id'];
 

}


$film_id=$_SESSION['film_id'];
$category_id=$_SESSION['category_id'];
    


if(isset($_POST["update2"])){


    $error=0;

    $id = $_POST["film_id"];


    if(!empty($_POST["category_id"])) {

      $temp = $_POST["category_id"];


      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['category_id_err'] = 'Category ID must only contain digits';

        $error=1; }



      $query = "SELECT DISTINCT * FROM category WHERE category_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $errors['category_id_err'] = 'Invalid category ID'; }



    } 

      
    if($error==0){


 			$category_id = !empty($_POST["category_id"]) ? "'".$_POST["category_id"]."'" : "NULL"; 



        $sql="UPDATE film_category SET film_id=$id,
    category_id=$category_id, last_update=NOW() WHERE film_id=$id";


      
    if(mysqli_query($conn, $sql))
    {
      echo("<script>alert('Film category information successfully updated.')</script>");
      echo("<script>window.location = '../film_category/index.php';</script>");

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
    <title>Edit Film Category Data</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->

<body class=page>
<h3 align=center>Edit Film Category Data</h3>
<form action="../film_category/updateform.php" method="post">
    <div class="input-group">
        <input type="hidden" name="film_id" value="<?php echo $film_id; ?>">
        <label>Category ID:</label><br>
        <input type="text" name="category_id" value="<?php echo $category_id; ?>">
        <div class="red-text"><?php echo $errors['category_id_err']; ?></div> 

    </div>
    <br>
        <input type="submit" name="update2" value="update">
</form>
</body>


