<?php
require_once('../config.php');

$searchresult = '';
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'customer_name';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$query = isset($_POST['query']) ? $_POST['query'] : false;
$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;
$total = 20;
//$count = $db->search_count('contacts', $searchstring, $search_contacttypes, $search_mailshots, $search_activities);
    

 if (isset($_GET['search'])) {
 	$db = new Db();
    $searchstring = $_GET['search'];
    $total = $db->search_count($searchstring);
    
    $pages = ceil($total / $rp);
    $start_from = ($page-1) * $rp;
    $searchresult = $db->search($searchstring, $sortname, $sortorder, $start_from ,$rp);
    
  }  
//search($text, $sortby, $descasc)



	header("Content-type: application/json");
	$jsonData = array('page'=>$page,'total'=>$total,'rows'=>array());
	foreach($searchresult AS $searchitem){
		//If cell's elements have named keys, they must match column names
		//Only cell's with named keys and matching columns are order independent.
		$entry = array('id'=>$searchitem->id,
			'cell'=>array(
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