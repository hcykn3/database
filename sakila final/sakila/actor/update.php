<?php

//update for actor

include('https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/database_connection.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM actor WHERE actor_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['actor_id'] = $n['actor_id'];
    $_SESSION['first_name'] = $n['first_name'];
    $_SESSION['last_name'] = $n['last_name'];

}


$actor_id=$_SESSION['actor_id'];
$first_name=$_SESSION['first_name'];
$last_name=$_SESSION['last_name'];

    
//------------------array to store errors------------------

$first_name_err = $last_name_err = '';
$errors = array('first_name_err'=>'', 'last_name_err'=>'');

if(isset($_POST['update2'])){


    $error=0;
    $id = $_POST['actor_id'];



    if(!empty($_POST["first_name"])) {

        $temp = $_POST["first_name"];

        if (!preg_match('/^[a-zA-Z\s-]+$/', $temp)){
        
            $errors['first_name_err'] = 'First name must only contain alphabets and - ';

            $error=1;
        }


    } 


    if(!empty($_POST["last_name"])) {

      $temp = $_POST["last_name"];

      if (!preg_match('/^[a-zA-Z\s-]+$/', $temp)){


        $errors['last_name_err'] = 'Last name must only contain alphabets and - ';

        $error=1; }


    } 

         
      
    if($error==0){



        $first_name = !empty($_POST["first_name"]) ? "'".$_POST["first_name"]."'" : "NULL";

        $last_name = !empty($_POST["last_name"]) ? "'".$_POST["last_name"]."'" : "NULL";



        $sql="UPDATE actor SET actor_id=$id,
        first_name=$first_name,
        last_name=$last_name,
        last_update=NOW() 
        WHERE actor_id=$id";



      
    try {


        if(mysqli_query($conn, $sql))
        {
          echo("<script>alert('Actor information successfully updated.')</script>");
          echo("<script>window.location = 'https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/index.php';</script>");

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
    <title>Edit Actor Data</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->
<body class=page>
<h3 align=center> Edit Actor Data </h3>
<form action="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/update.php" method="post">
    <div class="input-group">
        <input type="hidden" name="actor_id" value="<?php echo $actor_id; ?>">
        <label>First Name:</label><br>
        <input type="text" name="first_name" value="<?php echo $first_name; ?>">
        <div class="red-text"><?php echo $errors['first_name_err']; ?></div>
    </div>
    <br><br>
    <div class="input-group">
        <label>Last Name: </label><br>
        <input type="text" name="last_name" value="<?php echo $last_name; ?>">
        <div class="red-text"><?php echo $errors['last_name_err']; ?></div>

    <br><br>
        <input type="submit" name="update2" value="edit"><br>
</form>
</body>



