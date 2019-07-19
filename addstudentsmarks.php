<?php
session_start();
include 'header.php';
$marksadd="";
	if($_SERVER["REQUEST_METHOD"]=="POST"){
	$link = start_connection($database_name);
	$marks =$_POST["marks"];
	if(IsMarksNotValid($marks,$_SESSION["subject"])){
		$_SESSION["updated"] = false; 
		header('location:studentmarks.php');
	}else{
		$marksadd = GetMarksTable($_SESSION["subject"]);
		$sectiontable = $_SESSION["section"];
		$i=0;
		$sql = "SELECT * FROM $sectiontable";
			$result = mysqli_query($link,$sql);
			if(mysqli_num_rows($result)>0){
				while($rows = mysqli_fetch_assoc($result)){
					$x = $marks[$i++];
					$fullname  = $rows["fullname"];
			$update = "UPDATE $sectiontable SET $marksadd=$x WHERE fullname = '$fullname'";
			mysqli_query($link,$update);	
			}
		}
		mysqli_close($link);
		$_SESSION["marksadded"]=$marksadd;
		$file = fopen("marksadded.txt", "a");
		fwrite($file, $_SESSION["section"]);
		fwrite($file, "\n");
		fwrite($file,$_SESSION["subject"]);
		fwrite($file, "\n");
		fclose($file);
		$_SESSION["updated"] = true;
		header('Location:viewstudent.php');
	}
}
?>