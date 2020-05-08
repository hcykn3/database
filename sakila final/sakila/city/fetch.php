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
	SELECT DISTINCT * FROM city 
	WHERE city_id LIKE '%".$search."%'
	OR city LIKE '%".$search."%'
	OR country_id LIKE '%".$search."%' 
	OR last_update LIKE '%".$search."%' 
	";
}
else
{
	$query = "
	SELECT DISTINCT * FROM city ORDER BY city_id";
}
//---------------end search----------------


//-----------------delete-------------------


if(isset($_POST['delete'])){
    $deleteid = $_POST['deleteid'];
    echo '</script>';
    mysqli_query($conn,"DELETE FROM city WHERE city_id = '$deleteid'");
    echo '<script type="text/javascript">'; 
    echo 'alert("You have deleted the data.");';
    echo 'window.location= "https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/city/index.php";';
    echo '</script>'; 
    }


//----------------- end delete-----------------





$result = mysqli_query($conn, $query);


if(mysqli_num_rows($result) > 0 && !isset($_POST['update']))
{
	echo"<div class=table-responsive>
			<table class=table table bordered> <tr> 
	<th>City ID</th>
	<th>City name</th>
	<th>Country ID</th>
	<th>Last update</th>
	<th></th>
	<th></th>


	</tr>";

	while($row = mysqli_fetch_array($result))
	{
		$id = $row['city_id'];



		$last_update=strtr($row['last_update'],'/','-');
		$a=explode('-',$last_update);

		$b=explode(' ',$a[2]);

		if(strlen($b[0])>2){ //if date starts with year
			
			$c=0;

			if(strlen($a[1]==1)){ //if month is 1 digit

				if(strlen($a[0]==1)) //if day is 1 digit
					$date=$c.$a[0].'/'.$c.$a[1].'/'.$b[0].' '.$b[1];

				//if day is 2 digit
				else $date=$a[0].'/'.$c.$a[1].'/'.$b[0].' '.$b[1];

			}

			else { //if month is 2 digits

					if(strlen($a[0]==1)) //if day is 1 digit
					$date=$c.$a[0].'/'.$c.$a[1].'/'.$b[0].' '.$b[1];

					//if day is 2 digit
					else $date=$a[0].'/'.$c.$a[1].'/'.$b[0].' '.$b[1];

			}

			

		} else {

			$date=$b[0].'/'.$a[1].'/'.$a[0].' '.$b[1];

		}





    	echo"<tr>";
   		echo"<td>".$row['city_id']."</td>";
    	echo"<td>".$row['city']."</td>";
    	echo"<td>".$row['country_id']."</td>";
    	echo"<td>".$date."</td>";
   
    	echo"<td><form method='POST' action=https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/city/fetch.php><input type='hidden' id='deleteid' name='deleteid' value='".$id."'><input type='submit' name='delete' value='delete'></form></td>";
    	echo"<td><form method='POST' action=https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/city/updateform.php><input type='hidden' id='updateid' name='updateid' value='".$id."'><input type='submit' name='update' value='edit'></form></td>";
		echo"</tr>"; 

	}

	echo "</table>";
}
else
{
	echo 'Data Not Found';
}



?>