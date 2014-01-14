<?php

  require_once('../config.php');

  $db = new Db();
  $searchresult = '';
  $searchstring = '';
 if (isset($_GET['search'])) {
    $searchstring = $_GET['search'];
    $_SESSION['searchstring'] = $searchstring;
     header("Location: index.php");
  }  


