<?php
	require_once('../../config.php');
	$db = new Db();
  $id = $_GET['id'];
	$deleteCustomer = $db->deleteCustomer($id);

	if($deleteCustomer){
    $_SESSION['deletecustomer'] = true;
		set_feedback("success", "Kund är borttaget.");
		header('location: admin.php');
	} else {
    set_feedback("error", "feeeeel!");
    header('location: admin.php');
  }

?>
 
