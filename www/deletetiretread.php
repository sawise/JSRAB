<?php

	require_once('../config.php');
	$db = new Db();
  $id = $_GET['id'];
	$deleteTiretread = $db->deleteTiretread($id);

	if($deleteTiretread){
    $_SESSION['deletetirethread'] = true;
		set_feedback("success", "Mönster är borttaget.");
		header('location: admin.php');
	} else {
    set_feedback("success", "feeel....");
    header('location: admin.php');
  }

?>
