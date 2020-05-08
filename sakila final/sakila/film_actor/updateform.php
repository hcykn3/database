<?php

include('../database_connection.php');
include('../film_actor/error_array.php');
session_start();


if (!isset($_SESSION['actor_id'])){ //id
    $_SESSION['actor_id']=$_POST['update_actor'];
    $_SESSION['film_id']=$_POST['update_film'];

}


    $old_actor_id = $_SESSION['actor_id'];
    $old_film_id=$_SESSION['film_id'];
 



if (isset($_POST["update2"])){


    $error=0;

    


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

     } else {

      $error=1;

      $errors['film_id_err'] = 'Film ID cannot be empty';
     
     }


//-----------------------end error check-----------------------
     

      
    if($error==0){


      //$actor_id = $old_actor_id;


      $film_id = $_POST["film_id"]; 
    


      $query = "SELECT DISTINCT * FROM film_actor WHERE actor_id = '$old_actor_id' AND film_id = '$film_id'";

      $result = mysqli_query($conn, $query);


      if(mysqli_num_rows($result)) {


        $error=1;


        $errors['entry_err'] = 'Duplicate entry'; }

      else {


        $sql="UPDATE film_actor SET actor_id=$old_actor_id,
        film_id=$film_id, last_update=NOW() WHERE actor_id=$old_actor_id AND film_id=$old_film_id";


        try {
            if(mysqli_query($conn, $sql))
            {
              echo("<script>alert('Film actor information successfully updated.')</script>");
              echo("<script>window.location = '../film_actor/index.php';</script>");

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




    }


    





    } //end if error==0


} //end if button is pressed




?>


<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
    <title>Edit Film Actor Data</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->

<body class=page>
<h3 align=center>Edit Film Actor Data</h3>
<form action="../film_actor/updateform.php" method="post">
    <div class="input-group">

        <label>Film ID:</label><br>
        <input type="text" name="film_id" value="<?php echo $old_film_id; ?>">
        <div class="red-text"><?php echo $errors['film_id_err']; ?></div> 

    </div>
    <br>

    <p>
        <input type="submit" name="update2" value="update"><br>

        <div class="red-text"><?php echo $errors['entry_err']; ?></div>
    </p>
</form>
</body> 


