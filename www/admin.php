<!DOCTYPE html>

<?php

    //require_once('../../private/config.php');
    require_once('../config.php');
    
    require_once(ROOT_PATH.'/classes/authorization.php');
    $_SESSION['admin'] = true;
    $db = new Db();
    $editaccount = "editaccount.php";
    if(isset($_GET['editaccount'])){
      $editaccount .= '?userid='.$_GET['editaccount'];
    }else if(isset($_GET['editcustomer'])){
      $editaccount .= "?customerId=".$_GET['editcustomer'];
    } else if(isset($_GET['edittiretread'])){
      $editaccount .= "?tiretreadid=".$_GET['edittiretread'];
    } else if(isset($_GET['edittiresize'])){
      $editaccount .= "?tiresizeid=".$_GET['edittiresize'];
    }


?>

<?php  require_once(ROOT_PATH.'/header.php');?>
<body>


</div>

  <img src="img/logo.png" class="logo">
  <div class="container centered mainDiv adminDiv">
    <div class="row-fluid">
      <div class="span12">
        <div id="indextabs">
          <ul>
          <li><a href="register.php">Skapa konto</a></li> 
          <li><a href="showallusers.php">Alla konton</a></li>
          <li><a href="<?php echo $editaccount ?>">Redigera konto/Kunder/Däckmonster/Däckstorlekar</a></li>
          <li><a href="customers.php">Kunder/Däckmönster/Däckstorlekar</a></li>
          </ul>
        </div>
      </div>
     </div>
    </div>


</body>
<script>
    <?php
      if(isset($_GET['editaccount']) || isset($_GET['edittiretread']) || isset($_GET['edittiresize']) || isset($_GET['editcustomer'])){
        echo "$('#indextabs').tabs({active: 2})";     
      } else if($_SESSION['delete']){
        echo "$('#indextabs').tabs({active: 1})"; 
        $_SESSION['delete'] = null;
      } else if ($_SESSION['deletecustomer'] || $_SESSION['deletetiresize'] || $_SESSION['deletetirethread']){
        echo "$('#indextabs').tabs({active: 3})";
        $_SESSION['deletecustomer'] = null;
        $_SESSION['deletetiresize'] = null;
        $_SESSION['deletetirethread'] = null;
      }  
        ?> 
      
      
  </script>

<?php require_once(ROOT_PATH.'/footer.php');?>
