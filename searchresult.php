<?php
session_start();
include 'header.php';
if(!isset($_SESSION["searchrollno"]))
	header('Location:index.php');
$rollno =  $_SESSION["searchrollno"];
$section = $_SESSION["searchsection"]; 
$link = start_connection($database_name);
$sql = "SELECT * FROM $section WHERE rollno=$rollno";
$reslut = mysqli_query($link,$sql);
$rows = mysqli_fetch_assoc($reslut);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title>
</head>
<link rel="stylesheet" type="text/css" href="allcss.css">
<body>
<p class="instruc">Roll Number : <span id="detailtext"><?php echo $rows["rollno"]?></span></p>
<p class="instruc">Full Name : <span id="detailtext"><?php echo $rows["fullname"]?></span></p>
<p class="instruc">Section : <span id="detailtext"><?php echo strtoupper($section)?></span></p>
<table class="searchresulttable" width="50%">
	<tr><td class="searchresulttabletd" width="150px"><center>Subjects</center></td><td class="searchresulttabletd" width="60px"><center>Marks</center></td></tr>
	<?php
	$obtained = 0;
	$subjects = array('Physics','Chemistry','Mathematics','Biology/Comp.Sc.','Islamiat/Pak.St','Urdu','English');
	$subjecttables = array('pmarks','cmarks','mmarks','bcmarks','ipmarks','umarks','emarks');
	for($i=0;$i<7;$i++){
	echo "<tr><td class=\"searchresulttabletd\">$subjects[$i]</td>
		<td class=\"searchresulttabletd\"><center>".$rows[$subjecttables[$i]]."</center></td>
		</tr>";
		$obtained = $obtained + $rows[$subjecttables[$i]];
	}
	$percentage = $obtained/550*100;
	?>
</table>
<p class="instruc">Obatined Marks : <span id="detailtext"><?php echo $obtained?></p></span>
<p class="instruc">Total Marks : <span id="detailtext">550</span></p>
<p class="instruc">Percentage : <span id="detailtext"><?php echo number_format($percentage,2,".",",")?></span></p>
<p class="instruc">Status : <span id="detailtext"><?php echo ($percentage<40) ? "Fail" : "Pass" ?></span></p>
<?php
session_destroy()?>
</body>
</html>