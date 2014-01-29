<?php
  
  
  define('ROOT_PATH', dirname(__FILE__));

  define('DB_USER', 'root');
  define('DB_PASS', 'root');
  define('DB_NAME', 'jsrab');
  define('DB_HOST', 'localhost');
  
  define('USER', 'user');
  define('PASS', 'pass');
  define('SALT', '34A75DD4C4DF5E4DDFC68CA975B35');

  date_default_timezone_set('Europe/Stockholm');  
  
  require_once(ROOT_PATH.'/includes.php');
  session_start();

  