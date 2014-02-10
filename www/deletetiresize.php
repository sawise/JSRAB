<?php
	require_once('../../config.php');
	$db = new Db();
  $id = $_GET['id'];
	$deleteTiresize = $db->deleteTiresize($id);

	if($deleteTiresize){
    $_SESSION['deletetiresize'] = true;
		set_feedback("success", "Däckstorlek är borttaget.");
		header('location: admin.php');
	} else {
    set_feedback("success", "feeeeel...");
    header('location: admin.php');
  }



?>
