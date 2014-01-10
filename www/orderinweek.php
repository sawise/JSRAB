<?php 
  require_once('../config.php');
  $year = $_GET['year'];
  $week = $_GET['week'];
  $db = new Db();
  $searchresults = $db->searchyear($year);
  //echo showTooltip($searchresults);
?>	

<link rel="stylesheet" type="text/css" href="css/flexigrid.pack.css" />
 <link rel="stylesheet" href="css/flexigridstyle.css" />
<script type="text/javascript" src="js/flexigrid.pack.js"></script>


<script type="text/javascript">
$(function () {
    $(".popover-examples").popover({
        
    });
});
</script>

<div class="searchResult Ubuntufont">
	<table class="flexme1 table table-striped">
		<thead>
			<th>Leveransdatum</th>
			<th>Företag/Kund</th>
			<th>Mönster</th>
			<th>Dimension</th>
			<th>Antal</th>
			<th></th>
		</thead>
		<tbody>
		<?php foreach($searchresults as $searchresult) : ?>
			<?php if (getWeek($searchresult->deliverydate) == $week) : ?>
				<tr>
				   <td><?php echo $searchresult->deliverydate ?></td>
			                <td><?php echo $searchresult->customer_name ?></td>
			                <td><?php echo $searchresult->tiretread_name ?></td>
			                <td><?php echo $searchresult->tiresize_name ?></td>
			                <td><?php echo $searchresult->total ?></td>
			                <td><?php echo showTooltiptest($searchresult) ?></td>
					 
				</tr>
			<?php endif ?>
		<?php endforeach ?>
		</tbody>
	</table>
</div>   <script>
        $('.flexme1').flexigrid({height:500,striped:false});

        </script>