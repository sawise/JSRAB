   <?php

        require_once('../config.php');
  //require_once('../style.php');


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


<!-- body -->
 <div class="searchInput">
	         <form method="get" action="searchcaller.php">
	         <input id="search" name="search" type="text" placeholder="" value="<?php echo $_SESSION['searchstring'] ?>" class="input-xxlarge search-query">
			    <button type="submit" class="btn">Sök</button>	
		</form> 
		</div>
<div>
        
    </div>
<table class="flexme1 Ubuntufont">
</table>


<?php if(isset($_SESSION['searchstring'])) : ?>   
	<?php $searchstring = $_SESSION['searchstring'];
	$_SESSION['searchstring'] = null;
	//echo showTooltip($searchresults); ?>

        <script> 

        	$(".flexme1").flexigrid({
                url : "post-json.php?search=<?php echo $searchstring ?>",
                dataType: 'json',
	colModel : [
	{display:  'Leveransdatum', name : 'deliverydate', width : 60, sortable : true, align: 'left'},
		{display: 'Name', name : 'customer_name', width : 180, sortable : true, align: 'left'},
		{display:  'Mönster', name : 'tiretread_name', width : 40, sortable : true, align: 'left'},
		{display: 'Dimension', name : 'tiresize_name', width : 120, sortable : true, align: 'left'},
		{display: 'Antal', name : 'total', width : 130, sortable : true, align: 'left'},
		{display: '', name : 'numcode', sortable : false, align: 'center'}
		], 	
	
	sortname: "deliverydate",
	sortorder: "asc",
	usepager: true,
	title: '',
	useRp: true,
	rp: 15,
	showTableToggleBtn: true,
	width: 'auto',
	height: 300
            });      

            
        </script>      <?php endif ?>  
<body> <!--<a href="#" class="btn popover-examples" data-toggle="popover" title="Popover title" data-content="Default popover<br>ss<br>">Popover</a><?php //echo tooltipButton($searchresult); ?> -->