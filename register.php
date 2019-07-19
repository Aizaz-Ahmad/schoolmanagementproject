<?php
session_start();
if(!isset($_SESSION["section"]) and !isset($_SESSION["username"])) header('Location:index.php');
include 'header.php';
$check = false;
$link = start_connection($database_name);
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$username=$password=$passwordagain="";
	if(isset($_POST["username"]) &&isset($_POST["password"])&&isset($_POST["passwordagain"])){
		$username = $_POST["username"];
		$password = md5($_POST["password"]);
		$passwordagain=md5($_POST["passwordagain"]);
		$section = strtolower($_POST["section"]);
		$subject = $_POST["subject"]; 
	}
	if(empty($username)||empty($password)||empty($passwordagain)){
		$_SESSION["register"] = "Missing Fields! Must fill all of them";
		header('Location:main.php');
	}
	else if($_POST["password"] != $_POST["passwordagain"]){
		$_SESSION["register"] = "Password Must Match";
		header('Location:main.php');
	}
	else if(IsUsernamePresent("teacherregister",$link,$username)){
		$_SESSION["register"] =  "Username Already Exists";
		header('Location:main.php');
	}
	else if(!ctype_alnum($username)){
		$_SESSION["register"] =  "Username must contain Only Numbers and Alphabets";
		header('Location:main.php');
	}
	else{
		Insert_data($link,$username,$password,$section,$subject);
		$_SESSION["register"] = "Teacher Record Created Successfully";
		header('Location:main.php');
	}
}
	mysqli_close($link);
	?>