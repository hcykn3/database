<?php



include('../database_connection.php');
include('../film_category/error_array.php');



  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    

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


//-----------------------end error check-----------------------
     


    	if($error==0){


		    $film_id = !empty($_POST["film_id"]) ? "'".$_POST["film_id"]."'" : "NULL"; 

		    $category_id = !empty($_POST["category_id"]) ? "'".$_POST["category_id"]."'" : "NULL"; 



		    $sql="INSERT INTO film_category (film_id,category_id,last_update) 
					VALUES ($film_id, $category_id, NOW())";



		  
		    try{


		    	if(mysqli_query($conn, $sql))
		        {

		          echo("<script>alert('Film category information successfully added.')</script>");
		          echo("<script>../film_category/window.location = 'index.php';</script>");

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
    <title>New Film Category</title>
    <meta charset="utf-8">
</head>

<!-- Insert -->

<body class=page>
<h3 align=center> New Film Category </h3>
<form action="../film_category/insert.php" method="post">
	<p>
    <label for="film_id">Film ID:</label><br>
    <input type="text" name="film_id" id="film_id" >
    <div class="red-text"><?php echo $errors['film_id_err']; ?></div>


   </p>
   <p>
    <label for="category_id">Category ID:</label><br>
    <input type="text" name="category_id" id="category_id" >
    <div class="red-text"><?php echo $errors['category_id_err']; ?></div>


   </p>
   
        <input type="submit" name="insert">
</form>
</body>
