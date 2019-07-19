<?php
session_start();
if(!isset($_SESSION["section"]) and !isset($_SESSION["username"])) header('Location:index.php');
include 'header.php';
$rollnumber = $_SESSION["rollnumber"];
$section = $_SESSION["sectionupdate"];
$link = start_connection($database_name);
$message = "";
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$delete = "DELETE FROM $section WHERE rollno=$rollnumber";
	mysqli_query($link,$delete);
	$message = "Record Deleted Successfully";
}
$sql = "SELECT * FROM $section WHERE rollno=$rollnumber";
$result = mysqli_query($link,$sql);
$rows = mysqli_fetch_assoc($result);
?>
<html><head>
	<link rel="stylesheet" type="text/css" href="allcss.css">
	<title>Delete Student Details</title></head>
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
<div id="bigwrapadd">
<p id="p2">Delete Student Record</p>
<p class="errors"><?php echo $message?></p>
<?php		
echo "<form action=\"phpdeletestudent.php\" method=\"POST\">
<p class=\"instruc\">Roll No: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type=\"text\" id=\"fn\" name =\"roll\" value = '".$rows["rollno"]."' readonly></p>";
echo "<p class=\"instruc\">Full Name : <input style=\"width:auto;\" type=\"text\" name=\"name\" id=\"fn\" value = '".$rows["fullname"]."' readonly></p>";
echo "<input type=\"submit\" name=\"update\" id=\"donebutt\" value=\"DELETE\"></form>";
echo "<input type =\"submit\" id=\"donebutt\" value = \"GO BACK\" onclick = \"location.href='viewstudent.php'\">";
?>
</div>
</body>
</html>