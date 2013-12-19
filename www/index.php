<!DOCTYPE html>

<?php

        require_once('../config.php');
    $title = "Lägg till ny order";
    $db = new Db();

?>

<?php require_once(ROOT_PATH.'/header.php');?>
<body>
  <img src="img/logo.png" class="logo">
  <div class="container centered mainDiv">
    <div class="row-fluid">
      <div class="span12">
        <div id="indextabs">
          <ul> 
          <li><a href="yearoverview.php">Veckoöversikt</a></li>
            <li><a href="addorder.php">Skapa order</a></li>
            <li><a href="search.php">Sök</a></li>
            <li><a href="orderdetails.php">Order</a></li>
          </ul>
        </div>
      </div>
     </div>
    </div>
   </div>
  </div>

</body>
<script>

// setter
//$('#tabs').tabs({ selected: 1 });
    <?php
      if(isset($_SESSION['search'])){
        echo "$('#indextabs').tabs({active: 2})";
        //echo '$(\'#myTab a[href="#search"]\').tab(\'show\');'; // Select tab by name        
      } else if(isset($_SESSION['createdorder'])){
        echo "$('#indextabs').tabs({active: 3})";
      }
        ?> 
  </script>

<?php require_once(ROOT_PATH.'/footer.php');?>
