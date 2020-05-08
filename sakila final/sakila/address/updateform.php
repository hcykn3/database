<?php

include('../database_connection.php');
session_start();


if (!isset($_SESSION['id'])){
    $_SESSION['id']=$_POST['updateid'];
    $id = $_SESSION['id'];
    $record = mysqli_query($conn, "SELECT * FROM address WHERE address_id = $id");
    $n = mysqli_fetch_array($record);
    $_SESSION['address_id'] = $n['address_id'];
    $_SESSION['address'] = $n['address'];
    $_SESSION['address2'] = $n['address2'];
    $_SESSION['district'] = $n['district'];
    $_SESSION['city_id'] = $n['city_id'];
    $_SESSION['postal_code'] = $n['postal_code'];
    $_SESSION['phone'] = $n['phone'];

}


$address_id=$_SESSION['address_id'];
$address=$_SESSION['address'];
$address2=$_SESSION['address2'];
$district=$_SESSION['district'];
$city_id=$_SESSION['city_id'];
$postal_code=$_SESSION['postal_code'];
$phone=$_SESSION['phone'];
    







$city_id_err = $postal_code_err = $phone_err = '';
$errors = array('city_id_err'=>'', 'postal_code_err'=>'', 'phone_err'=>'');

if(isset($_POST["update2"])){


    $error=0;
    $id = $_POST["address_id"];



    if(!empty($_POST["city_id"])) { //FK

      $temp = $_POST["city_id"];

      if (!preg_match('/^[1-9][0-9]*$/', $temp)){ 
          
        $errors['city_id_err'] = 'City ID must only contain digits';

        $error=1; }

      $query = "SELECT DISTINCT * FROM city WHERE city_id = '$temp' ";

      $result = mysqli_query($conn, $query);


      if(!mysqli_num_rows($result)) {


        $error=1;


        $errors['city_id_err'] = 'Invalid city ID';


      }
    }





    if(!empty($_POST["postal_code"])) {

        $temp = $_POST["postal_code"];

        if (!preg_match('/^[0-9-\s]+$/', $temp)){

        $errors['postal_code_err'] = 'Postal code must only contain digits and - ';

        $error=1; }


    } 





    if(!empty($_POST["phone"])) {

        $temp = $_POST["phone"];

        if (!preg_match('/^[0-9-]+$/', $temp)){

            $errors['phone_err'] = 'Phone number must only contain digits and - ';

            $error=1; }


    }

         
      
    if($error==0){



        $address = !empty($_POST["address"]) ? "'".$_POST["address"]."'" : "NULL"; 


        $address2 = !empty($_POST["address2"]) ? "'".$_POST["address2"]."'" : "NULL";


        $district = !empty($_POST["district"]) ? "'".$_POST["district"]."'" : "NULL"; 


        $city_id =!empty($_POST["city_id"]) ? "'".$_POST["city_id"]."'" : "NULL"; 


        $postal_code =!empty($_POST["postal_code"]) ? "'".$_POST["postal_code"]."'" : "NULL";


        $phone =!empty($_POST["phone"]) ? "'".$_POST["phone"]."'" : "NULL"; 


        $sql="UPDATE address SET address_id=$id,
    address=$address, address2=$address2, district=$district, city_id=$city_id, postal_code=$postal_code, phone=$phone, last_update=NOW() WHERE address_id=$id";


    try {



        if(mysqli_query($conn, $sql))
        {
            echo("<script>alert('Address information successfully updated.')</script>");
            echo("<script>window.location = 'https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/address/index.php';</script>");

        }


    }  catch (Exception $e) { echo ("<script>alert('Error updating record. Please try again.')</script>");}
    


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
    <title>Edit Address Data</title>
    <meta charset="utf-8">
</head>
    
<!-- Update -->

<body class=page>
<h3 align=center>Edit Address Data</h3>
<form action="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/address/updateform.php" method="post">
    <div class="input-group">
        <input type="hidden" name="address_id" value="<?php echo $address_id; ?>">
        <label>Address:</label><br>
        <input type="text" name="address" value="<?php echo $address; ?>"> 

    </div>
    <br>

    <div class="input-group">
        <label>Address 2: </label><br>
        <input type="text" name="address2" value="<?php echo $address2; ?>">
    </div>
    <br>

    <div class="input-group">
        <label>District:</label><br>
        <input type="text" name="district" value="<?php echo $district; ?>">

    </div>
    <br>


    <div class="input-group">
        <label>City ID:</label><br>
        <input type="text" name="city_id" value="<?php echo $city_id; ?>">
        <div class="red-text"><?php echo $errors['city_id_err']; ?></div>

    </div>
    <br>


    <div class="input-group">
        <label>Postal Code:</label><br>
        <input type="text" name="postal_code" value="<?php echo $postal_code; ?>">
        <div class="red-text"><?php echo $errors['postal_code_err']; ?></div>

    </div>
    <br>



    <div class="input-group">
        <label>Phone number:</label><br>
        <input type="text" name="phone" value="<?php echo $phone; ?>">
        <div class="red-text"><?php echo $errors['phone_err']; ?></div>
    <br>

    <p>
        <input type="submit" name="update2" value="update">
    </p>
    
</form>
</body>

