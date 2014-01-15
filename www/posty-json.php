<?php
require_once('../config.php');

$searchresult = '';
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'deliverydate';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$total = 0;

 if (isset($_GET['search'])) {
 	$db = new Db();
    $searchstring = $_GET['search'];
    $total = $db->search_count($searchstring);
    $pages = ceil($total / $rp);
    $start_from = ($page-1) * $rp;
    $searchresult = $db->search($searchstring, $sortname, $sortorder, $start_from ,$rp);
  }  

	header("Content-type: application/json");
	$jsonData = array('page'=>$page,'total'=>$total,'rows'=>array());
	foreach($searchresult AS $searchitem){
		$entry = array('id'=>$searchitem->id,
			'cell'=>array(
				'id'=>$searchitem->id,
				'deliverydate'=>$searchitem->deliverydate,
				'customer_name'=>$searchitem->customer_name,
				'tiretread_name'=>$searchitem->tiretread_name,
				'tiresize_name'=>$searchitem->tiresize_name,
				'total'=>$searchitem->total,
				'numcode'=>showTooltiptest($searchitem)
			),
		);
		$jsonData['rows'][] = $entry;

	} 

echo json_encode($jsonData);