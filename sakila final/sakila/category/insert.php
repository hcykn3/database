<?php

include('../database_connection.php');



//------------------array to store errors------------------

$category_id_err = $name_err = '';

$errors = array('category_id_err' => '', 'name_err' => '');


  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    

 	if(!empty($_POST["category_id"])) { //-----PK

      $temp = $_POST["category_id"];


      $query = "SELECT DISTINCT * FROM category WHERE category_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(mysqli_num_rows($result)) {
        $error=1;
        $errors['category_id_err'] = 'Duplicate category ID. Please leave blank or enter another one.';

      }

      else if (!preg_match('/^[1-9][0-9]*$/', $temp)){

        
        $errors['category_id_err'] = 'Category ID must only contain digits';

        $error=1;}


    } 


    if(!empty($_POST["name"])) { 

      $temp = $_POST["name"];

      if (!preg_match('/^[a-zA-Z\s]+$/', $temp)){ 

        $errors['name_err'] = 'Category name must only contain alphabets';

        $error=1; }
	} 


//-----------------------end error check-----------------------
     


    	if($error==0){


		    $category_id = !empty($_POST["category_id"]) ? "'".$_POST["category_id"]."'" : "NULL"; 

		   	$name = !empty($_POST["name"]) ? "'".$_POST["name"]."'" : "NULL"; 


		    $sql="INSERT INTO category (category_id,name,last_update) 
		      VALUES ($category_id, $name, NOW())";


		  
		    try{


		    	if(mysqli_query($conn, $sql))
		        {

		          echo("<script>alert('Category information successfully added.')</script>");
		          echo("<script>window.location = 'https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/category/index.php';</script>");

		        }

		        else {
		          echo "Error inserting record";
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

    <title>New Category</title>
    <meta charset="utf-8">

</head>

<!-- Insert -->
<body class=page>
<h3 align="center"> New Category </h3>
<form action="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/category/insert.php" method="post">
   <p>
    <label for="category_id">Category ID:</label><br>
    <input type="text" name="category_id" id="category_id" >
    <div class="red-text"><?php echo $errors['category_id_err']; ?></div>
   </p>
   <p>
    <label for="name">Category name:</label><br>
    <input type="text" name="name" id="name" >
    <div class="red-text"><?php echo $errors['name_err']; ?></div>

   </p>
   
    <input type="submit" name="insert"><br>
</form>

</body>