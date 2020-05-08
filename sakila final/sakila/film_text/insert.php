<?php



include('../database_connection.php');


  $film_id_err = '';

  $errors = array('film_id_err' => '');


  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    


    if(!empty($_POST["film_id"])) { 

      $temp = $_POST["film_id"];

      $query = "SELECT DISTINCT * FROM film_text WHERE film_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(mysqli_num_rows($result)) {
        $error=1;

        $errors['film_id_err'] = 'Duplicate film ID. Please leave blank or enter another one.';

      }


      else if (!preg_match('/^[1-9][0-9]*$/', $temp)){ //if address contains non digits
        
        $errors['film_id_err'] = 'Film ID must only contain digits';

        $error=1; }
	} 



//-----------------------end error check-----------------------
     


    	if($error==0){


		    $film_id = "'".$_POST["film_id"]."'" ; 

		    $title = !empty($_POST["title"]) ? "'".$_POST["title"]."'" : "NULL";

		    $description = !empty($_POST["description"]) ? "'".$_POST["description"]."'" : "NULL"; 



		    $sql="INSERT INTO film_text (film_id,title,description) 
					VALUES ($film_id, $title, $description)";



		  
		    try{


		    	if(mysqli_query($conn, $sql))
		        {

		          echo("<script>alert('Film text information successfully added.')</script>");
		          echo("<script>window.location = '../film_text/index.php';</script>");

		        }

		        else {
		          echo "Error inserting record";
		        }
		    } catch (Exception $e)
		    
		    { echo ("<script>alert('Invalid film ID')</script>");}
		        

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
    <title>New Film Text</title>
    <meta charset="utf-8">
</head>

<!-- Insert -->

<body class=page>
<h3 align=center> New Film Text </h3>
<form action="../film_text/insert.php" method="post">
	<p>
    <label for="film_id">Film ID:</label><br>
    <input type="text" name="film_id" id="film_id" >
    <div class="red-text"><?php echo $errors['film_id_err']; ?></div>
   </p>
   <p>
    <label for="title">Title:</label><br>
    <input type="text" name="title" id="title" > </p>
    
    <p>
    <label for="description">Description:</label><br>
    <input type="text" name="description" id="description" >

   </p>
    <input type="submit" name="insert">
</form>
</body>

