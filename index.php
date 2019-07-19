<?php
session_start();
include 'header.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$link = start_connection($database_name);
	if(isset($_POST["rollnumber"]) and isset($_POST["password"])){
		$rollnumber = $_POST["rollnumber"];
		$password = $_POST["password"];
		$section =strtolower($_POST["section"]);
	}
	if(empty($_POST["rollnumber"])||empty($_POST["password"]))
		$_SESSION["indexerror"] = "Must Fill All the fields";
	elseif(!IsRollNoPresent($link,strtolower($_POST["section"]),$_POST["rollnumber"]))
		$_SESSION["indexerror"] = "Roll Number Doesn't Exist";
	elseif(!empty($rollnumber) and !StudentPasswordMatch($link,$rollnumber,md5($password),$section))
		$_SESSION["indexerror"] = "Wrong Password";
	else{
		unset($_SESSION["indexerror"]);
		$_SESSION["searchrollno"] = $_POST["rollnumber"];
		$_SESSION["searchsection"]  =strtolower($_POST["section"]);
		header('Location:searchresult.php');
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="allcss.css">
	<title>Log In</title>
</head>
<body>
	<a style="margin-left: 1000px;text-decoration: none;" id="searchbutt" href="adminlogin.php">Admin's LogIn</a>
	<div id="login">
	<p class="errors"><?php if(isset($_SESSION["errors"])) {echo $_SESSION["errors"];unset($_SESSION["errors"]);}?></p>
<center>
	<p id="p2">Teacher's Log In</p>
	<form action="login.php" method="POST">
	<input id="fn" type="text" name="username" placeholder=" Username"><br><br>
	<input id = "fn" type="password" name="password" placeholder=" Password"><br>
	<input id = "loginbutt" type="submit" name="submit" value="Log In"><br>
	</form>
</div>
</center>
	<p id="psearch">Search Result</p>
<div class="searchresult">
	<p class="errors"><?php if(isset($_SESSION["indexerror"])) {echo $_SESSION["indexerror"];unset($_SESSION["indexerror"]);}?></p>
	<form action="index.php" method="POST">
		<p class="instruc">Enter Roll Number :
		<input id="fn" type="number" name="rollnumber"></p><br>
		<p class="instruc">Select Section :
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
		<br>
		<p class="instruc">Enter the Password That is given to you by school : </p>
		<input id="fn" type="password" name="password">
		<input id="searchbutt" type="submit" name="search" value="SEARCH">
	</form>
</div>
</body>
</html>
