<?php

  require_once('../../config.php');

 if (isset($_GET['search'])) {
 	$adv = '';
 	if($_GET['search'] != null || $_GET['search'] != ''){
 		$adv .= $_GET['search'];	
 	} else{
 		$adv.= 'nosearch';
 	}
 	
    
 	if(isset($_GET['tiresizessearch']) && $_GET['tiresizessearch'] != null || $_GET['tiresizessearch'] != ''){
 		$adv .= ','.$_GET['tiresizessearch'];
 	} else {
 		$adv .=',nosize';
 	}
 	if(isset($_GET['tirethreadssearch']) && $_GET['tirethreadssearch'] != null || $_GET['tirethreadssearch'] != ''){
 		$adv .= ','.$_GET['tirethreadssearch'];	
 	} else {
 		$adv .= ',nothread';
 	}

 	if(isset($_GET['datepickerstart']) && $_GET['datepickerstart'] != null && isset($_GET['datepickerstart']) && $_GET['datepickerend'] != null){
 		$adv .= ','.$_GET['datepickerstart'].','.$_GET['datepickerend'];
 	} else {
 		$adv .= ',nodate';
 	}
    $_SESSION['searchstring'] = $adv;
    
    header("Location: index.php");
  }  


