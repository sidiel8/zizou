<?php
  
  include 'connect.php' ;
  //Routes
   $tpl = 'includes/templates/' ; // templates directory
   $lang = 'includes/languages/';// languages directory
   $func = 'includes/functions/' ;// functions directory
   // Include Files
   include $func.'functions.php' ;
   include $lang.'english.php';
   include $tpl.'header.php' ;
   
   // include navbar on all pages except 
   if(!isset($nonavbar)){
   include $tpl.'navbar.php' ;
  }