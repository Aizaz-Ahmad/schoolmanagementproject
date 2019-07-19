<?php
session_start();
if(!isset($_SESSION["section"])) header('Location:index.php');
include "header.php";
if(isset($_SESSION["username"])){
	session_destroy();
	session_start();
}
$check = false;
$link = start_connection($database_name);
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$username=$password="";
	if(isset($_POST["username"]) &&isset($_POST["password"])){
		$username = $_POST["username"];
		$password = md5($_POST["password"]);
	}
	if(empty($username)||empty($password)){
		$_SESSION["errors"] = "Missing Fields! Must fill all of them";
	$check=true;
		header('Location:index.php');
	}
	else if(!IsUsernamePresent("teacherregister",$link,$username)){
		$_SESSION["errors"] =  "Username Does not Exists";
		$check=true;
		header('Location:index.php');
	}
	else if(!ctype_alnum($username)){
		$_SESSION["errors"] =  "Username must contain Only Numbers and Alphabets";
		$check=true;
		header('Location:index.php');
	}
	else if(!empty($username) && !PasswordMatch($link,$username,$password,"teacherregister")){
		$_SESSION["errors"] = "Wrong Password";
		$check=true;
		header('Location:index.php');
	}
	else{
		$_SESSION["errors"] = "";
		$query = "SELECT * FROM teacherregister WHERE (username LIKE '%".$username."%')";
		$result = mysqli_query($link,$query);
		$rows = mysqli_fetch_assoc($result);	
		$_SESSION['section'] = $rows["section"];
		$_SESSION["subject"] = $rows["subject"];
		header('Location:viewstudent.php');
	}
}
	?>