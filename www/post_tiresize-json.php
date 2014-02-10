<?php
require_once('../../config.php');
   $db = new Db();
   $tireSizes = $db->getTiresize();

header("Content-type: application/json");
	$jsonData = array('page'=>$page,'total'=>$total,'rows'=>array());
	
		foreach($tireSizes AS $tireSize){
			$entry = array('id'=>$tireSize->id,
				'cell'=>array(
					'id'=>$tireSize->id,
					'name'=>$tireSize->name
				),
			);
			$jsonData['rows'][] = $entry;
		} 
echo json_encode($jsonData);