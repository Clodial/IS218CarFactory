<!doctype html>
<html>
<head>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
//include("inc/db_credentials.php");	//This is getting ready for PHP funsies
include("app/app_class.php");
//include("app/app_func.php");
include("app/db_connect.php");

$fFile = "files/carCSV.csv";

$main = new cl_main($fFile);

?>	
</body>
</html>