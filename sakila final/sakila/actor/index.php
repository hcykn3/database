<!DOCTYPE html>
<html>
<title>Sakila</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>

<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block w3-border-right bar" style="display:none" id="mySidebar">
  <button onclick="w3_close()" class="w3-bar-item w3-large bar">Close &times;</button>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/index.php" class="w3-bar-item w3-button">Actor</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/address/index.php" class="w3-bar-item w3-button">Address</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/category/index.php" class="w3-bar-item w3-button">Category</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/city/index.php" class="w3-bar-item w3-button">City</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/country/index.php" class="w3-bar-item w3-button">Country</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/customer/index.php" class="w3-bar-item w3-button">Customer</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/film/index.php" class="w3-bar-item w3-button">Film</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/film_actor/index.php" class="w3-bar-item w3-button">Film actor</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/film_category/index.php" class="w3-bar-item w3-button">Film category</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/film_text/index.php" class="w3-bar-item w3-button">Film text</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/inventory/index.php" class="w3-bar-item w3-button">Inventory</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/language/index.php" class="w3-bar-item w3-button">Language</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/payment/index.php" class="w3-bar-item w3-button">Payment</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/rental/index.php" class="w3-bar-item w3-button">Rental</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/staff/index.php" class="w3-bar-item w3-button">Staff</a>
  <a href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/store/index.php" class="w3-bar-item w3-button">Store</a>

</div>

<div class="bar">
  <button class="w3-button w3-xlarge bar " onclick="w3_open()">☰</button>
  <div class="w3-container">

  </div>
</div>



<div class="w3-container">



<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Actor</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
    </head>
	<body>
		<div class="container">
			<br />
			<br />
			<h1 align="center">Actor</h1><br />
			<div>
             <form action="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/logout.php"><input type="submit" value="Sign out" style="float: right"/> </form>
             </br>
             </br>
        		<form action="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/insert_actor.php"><input type="submit" value="Insert new actor" style="float: right"/> </form>
			</div>
			<br />
			<br />
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon ab">Search</span>
					<input type="text" name="search_text" id="search_text" placeholder="by actor ID, first name, last name or last update" class="form-control abc" />
				</div>
			</div>
			<br />


			
			<div id="result"></div>
		</div>
		<div style="clear:both"></div>
		<br />
		
		<br />
		<br />
		<br />

	</body>
</html>


<script>
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
}

function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
}





$(document).ready(function(){
	load_data();
	function load_data(query)
	{
		$.ajax({
			url:"https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/actor/fetch.php",
			method:"post",
			data:{query:query},
			success:function(data)
			{
				$('#result').html(data);
			}
		});
	}
	
	$('#search_text').keyup(function(){
		var search = $(this).val();
		if(search != '')
		{
			load_data(search);
		}
		else
		{
			load_data();			
		}
	});


});
</script>







