<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['userSession'])!="")
{
 header("Location: index.php");
 exit;
}

if(isset($_POST['btn-login']))
{
	$email = $MySQLi_CON->real_escape_string(trim($_POST['user_email']));
	$upass = $MySQLi_CON->real_escape_string(trim($_POST['password']));
	
	$query = $MySQLi_CON->query("SELECT * FROM users WHERE email='$email'");
	$row=$query->fetch_array();
	$hash=$row['password'];

	if(!strcmp($upass,$hash))
	{
		$_SESSION['userSession'] = $row['user_id'];
		header("Location: index.php");
		echo "hi";
	}
	else
	{
		$msg = "Email or Password does not exist !";
		//echo "$msg";
	}

	$MySQLi_CON->close();
	
}

	if(isset($_GET['thankyou'])){
		if($_GET['thankyou']==1)
			$msg = "Kindly login with your credentials or sign up!";
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>GO-JEK Dashboard | Login</title>
	<style type="text/css">
		html {padding-top: 5rem;border: none;}
		.login {color:#BDB2D5;padding:5px;}
		.login legend {font-family: 'Oswald', sans-serif;font-weight: lighter;font-size: 30px;padding: 0;color: #BDB2D5;}
		.login .login-form {max-width: 400px;padding: 4rem;margin: 0 auto;}
		.login .form-group {margin: 0;margin-bottom: 2rem;padding: 0;}
		.login form {border: 1px solid #CEE1F1; border-radius: 4px}
	</style>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
	<div class="container login">
		<form class="login-form form-horizontal" method="post" style="background: rgb(25, 25, 54);background: rgba(25, 25, 54, .3);">
			
			<fieldset>
				<legend>Dashboard Login</legend>
				<?php
				  /*if(isset($msg)){
				     print "<br />".$msg;
				  }*/
					if(isset($msg))
						echo $msg."<hr />";
				?>
				<div class="form-group">
					<label for="user">Username</label>
					<input class="form-control" type="text" placeholder="Enter Email Address" name="user_email" required/>
					<br/>
					<label for="password">Password</label>
					<input class="form-control" type="password" placeholder="Enter Password" name="password" required/>
					<br/>
					<!--
					<label>
						<input type="checkbox" name="required">&nbsp;Remember Me
					</label>
					-->
				</div>
					<button type="submit" class="btn btn-lg btn-default btn-block"  name="btn-login"><span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;Login</button>
					
			</fieldset>
					<br />
					<label for="btn-reg">Not a member yet?</label>
					<a href="register.php" class="btn btn-lg btn-default btn-block"  name="btn-reg">Register&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span></a>
		</form>
		
	</div>
</body>
</html>
