<?php
session_start();
if(!isset($_SESSION["section"]) and !isset($_SESSION["username"])) header('Location:index.php');
include 'header.php';
if(isset($_SESSION["updated"])){
if($_SESSION["updated"])
	header('location:viewstudent.php');
else
	echo "<script>alert('Enter Valid Marks')</script>";
unset($_SESSION["updated"]);
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="allcss.css">
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<title>Student Marks</title>
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
<?php 
if(isset($_SESSION["username"])){
	die("<p class=\"marksadd\">Only Teachers have access to this Page</p>");
}
elseif(MarksAlreadyAdded($_SESSION["section"],$_SESSION["subject"]))
	die("<p class=\"marksadd\">Marks Already Added<br><span>Note : Use Update Marks Option to Upload New Marks<span></p>")
?>
<div class="bigwrapmarks">
	<p id="p2">Upload Student Marks</p>
	<table class="viewstudenttable">
		<tr>
			<td class="vistutabtd">Roll No.</td>
			<td class="vistutabtd" width="300px"><center>Full Name</center></td>
			<td class="vistutabtd">Enter <?php echo $_SESSION["subject"]?> Marks</td>
		</tr>
		<form action="addstudentsmarks.php" method="POST">
		<?php
		$placeholder="";
		$placeholder = $_SESSION["subject"]!="Islamiat/Pak.St" ? "Enter Marks out of 75" : "Enter Marks out of 50";
			$link = start_connection($database_name);
			$sql = "SELECT * FROM ".$_SESSION["section"]."";
			$result = mysqli_query($link,$sql);
			if(mysqli_num_rows($result)>0){
				while($rows = mysqli_fetch_assoc($result)){
					echo "<tr>
			<td class=\"vistutabtd\">".$rows["rollno"]."</td>
			<td width=\"300px\" class=\"vistutabtd\"><center>".$rows["fullname"]."</center></td>
			<td class=\"vistutabtd\"><input type=\"text\" class=\"input\" name=\"marks[]\" placeholder='$placeholder'></td>
		</tr>";
			}
			}
			else{
				echo "<tr><td class=\"vistutabtd\" colspan=\"9\"><center>0 records Exists</center><td><tr>"; 
			}
			echo "</table>";
			echo "<input type=\"submit\"id=\"donebutt\"  name=\"submitmarks\" value=\"Upload\">";
		?>
	</form>
</div>
</body>
</html>