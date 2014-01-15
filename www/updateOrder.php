<?php

  require_once('../config.php');

  $db = new Db();

  $tiresizeID = '';
  $tiretreadID = '';
  $customerID = '';

  $id = $_POST['id'];
  
  $customer = $_POST['customer'];
  $dimension = $_POST['dimension'];
  $tirethread = $_POST['tirethreads'];
  $total = $_POST['total'];
  $notes = $_POST['notes'];
  $now = date('Y-m-d');

  $deliverydate = $_POST['datepicker'];


	if (strpos($tirethread,'->')) {
		$arrayslice = explode('->',$tirethread);
		$tiretreadID = $arrayslice[0];
		echo $tiretreadID;
	} else {
		$tiretreadID = $db->createTiretread($tirethread);
	}

	if (strpos($dimension,'->')) {
		$arrayslice = explode('->',$dimension);
		$tiresizeID = $arrayslice[0];
		echo $tiresizeID;
	} else {
		$tiresizeID = $db->createTireSize($dimension);
	}
	if (strpos($customer,'->')) {
		$arrayslice = explode('->',$customer);
		$customerID = $arrayslice[0];
		echo $customerID;
	} else {
		$customerID = $db->createCustomer($customer, 0000);
	}

	$orderID = $db->updateOrder($id, $date, $customerID, $tiretreadID, $tiresizeID, $total, $comments, $deliverydate, 1,$now);
	if($orderID){
		$arrayslice = explode('->',$customer);
		set_feedback('success', 'Ordern skapades, gå in i sök för att hitta den');
		 header("Location: searchcaller.php?search=".$arrayslice[1]);
	} else{
		set_feedback('error', 'Något blev galet, försök igen');
		//header("Location: index.php");
	}




 

