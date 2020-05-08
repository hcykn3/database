<?php

include('../database_connection.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM film_text WHERE film_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['film_id'] = $n['film_id'];
    $_SESSION['title'] = $n['title'];
    $_SESSION['description'] = $n['description'];


}


$film_id=$_SESSION['film_id'];
$title=$_SESSION['title'];
$description=$_SESSION['description'];
    


if(isset($_POST["update2"])){

    $id = $_POST["film_id"];


	$title = !empty($_POST["title"]) ? "'".$_POST["title"]."'" : "NULL"; 

	$description = !empty($_POST["description"]) ? "'".$_POST["description"]."'" : "NULL"; 



    $sql="UPDATE film_text SET film_id=$id, title=$title,
    description=$description WHERE film_id=$id";


      
    if(mysqli_query($conn, $sql))
    {
      echo("<script>alert('Film text information successfully updated.')</script>");
      echo("<script>window.location = '../film_text/index.php';</script>");

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




}




?>


<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
    <title>Edit Film Text Data</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->

<body class=page>
<h3 align=center>Edit Film Text Data</h3>
<form action="../film_text/updateform.php" method="post">
	<div class="input-group">
        <input type="hidden" name="film_id" value="<?php echo $film_id; ?>">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo $title; ?>">
    </div>
    <br>
    <div class="input-group">
        <label>Description: </label><br>
        <input type="text" name="description" value="<?php echo $description; ?>">

    <br>    
        <input type="submit" name="update2" value="edit"><br>
</form>
</body>


   


