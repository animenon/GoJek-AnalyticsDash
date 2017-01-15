<?php
session_start();
include_once 'dbconnect.php';
/*
if(!isset($_SESSION['userSession']))
{
 header("Location: login.php");
 exit;
}
*/

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Free India | Complaint Status</title>
		<link rel="shortcut icon" href="./assets/img/logo.png">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
		<script src="./assets/js/jquery.min.js"></script>
		<script src="./assets/js/bootstrap.min.js"></script>
		<script type= "text/javascript" src = "./assets/js/cs.js"></script>
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
		
		<div  class="col-md-offset-2 col-md-8 col-md-offset-2" style="background-color:rgba(239, 235, 229,0.5);border-radius:10px;padding-bottom:5%;font-size:15px;">
			
			<?php
				echo "<h3>User Retention<br /></h3><hr /><br />
					<div class='col-md-6'>";
				$res=array();
				//lost>100
				//retainable<100 but >10
				//active <10
				$retain = $MySQLi_CON->query("SELECT COUNT(*) FROM (SELECT user_id, CONCAT(DATEDIFF(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'),STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i')), 'days') FROM gojek.sales WHERE DATEDIFF(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'),STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))>10 AND DATEDIFF(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'),STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))<100 ORDER BY DATEDIFF(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'),STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i')) ) AS A");
				$row = mysqli_fetch_array($retain);$res[0]=$row[0];
				echo "<h4><div class='col-md-6'>Retainable Users</div>: $row[0]users<br /><br />";
				$active = $MySQLi_CON->query("SELECT COUNT(*) FROM (SELECT user_id, CONCAT(DATEDIFF(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'),STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i')), 'days') FROM gojek.sales WHERE DATEDIFF(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'),STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))<10 ORDER BY DATEDIFF(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'),STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i')) ) AS A");
				$row = mysqli_fetch_array($active);$res[1]=$row[0];
				echo "<div class='col-md-6'>Activer Users</div>: $row[0]users<br /><br />";
				$lost = $MySQLi_CON->query("SELECT COUNT(*) FROM (SELECT user_id, CONCAT(DATEDIFF(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'),STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i')), 'days') FROM gojek.sales WHERE DATEDIFF(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'),STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))>100 ORDER BY DATEDIFF(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'),STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i')) ) AS A");
				$row = mysqli_fetch_array($lost);$res[2]=$row[0];
				echo "<div class='col-md-6'>Lost Customers</div>: $row[0]users</h4>";

				
			?></div><!-- md8 -->

			<div class="col-md-6">
				<div id="chartContainer" style="height: 200px; width: 100%;"></div>
			</div>
<br />
			<div class="col-md-12">
				<hr /><h4>User Churn<br /></h4><br />
					<div class='col-md-4 col-md-offset-2'><b>
			<?php
				$churn = $MySQLi_CON->query("SELECT QUARTER(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i')),COUNT(user_id) FROM gojek.sales WHERE QUARTER(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'))=1
GROUP BY QUARTER(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'))");
				$q1 = mysqli_fetch_array($churn);
				echo "Quarter 1 : ".$q1[1]." users<br /><br />";
			 	$churn = $MySQLi_CON->query("SELECT QUARTER(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i')),COUNT(user_id) FROM gojek.sales WHERE QUARTER(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'))=2
GROUP BY QUARTER(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'))");
				$q2 = mysqli_fetch_array($churn);
				echo "Quarter 2 : ".$q2[1]." users<br /><br />";
			 	$churn = $MySQLi_CON->query("SELECT QUARTER(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i')),COUNT(user_id) FROM gojek.sales WHERE QUARTER(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'))=3
GROUP BY QUARTER(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'))");
				$q3 = mysqli_fetch_array($churn);
				echo "Quarter 3 : ".$q3[1]." users<br /><br />";
			 	$churn = $MySQLi_CON->query("SELECT QUARTER(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i')),COUNT(user_id) FROM gojek.sales WHERE QUARTER(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'))=4
GROUP BY QUARTER(STR_TO_DATE(`Last_Login`, '%d/%m/%y %H:%i'))");
				$q4 = mysqli_fetch_array($churn);
				echo "Quarter 4 : ".$q4[1]." users<br />";
			 	$MySQLi_CON->close();
			?></b></div>
			<div class="col-md-6">
				<div id="chartContainer1" style="height: 200px; width: 100%;"></div>
			</div>
			</div>
		</div>
	</body>
<script type="text/javascript">
	window.onload = function () {
		var chart = new CanvasJS.Chart("chartContainer", {
			title:{
				text: "Customer Retention",
				horizontalAlign: "right"
			},
			axisX: {
				tickThickness: 0,
				interval: 1,
				intervalType: "year"
			},
                        animationEnabled: true,
			toolTip: {
				shared: true
			},
			axisY: {
				lineThickness: 0,
				tickThickness: 0,
				interval: 20
			},
			legend:{
				verticalAlign: "center",
				horizontalAlign: "left"
			},

			data: [
			{        
				name: "Active",
				showInLegend: true,
				type: "stackedColumn100", 
				color: "#004B8D ",
				dataPoints: [
				{x: new Date(2009,0), y: <?php echo $res[1]; ?> },
				]
			}, 
			{        
				name: "Retainable",
				showInLegend: true,
				type: "stackedColumn100", 
				color: "#0074D9 ",
				dataPoints: [
				{x: new Date(2009,0), y: <?php echo $res[0]; ?>}
				]
			}, 
			{        
				name: "Lost",
				showInLegend: true,
				type: "stackedColumn100", 
				color: "#7ABAF2 ",
				dataPoints: [
				{x: new Date(2009,0), y: <?php echo $res[2]; ?>}
				]
			}

			]
		});
		chart.render();
		var chart = new CanvasJS.Chart("chartContainer1",
		    {
		      theme: "theme2",
		      title:{
			text: "Churn per Month"
		      },
		      animationEnabled: true,
		      axisX: {
			valueFormatString: "MMM",
			interval:1,
			intervalType: "month"
		
		      },
		      axisY:{
			includeZero: false
		
		      },
		      data: [
		      {        
			type: "line",
			//lineThickness: 3,        
			dataPoints: [
			{ x: new Date(2009, 00, 1), y: 450 },
			{ x: new Date(2009, 01, 1), y: 414},
			{ x: new Date(2009, 02, 1), y: 520, indexLabel: "highest",markerColor: "red", markerType: "triangle"},
			{ x: new Date(2009, 03, 1), y: 460 },
			{ x: new Date(2009, 04, 1), y: 450 },
			{ x: new Date(2009, 05, 1), y: 500 },
			{ x: new Date(2009, 06, 1), y: 480 },
			{ x: new Date(2009, 07, 1), y: 480 },
			{ x: new Date(2009, 08, 1), y: 410 , indexLabel: "lowest",markerColor: "DarkSlateGrey", markerType: "cross"},
			{ x: new Date(2009, 09, 1), y: 500 },
			{ x: new Date(2009, 10, 1), y: 480 },
			{ x: new Date(2009, 11, 1), y: 510 }
		
			]
		      }
		      
		      
		      ]
		    });

		chart.render();
	}
</script>

<script src="./assets/js/canvasjs.min.js"></script>


</html>

