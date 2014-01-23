<?php

  require_once('../config.php');

 if (isset($_GET['search'])) {
 	$adv = '';
 	if($_GET['search'] != null || $_GET['search'] != ''){
 		$adv .= $_GET['search'];	
 	} else{
 		$adv.= 'nosearch';
 	}
 	
    
 	if(isset($_GET['tiresizes']) && $_GET['tiresizes'] != null || $_GET['tiresizes'] != ''){
 		$adv .= ','.$_GET['tiresizes'];
 	} else {
 		$adv .=',nosize';
 	}
 	if(isset($_GET['tirethreads']) && $_GET['tirethreads'] != null || $_GET['tirethreads'] != ''){
 		$adv .= ','.$_GET['tirethreads'];	
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


