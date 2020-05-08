<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 

$dbname = "hcysa2_kw_sakila";

$conn = mysqli_connect("localhost", "hcysa2_kw_public","W1Q1LM=Qp[X~", $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>