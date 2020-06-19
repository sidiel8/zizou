<?php
 
 function lang($ph) {
     static $lang = array(
      'HOME_ADMIN' => 'الادمن',
      'CATEGOREIS' => 'الاقسام',
      'USER' => 'سيدي',
      'Edit' => 'تغيير لبروفايل',
      'SETTINGS' => 'الاعدادات',
      'LOGOUT' => 'الخروج',
         
     );
      return $lang[$ph] ;
     
 }