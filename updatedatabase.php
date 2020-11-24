<?php

	session_start();

	if(array_key_exists("content",$_POST))
	{
		
		include("diarydatabase.php");
		
		$query = "UPDATE `users` SET `diary` = '".mysqli_real_escape_string($db, $_POST['content'])."' WHERE id = ".mysqli_real_escape_string($db, $_SESSION['id'])." LIMIT 1";
		
		mysqli_query($db, $query);
		
	}

	





?>