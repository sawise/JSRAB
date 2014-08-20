<?php 
	require_once('../config.php');

	if (isset($_POST['user']) && isset($_POST['pass'])) {
		$username = $_POST['user'];
		$password = $_POST['pass'];
		
		$db = new Db();
		$db_username = $db->getUsername($username);
		$db_password = $db->getPassword($password);
		
		if (count($db_username) > 0) {
			if ($db_username->username == $username) {
				if (count($db_password) > 0) {
					if ($db_password->password == $password) {
						echo "true:".$db_username->id;
						//echo $db_username->id;
					} else {
						echo "false";
					}
				} else {
					echo "false";
				}
			} else {
				echo "false";
			}
		} else {
			echo "false";
		}
  	} else {
		echo "not set";
	}

?>