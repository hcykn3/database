<?php

include('../database_connection.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM language WHERE language_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['language_id'] = $n['language_id'];
    $_SESSION['name'] = $n['name'];


}


$language_id=$_SESSION['language_id'];
$name=$_SESSION['name'];
    


if(isset($_POST["update2"])){


    $id = $_POST["language_id"];


	$name = !empty($_POST["name"]) ? "'".$_POST["name"]."'" : "NULL"; 


    $sql="UPDATE language SET language_id=$id, name=$name,
    last_update=NOW() WHERE language_id=$id";


      
    if(mysqli_query($conn, $sql))
    {
      echo("<script>alert('Language information successfully updated.')</script>");
      echo("<script>window.location = '../language/index.php';</script>");

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
    <title>Edit Language Data</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->

<body class=page>
<h3 align=center>Edit Language Data</h3>
<form action="../language/updateform.php" method="post">
	<div class="input-group">
        <input type="hidden" name="language_id" value="<?php echo $language_id; ?>">
        <label>Language name:</label><br>
        <input type="text" name="name" value="<?php echo $name; ?>">
    </div>
   </br>
        <input type="submit" name="update2" value="edit"><br>
</form>
</body>


   


