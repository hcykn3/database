<?php



include('../database_connection.php');
include('error_array.php');

  
  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    

    if(!empty($_POST["film_id"])) { 

      $temp = $_POST["film_id"];

      $query = "SELECT DISTINCT * FROM film WHERE film_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(mysqli_num_rows($result)) {
        $error=1;
        $errors['film_id_err'] = 'Duplicate film ID. Please leave blank or enter another one.';}


      else if (!preg_match('/^[1-9][0-9]*$/', $temp)){ //if address contains non digits
        
        $errors['film_id_err'] = 'Film ID must only contain digits';

        $error=1; }
    } 


      if(!empty($_POST["release_year"])) { 

        $temp = $_POST["release_year"];

        if (!preg_match('/^[1-9][0-9]{3}$/', $temp)){ //if address contains non digits
          
          $errors['release_year_err'] = 'Release year must only contain 4 digits';

          $error=1; }
      } 


      if(!empty($_POST["language_id"])) { 

        $temp = $_POST["language_id"];

        if (!preg_match('/^[1-9][0-9]*$/', $temp)){ //if address contains non digits
          
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

        if (!preg_match('/^[1-9][0-9]*$/', $temp)){ //if address contains non digits
          
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
        
        $errors['rental_duration_err'] = 'Rental duration must only contain digits';

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


        $errors['rating_err'] = 'Rating must contain only alphanumeric and -';

        $error=1; }


    }    



//-----------------------end error check-----------------------
     


      if($error==0){


        $film_id = !empty($_POST["film_id"]) ? "'".$_POST["film_id"]."'" : "NULL";

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
        



        $sql= "INSERT INTO film 
        (film_id, title, description, release_year,language_id,original_language_id, 
        rental_duration,rental_rate,length,replacement_cost, rating, special_features,last_update)
        VALUES 
        ($film_id, $title, $description, $release_year, $language_id, $original_language_id, 
        $rental_duration, $rental_rate, $length, $replacement_cost, $rating, $special_features, NOW())";


      
        try{


          if(mysqli_query($conn, $sql))
            {

              echo("<script>alert('Film information successfully added.')</script>");
              echo("<script>window.location = '../film/index.php';</script>");

            }

          
        } catch (Exception $e)
        
        { echo ("<script>alert('Error inserting record. Please try again.')</script>");}
            

      $conn -> close(); 

     } //---------------------------------------end of insert--------------------------------------

      

}



?>

<!DOCTYPE html>
<html>
<head>
        <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
    <title>New Film</title>
    <meta charset="utf-8">
</head>

<!-- Insert -->

<body class=page>

<h3 align:center> New Film </h3>
<form action="../film/insert.php" method="post">
   <p>
    <label for="film_id">Film ID:</label><br>
    <input type="text" name="film_id" id="film_id" >
    <div class="red-text"><?php echo $errors['film_id_err']; ?></div>
   </p>
   <p>
    <label for="title">Title:</label><br>
    <input type="text" name="title" id="title" >
   </p>
   <p>
    <label for="description">Description:</label><br>
    <input type="text" name="description" id="description">
   </p>
   <p>
    <label for="release_year">Release year:</label><br>
    <input type="text" name="release_year" id="release_year" >
    <div class="red-text"><?php echo $errors['release_year_err']; ?></div>
   </p>
   <p>
    <label for="language_id">Language ID:</label><br>
    <input type="text" name="language_id" id="language_id" >
    <div class="red-text"><?php echo $errors['language_id_err']; ?></div>
   </p>
   <p>
    <label for="original_language_id">Original language ID:</label><br>
    <input type="text" name="original_language_id" id="original_language_id">
    <div class="red-text"><?php echo $errors['original_language_id_err']; ?></div>
   </p>
   <p>
    <label for="rental_duration">Rental duration:</label><br>
    <input type="text" name="rental_duration" id="rental_duration">
    <div class="red-text"><?php echo $errors['rental_duration_err']; ?></div>
   </p>
   <p>
    <label for="rental_rate">Rental rate:</label><br>
    <input type="text" name="rental_rate" id="rental_rate" >
    <div class="red-text"><?php echo $errors['rental_rate_err']; ?></div>
   </p>
   <p>
    <label for="length">Length:</label><br>
    <input type="text" name="length" id="length" >
    <div class="red-text"><?php echo $errors['length_err']; ?></div>
   </p>
   <p>
    <label for="replacement_cost">Replacement cost:</label><br>
    <input type="text" name="replacement_cost" id="replacement_cost" >
    <div class="red-text"><?php echo $errors['replacement_cost_err']; ?></div>
   </p>
   <p>
    <label for="rating">Rating:</label><br>
    <input type="text" name="rating" id="rating" >
    <div class="red-text"><?php echo $errors['rating_err']; ?></div>
   </p>
   <p>
    <label for="special_features">Special features:</label><br>
    <input type="text" name="special_features" id="special_features">
   </p>
        <input type="submit" name="insert">
</form>
</body>