<?php

  require_once('../../config.php');

  $db = new Db();
  $tireTreads = $db->getTiretreads();
   $tireSizes = $db->getTiresize();
   $customers = $db->getCustomers();

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

  foreach ($tireSizes as $tireSize) {
  	if($tireSize->name == $_POST['dimension']){
  		echo 'storlek finns ';
  			$tiresizeID = $tireSize->id;
  			break;
  	}
  }
  foreach ($tireTreads as $tireTread) {
  	if($tireTread->name == $_POST['tirethreads']){
  			echo 'tread finns ';
  			$tiretreadID = $tireTread->id;
  			break;
  	}
  }
  foreach ($customers as $customer) {
  	if($customer->name == $_POST['customer']){
  		echo 'kund finns ';
  			$customerID = $customer->id;
  			break;
  	}
  }

  if(strlen($customerID) == 0) {
  	echo "new customer ";
    echo $customerID;
  	$customerID = $db->createCustomer($_POST['customer'], 0000);
  }
  if(strlen($tiresizeID) == 0) {
  	echo "new thread ";
  		$tiresizeID = $db->createTireSize($_POST['dimension']);
  }
  if(strlen($tiretreadID) == 0) {
  	echo "new thread ";
  		$tiretreadID = $db->createTiretread($_POST['tirethreads']);
  }

	/*if (strpos($tirethread,'->')) {
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

	$orderID = $db->updateOrder($id, $date, $customerID, $tiretreadID, $tiresizeID, $total, $notes, $deliverydate, 1,$now);
	if($orderID){
		set_feedback('success', 'Ordern redigerades');
		 header("Location: searchcaller.php?search=".$id);
	} else{
		set_feedback('error', 'Något blev galet, försök igen');
		//header("Location: index.php");
	}
  




 

