<?php



include('../database_connection.php');
include('../film_actor/error_array.php');

$actor_id=$film_id='';

  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    

    if(!empty($_POST["actor_id"])) { 

      $actor_id = $_POST["actor_id"];

      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['actor_id_err'] = 'Actor ID must only contain digits';

        $error=1; }

      $query = "SELECT DISTINCT * FROM actor WHERE actor_id = '$actor_id' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $actor_id='';


        $errors['actor_id_err'] = 'Invalid actor ID'; }

	   } else {

      $error=1;

      $errors['actor_id_err'] = 'Actor ID cannot be empty';
     
     }



    if(!empty($_POST["film_id"])) {

      $film_id = $_POST["film_id"];


      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['film_id_err'] = 'Film ID must only contain digits';

        $error=1; }

      $query = "SELECT DISTINCT * FROM film WHERE film_id = '$film_id' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $film_id='';


        $errors['film_id_err'] = 'Invalid film ID'; }

     } else {

      $error=1;

      $errors['film_id_err'] = 'Film ID cannot be empty';
     
     }




    if($error==0){


      $film_id = $_POST["film_id"];

      $actor_id = $_POST["actor_id"];

      $query = "SELECT DISTINCT * FROM film_actor WHERE actor_id = '$actor_id' AND film_id = '$film_id'";

      $result = mysqli_query($conn, $query);


      if(mysqli_num_rows($result)) {


        $error=1;


        $errors['entry_err'] = 'Duplicate entry'; }

      else {


        $sql="INSERT INTO film_actor (actor_id,film_id,last_update) 
          VALUES ($actor_id, $film_id, NOW())";


        try{


          if(mysqli_query($conn, $sql))
            {

              echo("<script>alert('Film actor information successfully added.')</script>");
              echo("<script>window.location = '../film_actor/index.php';</script>");

            }

            else {
              echo "Error inserting record";
            }
        } catch (Exception $e)
        
        { echo ("<script>alert('Error inserting record. Please try again.')</script>");}
            

      $conn -> close(); 





     }




     }



} //end if button is pressed

      




?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
    <title>New Film Actor</title>
    <meta charset="utf-8">
</head>

<!-- Insert -->
<body class=page>
<h3 align=center> New Film Actor </h3>
<form action="../film_actor/insert.php" method="post">
	<p>
    <label for="actor_id">Actor ID:</label><br>
    <input type="text" name="actor_id" id="actor_id" value="<?php echo $actor_id; ?>">
    <div class="red-text"><?php echo $errors['actor_id_err']; ?></div>


   </p>
   <p>
    <label for="film_id">Film ID:</label><br>
    <input type="text" name="film_id" id="film_id" value="<?php echo $film_id; ?>">
    <div class="red-text"><?php echo $errors['film_id_err']; ?></div>

 
    
   </p>
   
        <input type="submit" name="insert">   <br>

        <div class="red-text"><?php echo $errors['entry_err']; ?></div>
</form>
</body>
