<?php



$rental_id_err = $customer_id_err = $inventory_id_err = $rental_id_err = $return_date_err= '';

$errors = array('payment_id_err' => '', 'customer_id_err'=>'', 'staff_id_err'=>'', 'rental_id_err'=>'', 'amount_err'=>'','return_date_err'=>'','inventory_id_err'=>'');


if(isset($_POST['return_date'])){

  $_SESSION['return_date']=$_POST["return_date"]; 

}


if(isset($_POST['rental_date'])){

  $_SESSION['rental_date']=$_POST["rental_date"]; 

}


?>

