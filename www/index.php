<!DOCTYPE html>
<?php
    require_once('../config.php');
$title = "Lägg till ny order";

              ?>
<?php require_once(ROOT_PATH.'/header.php');?>
  <body><img src="img/logo.png" class="logo">
<div class="container centered mainDiv">
  <div class="row-fluid">
  <div class="span12">
 <ul class="nav nav-tabs menu" id="myTab">
  <li class="active"><a href="#week">Veckoöversikt</a></li>
  <li><a href="#createOrder">Lägg till ny order</a></li>
  <li><a href="#search">Sök</a></li>
</ul>
 
<div class="tab-content">
  <div class="tab-pane active" id="week"><?php require_once('weekview.php');?></div>
  <div class="tab-pane" id="createOrder">Lägg till ny order</div>
  <div class="tab-pane" id="search"><?php require_once('search.php');?></div>
</div>
 
<script>
  $(function () {
    $('#myTab a:first').tab('show');
  })
</script>
 

    

    </div>
    </div>
      </div>
  </div>
</div>
  
  </body>


<?php require_once(ROOT_PATH.'/footer.php');?>
