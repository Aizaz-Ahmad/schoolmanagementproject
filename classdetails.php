<?php 
include "header.php"?>
<!DOCTYPE html>
<html>
<head>
	<title>Class Details</title>
</head>
<body>
	<?php
	$noOfSections=0;
	$sections= array();
	$sectioerr="";
	if($_SERVER["REQUEST_METHOD"]=="POST" and isset($_POST["submit"])){
		if(!empty($_POST["noOfSections"])){
			$_SESSION['noOfSections'] = $_POST["noOfSections"];
			$_SESSION['classes'] = $_POST["classes"];
		}
		else
			$sectioerr="Must Enter Number of Sections";
	}
	if($_SERVER["REQUEST_METHOD"]=="GET" and isset($_GET["submitnames"])){
		$sections = $_GET["sections"];
		if(IsEmpty($sections))
			echo "<script>alert('Must Fill all Fields')</script>";
		else{
				$file = fopen("classdetails.txt", "w");
				fwrite($file, $_SESSION["classes"]);
				fwrite($file, "\n");
				fwrite($file, $_SESSION["noOfSections"]);
				fwrite($file, "\n");
				fclose($file);
				$file = fopen("sectiondetails.txt", "w");
				foreach ($sections as  $value) {
				fwrite($file, $value);
				fwrite($file, "\n");
				}
				fclose($file);
			}
	}
	?>
<form action="classdetails.php" method="POST">
	<p>Select Class : </p>
	<select name="classes">
		<option value="ninth">9<sup>th</sup></option>
		<option value="tenth">10<sup>th</sup></option>
	</select>
	<br>
	<p>Enter Number of Sections : </p>
	<input type="text" name="noOfSections">*<?php echo $sectioerr?>
	<input type="submit" name="submit" value="Enter"><br>
</form>
	<form action="classdetails.php" method="GET">
	<?php
	if($_SERVER["REQUEST_METHOD"]=="POST" and isset($_SESSION["noOfSections"])){
	echo "<p>Enter Names of Sections : </p><br>";
		for($x=0;$x<$_SESSION['noOfSections'];$x++){
			echo "Enter Name of Section No. ".($x+1)."<br>";
			echo "<input type=\"text\" name=\"sections[]\">*<br>";
		}
			echo "<input type=\"submit\" name=\"submitnames\"><br>";
}
	?>
	<?php
	if($_SERVER['REQUEST_METHOD']=="GET" and isset($_GET['submitnames'])){
	if(!IsEmpty($sections)){
	echo "<form>
		Are you Sure You want to make changes? <input type=\"button\" onclick=\"location.href='classtable.php';\" value=\"YES\">
		<input type=\"button\"onclick=\"location.href='classdetails.php';\"value=\"NO\">
	</form>";
}
}
	?>
	</form>
</body>
</html>