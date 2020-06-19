<?php 
ob_start();
session_start();

$pagetitel = 'Items';
if(isset($_SESSION['username'])){
    include 'init.php' ;
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
      // If the page is a Main Page

      if($do == 'Manage' ){
        echo 'Welcome You Are in Items page' ;
      }elseif($do == 'Add'){
       

        }
      elseif($do == 'Insert'){
        echo 'Welcome You Are in Insert Item Page' ;
      }
      elseif($do == 'Update'){
        echo 'Welcome You Are in Update Item Page' ;
      } elseif($do == 'Delete'){
        echo 'Welcome You Are in Delete Item Page' ;
      }elseif($do == 'Activate'){
        echo 'Welcome You Are in Activate Item Page' ;
      }


       include $tpl.'footer.php';
    }else{
        //echo ' You can not brows this page directtly' ;
        header('Location: index.php');
    }
ob_end_flush();
?>