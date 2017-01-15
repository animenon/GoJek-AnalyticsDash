<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['userSession']))
{
 header("Location: login.php");
 exit;
}


?>
<!DOCTYPE html>
<html>
	<head>
		<title>GoJek | Dashboard - Usage Analysis</title>
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
			<li><a href="index.php"><img src="./assets/img/logo.png" width="15px" title="GoJek-Dashboard" alt="" />&nbsp;Home</a></li>
			<li><a href="location.php">Geographical Analysis</a></li>
			<li><a href="usage.php">Usage Analysis</a></li>
			<li><a href="user_ret.php">User based Analysis</a></li>
			<li style="float:right;"><a href="logout.php?logout='bye'" style="text-decoration:none;">Logout</a></li>
		</ul>
		
		
		
		<div  class="col-md-offset-2 col-md-8 col-md-offset-2" style="background-color:rgba(239, 235, 229,0.5);border-radius:10px;padding-bottom:5%;font-size:15px;">
			
			<?php
				echo "<h3>User Analysis<br /></h3><hr />
					<div class='col-md-6 text-center' style='height: 200px;border-right: thick double #000000;'><br />";
				
				$years = array("2008","2009","2010","2011");
				echo "<h4>Yearly Analysis</h4><br /><form action='user.php' method='post'>
					<select name='years'>";

				for ($i=0; $i<count($years); $i++)
				{
					echo "<option value='$years[$i]'>$years[$i]</option>";
				}
				if(isset($_POST['btn1'])){
					echo "<option selected value='".$_POST['years']."'>".$_POST['years']."</option>";
				}
				else{
					echo "<option selected value=''>Select a Year</option>";
				}
				echo" </select>
				<input type='submit' name='btn1' />
				</form>";

				
				if(isset($_POST['btn1'])){
					if($_POST['years']==''){
						echo "Choose a Year!";
					}
					else{
/**** PRINT YEARLY SALES ***
						$query1 = $MySQLi_CON->query("SELECT COUNT(ID) FROM `gojek.sales` WHERE YEAR(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))= 2009");
						$row1 = mysqli_fetch_array($query1);
						echo $row1[0];
******/
						$query = $MySQLi_CON->query("SELECT QUARTER(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i')), COUNT(QUARTER(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))) FROM gojek.sales WHERE YEAR(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))='".$_POST['years']."' GROUP BY QUARTER(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))");
						$res=array();
						$i=0;$tot=0;
						while($row = mysqli_fetch_array($query)) {				
							$res[$i][0]=$row[0];
							$res[$i][1]=$row[1];
							$i++;
							$tot+=$row[1];
						}
				
						echo "<br/><h4>Total yearly sales: $tot products sold</h4>";
					}
					
				}
			?>
			</div>
			<div class="col-md-6">
				<div id="yrChartContainer" style="height: 200px; width: 100%;"></div>
			</div>
			<div class="col-md-12"><br/><hr /><br /></div>
			<?php
				echo "<div class='col-md-6 text-center' style='height: 200px;border-right: thick double #000000;'><br />";
				
				$quarters = array("1","2","3","4");
				echo "<h4>Quarterly Analysis</h4><br /><form action='user.php' method='post'>
					<select name='quarters'>";

				for ($i=0; $i<count($quarters); $i++)
				{
					echo "<option value='$quarters[$i]'>$quarters[$i]</option>";
				}
				if(isset($_POST['btn2'])){
					echo "<option selected value='".$_POST['quarters']."'>".$_POST['quarters']."</option>";
				}
				else{
					echo "<option selected value=''>Select a Quarter</option>";
				}
				echo" </select>
				<input type='submit' name='btn2' />
				</form>";

				
				if(isset($_POST['btn2'])){
					
					if($_POST['quarters']==''){
						echo "Choose a Quarter of the Year!";
					}
					else{
						$_POST['years'] = '2009'; $_POST['btn1']=1;
						$query = $MySQLi_CON->query("SELECT MONTHNAME(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i')), COUNT(MONTH(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))) FROM gojek.sales WHERE QUARTER(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))='".$_POST['quarters']."'  GROUP BY MONTHNAME(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))");
						$res1=array();
						$i=0;$tot=0;
						while($row = mysqli_fetch_array($query)) {				
							$res1[$i][0]=$row[0];
							$res1[$i][1]=$row[1];
							$i++;
							$tot+=$row[1];
						}
				
						echo "<br/><h4>Total quaterly sales: $tot products sold</h4>";

/******************************/
						$query = $MySQLi_CON->query("SELECT QUARTER(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i')), COUNT(QUARTER(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))) FROM gojek.sales WHERE YEAR(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))='".$_POST['years']."' GROUP BY QUARTER(STR_TO_DATE(`Transaction_date`, '%d/%m/%y %H:%i'))");
												$res=array();
												$i=0;$tot=0;
												while($row = mysqli_fetch_array($query)) {				
													$res[$i][0]=$row[0];
													$res[$i][1]=$row[1];
													$i++;
												$tot+=$row[1];
						}
						
						echo "<br/><h4>Total yearly sales: $tot products sold</h4>";
/************/
					}
					
				}
			?>
			</div>
			<div class="col-md-6">
				<div id="chartContainer" style="height: 200px; width: 100%;"></div>
			</div>
		</div>
	</body>
<script type="text/javascript">
	window.onload = function () {
		var chart = new CanvasJS.Chart("chartContainer", {
			title: {
				text: "Quarterly Chart"
			},
			data: [{
				type: "column",
				dataPoints: [
					<?php
						$i=0;while($i<count($res1)){
						echo "{ y: ".$res1[$i][1].", label: '".$res1[$i][0]."'},";$i++;
						}
					?>

				]
			}]
		});
		chart.render();
		/*var chart1 = new CanvasJS.Chart("yrChartContainer", {
			title: {
				text: "Yearly Chart"
			},
			data: [{
				type: "column",
				dataPoints: [
					<?php
						$i=0;while($i<count($res)){
						echo "{ y: ".$res[$i][1].", label: '".$res[$i][0]."'},";$i++;
						}
					?>

				]
			}]
		});*/
		var chart1 = new CanvasJS.Chart("yrChartContainer",
		{
			title:{
				text: "Sales this year?",
				fontFamily: "arial black"
			},
		        animationEnabled: true,
			legend: {
				verticalAlign: "bottom",
				horizontalAlign: "center"
			},
			theme: "theme1",
			data: [
			{        
				type: "pie",
				indexLabelFontFamily: "Garamond",       
				indexLabelFontSize: 10,
				indexLabelFontWeight: "bold",
				startAngle:0,
				indexLabelFontColor: "MistyRose",       
				indexLabelLineColor: "darkgrey", 
				indexLabelPlacement: "inside", 
				toolTipContent: "Quarter:{name}",
				showInLegend: true,
				indexLabel: "#percent%", 
				dataPoints: [
					<?php
						$i=0;while($i<count($res)){
						echo "{ y: ".$res[$i][1].", name: '".$res[$i][0]."'},";$i++;
						}
					?>
				]
			}
			]
		});
		chart1.render();
	}
</script>

<script src="./assets/js/canvasjs.min.js"></script></html>

