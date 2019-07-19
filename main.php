<?php
session_start();
include 'header.php';
if(!isset($_SESSION["section"]) and !isset($_SESSION["username"])) header('Location:index.php');
?>
<!DOCTYPE HTML>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="allcss.css">
	<title>Register Teacher</title>
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
}
?>
	<div id="bigwrapadd">
		<p id="p2">Register Teacher</p>
		<p class="errors"><?php if(isset($_SESSION["register"])) {echo $_SESSION["register"];unset($_SESSION["register"]);}?></p>
<form action="register.php" method="POST">
		<p class="instruc">Username : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input id="fn" type="text" name="username"></p>
		<p class="instruc">Password : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input id="fn" type="password" name="password"></p>
		<p class="instruc">Password Again : &nbsp&nbsp<input id="fn" type="password" name="passwordagain"></p>
		<p class="instruc">Select Section : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
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
		<p class="instruc">Select Subject : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
		<select name="subject">
			<?php
				$subjects = array('Physics','Chemistry','Mathematics','Biology/Comp.Sc.','Islamiat/Pak.St','Urdu','English');
				foreach ($subjects as $value) {
					echo "<option value=$value>$value</option>";
				}
			?>
		</select>
	</p>
		<input type="submit" id="donebutt" name="submit"><br>
	</form>
</div>
</body>
</html>
