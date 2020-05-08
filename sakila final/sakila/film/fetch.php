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

mysqli_set_charset ($conn,"utf8");
$output = '';

//------------------search-----------------------


if(isset($_POST["query"]))
{
	$search = mysqli_real_escape_string($conn, $_POST["query"]);
	$query = "
	SELECT DISTINCT * FROM film 
	WHERE film_id LIKE '%".$search."%' 
	OR title LIKE '%".$search."%'
	OR description LIKE '%".$search."%' 
	OR release_year LIKE '%".$search."%' 
	OR language_id LIKE '%".$search."%' 
	OR original_language_id LIKE '%".$search."%' 
	OR rental_duration LIKE '%".$search."%' 
	OR rental_rate LIKE '%".$search."%' 
	OR length LIKE '%".$search."%' 
	OR replacement_cost LIKE '%".$search."%' 
	OR rating LIKE '%".$search."%' 
	OR special_features LIKE '%".$search."%' 
	OR last_update LIKE '%".$search."%' 
	";
}
else
{
	$query = "
	SELECT DISTINCT * FROM film ORDER BY film_id";
}


//---------------end search----------------


//-----------------delete-------------------

try {

	if(isset($_POST['delete'])){
	    $deleteid = $_POST['deleteid'];
	    echo '</script>';
	    mysqli_query($conn,"DELETE FROM film WHERE film_id = '$deleteid'");
	    echo '<script type="text/javascript">'; 
	    echo 'alert("You have deleted the data.");';
	    echo 'window.location= "../film/index.php";';
	    echo '</script>'; 
	}



} catch (Exception $e)
        
        { echo ("<script>alert('Error deleting record. Related inventory data exists.')</script>");
    		echo ("<script>window.location= '../film/index.php'</script>");}



//----------------- end delete-----------------





$result = mysqli_query($conn, $query);


if(mysqli_num_rows($result) > 0)
{
	echo"<div class=table-responsive>
					<table class=table table bordered> <tr> 
	<th>Film ID</th>
	<th>Title</th>
	<th>Description</th>
	<th>Release year</th>
	<th>Language ID</th>
	<th>Original language ID</th>
	<th>Rental duration</th>
	<th>Rental rate</th>
	<th>Length</th>
	<th>Replacement cost</th>
	<th>Rating</th>
	<th>Special features</th>
	<th>Last update</th>
	<th></th>
	<th></th>
	</tr>";

	
	while($row = mysqli_fetch_array($result))
	{
		$id = $row['film_id'];


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
   		echo"<td>".$row['film_id']."</td>";
    	echo"<td>".$row['title']."</td>";
    	echo"<td>".$row['description']."</td>";
    	echo"<td>".$row['release_year']."</td>";
    	echo"<td>".$row['language_id']."</td>";
	    echo"<td>".$row['original_language_id']."</td>";
	    echo"<td>".$row['rental_duration']."</td>";
	    echo"<td>".$row['rental_rate']."</td>";
	    echo"<td>".$row['length']."</td>";
	    echo"<td>".$row['replacement_cost']."</td>";
	    echo"<td>".$row['rating']."</td>";
	    echo"<td>".$row['special_features']."</td>";
	    echo"<td>".$date."</td>";
	    
    	echo"<td><form method='POST' action=../film/fetch.php><input type='hidden' id='deleteid' name='deleteid' value='".$id."'><input type='submit' name='delete' value='delete'></form></td>";
    	echo"<td><form method='POST' action=../film/update.php><input type='hidden' id='updateid' name='updateid' value='".$id."'><input type='submit' name='update' value='edit'></form></td>";
		echo"</tr>"; 
	}

	echo "</table>";
}
else
{
	echo 'Data Not Found';
}



?>