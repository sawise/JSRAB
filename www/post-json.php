<?php
require_once('../config.php');

$searchresult = '';
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'deliverydate';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$total = 100;
$searchstring = $_GET['search'];
 if (isset($_GET['search'])) {
 	$db = new Db();
 	//$searchstring = $_GET['search'];
 	if(isset($_GET['mobile'])){
 		$searchstring = iconv("ISO-8859-1", "UTF-8", $_GET['search']);	
 	} else {
 		$searchstring = $_GET['search'];	
 	}
 	
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
			$output = str_split($searchitem->comments, 25);
			$entry = array('id'=>$searchitem->id,
				'cell'=>array(
					'id'=>$searchitem->id,
					'deliverydate'=>$searchitem->deliverydate,
					'customer_name'=>$searchitem->customer_name,
					'tiretread_name'=>$searchitem->tiretread_name,
					'tiresize_name'=>$searchitem->tiresize_name,
					'total'=>$searchitem->total,
					'comments'=>$searchitem->comments,
					'username'=>$searchitem->username,
					'lastchange'=>$searchitem->lastChange,
					
				),
			);
			$jsonData['rows'][] = $entry;
		}
	} else {
		foreach($searchresult AS $searchitem){
			$output = str_split($searchitem->comments, 25);
			$entry = array('id'=>$searchitem->id,
				'cell'=>array(
					'id'=>$searchitem->id,
					'deliverydate'=>$searchitem->deliverydate,
					'customer_name'=>$searchitem->customer_name,
					'tiretread_name'=>$searchitem->tiretread_name,
					'tiresize_name'=>$searchitem->tiresize_name,
					'total'=>$searchitem->total,
					'comments'=>$searchitem->comments,
					'actions'=>showTooltiptest($searchitem)
				),
			);
			$jsonData['rows'][] = $entry;
		}
	}
		 
	   /*$content .= '<p><a href="index.php?editOrder='.$searchresult->id.'">Redigera</p></a>';
              $content .= '<p><a href="deleteorder.php?orderid='.$searchresult->id.'">Ta bort</p></a>';*/

echo json_encode($jsonData);