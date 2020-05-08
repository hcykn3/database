<?php



include('../database_connection.php');



  $language_id_err = $name_err = '';

  $errors = array('language_id_err'=>'','name_err' => '');


  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    

    if(!empty($_POST["language_id"])) { 

      $temp = $_POST["language_id"];

      if (!preg_match('/^[0-9-\s]+$/', $temp)){ 
        
        $errors['language_id_err'] = 'Language ID must contain only digits';

        $error=1; }


      $query = "SELECT DISTINCT * FROM customer WHERE customer_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(mysqli_num_rows($result)) {
        $error=1;
        $errors['language_id_err'] = 'Duplicate language ID. Please leave blank or enter another one.';

      }
    }


    if(!empty($_POST["name"])) { 

      $temp = $_POST["name"];

      if (!preg_match('/^[a-zA-Z]+$/', $temp)){ 
        
        $errors['name_err'] = 'Language name must contain only alphabets';

        $error=1; }

	} else { 

      $error=1; 

      $errors['name_err'] = 'Language name cannot be empty';}



//-----------------------end error check-----------------------
     


    	if($error==0){


		    $language_id = !empty($_POST["language_id"]) ? "'".$_POST["language_id"]."'" : "NULL"; 

		    $name = !empty($_POST["name"]) ? "'".$_POST["name"]."'" : "NULL";



		    $sql="INSERT INTO language (language_id,name,last_update) 
					VALUES ($language_id, $name, NOW())";



		  



		    	if(mysqli_query($conn, $sql))
		        {

		          echo("<script>alert('Language information successfully added.')</script>");
		          echo("<script>window.location = '../language/index.php';</script>");

		        }

		        else {
		          echo "Error inserting record";
		        }


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
    <title>New Language</title>
    <meta charset="utf-8">
</head>

<!-- Insert -->
<body class=page>
<h3 align=center> New Language </h3>
<form action="../language/insert.php" method="post">
	<p>
    <label for="language_id">Language ID:</label><br>
    <input type="text" name="language_id" id="language_id" >
    <div class="red-text"><?php echo $errors['language_id_err']; ?></div>


   </p>
   <p>
    <label for="name">Language name:</label><br>
    <input type="text" name="name" id="name" > </p>
    <div class="red-text"><?php echo $errors['name_err']; ?></div>

   
        <input type="submit" name="insert">
</form>
</body>
