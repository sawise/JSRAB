<?php

  require_once('../config.php');

 if (isset($_GET['search'])) {
    $searchstring = $_GET['search'];
    $_SESSION['searchstring'] = $searchstring;
    header("Location: index.php");
  }  


