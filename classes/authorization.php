<?php
  if (!isset($_SESSION['is_logged_in'])) {
    $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
    set_feedback('error', 'Du måste vara inloggad för att nå sidan.');
    header('location: /login.php');
  }
?>