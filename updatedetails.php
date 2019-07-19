<?php
session_start();
if(!isset($_SESSION["section"]) and !isset($_SESSION["username"])) header('Location:index.php');
include 'header.php';
 $error = "";
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$link = start_connection($database_name);
	if (!ctype_digit($_POST["rollnumber"])) {
	 	$error = "Invalid Enrty! Roll Number Must be in digits";
	}
	elseif(empty($_POST["rollnumber"])){
		$error = "Must Enter Roll Number";
	}
	elseif(!IsRollNoPresent($link,strtolower($_POST["section"]),$_POST["rollnumber"]))
		$error = "Roll Number Doesn't Exists";
	else{
		$_SESSION["rollnumber"]=$_POST["rollnumber"];
		$_SESSION["sectionupdate"] = $_POST["section"];
		header('Location:phpupdatedetails.php');
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="allcss.css">
	<title>Update Student Details</title>
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
if(!isset($_SESSION["username"])){
	die("<p class=\"marksadd\">Only Admin has access to this Page</p>");
};
?>
<div id="bigwrapadd">
	<p id="p2">Update Student Details</p>
	<p class="errors"><?php echo $error?></p>
	<form action="updatedetails.php" method="POST">
	<p class="instruc">Enter Student Roll Number : 
	<input id="fn" type="text" name="rollnumber"></p>
		<p class="instruc">Select Student Section : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
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
</p>
	<input type="submit" id="donebutt" value="Enter">
</form>
</div>
</body>
</body>
</html>