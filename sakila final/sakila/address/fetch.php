<?php


include('../database_connection.php');

if(!isset($_SESSION)){session_start();}

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


mysqli_set_charset ($conn,"utf8");
$output = '';

//------------------search-----------------------
if(isset($_POST["query"]))
{
	$search = mysqli_real_escape_string($conn, $_POST["query"]);
	$query = "
	SELECT DISTINCT * FROM address 
	WHERE address_id LIKE '%".$search."%'
	OR address LIKE '%".$search."%'
	OR address2 LIKE '%".$search."%' 
	OR district LIKE '%".$search."%'
	OR city_id LIKE '%".$search."%' 
	OR postal_code LIKE '%".$search."%'  
	OR phone LIKE '%".$search."%' 
	OR last_update LIKE '%".$search."%' 
	";
}
else
{
	$query = "
	SELECT DISTINCT * FROM address ORDER BY address_id";
}
//---------------end search----------------


//-----------------delete-------------------


if(isset($_POST['delete'])){
    $deleteid = $_POST['deleteid'];
    echo '</script>';
    mysqli_query($conn,"DELETE FROM address WHERE address_id = '$deleteid'");
    echo '<script type="text/javascript">'; 
    echo 'alert("You have deleted the data.");';
    echo 'window.location= "../address/index.php";';
    echo '</script>'; 
    }


//----------------- end delete-----------------





$result = mysqli_query($conn, $query);


if(mysqli_num_rows($result) > 0 && !isset($_POST['update']))
{
	echo"<div class=table-responsive>
					<table class=table table bordered> <tr> 
	<th>Address ID</th>
	<th>Address</th>
	<th>Address 2</th>
	<th>District</th>
	<th>City ID</th>
	<th>Postal code</th>
	<th>Phone number</th>
	<th>Last update</th>
	<th></th>
	<th></th>


	</tr>";

	while($row = mysqli_fetch_array($result))
	{
		$id = $row['address_id'];


		$last_update= $row['last_update'];


		$a=explode('-',$last_update);
		
		$b=explode(' ',$a[2]);

		$d=explode(':',$b[1]);

		$time=$d[0].':'.$d[1];

		if(strlen($b[0])>2){ //if date starts with year
			
			$c=0;

			if(strlen($a[1]==1)){ //if month is 1 digit


				$b=explode(':',$b[1]);

				if(strlen($a[0]==1)) //if day is 1 digit
					$date=$c.$a[0].'/'.$c.$a[1].'/'.$b[0].' '.$time;

				//if day is 2 digit
				else $date=$a[0].'/'.$c.$a[1].'/'.$b[0].' '.$time;

			}

			else { //if month is 2 digits

					if(strlen($a[0]==1)) //if day is 1 digit
					$date=$c.$a[0].'/'.$c.$a[1].'/'.$b[0].' '.$rime;

					//if day is 2 digit
					else $date=$a[0].'/'.$c.$a[1].'/'.$b[0].' '.$time;

			}

			

		} else {

			$date=$b[0].'/'.$a[1].'/'.$a[0].' '.$time;

		}





    	echo"<tr>";
   		echo"<td>".$row['address_id']."</td>";
    	echo"<td>".$row['address']."</td>";
    	echo"<td>".$row['address2']."</td>";
    	echo"<td>".$row['district']."</td>";
		echo"<td>".$row['city_id']."</td>";
    	echo"<td>".$row['postal_code']."</td>";
    	echo"<td>".$row['phone']."</td>";
    	echo"<td>".$date."</td>";
   
    	echo"<td><form method='POST' action=../address/fetch.php><input type='hidden' id='deleteid' name='deleteid' value='".$id."'><input type='submit' name='delete' value='delete'></form></td>";
    	echo"<td><form method='POST' action=../address/updateform.php><input type='hidden' id='updateid' name='updateid' value='".$id."'><input type='submit' name='update' value='edit'></form></td>";
		echo"</tr>"; 

	}

	echo "</table>";
}
else
{
	echo 'Data Not Found';
}



?>