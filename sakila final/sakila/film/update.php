<?php

include('../database_connection.php');
include('../film/error_array.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM film WHERE film_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['film_id'] = $n['film_id'];
    $_SESSION['title'] = $n['title'];
    $_SESSION['description'] = $n['description'];
    $_SESSION['release_year'] = $n['release_year'];
    $_SESSION['language_id'] = $n['language_id'];
    $_SESSION['original_language_id'] = $n['original_language_id'];
    $_SESSION['rental_duration'] = $n['rental_duration'];
    $_SESSION['rental_rate'] = $n['rental_rate'];
    $_SESSION['length'] = $n['length'];
    $_SESSION['replacement_cost'] = $n['replacement_cost'];
    $_SESSION['rating'] = $n['rating'];
    $_SESSION['special_features'] = $n['special_features'];

}


$film_id=$_SESSION['film_id'];
$title=$_SESSION['title'];
$description=$_SESSION['description'];
$release_year=$_SESSION['release_year'];
$language_id=$_SESSION['language_id'];
$original_language_id=$_SESSION['original_language_id'];
$rental_duration=$_SESSION['rental_duration'];
$rental_rate=$_SESSION['rental_rate'];
$length=$_SESSION['length'];
$replacement_cost=$_SESSION['replacement_cost'];
$rating=$_SESSION['rating'];
$special_features=$_SESSION['special_features'];



    
if(isset($_POST['update2'])){


    $error=0;
    $id = $_POST['film_id'];



    if(!empty($_POST["release_year"])) { 

        $temp = $_POST["release_year"];

        if (!preg_match('/^[1-9][0-9]{3}$/', $temp)){ 
          
          $errors['release_year_err'] = 'Release year must contain only 4 digits';

          $error=1; }
      } 


    if(!empty($_POST["language_id"])) { 

        $temp = $_POST["language_id"];

        if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
          $errors['language_id_err'] = 'Language ID must only contain digits';

          $error=1; }


        $query = "SELECT DISTINCT * FROM language WHERE language_id = '$temp' ";

        $result = mysqli_query($conn, $query);


        if(!mysqli_num_rows($result)) {


          $error=1;


          $errors['language_id_err'] = 'Invalid language ID'; }



      } 


    if(!empty($_POST["original_language_id"])) { 

        $temp = $_POST["original_language_id"];

        if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
          $errors['original_language_id_err'] = 'Original language ID must only contain digits';

          $error=1; }



        $query = "SELECT DISTINCT * FROM language WHERE language_id = '$temp' ";

        $result = mysqli_query($conn, $query);


        if(!mysqli_num_rows($result)) {


          $error=1;


          $errors['language_id_err'] = 'Invalid language ID'; }
      } 



    if(!empty($_POST["rental_duration"])) {

      $temp = $_POST["rental_duration"];

      if (!preg_match('/^[1-9][0-9]*$/', $temp)){
        
        $errors['rental_duration_err'] = 'Rental duration must contain only digits';

        $error=1;}


    } 


    if(!empty($_POST["rental_rate"])) {

      $temp = $_POST["rental_rate"];

      if (!preg_match('/^[0-9]{1,3}(\.[0-9]{2})?$/', $temp)){


        $errors['rental_rate_err'] = 'Invalid decimal number. Only numbers between 0 and 999.99 allowed with a maximum of 2 decimal places';

        $error=1; }


    } 
    
    if(!empty($_POST["length"])) {

      $temp = $_POST["length"];

      if (!preg_match('/^[1-9][0-9]*$/', $temp)){


        $errors['length_err'] = 'Length must contain only digits';

        $error=1; }


    }    

    
    if(!empty($_POST["replacement_cost"])) {

      $temp = $_POST["replacement_cost"];

      if (!preg_match('/^[0-9]{1,4}(\.[0-9]{2})?$/', $temp)){


        $errors['replacement_cost_err'] = 'Invalid replacement cost. Only numbers between 0 and 9999.99 allowed with a maximum of 2 decimal places';

        $error=1; }


  } 
    

    if(!empty($_POST["rating"])) {

      $temp = $_POST["rating"];

      if (!preg_match('/^[0-9A-Za-z-]*$/', $temp)){


        $errors['rating_err'] = 'Rating must contain only digits';

        $error=1; }


    }    

         
      
    if($error==0){

        $title = !empty($_POST["title"]) ? "'".$_POST["title"]."'" : "NULL";

        $description = !empty($_POST["description"]) ? "'".$_POST["description"]."'" : "NULL";

        $release_year = !empty($_POST["release_year"]) ? "'".$_POST["release_year"]."'" : "NULL";

        $language_id = !empty($_POST["language_id"]) ? "'".$_POST["language_id"]."'" : "NULL";

        $original_language_id = !empty($_POST["original_language_id"]) ? "'".$_POST["original_language_id"]."'" : "NULL";
        
        $rental_duration = !empty($_POST["rental_duration"]) ? "'".$_POST["rental_duration"]."'" : "NULL";

        $rental_rate = !empty($_POST["rental_rate"]) ? "'".$_POST["rental_rate"]."'" : "NULL";

        $length = !empty($_POST["length"]) ? "'".$_POST["length"]."'" : "NULL";

        $replacement_cost = !empty($_POST["replacement_cost"]) ? "'".$_POST["replacement_cost"]."'" : "NULL";

        $rating = !empty($_POST["rating"]) ? "'".$_POST["rating"]."'" : "NULL";

        $special_features = !empty($_POST["special_features"]) ? "'".$_POST["special_features"]."'" : "NULL";



        $sql="UPDATE film SET film_id=$id,
        title=$title,
        description=$description,
        release_year=$release_year,
        language_id=$language_id,
        original_language_id=$original_language_id,
        rental_duration=$rental_duration,
        rental_rate=$rental_rate,
        length=$length,
        replacement_cost=$replacement_cost,
        rating=$rating,
        special_features=$special_features,
        last_update=NOW() 
        WHERE film_id=$id";


        try {


          if(mysqli_query($conn, $sql))
          {
            echo("<script>alert('Film information successfully updated.')</script>");
            echo("<script>window.location = '../film/index.php';</script>");

          }

        } catch (Exception $e)
        
        { echo ("<script>alert('Error updating record. Please try again.')</script>");
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
    <title>Edit Film Data</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->
<body class=page>
<h3> Edit Film Data </h3>
<form action="../film/update.php" method="post">
    <div class="input-group">
        <input type="hidden" name="film_id" value="<?php echo $film_id; ?>">
           <p>
    <label for="title">Title:</label><br>
    <input type="text" name="title" id="title" value=" <?php echo $title; ?>">

   </p>
   <p>
    <label for="description">Description:</label><br>
    <input type="text" name="description" id="description" value=" <?php echo $description; ?>">
   </p>
   <p>
    <label for="release_year">Release Year:</label><br>
    <input type="text" name="release_year" id="release_year" value=" <?php echo $release_year; ?>">
    <div class="red-text"><?php echo $errors['release_year_err']; ?></div>
   </p>
   <p>
    <label for="language_id">Language ID:</label><br>
    <input type="text" name="language_id" id="language_id" value=" <?php echo $language_id; ?>">
    <div class="red-text"><?php echo $errors['language_id_err']; ?></div>
   </p>
   <p>
    <label for="original_language_id">Original Language ID:</label><br>
    <input type="text" name="original_language_id" id="original_language_id" value=" <?php echo $original_language_id; ?>">
    <div class="red-text"><?php echo $errors['original_language_id_err']; ?></div>
   </p>
   <p>
    <label for="rental_duration">Rental Duration:</label><br>
    <input type="text" name="rental_duration" id="rental_duration" value=" <?php echo $rental_duration; ?>">
    <div class="red-text"><?php echo $errors['rental_duration_err']; ?></div>
   </p>
   <p>
    <label for="rental_rate">Rental Rate:</label><br>
    <input type="text" name="rental_rate" id="rental_rate" value=" <?php echo $rental_rate; ?>">
    <div class="red-text"><?php echo $errors['rental_rate_err']; ?></div>
   </p>
   <p>
    <label for="length">Length:</label><br>
    <input type="text" name="length" id="length" value=" <?php echo $length; ?>">
    <div class="red-text"><?php echo $errors['length_err']; ?></div>
   </p>
   <p>
    <label for="replacement_cost">Replacement Cost:</label><br>
    <input type="text" name="replacement_cost" id="replacement_cost" value=" <?php echo $replacement_cost; ?>">
    <div class="red-text"><?php echo $errors['replacement_cost_err']; ?></div>
   </p>
   <p>
    <label for="rating">Rating:</label><br>
    <input type="text" name="rating" id="rating" value=" <?php echo $rating; ?>">
    <div class="red-text"><?php echo $errors['rating_err']; ?></div>
   </p>
   <p>
    <label for="special_features">Special Features:</label><br>
    <input type="text" name="special_features" id="special_features" value=" <?php echo $special_features; ?>">
   </p>
        
    <input type="submit" name="update2" value="update"><br>

</form>
</body>
