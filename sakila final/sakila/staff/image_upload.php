<?php



include('../database_connection.php'); 
include('../staff/error_array.php');
session_start();
$id= $_SESSION['id'];




if(isset($_POST['submit'])){



  $file=$_FILES['file']; //file name

  $fileName=$_FILES['file']['name'];
  $fileTmpName=$_FILES['file']['tmp_name'];
  $fileSize=$_FILES['file']['size'];
  $fileError=$_FILES['file']['error'];
  $fileType=$_FILES['file']['type'];

  $fileExt=explode('.',$fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array ('jpg','jpeg','png'); //file types allowed

  if (in_array($fileActualExt, $allowed)){ //if file type matches

    if($fileError===0){

      if($fileSize<65535){


        $fileNameNew = uniqid('',true).".".$fileActualExt;


        $fileDestination='upload/'.$fileNameNew;

        move_uploaded_file($fileTmpName, $fileDestination);
        

		$sql="UPDATE staff SET picture='$fileDestination' WHERE staff_id=$id";


		    	if(mysqli_query($conn, $sql))
		        {

		          echo("<script>alert('Staff information successfully added.')</script>");
		          echo("<script>window.location = '../staff/index.php';</script>");

		        }


		        

			 $conn -> close(); 













     




      } else {

        $errors['picture_err'] = 'File is too big';

      }


    } else {

      $errors['picture_err'] = 'Error uploading file';

    }

  } else {

      $errors['picture_err'] = 'You cannot upload files of this type.';

  }





}


?>



<!DOCTYPE html>


<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://hcysa2.mercury.nottingham.edu.my/hcykn3/sakila/test.css" />
    <title>Staff image</title>
    <meta charset="utf-8">
</head>

<body class=upl>
<form action="../staff/image_upload.php" method="post" enctype="multipart/form-data">
        </br>
        </br>
        Select image to upload:
        </br>
        </br>
        <input type="file" title="upload" name="file" id="file" >
        <div class="red-text"><?php echo $errors['username_err']; ?></div>
        <button type="submit" name="submit">Upload</button>
        <div class="red-text"><?php echo $errors['picture_err']; ?></div>
</form>
</body>




