<?php
include "header.php";
$link = start_connection($database_name);
$file = fopen("sectiondetails.txt","r");
while (!feof($file)) {
	$name = fgets($file);
	echo $name;
	echo createSectionTable($link,$name);
}
fclose($file);
mysqli_close($link);
header("Location:classdetails.php");
?>