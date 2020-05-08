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
	SELECT DISTINCT * FROM staff 
	WHERE staff_id LIKE '%".$search."%'
	OR first_name LIKE '%".$search."%' 
	OR last_name LIKE '%".$search."%'
	OR address_id LIKE '%".$search."%' 
	OR email LIKE '%".$search."%' 
	OR store_id LIKE '%".$search."%'
	OR active LIKE '%".$search."%'
	OR username LIKE '%".$search."%'
	OR password LIKE '%".$search."%'
	";
}
else
{
	$query = "
	SELECT DISTINCT * FROM staff ORDER BY staff_id";
}
//---------------end search----------------


//-----------------delete-------------------


try{

	if(isset($_POST['delete'])){
    $deleteid = $_POST['deleteid'];
    echo '</script>';
    mysqli_query($conn,"DELETE FROM staff WHERE staff_id = '$deleteid'");
    echo '<script type="text/javascript">'; 
    echo 'alert("You have deleted the data.");';
    echo 'window.location= "../staff/index.php";';
    echo '</script>'; 
    }


} catch (Exception $e)
                
    { echo ("<script>alert('Error deleting record. Related payment and rental data exists.')</script>");

    echo ("<script>window.location= '../staff/index.php'</script>");}




//----------------- end delete-----------------





$result = mysqli_query($conn, $query);


if(mysqli_num_rows($result) > 0 && !isset($_POST['update']))
{
	echo"<div class=table-responsive>
					<table class=table table bordered> <tr> 
	<th>Staff ID</th>

	<th>First name</th>
	<th>Last name</th>
	<th>Address ID</th>
	<th>Picture</th>
	<th>Email</th>
	<th>Store ID</th>
	<th>Active</th>
	<th>Username</th>
	<th>Password</th>
	<th>Last update</th>
	<th></th>
	<th></th>


	</tr>";




	while($row = mysqli_fetch_array($result))
	{
		$id = $row['staff_id'];

		$last_update=strtr($row['last_update'],'/','-');
		
		$a = explode('-',$last_update);

		$b = explode(' ',$a[2]);

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
   		echo"<td>".$row['staff_id']."</td>";
    	echo"<td>".$row['first_name']."</td>";
    	echo"<td>".$row['last_name']."</td>";
    	echo"<td>".$row['address_id']."</td>";
    	echo "<td><img src='".$row['picture']."' width='200' height='200'></td>";
		echo"<td>".$row['email']."</td>";
    	echo"<td>".$row['store_id']."</td>";
    	echo"<td>".$row['active']."</td>";
    	echo"<td>".$row['username']."</td>";
    	echo"<td>".$row['password']."</td>";
    	echo"<td>".$date."</td>";
   
    	echo"<td><form method='POST' action=../staff/fetch.php><input type='hidden' id='deleteid' name='deleteid' value='".$id."'><input type='submit' name='delete' value='delete'></form></td>";
    	echo"<td><form method='POST' action=../staff/updateform.php><input type='hidden' id='updateid' name='updateid' value='".$id."'><input type='submit' name='update' value='edit'></form></td>";
		echo"</tr>"; 

	}

	echo "</table>";
}
else
{
	echo 'Data Not Found';
}



?>