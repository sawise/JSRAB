<?php
require_once('../../config.php');

$searchresult = '';
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'deliverydate';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$total = 100;

 if (isset($_GET['search'])) {
 	$db = new Db();
    $searchstring = $_GET['search'];
    $total = $db->search_count($searchstring, $_GET['tiresize'], $_GET['tirethread'], $_GET['datestart'], $_GET['dateend']);
    if(isset($_GET['mobile'])){
    	$rp = 1000;
    }
    $pages = ceil($total / $rp);
    $start_from = ($page-1) * $rp;
    $searchresult = $db->search($searchstring,$_GET['tiresize'], $_GET['tirethread'], $_GET['datestart'], $_GET['dateend'], $sortname, $sortorder, $start_from ,$rp);
  }  

//search($text, $tiresize, $tirethread, $sortby, $descasc, $startform ,$limit)
	header("Content-type: application/json");
	$jsonData = array('page'=>$page,'total'=>$total,'rows'=>array());
	if(isset($_GET['mobile'])){
		foreach($searchresult AS $searchitem){
			$entry = array('id'=>$searchitem->id,
				'cell'=>array(
					'id'=>$searchitem->id,
					'deliverydate'=>$searchitem->deliverydate,
					'customer_name'=>$searchitem->customer_name,
					'tiretread_name'=>$searchitem->tiretread_name,
					'tiresize_name'=>$searchitem->tiresize_name,
					'comments'=>$searchitem->comments,
					'total'=>$searchitem->total
				),
			);
			$jsonData['rows'][] = $entry;
		} 
	} else {
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
	}

echo json_encode($jsonData);