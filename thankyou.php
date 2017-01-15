
<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['userSession']))
{
 header("Location: login.php");
 exit;
}

?>
<html>
	<head>
		<title>Free India | Complaint has been lodged!</title>
		<link rel="shortcut icon" href="./assets/img/logo.png">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--<meta http-equiv="refresh" content="3;url=home.php" />-->
		<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
		<script src="./assets/js/jquery.min.js"></script>
		<script src="./assets/js/bootstrap.min.js"></script>
		<script type= "text/javascript" src = "./assets/js/cs.js"></script>
		<script type= "text/javascript" src = "./assets/js/loc.js"></script>
		<link rel="stylesheet" href="./assets/css/style.css">
		
	</head>
	<body>
		<ul class="nav nav-pills" role="tablist" style="background-color:rgba(63,84,191,0.3);margin:5%;border-radius:5px;">
			<li><a href="home.php"><img src="./assets/img/logo.png" width="15px" title="Citizen Services" alt="" />&nbsp;Home</a></li>
			<li><a href="complaint.php">Complaints Analysis</a></li>
			<li><a href="status.php">Complaint Status</a></li>
			<li style="float:right;"><a href="logout.php?logout='bye'" style="text-decoration:none;">Logout</a></li>
			<li style="float:right;"><a href="others.php">Other Useful Links</a></li>
			
		</ul>
		<div  class=" col-md-offset-2 col-md-8 col-md-offset-2" style="background-color:rgba(239, 235, 229,0.5);border-radius:10px;padding-bottom:5%;font-size:15px;">
			<?php
			if(isset($_GET['comp']))
			{
				echo "<h2>Your complaint has been lodged!<br /> Complaint number: ".$_GET['comp']." </h2>";
				$query = $MySQLi_CON->query("SELECT email FROM users WHERE user_id='".$_SESSION['userSession']."'");
				$row=mysqli_fetch_array($query);
				$msg = "You have lodged a complaint using the 'Free India' website.\n Your complaint number is ".$_GET['comp'];
				// use wordwrap() if lines are longer than 70 characters
				$msg = wordwrap($msg,70);
				// send email
				//mail($row[0],"Citizen Services complaint lodged",$msg);
				echo "The complaint number is mailed to you on <b>".$row[0]."</b>";				
			}
			?>
		</div>
	</body>
</html>
