<?php 
  require_once('../config.php');
  $year = $_GET['year'];
  $week = $_GET['week'];
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
	<table class="flexme1">
	</table>
</div>   


<script> 
	$(".flexme1").flexigrid({
	    url : "post_year-json.php?year=<?php echo $year ?>&week=<?php echo $week ?>",
	    dataType: 'json',
	colModel : [
	{display:  'ID', name : 'id', width : 10, sortable : true, align: 'left'},
	{display:  'Leveransdag', name : 'deliverydate', width : 75, sortable : true, align: 'left'},
	{display: 'Kund', name : 'customer_name', width : 180, sortable : true, align: 'left'},
	{display:  'Mönster', name : 'tiretread_name', width : 40, sortable : true, align: 'left'},
	{display: 'Dimension', name : 'tiresize_name', width : 120, sortable : true, align: 'left'},
	{display: 'Antal', name : 'total', width : 130, sortable : true, align: 'left'},
	{display: ' ', name : 'numcode', sortable : false, align: 'center'}
	], 	

	sortname: "deliverydate",
	sortorder: "asc",
	usepager: true,
	title: '',
	useRp: true,
	rp: 10,
	showTableToggleBtn: true,
	width: 'auto',
	height: 300
	});      
</script>