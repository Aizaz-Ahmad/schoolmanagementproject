<?php
session_start();
if(!isset($_SESSION["section"]) and !isset($_SESSION["username"])) header('Location:index.php');
	include 'header.php';
$link = start_connection($database_name);
if($_SERVER["REQUEST_METHOD"]=="POST" and isset($_SESSION["username"]))
	$sql = "SELECT * FROM ".$_POST['section']."";
else
	$sql = "SELECT * FROM ".$_SESSION['section']."";
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="allcss.css">
	<title>View Students</title>
</head>
<body>
<div id="sidebar">
	<a href="studentdetails.php">Add Student</a>
	<a href="viewstudent.php">View Students</a>
	<a href="main.php">Register Teacher</a>
	<a href="studentmarks.php">Upload Marks</a>
	<a href="updatemarks.php">Update Marks</a>
	<a href="updatedetails.php">Update Student Details</a>
	<a href="deletestudent.php">Delete Student Record</a>
	<a href="logout.php">Log Out</a>
</div>
<div id="bigwrap">
	<p id="p2">Student Record</p>
	<?php if(isset($_SESSION["username"]) and !isset($_SESSION["section"])){?>
	<form action="viewstudent.php" method="POST">
	<select name="section">
			<?php
				if(file_exists("sectiondetails.txt")){
					$file =fopen("sectiondetails.txt","r");
					while (!feof($file)) {
						$names = fgets($file);
						if(!feof($file))
						echo "<option value=$names>$names</option>";
					}
				}
			?>
	</select>
	<input type="submit" name="sectionselec" value="Select">
	</form>
<?php }?>
	<table class="viewstudenttable">
		<tr>
			<td class="vistutabtd">Roll No.</td>
			<td class="vistutabtd" width="300px"><center>Full Name</center></td>
			<td class="vistutabtd">Physics Marks</td>
			<td class="vistutabtd">Maths Marks</td>
			<td class="vistutabtd">Chem Marks</td>
			<td class="vistutabtd">English Marks</td>
			<td class="vistutabtd">Urdu Marks</td>
			<td class="vistutabtd">Bio/Comp Marks</td>
			<td class="vistutabtd">Isl/Pak.St Marks</td>
		</tr>
		<?php
			$result = mysqli_query($link,$sql);
			if(mysqli_num_rows($result)>0){
				while($rows = mysqli_fetch_assoc($result)){
					echo "<tr>
			<td class=\"vistutabtd\">".$rows["rollno"]."</td>
			<td class=\"vistutabtd\" width=\"300px\"><center>".$rows["fullname"]."</center></td>
			<td class=\"vistutabtd\">".$rows["pmarks"]."</td>
			<td class=\"vistutabtd\">".$rows["mmarks"]."</td>
			<td class=\"vistutabtd\">".$rows["cmarks"]."</td>
			<td class=\"vistutabtd\">".$rows["emarks"]."</td>
			<td class=\"vistutabtd\">".$rows["umarks"]."</td>
			<td class=\"vistutabtd\">".$rows["bcmarks"]."</td>
			<td class=\"vistutabtd\">".$rows["ipmarks"]."</td>
		</tr>";
				}
			}
			else{
				echo "<tr><td class=\"vistutabtd\" colspan=\"9\"><center>0 records Exists</center><td><tr>"; 
			}
		?>
	</table>
</div>
</body>
</html>