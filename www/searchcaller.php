<?php

  require_once('../config.php');

  $db = new Db();
  $searchresult = '';
  $searchstring = '';
 if (isset($_GET['search'])) {
    $searchstring = $_GET['search'];
    $searchresult = $db->search($searchstring);
    $_SESSION['search'] = $searchresult;
    $_SESSION['searchstring'] = $searchstring;
     header("Location: index.php");

  }  


