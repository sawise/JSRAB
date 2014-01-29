<!DOCTYPE html>

<?php
    require_once('../config.php');
    //require_once(ROOT_PATH.'/classes/authorization.php');
    $print = true;
  $db = new Db();
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'deliverydate';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$total = 100;

  $tirethreads = $db->getTiretreads();
   $tireSize = $db->getTiresize();
   $searchstring = '';
   $datestart = '';
   $dateend = '';
   $tiresizeID = '';
   $tirethreadID = '';
 //$adv->search->size->thread->datestart->dateend
if(isset($_SESSION['print'])) {
  $searcharray = explode(",", $_SESSION['print']);
    
   $tirethreadID = $searcharray[2];
   $tiresizeID = $searcharray[1];

    if($searcharray[0] != 'nosearch'){
      $searchstring = $searcharray[0];  
    }
    if($searcharray[3] != 'nodate' && $searcharray[4] != 'nodate') {
      $dateend = $searcharray[4];
      $datestart = $searcharray[3];
    }
   
    $total = $db->search_count($searchstring, $_GET['tiresize'], $_GET['tirethread'], $_GET['datestart'], $_GET['dateend']);
    $pages = ceil($total / $rp);
    $start_from = ($page-1) * $rp;
    $searchresult = $db->search($searchstring,$_GET['tiresize'], $_GET['tirethread'], $_GET['datestart'], $_GET['dateend'], $sortname, $sortorder, $start_from ,$rp);
  }  
//search($text, $tiresize, $tirethread, $sortby, $descasc, $startform ,$limit)
  
?>

<?php require_once(ROOT_PATH.'/header.php');?>
<body>

<table class="Ubuntufont table table-bordered printtable">;
        <thead><th>Leveransdag<th>Företag/Kund<th>Mönster</th><th>Dimension</th><th>Antal</th><th>Kommentarer</th></thead>';
        <tbody>
          <?php foreach($searchresult AS $searchitem) : ?>
            <tr> 
            <td><?php echo getWeekday($searchitem->deliverydate) ?></td>
            <td><?php echo $searchitem->customer_name ?></td>
            <td><?php echo $searchitem->tiretread_name ?></td>
            <td><?php echo $searchitem->tiresize_name ?></td>
            <td><?php echo $searchitem->total ?></td>
            <td><?php echo $searchitem->comments ?></td>
            </tr>
        <?php endforeach ?>
        
      </tbody></table></div>
</body>
<?php require_once(ROOT_PATH.'/footer.php');?>
<script type="text/javascript">
<!--
window.print();
//-->
</script>
