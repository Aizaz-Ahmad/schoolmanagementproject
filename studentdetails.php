<?php
session_start();
include 'header.php';
if(!isset($_SESSION["section"]) and !isset($_SESSION["username"])) header('Location:index.php');
	$file=$names=$error="";
	if(!file_exists("sectiondetails.txt")){
		header('Location:classdetails.php');
	}
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		if(empty($_POST["rollno"]) or empty($_POST["fullname"]) or empty($_POST["passwordtoparent"])){
			$error = "Must fill all Fields";
 		}
 		elseif ($_POST["rollno"]<500 or $_POST["rollno"]>600) {
 			$error = "Roll No should be between 500 and 600";
 		}
 		else if(!filter_var($_POST["rollno"],FILTER_VALIDATE_INT) or strlen($_POST["rollno"])!="3"){
 			$error = "Invalid RollNo. Must Contain Only be Numbers <br> and Contain only 6 digits";
 		}
 		else if(!ctype_alpha(str_replace(' ','',$_POST["fullname"]))){
 			$error = "Must Contain Only Alphabets";
 		}
 		else
 		{
 			$link = start_connection($database_name);
 			echo AddStudent($link,strtolower($_POST["section"]),$_POST["rollno"],$_POST["fullname"],md5($_POST["passwordtoparent"]));
 		mysqli_close($link);
 		header('Location:viewstudent.php');
 		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="allcss.css">
	<title>Student Details</title>
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
	<p id="p2">Add New Student</p>
	<form method="POST" action="studentdetails.php">
		<p class="errors"><?php echo $error?></p>
		<p class="instruc">Enter Roll Number of Student : <input id="fn" type="number" name="rollno"></p>
		<p class="instruc">Enter Full Name of Student :  &nbsp&nbsp&nbsp&nbsp<input id="fn" type="text" name="fullname"></p>
		<p class="instruc">Enter Password : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input id="fn" type="password" name="passwordtoparent"></p>
		<p class="instruc">Select Section :  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
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
			<input type="submit" name="Done" id="donebutt" value="ADD">
	</form>
</div>
</body>
</html>