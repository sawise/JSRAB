<?php
	require_once('../../config.php');
	$db = new Db();
  $id = $_GET['id'];
	$deleteUser = $db->deleteUser($id);

	if($deleteUser){
    $_SESSION['delete'] = true;
		set_feedback("success", "Kontot är borttaget.");
		header('location: admin.php');
	} else {
    set_feedback("success", "Kontot är borttaget.");
    header('location: admin.php');
  }

?>
