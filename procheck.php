<?php
	$link = new mysqli('localhost', 'root', '', 'mt');
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$procode = $_POST['procode'];
		$stmt = mysqli_prepare($link, "SELECT * FROM `pro` WHERE `procode` = ?");
		mysqli_stmt_bind_param($stmt, 's', $procode);
		mysqli_stmt_bind_result($stmt, $res);
		mysqli_stmt_execute($stmt);
		if(mysqli_stmt_fetch($stmt)) {
			
		}
	}
	mysqli_close($link);
?>