<?php  

  $orders = array(array(1111, "Åkes D/S", "BDR-W+" , "315/80-22,5", 8),
               array(1112, "daiKalles Däcksy", "BDR-HG", "315/70-22,5" , 4),
               array(1113, "Däckia Kalmar", "bdy", "10.00-20" , 4),
               array(1114, "LINKÖPINGS DÄCKCENTRAL", "B104", "265/70-19,5" , 2),
               array(1115, "Olles D/S", "BDR-W+", "295/80-22,5" , 4)); ?>

<div class="searchResult">

	<?php echo yearView($orders); ?>
</div>