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
		<title>GoJek | Location Analysis</title>
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
				echo "<h3>Location Analysis<br /></h3><hr />
					<div class='col-md-12 text-center'><br />";
				/*$query = $MySQLi_CON->query("SELECT `Country`, `City`, COUNT(`ID`) FROM gojek.sales GROUP BY `Country`, `City` ORDER BY COUNT(`ID`) DESC LIMIT 5 ");
				$i=0;
				while($row = mysqli_fetch_array($query)) {				
				$rec[$i][0]=$row[0];
				$rec[$i][1]=$row[1];
				$rec[$i][2]=$row[2];
				$i++;
				}
				$m=0;
				while($i>=$m){
					$j=0;
					while($j<3){
						echo $rec[$m][$j]." ";
						$j++;
					}
					echo "<br />";
					$m++;
				}*/
			?>
			
			<?php
				
				$cars = array("United States", "United Kingdom", "Canada", "Ireland", "Australia", "Switzerland", "France", "Germany", "Netherlands", "Norway", "Denmark", "Italy", "Sweden", "Spain", "Belgium", "Austria", "New Zealand", "Turkey", "United Arab Emirates", "Brazil", "South Africa", "Czech Republic", "Hungary", "Finland", "India", "Japan", "Malta", "Monaco", "Philippines", "Poland", "Thailand", "The Bahamas", "Argentina", "Bahrain", "Bermuda", "Bulgaria", "Cayman Isls", "China", "Costa Rica", "Dominican Republic", "Greece", "Guatemala", "Hong Kong", "Iceland", "Israel", "Jersey", "Kuwait", "Latvia", "Luxembourg", "Malaysia", "Mauritius", "Moldova", "Romania", "Russia", "South Korea", "Ukraine");
				echo "<form action='location.php' method='post'>
					<select name='cars'>";

				for ($i=0; $i<count($cars); $i++)
				{
					echo "<option value='$cars[$i]'>$cars[$i]</option>";
				}
				if(isset($_POST['btn1'])){
					echo "<option selected value='".$_POST['cars']."'>".$_POST['cars']."</option>";
				}
				else{
					echo "<option selected value=''>Select a Country</option>";
				}
				echo" </select>
				<input type='submit' name='btn1' />
				</form>";

				
				if(isset($_POST['btn1'])){
					//echo "SELECT `City`,COUNT(`ID`) FROM `sales` WHERE `Country`= 'United States' GROUP BY `City`";
					if($_POST['cars']==''){
						echo "Choose a Country!";
					}
					else{
						$query = $MySQLi_CON->query("SELECT `City`, COUNT(`ID`) FROM gojek.sales WHERE `Country`= '".$_POST['cars']."' GROUP BY `Country`, `City`");
						$res=array();
						$i=0;
						while($row = mysqli_fetch_array($query)) {				
							$res[$i][0]=$row[0];
							$res[$i][1]=$row[1];
							$i++;
						}
					}
					/*$i=0;
					  while($i<count($res)){
						echo $res[$i][0]." ".$res[$i][1]."\n";
						$i++;
					}*/
				}
			?>
			</div>
			<div class="col-md-12">
				<div id="chartContainer" style="height: 200px; width: 100%;"></div>
			</div>
		</div>
	</body>
<script type="text/javascript">
	window.onload = function () {
		var chart = new CanvasJS.Chart("chartContainer", {
			title: {
				text: "Analysis Chart"
			},
			data: [{
				type: "column",
				dataPoints: [
					<?php
						$i=0;while($i<count($res)){
						echo "{ y: ".$res[$i][1].", label: '".$res[$i][0]."'},";$i++;
						}
					?>

					/*{ y: <?php echo $res[0][1]; ?>, label: "<?php echo $res[0][0]; ?>" },
					{ y: <?php echo "1"; ?>, label: "Resolved" },
					{ y: <?php echo "1"; ?>, label: "Assigned" },
					{ y: <?php echo "1"; ?>, label: "In Progress" },
					*/
				]
			}]
		});
		chart.render();
	}
</script>

<script src="./assets/js/canvasjs.min.js"></script>

</html>

