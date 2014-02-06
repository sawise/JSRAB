<?php
require_once('../config.php');

$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'deliverydate';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
	
 	$db = new Db();
 	$year = $_GET['year'];
  	$week = $_GET['week'];
  	$total = $db->searchYear_count($year, $week);
    $pages = ceil($total / $rp);
    $start_from = ($page-1) * $rp;
    $searchresult = $db->searchyear($year, $week, $sortname, $sortorder, $start_from ,$rp);

	header("Content-type: application/json");
	$jsonData = array('page'=>$page,'total'=>$total,'rows'=>array());
	foreach($searchresult AS $searchitem){
		$entry = array('id'=>$searchitem->id,
			'cell'=>array(
				'id'=>$searchitem->id,
				'deliverydate'=>$searchitem->deliverydate,//getWeekday($searchitem->deliverydate),
				'customer_name'=>$searchitem->customer_name,
				'tiretread_name'=>$searchitem->tiretread_name,
				'tiresize_name'=>$searchitem->tiresize_name,
				'total'=>$searchitem->total,
				'comments'=>$searchitem->comments,
				'numcode'=>showTooltiptest($searchitem)
			),
		);
		$jsonData['rows'][] = $entry;

	} 

echo json_encode($jsonData);