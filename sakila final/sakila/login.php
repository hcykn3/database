<?php

include('https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/database_connection.php');

session_start(); 

$username_err = '';

$errors = array('username_err' => '');

$error=0;


if(isset($_POST["insert"])){

	if (empty($_POST['username'])||empty($_POST['password'])) {

		$errors['username_err']="Username or password cannot be empty.";
		$error=1;

	} else {

		$username=$_POST['username'];
		$password=$_POST['password'];

		$sql="SELECT * FROM staff WHERE username='$username' AND password='$password';";

		$result=mysqli_query($conn,$sql);

		$num=mysqli_num_rows($result);

		if($num<1){

			$errors['username_err']="Invalid username or password. Please try again.";


			$error=1;


		} else {

					if($error==0){

						session_start();
						$_SESSION['login']=$row['username'];
						$_SESSION['password']=$row['password'];
						header("Location: https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/index.php");

					}  
					

			} 
		}


}
	


?>



<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
</head>

<body class=page>
<form action="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/login.php" method="post">

    <h3 align=center>Log In</h3>
   <p>
    <label for="username">Username:</label><br>
    <input type="text" name="username" id="username">
   
   </p>
   <p>
    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password">
    </p>
    </br>
    </br>

    <input type="submit" name="insert" value="login"><br>
    <div class="red-text"><?php echo $errors ['username_err']; ?></div>
   
   </p>
</form>
</body>


