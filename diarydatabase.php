<?php

$dbhost = "localhost";
	
	$dbuser = "root";
	
	$dbpass = "";
	
	$dbname = "secretdiary";
	
	$db = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
	
	if(mysqli_connect_error())
	{
		
		die ("There was an error connecting to the database");
		
	}
	
?>