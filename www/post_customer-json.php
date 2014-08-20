<?php
require_once('../config.php');
   $db = new Db();
   $customers = $db->getCustomers();

header("Content-type: application/json");
	$jsonData = array('page'=>$page,'total'=>$total,'rows'=>array());
	
		foreach($customers AS $customer){
			$entry = array('id'=>$customer->id,
				'cell'=>array(
					'id'=>$customer->id,
					'name'=>$customer->name
				),
			);
			$jsonData['rows'][] = $entry;
		} 
echo json_encode($jsonData);