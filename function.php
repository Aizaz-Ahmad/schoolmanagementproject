<?php
function start_connection($database){
$link = mysqli_connect("localhost","root","",$database);
if(!$link)
	die("Sorry, we\'re facing some problems connecting our DataBase"); 
else
	return $link;
}
function IsUsernamePresent($tablename,$link,$username){
	$query = "SELECT * FROM $tablename WHERE (username LIKE '".$username."')";
	$result = mysqli_query($link,$query);
	if(mysqli_num_rows($result)>0)
		return true;
	else
		return false;
}
function PasswordMatch($link,$username,$password,$tablename){
	$query = "SELECT * FROM $tablename WHERE (username LIKE '".$username."')";
	$result = mysqli_query($link,$query);
	$rows = mysqli_fetch_assoc($result);
	return $rows["password"]==$password;
}
function StudentPasswordMatch($link,$rollno,$password,$section){
	$query = "SELECT * FROM $section WHERE (rollno LIKE '".$rollno."')";
	$result = mysqli_query($link,$query);
	$rows = mysqli_fetch_assoc($result);
	echo mysqli_error($link);
	return $rows["password"]==$password;
}
function Insert_data($link,$username,$password,$section,$subject){
	$sql = "INSERT INTO teacherregister(username,password,section,subject) VALUES ('$username','$password','$section','$subject')";
	mysqli_query($link,$sql);
}
function IsEmpty($sections){
	for($x=0;$x < count($sections);$x++){
		if($sections[$x]=="")
			return true;
	}
	return false;
}
function createSectionTable($link,$name){
	$sql = "CREATE TABLE $name(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	rollno INT NOT NULL,
	fullname varchar(50) NOT NULL,
	password varchar(50) NOT NULL, 
	pmarks INT NOT NULL default 0,
	cmarks INT NOT NULL default 0,
	mmarks INT NOT NULL default 0,
	emarks INT NOT NULL default 0,
	umarks INT NOT NULL default 0,
	ipmarks INT NOT NULL default 0,
	bcmarks INT NOT NULL default 0
	)";
	mysqli_query($link,$sql);
}
function MarksAlreadyAdded($section,$subject):bool{
if(file_exists("marksadded.txt")){
	$file = fopen("marksadded.txt", "r");
	while (!feof($file)) {
		$filesection=trim(fgets($file));
		$filesubject=trim(fgets($file));
		if($section==$filesection){
			if($subject==$filesubject) 
				return true;
	}
}
}
return false;
}

function IsAdmin($username){

}
function AddStudent($link,$section,$rollno,$name,$password){
	$stmt = $link->prepare("INSERT INTO $section(rollno,fullname,password) VALUES(?,?,?)");
	$stmt->bind_param("iss",$rollno,$name,$password);
	$stmt->execute();
	echo mysqli_error($link);
	//echo "<script>alert('Student record added Successfully')</script>";
}
function IsMarksNotValid($marks,$subject){
	if($subject=="Islamiat/Pak.St"){
		foreach ($marks as $value) {
			if($value > 50 or $value < 0) 
				return true; 
		}
	}
	else{
		foreach ($marks as $value) {
			if($value > 75 or $value < 0) 
				return true; 
		}
	}
	return false;
}
function GetMarksTable($section){
	$i=0;
		$subjects = array('Physics','Chemistry','Mathematics','Biology/Comp.Sc.','Islamiat/Pak.St','Urdu','English');
		$subjecttables = array('pmarks','cmarks','mmarks','bcmarks','ipmarks','umarks','emarks');
		foreach ($subjects as $value) {
			if($_SESSION["subject"]==$value){
				$marksadd = $subjecttables[$i];
				break;
			}
		$i++;
		}
	return $marksadd;
}
function IsRollNoPresent($link,$section,$rollno){
	$sql = "SELECT rollno FROM $section WHERE rollno=$rollno";
	$result = mysqli_query($link,$sql);
	return (mysqli_num_rows($result)>0) ? true : false;
}
?>