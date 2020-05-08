<?php



include('https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/database_connection.php');

$actor_id = $first_name = $last_name = '';

//------------------array to store errors------------------

$actor_id_err = $first_name_err = $last_name_err = '';
$errors = array('actor_id_err' => '', 'first_name_err'=>'', 'last_name_err'=>'');



  
  if(isset($_POST['insert'])){ //button is pressed

    $error=0;

//------------------check for errors (when button is pressed)------------------
    

    if(!empty($_POST["actor_id"])) { 

      $actor_id = $_POST["actor_id"];

      $query = "SELECT DISTINCT * FROM actor WHERE actor_id = '$actor_id' ";

      $result = mysqli_query($conn, $query);


      if(mysqli_num_rows($result)) {
        $error=1;
        $actor_id='';
        $errors['actor_id_err'] = 'Duplicate actor ID. Please leave blank or enter another one.';

      }


      else if (!preg_match('/^[1-9][0-9]*$/', $actor_id)){ //if address contains non digits
        $actor_id='';

        $errors['actor_id_err'] = 'Actor ID must only contain digits';

        $error=1; }
      } else {

        $actor_id="NULL";

        }



    if(!empty($_POST["first_name"])) {

      $first_name = $_POST["first_name"];

      if (!preg_match('/^[a-zA-Z\s-]+$/', $first_name)){


        $first_name='';

        
        $errors['first_name_err'] = 'First name must only contain alphabets and - ';

        $error=1;}


    } 


    if(!empty($_POST['last_name'])) {

      $last_name = $_POST["last_name"];

      if (!preg_match('/^[a-zA-Z\s-]+$/', $last_name)){

        $last_name='';

        $errors['last_name_err'] = 'Last name must only contain alphabets and - ';

        $error=1; }


    } 



//-----------------------end error check-----------------------
     


      if($error==0){

        $actor_id = !empty($_POST["actor_id"]) ? "'".$_POST["actor_id"]."'" : "NULL";

        $first_name = !empty($_POST["first_name"]) ? "'".$_POST["first_name"]."'" : "NULL";

        $last_name = !empty($_POST["last_name"]) ? "'".$_POST["last_name"]."'" : "NULL";
        

        $sql= "INSERT INTO actor (actor_id,first_name,last_name,last_update) VALUES ($actor_id, $first_name, $last_name, NOW())";



        try {


          if(mysqli_query($conn, $sql))
          {

            echo("<script>alert('Actor information successfully added.')</script>");
            echo("<script>window.location = 'https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/index.php';</script>");

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
    <title>New Actor</title>
    <meta charset="utf-8">
</head>

<!-- Insert -->

<body class=page>
<h3 align=center> New Actor </h3>
<form action="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/insert_actor.php" method="post">
   <p>
    <label for="actor_id">Actor ID:</label><br>
    <input type="text" name="actor_id" id="actor_id" value="<?php echo $actor_id; ?>">
    <div class="red-text"><?php echo $errors['actor_id_err']; ?></div>
   </p>
   <p>
    <label for="first_name">First Name:</label><br>
    <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>">
    <div class="red-text"><?php echo $errors['first_name_err']; ?>
   </p>
   <p>
    <label for="address2">Last Name:</label><br>
    <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>">
    <div class="red-text"><?php echo $errors['last_name_err']; ?>
   </p>

    <input type="submit" name="insert"><br>
</form>
</body>


