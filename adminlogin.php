<?php
session_start();
include 'header.php';
if(isset($_SESSION["section"])){
	session_destroy();
	session_start();
}
$link = start_connection($database_name);
$errors = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$username=$password="";
	if(isset($_POST["username"]) &&isset($_POST["password"])){
		$username = $_POST["username"];
		$password = md5($_POST["password"]);
	}
	if(empty($username)||empty($password)){
		$errors = "Missing Fields! Must fill all of them";
	}
	else if(!IsUsernamePresent("register",$link,$username)){
		$errors =  "Username Does not Exists";
	}
	else if(!ctype_alnum($username)){
		$errors =  "Username must contain Only Numbers and Alphabets";
	}
	else if(!empty($username) && !PasswordMatch($link,$username,$password,"register")){
		$errors = "Wrong Password";
	}
	else{
		$errors="";
		$query = "SELECT * FROM register WHERE (username LIKE '%".$username."%')";
		$result = mysqli_query($link,$query);
		$rows = mysqli_fetch_assoc($result);
		$_SESSION["username"] = $username;
		header('Location:viewstudent.php');
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin's LogIn</title>
	<link rel="stylesheet" type="text/css" href="allcss.css">
</head>
<body>
	<p class="errors"><?php echo $errors;?></p>
<center>
	<p id="p2">Admin's Log In</p>
	<form action="adminlogin.php" method="POST">
	<input id="fn" type="text" name="username" placeholder=" Username"><br><br>
	<input id = "fn" type="password" name="password" placeholder=" Password"><br>
	<input id = "loginbutt" type="submit" name="submit" value="Log In"><br>
	</form>
</body>
</html>