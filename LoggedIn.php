<?php

	session_start();
	
	$diary = "";
	
	if(array_key_exists("id",$_COOKIE))
	{
		
		$_SESSION['id'] = $_COOKIE['id'];
		
	}
	
	if(array_key_exists("id",$_SESSION))
	{
		
		include("diarydatabase.php");
		
		$query = "SELECT `diary` from `users` WHERE id = ".mysqli_real_escape_string($db,$_SESSION['id'])." LIMIT 1";
		
		$row = mysqli_fetch_array(mysqli_query($db,$query));
		
		$diary = $row['diary'];
		
		
	}
	else
	{
		
		header("Location: index.php");
		
	}
	
	include("header.php");

?>
	
	
	<nav class="navbar navbar-dark bg-dark fixed-top">
		<a class="navbar-brand">Secret Diary</a>
		<div class="form-inline">
			<a href="index.php?logout=1"><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button></a>
		</div>
	</nav>
	
	<div class="container-fluid" id="containerLoggedInPage">
	
		<textarea id="diary" class="form-control"><?php echo $diary; ?> </textarea>

	</div>
	
	
	
<?php	
	
	include("footer.php");

?>
