<?php
	
	session_start();
	
	ob_start();
	
	$error ="";
	
	if(array_key_exists("logout",$_GET))
	{
		
		session_destroy();
		unset($_SESSION['id']);
		setcookie("id","",time() - 60 * 60);
		$_COOKIE["id"] = "";
	
	}
	else if((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("id",$_COOKIE) AND $_COOKIE['id']))
	{
		
		header("Location: LoggedIn.php");
		
	}
		

	if(array_key_exists("submit", $_POST))
	{
		
		include("diarydatabase.php");
		
		
		if($_POST['email'] == null)
		{
			
			$error .= "The email field is required!<br>";
			
		}
		
		if($_POST['password'] == null)
		{
			
			$error .= "The password field is required!<br>";
			
		}
		
		if($error != null)
		{
			
			$error = "<p>There were error(s) in your form</p>" . $error;
			
		}
		else
		{
			
			if($_POST['signUp'] == 1)
			{
				
				$query = "SELECT `id` FROM `users` WHERE email = '" .mysqli_real_escape_string($db,$_POST['email']). "' LIMIT 1";
				
				$result = mysqli_query($db,$query);
				
				if(mysqli_num_rows($result) > 0)
				{
					
					$error = "This email is already registered with us!";
					
				}
				else
				{
					
					$query = "INSERT INTO `users` (`email`,`password`) VALUES ('" .mysqli_real_escape_string($db,$_POST['email']). "','" .mysqli_real_escape_string($db,$_POST['password']). "')"; 
					
					if(!mysqli_query($db,$query))
					{
						
						$error = "<p>	Could not sign you up - please try again later.</p>";
						
					}
					else
					{
						
						$query = "UPDATE `users` SET password = '".password_hash($_POST['password'],PASSWORD_DEFAULT)."' WHERE id =".mysqli_insert_id($db)." LIMIT 1";
						
						mysqli_query($db,$query);
						
						$_SESSION['id']  = mysqli_insert_id($db);
						
						if($_POST['LoggedIn'] == '1')
						{
							
							setcookie("id",mysqli_insert_id($db),time() + 60 * 60 *24 * 365);						
							
							header("Location: LoggedIn.php");
						
						}
					
					}
				}
			}
			else
			{
				
				$query = "SELECT * FROM `users` WHERE email ='".mysqli_real_escape_string($db,$_POST['email'])."'";
				
				$result = mysqli_query($db,$query);
				
				$row = mysqli_fetch_array($result);
					
				if(isset($row))
				{
				
					if(password_verify($_POST['password'],$row['password']))
					{
						
						$_SESSION['id'] = $row['id'];
						
						if($_POST['LoggedIn'] == '1')
						{
							
							setcookie("id",$row['id'],time() + 60 * 60 *24 * 365);
				
						}
						
						header("Location: LoggedIn.php");
						
					}
					else
					{
					
					$error = "The Email or Password you entered is wrong.";
					
					}
				}
				else
				{
					
					$error = "The Email or Password you entered is wrong.";
					
				}
			}
		
		}
	}
	
	





ob_end_flush();

?>

	<?php include("header.php"); ?>
	
		<div id="homePageContainer" class="container">
		
			<h1> Secret Diary </h1>
			
			<p><strong>Store your Thoughts permanently and securely!</strong></p>
			
			<div id="error"><?php if($error != null)
								  {
										
									echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';	
								
								  }
								
							?>
			</div>
			
			<form method="post" id="signUpForm">
			
				<p>Intrested?Sign Up now.</p>
				
				<div class="form-group">
					<input type="email" class="form-control" name="email" placeholder="Your Email" >
				</div >
					
				<div class="form-group">
					<input type="password" class="form-control" name="password" placeholder="Password" >
				</div>
					
				<div class="form-group form-check">		
					<input  type="checkbox" class="form-check-input" id="check1" name="LoggedIn" value="1">
					<label class="form-check-label" for="check1">Stay Logged In</label>
				</div>
					
				<div class="form-group">
					<input type="hidden" name="signUp" value="1">
					<input type="submit" class="btn btn-success" name="submit" value="SignUp!">
				</div>
					
				<p><a href="#" class="toggleForms">Log in</a></p>	
				
				
			</form>	
			
			<form method="post" id="logInForm">
			
				<p>Login using your Username and Password.</p>
				
				<div class="form-group">
					<input type="email" class="form-control" name="email" placeholder="Your Email" >
				</div>
					
				<div class="form-group">
					<input type="password" class="form-control" name="password" placeholder="Password" >
				</div>
					
				<div class="form-group form-check">
					<input  type="checkbox" class="form-check-input" id="check2" name="LoggedIn" value="1">
					<label class="form-check-label" for="check2">Stay Logged In</label>
				</div>

				<div class="form-group">
					<input type="hidden" name="signUp" value="0">
					<input type="submit" class="btn btn-success" name="submit"  value="Login">
				</div>
					
				<p><a href="#" class="toggleForms">Sign Up</a></p>	
					
			</form>
				
		</div>
	
	
	<?php include("footer.php"); ?>