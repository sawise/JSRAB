<?php 
  require_once('../../config.php');
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
		{display:  'ID', name : 'id', width : 20, sortable : true, align: 'left'},
		{display:  'Leveransdatum', name : 'deliverydate', width : 100, sortable : true, align: 'left'},
			{display: 'Kund', name : 'customer_name', width : 100, sortable : true, align: 'left'},
			{display:  'Mönster', name : 'tiretread_name', width : 100, sortable : true, align: 'left'},
			{display: 'Dimension', name : 'tiresize_name', width : 100, sortable : true, align: 'left'},
			{display: 'Antal', name : 'total', width : 35, sortable : true, align: 'left'},
			{display: 'Kommentarer', name : 'comments', width : 350, sortable : false, align: 'left'},
      {display: '', name : 'actions', width : 50, sortable : false, align: 'center'}
			], 	
		
		sortname: "deliverydate",
		sortorder: "asc",
		usepager: true,
		title: '',
		useRp: true,
		rp: 10,
		showTableToggleBtn: true,
		width: 900,
		height: 300
	            });  
</script>