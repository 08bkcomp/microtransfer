<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_FILES) {
		if ($_FILES['upfile']['size'] <= 10485760 && !($_FILES['upfile']['type'] == 'application/x-php')) {
			//upload stuff
			move_uploaded_file($_FILES['upfile']['tmp_name'],"./upl/".hash('md5', $_FILES['upfile']['name']));
			//sql stuff
			$link = new mysqli('localhost', 'root', '', 'mt');
			if(!$link){
				die('Conn fail: ' . $link->error());
			}
			$sql = "INSERT INTO files (codehash, name, time) VALUES (?, ?, ?)";
			$stmt = $link->prepare($sql);
			do {
				$code = hash('sha512', $_FILES['upfile']['name'].time());
				$truncode = preg_replace('/\s+?(\S+)?$/', '', substr($code, 0, 15));
				$stmt->bind_param('sss', hash('sha512', $truncode), $_FILES['upfile']['name'], date('Y-m-d H:i:s'));
				$stmt->execute();
			} while (mysqli_stmt_error($stmt));
			
			$stmt->close();
			$link->close();
			echo $truncode;
		} else if($_FILES['upfile']['type'] == 'application/x-php') {
			echo "That seems to be a PHP file, sorry I can't accept it.<br/>Why not try another file?";
		} else {
			echo "File too large :(<br/>Files must be less than 10MB";
		}
	}
?>