<?php

  require_once('../../config.php');

  $db = new Db();
   $tireTreads = $db->getTiretreads();
   $tireSizes = $db->getTiresize();
   $customers = $db->getCustomers();

  $tiresizeID = '';
  $tiretreadID = '';
  $customerID = '';

  $deliverydate = $_POST['datepicker'];
  $customer = $_POST['customer'];
  $dimension = $_POST['dimension'];
  $tirethread = $_POST['tirethreads'];
  $total = $_POST['total'];
  $notes = $_POST['notes'];
  $userid = $_POST['user_id'];
  $now = date('m/d/y');
  foreach ($tireSizes as $tireSize) {
  	if($tireSize->name == $_POST['dimension']){
  		echo 'storlek finns';
  			$tiresizeID = $tireSize->id;
  			break;
  	}
  }
  foreach ($tireTreads as $tireTread) {
  	if($tireTread->name == $_POST['tirethreads']){
  			echo 'tread finns';
  			$tiretreadID = $tireTread->id;
  			break;
  	}
  }
  foreach ($customers as $customer) {
  	if($customer->name == $_POST['customer']){
  		echo 'kund finns';
  			$customerID = $customer->id;
  			break;
  	}
  }

  if(strlen($customerID) == 0) {
  	echo 'new customer';
  	$customerID = $db->createCustomer($_POST['customer'], 0000);
  }
  if(strlen($tiresizeID) == 0) {
  	echo "tiresize nope";
  		$tiresizeID = $db->createTireSize($_POST['dimension']);
  }
  if(strlen($tiretreadID) == 0) {
  	echo "tiretred.. no";
  		$tiretreadID = $db->createTiretread($_POST['tirethreads']);
  }

  /*
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
	}*/

	$orderID = $db->createOrder($customerID, $tiretreadID, $tiresizeID, $total, $notes, $deliverydate, $userid ,$now);
	if($orderID){
		set_feedback('success', 'Ordern skapades, gå in i sök för att hitta den');
		 header("Location: searchcaller.php?search=".$orderID);
	} else{
		set_feedback('error', 'Något blev galet, försök igen');
		header("Location: index.php");
	}