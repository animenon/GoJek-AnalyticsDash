<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['userSession']))
{
 header("Location: login.php");
}


if(isset($_POST['btn-submit']))
{
	$complaint = (trim($_POST['complaint']));
	$issue = trim($_POST['subIssue']);
	$loc= trim($_POST['loc']);
	$specific_loc= trim($_POST['address']);
	$desc= trim($_POST['desc']);
	$s="";
	$s.="PWD".rand(10000,100000);
	
	$query = $MySQLi_CON->query("INSERT INTO complaints(comp_id,user_id,comp_type,sub_type,description,loc,addr,status,assigned_to) VALUES('$s', '".$_SESSION['userSession']."',$complaint,$issue,'$desc','$loc','$specific_loc','IN_PROGRESS','0')");
	
	if($query === TRUE){
		$query = $MySQLi_CON->query("SELECT comp_id FROM complaints WHERE user_id='".$_SESSION['userSession']."' ORDER BY Time DESC LIMIT 1");
		$row=mysqli_fetch_array($query);
		//echo $row[0];
		header("Location: thankyou.php?comp=".$row[0]);
	}else{
		echo "Error: " . $query . "<br>" . $MySQLi_CON->error;
	}

	$MySQLi_CON->close();
	
}
?><!DOCTYPE html>
<html>
	<head>
		<title>GoJek | Dashboard</title>
		<link rel="shortcut icon" href="./assets/img/logo.png">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
		<script src="./assets/js/jquery.min.js"></script>
		<script src="./assets/js/bootstrap.min.js"></script>
		<script type= "text/javascript" src = "./assets/js/cs.js"></script>
		<script type= "text/javascript" src = "./assets/js/loc.js"></script>
		<link rel="stylesheet" href="./assets/css/style.css">
		<style>.btn:hover {
			    background-color: #BDBDB5;
			} .btn:active {
			    background-color: #BDB0B0;
			}
		</style>
		
	</head>
	<body>
		<ul class="nav nav-pills" role="tablist" style="background-color:rgba(63,84,191,0.3);margin:5%;border-radius:5px;">
			<li><a href="index.php"><img src="./assets/img/logo.png" width="15px" title="GoJek-Dashboard" alt="" />&nbsp;Home</a></li>
			<li><a href="location.php">Geographical Analysis</a></li>
			<li><a href="usage.php">Usage Analysis</a></li>
			<li><a href="user_ret.php">User based Analysis</a></li>
			<li style="float:right;"><a href="logout.php?logout='bye'" style="text-decoration:none;">Logout</a></li>
		</ul>
		
		<div class="container">
			<div class=" col-md-offset-2 col-md-8 col-md-offset-2" style="background-color:rgba(239, 235, 229,0.5);border-radius:10px;padding-bottom:5%;font-size:15px;">
				<h2><img src="./assets/img/logo.png" width="30px" title="GoJek-Dashboard" alt="" /> <span>GoJek</span></h2><hr />
				<form method="POST">	
					<div style="background-color:#EFEBE5; padding:2%;margin:2%;border-radius:5px;" title="The Total Aggregated Sales">Total Sales: <b>
					<?php $query = $MySQLi_CON->query("SELECT COUNT(*) FROM gojek.sales");
						$row=mysqli_fetch_array($query);
						echo $row[0]." units";
					?></b></div>
					<div style="background-color:#EFEBE5; padding:2%;margin:2%;border-radius:5px;" title="The Higehst sold product">Highest sold product: <b>
					<?php $query = $MySQLi_CON->query("SELECT `Product`, COUNT(`ID`) FROM gojek.sales GROUP BY `Product` LIMIT 1;");
						$row=mysqli_fetch_array($query);
						echo $row[0];
					?></b></div>
					<div style="background-color:#EFEBE5; padding:2%;margin:2%;border-radius:5px;" title="The Highest Sales by City">Highest Sales(by City):<b>
					<?php $query = $MySQLi_CON->query("SELECT `City`, COUNT(`ID`) FROM gojek.sales GROUP BY `City` ORDER BY COUNT(`ID`) DESC LIMIT 1;");
						$row=mysqli_fetch_array($query);
						echo $row[0];
					?></b></div>
					<div style="background-color:#EFEBE5; padding:2%;margin:2%;border-radius:5px;" title="The Highest Sales by Country">Highest Sales(by Country):<b>
					<?php $query = $MySQLi_CON->query("SELECT `Country`, COUNT(`ID`) FROM gojek.sales GROUP BY `Country` ORDER BY COUNT(`ID`) DESC LIMIT 1;");
						$row=mysqli_fetch_array($query);
						echo $row[0];
					?></b></div>
										
				</form>
					
			</div>
		</div>
	</body>
</html>

