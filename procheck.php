<?php
	session_start();
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$link = mysqli_connect('localhost', 'root', '', 'mt');
		$procode = $_POST['procode'];
		$stmt = mysqli_prepare($link, "SELECT `code` FROM `pro` WHERE `code`=?");
		mysqli_stmt_bind_param($stmt, 's', $procode);
		mysqli_stmt_bind_result($stmt, $res);
		mysqli_stmt_execute($stmt);
		if(mysqli_stmt_fetch($stmt)) {
			if($res == $procode){
				echo "Found";
				$_SESSION['pro']=1;
			}
		} else {
				echo "Failed";
				$_SESSION['pro']=0;
		};
		mysqli_close($link);
	}
?>