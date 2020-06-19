<?php
    ini_set('display_errors','on');
    error_reporting('E_ALL');
    $sessionUsername = '';
    $seessionName = '';
    if(isset($_SESSION['user'])){
      $sessionUsername = $_SESSION['user'] ;
    }
  include 'admin/connect.php' ;
  //Routes
   $tpl = 'includes/templates/' ; // templates directory
   $lang = 'includes/languages/';// languages directory
   $func = 'includes/functions/' ;// functions directory
   // Include Files
   include $func.'functions.php' ;
   include $lang.'english.php';
   include $tpl.'header.php' ;
 
   
   // include navbar on all pages except 
   