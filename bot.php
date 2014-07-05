#!/usr/local/bin/php -q
<?php
	//create link
	$link = new mysqli('localhost', 'root', '', 'mt');
	if(!$link){
		die('Conn fail: ' . $link->error());
	}
	//querying
	$curtime = time() - 21600;
	// $res = $link->query("SELECT `name`,`time` FROM `files`");
	$res = mysqli_query($link, "SELECT `name`,`time` FROM `files`");
	while ($row = mysqli_fetch_assoc($res)) {
		if (time() - strtotime($row['time']) > 21600) {
			mysqli_query($link, "DELETE FROM `files` WHERE `name` = '".$row['name']."'");
			unlink("./upl/".hash('md5', $row['name']));
			unlink("./upl/".$row['name']);
		}
		echo $row['time'];
		// echo "DELETE FROM `files` WHERE `name` = ".$row['name'];
	}
?>