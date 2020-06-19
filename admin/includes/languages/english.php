<?php
 
 function lang($ph) {
     static $lang = array(
       //dashboard page
       'HOME_ADMIN'  => 'Home',
       'CATEGORIES'  => 'Categories',
       'ITEMS'  => 'Items',
       'MEMBERS'  => 'Members',
       'STATISTICS'  => 'Statistics',
       'LOGS'  => 'Logs',
       'USER'        => 'Sidi',
       'COMMENTS'    =>  'Comments' ,
       'Edit'        => 'Edit Profile',
       'SETTINGS'    => 'Setting',
       'LOGOUT'      => 'Logout',

         
     );
      return $lang[$ph] ;
     
 }