<?php

include('https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/database_connection.php');


if(!isset($_SESSION)){session_start();}

$_SESSION=array();
if (ini_get("session.use_cookies")) {
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

mysqli_set_charset ($conn,"utf8");
$output = '';

//------------------search-----------------------


if(isset($_POST["query"]))
{
	$search = mysqli_real_escape_string($conn, $_POST["query"]);
	$query = "
	SELECT DISTINCT * FROM actor 
	WHERE first_name LIKE '%".$search."%'
	OR last_name LIKE '%".$search."%' 
	OR actor_id LIKE '%".$search."%' 
	OR last_update LIKE '%".$search."%' 
	";
}
else
{
	$query = "
	SELECT DISTINCT * FROM actor ORDER BY actor_id";
}


//---------------end search----------------


//-----------------delete-------------------


if(isset($_POST['delete'])){
    $deleteid = $_POST['deleteid'];
    echo '</script>';
    mysqli_query($conn,"DELETE FROM actor WHERE actor_id = '$deleteid'");
    echo '<script type="text/javascript">'; 
    echo 'alert("You have deleted the data.");';
    echo 'window.location= "https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/index.php";';
    echo '</script>'; 
    }


//----------------- end delete-----------------





$result = mysqli_query($conn, $query);


if(mysqli_num_rows($result) > 0)
{
	echo"<div class=table-responsive>
					<table class=table table bordered> <tr> 
	<th>Actor ID</th>
	<th>First name</th>
	<th>Last name</th>
	<th>Last update</th>
	<th></th>
	<th></th>
	</tr>";

	while($row = mysqli_fetch_array($result))
	{
		$id = $row['actor_id'];
    	echo"<tr>";
   		echo"<td>".$row['actor_id']."</td>";
    	echo"<td>".$row['first_name']."</td>";
    	echo"<td>".$row['last_name']."</td>";
    	echo"<td>".$row['last_update']."</td>";
    	echo"<td><form method='POST' action=https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/fetch.php><input type='hidden' id='deleteid' name='deleteid' value='".$id."'><input type='submit' name='delete' value='delete'></form></td>";
    	echo"<td><form method='POST' action=https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/update.php><input type='hidden' id='updateid' name='updateid' value='".$id."'><input type='submit' name='update' value='edit'></form></td>";
		echo"</tr>"; 
	}

	echo "</table>";
}
else
{
	echo 'Data Not Found';
}



?>