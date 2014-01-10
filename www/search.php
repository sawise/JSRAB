   <?php

        require_once('../config.php');
  //require_once('../style.php');

?>
<?php if(isset($_SESSION['search'])) : ?>   
	<?php //$searchresults = $_SESSION['search'];
	//echo showTooltip($searchresults); ?>
<?php endif ?>


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

<?php if(isset($_SESSION['search'])) : ?>   
					<?php $searchresults = $_SESSION['search']; ?>
<table class="flexme1 Ubuntufont">
            <thead><th>Leveransdatum<th>Företag/Kund<th>Mönster</th><th>Dimension</th><th>Antal</th><th></th></thead>
            <tbody><?php foreach($searchresults as $searchresult) : ?>
                <tr>
			                <td><?php echo $searchresult->deliverydate ?></td>
			                <td><?php echo $searchresult->customer_name ?></td>
			                <td><?php echo $searchresult->tiretread_name ?></td>
			                <td><?php echo $searchresult->tiresize_name ?></td>
			                <td><?php echo $searchresult->total ?></td>
			                <td><?php echo showTooltiptest($searchresult) ?></td>
			               
			 			</tr>
                <?php endforeach ?>
            </tbody>
        </table>
        

			<?php $_SESSION['search'] = null;$_SESSION['searchstring'] = null; ?>
		 <?php endif ?>
        <script>
        $('.flexme1').flexigrid({height:500,striped:false});

        </script>
<body> <!--<a href="#" class="btn popover-examples" data-toggle="popover" title="Popover title" data-content="Default popover<br>ss<br>">Popover</a><?php //echo tooltipButton($searchresult); ?> -->