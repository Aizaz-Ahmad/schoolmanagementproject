<!DOCTYPE html>
<html>
<head>
	<title>Update Details</title>
</head>
<body>
<table border="2px">
		<tr>
			<td>Roll No.</td>
			<td width="300px"><center>Full Name</center></td>
			<td>Update</td>
		</tr>
		<form action="studentdetailsupdate.php" method="POST">
		<?php
			session_start();
			include 'header.php';
			$link = start_connection($database_name);
			$sql = "SELECT * FROM ".$_SESSION["section"]."";
			$result = mysqli_query($link,$sql);
			if(mysqli_num_rows($result)>0){
				while($rows = mysqli_fetch_assoc($result)){
					echo "<tr>
			<td>".$rows["rollno"]."</td>
			<td width=\"300px\"><center>".$rows["fullname"]."</center></td>
			<td><input type=\"submit\" value=\"Update\"></td>
		</tr>";
			}
			}
			else{
				echo "<tr><td colspan=\"9\"><center>0 records Exists</center><td><tr>"; 
			}
			echo "</table>";
		?>
	
</body>
</html>