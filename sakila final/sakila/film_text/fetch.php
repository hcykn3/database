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
	SELECT DISTINCT * FROM film_text
	WHERE film_id LIKE '%".$search."%'
	OR title LIKE '%".$search."%'
	OR description LIKE '%".$search."%'
	";
}
else
{
	$query = "
	SELECT DISTINCT * FROM film_text ORDER BY film_id";
}
//---------------end search----------------


//-----------------delete-------------------


if(isset($_POST['delete'])){
    $deleteid = $_POST['deleteid'];
    echo '</script>';
    mysqli_query($conn,"DELETE FROM film_text WHERE film_id = '$deleteid'");
    echo '<script type="text/javascript">'; 
    echo 'alert("You have deleted the data.");';
    echo 'window.location= "../film_text/index.php";';
    echo '</script>'; 
    }


//----------------- end delete-----------------





$result = mysqli_query($conn, $query);


if(mysqli_num_rows($result) > 0 && !isset($_POST['update']))
{
	echo"<div class=table-responsive>
					<table class=table table bordered> <tr> 
	<th>Film ID</th>
	<th>Title</th>
	<th>Description</th>
	<th></th>
	<th></th>


	</tr>";

	while($row = mysqli_fetch_array($result))
	{
		$id = $row['film_id'];
    	echo"<tr>";
   		echo"<td>".$row['film_id']."</td>";
	    echo"<td>".$row['title']."</td>";
	    echo"<td>".$row['description']."</td>";

   
    	echo"<td><form method='POST' action=../film_text/fetch.php><input type='hidden' id='deleteid' name='deleteid' value='".$id."'><input type='submit' name='delete' value='delete'></form></td>";
    	echo"<td><form method='POST' action=../film_text/updateform.php><input type='hidden' id='updateid' name='updateid' value='".$id."'><input type='submit' name='update' value='edit'></form></td>";
		echo"</tr>"; 

	}

	echo "</table>";
}
else
{
	echo 'Data Not Found';
}



?>