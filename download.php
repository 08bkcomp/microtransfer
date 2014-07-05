<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$link = new mysqli('localhost', 'root', '', 'mt');
		if(!$link){
				die('Conn fail: ' . $link->error());
		}
		$hashcode = hash('sha512', $_POST['downcode']);
		$trunhashcode = preg_replace('/\s+?(\S+)?$/', '', substr($hashcode, 0, 15));
		$sql = "SELECT `name` FROM `files` WHERE codehash = ?";
		$stmt = $link->prepare($sql);
		$stmt->bind_param('s',$trunhashcode);
		$stmt->execute();
		$stmt->bind_result($name);
		if($stmt->fetch()){
			$md5name = hash('md5', $name);
			rename("./upl/$md5name", "./upl/$name");
			echo "<link rel=\"stylesheet\" href=\"file.css\"><div><a href=\"./upl/$name\">Your File (Right Click to Save)</a></div>";
			$stmt->close();
			if(!($link->query("UPDATE `files` SET `time` = '".(date('Y-m-d H:i:s', (time()-20400)))."' WHERE `codehash` = '$trunhashcode'"))){
				printf("Error %s\n", $link->error);
			}
		} else {
			echo "<link rel=\"stylesheet\" href=\"file.css\"><div><a>No file found</a></div>";
		}
		$link->close();
	}
?>