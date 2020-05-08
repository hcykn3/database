<?php

include('../database_connection.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM category WHERE category_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['category_id'] = $n['category_id'];
    $_SESSION['name'] = $n['name'];

}

$category_id=$_SESSION['category_id'];
$name=$_SESSION['name'];

    

$name_err = '';
$errors = array('name_err'=>'');

if(isset($_POST['update2'])){


    $error=0;
    $id = $_POST['category_id'];



    if(!empty($_POST["name"])) {

      $temp = $_POST["name"];

      if (!preg_match('/^[a-zA-Z\s]+$/', $temp)){

        $errors['name_err'] = 'Category name must only contain alphabets ';

        $error=1;}

      } 


    if($error==0){



        $name = !empty($_POST["name"]) ? "'".$_POST["name"]."'" : "NULL"; 


   

        $sql="UPDATE category SET category_id=$id,
    name=$name, last_update=NOW() WHERE category_id=$id";



    try {



    if(mysqli_query($conn, $sql))
    {
      echo("<script>alert('Category information successfully updated.')</script>");
      echo("<script>window.location = 'https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/category/index.php';</script>");

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

    <title>Edit Category Data</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->

<body class=page>
<h3 align=center>Edit Category Data</h3>
<form action="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/category/updateform.php" method="post">
    <div class="input-group ">
        <input type="hidden" name="category_id" value=" <?php echo $category_id; ?>">
        <label>Category name:</label><br>
        <input type="text" name="name" value=" <?php echo $name; ?>">
        <div class="red-text"><?php echo $errors['name_err']; ?></div> 

        </br>
        <input type="submit" name="update2" value="update">
    </div>
</form>
</body>
    
