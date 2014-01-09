<!DOCTYPE html>
<?php

        require_once('../config.php');
        //require_once('../style.php');
    $db = new Db();
    $order = '';
    $ordernumberArray = '';
    if(isset($_GET['orderid'])){
      $order = $db->getOrder($_GET['orderid']);   
      $ordernumberArray = explode(",", $order->comments);
    }

?>

<div class="searchResult Ubuntufont">
<div class="row-fluid">
  <div class="span7 bordertest"> 
    <div class="row">
      <div class="span4 bordertest">
              <p>Leveransdatum: <?php echo $order->deliverydate ?></p>
              </div>
              </div>
      <div class="row">
      <div class="span4 bordertest"><p>Kund: <?php echo $order->customer_name ?></p>
              <p>Däckmönster: <?php echo $order->tiretread_name ?></p>
              <p>Däckstorlek: <?php echo $order->tiresize_name ?></p>
              <p>Antal: <?php echo $order->total ?></p></div>
    </div>
    <div class="row">
      <div class="span4 bordertest">
      <p>Kommentarer<br><?php 
      for ($i=0; $i < count($ordernumberArray) ; $i++) { 
        $arrayCount = count($ordernumberArray);
        if($i == 0){
          echo '<p>Ordernummer: '.$ordernumberArray[$i].'<p>';
          echo '<p>Följenummer: ';
        } else if($i == $arrayCount-1) {
           echo $ordernumberArray[$i].'<p>'; 
        } else {
          echo $ordernumberArray[$i].',';
        } 
      } ?></p>
      </div>
    </div>
    </div>
    </div>
  </div>

