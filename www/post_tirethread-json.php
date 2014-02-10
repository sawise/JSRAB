<?php
require_once('../../config.php');


 	$db = new Db();
$tireTreads = $db->getTiretreads();

	header("Content-type: application/json");
	$jsonData = array('page'=>$page,'total'=>$total,'rows'=>array());
		foreach($tireTreads AS $tireTread){
			$entry = array('id'=>$tireTread->id,
				'cell'=>array(
					'id'=>$tireTread->id,
					'name'=>$tireTread->name
				),
			);
			$jsonData['rows'][] = $entry;
		} 
	

echo json_encode($jsonData);