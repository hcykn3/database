<?php 

//logout

session_start();
session_unset();
session_destroy();

header("Location:https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/login.php");