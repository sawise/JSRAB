<!DOCTYPE html>

<?php

    //require_once('../../private/config.php');
    require_once('../../config.php');
    
    require_once(ROOT_PATH.'/classes/authorization.php');
    $title = "Lägg till ny order";
    $db = new Db();
    $_SESSION['admin'] = false;
    $editorderLink = "editOrder.php";
    if(isset($_GET['editOrder'])){
      $editorderLink .= "?orderId=".$_GET['editOrder'];
    }

?>
 <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<?php  require_once(ROOT_PATH.'/header.php');?>
<body>


</div>

  <!--<img src="img/logo.png" class="logo">-->
  <div class="container centered mainDiv">
    <div class="row-fluid">
      <div class="span12">
        <div id="indextabs">
          <ul>
          <li><a href="prevyearoverview.php">Arkiverat</a></li> 
          <li><a href="yearoverview.php">Veckoöversikt</a></li>
            <li><a href="addorder.php">Skapa order</a></li>
            <li><a href="search.php">Sök</a></li>
            <li><a href="<?php echo $editorderLink ?>">Redigera order</a></li>
          </ul>
        </div>
      </div>
     </div>
    </div>


</body>
<script>
    <?php
      if(isset($_SESSION['searchstring'])){
        echo "$('#indextabs').tabs({active: 3})";     
      }  else if(isset($_GET['editOrder'])){
        echo "$('#indextabs').tabs({active: 4})";
      }  else {
        echo "$('#indextabs').tabs({active: 1})";
      }
        ?> 
  </script>

<?php require_once(ROOT_PATH.'/footer.php');?>
