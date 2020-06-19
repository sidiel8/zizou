<?php 

/*//==================== getcat()
//function to get categories
//==it brings out all kind of categories
//===========
*/
function getAll($tabble){
    global $con ;
    $stmt3 = $con->prepare("SELECT * FROM $tabble  ORDER BY item_ID DESC  ") ;
    $stmt3->execute();
    $rows= $stmt3->fetchall();
    return $rows ;
}
function getCat(){
    global $con ;
    $stmt3 = $con->prepare("SELECT * FROM categories  ORDER BY ID ASC  ") ;
    $stmt3->execute();
    $rows= $stmt3->fetchall();
    return $rows ;
}

/*//==================== getItem()
//function to get categories
//==it brings out all kind of categories
//===========
*/
function getItem($where , $value){
    global $con ;
    $stmt3 = $con->prepare("SELECT * FROM items   WHERE $where = ?  ORDER BY item_ID DESC  ") ;
    $stmt3->execute(array($value));
    $rows= $stmt3->fetchAll();
    return $rows ;
}
/*========this function check acount of the user is activated or not */
//========checkUserStatus
//======== it needs one para , it comes from the seesion
function checkUserStatus($user){
    global $con ;
    $stm = $con->prepare("SELECT Username , TrustStatus FROM users WHERE  Username = ? AND TrustStatus = 0 ");
    $stm->execute(array($user));
    $count= $stm->rowCount() ;
   return  $count ;
}




















/************************************************************************** */
function getTitel(){
     global $pagetitel ;
     if(isset($pagetitel)){
         echo $pagetitel ;
     }else {
         echo 'Default' ;
     }
 }
 /*
 ***Rdirect function
 *** $theMe
 *** time in seconds before redirecting
 */
 function  redirectTo($theM ,$url= null , $seconds = 3){
     if($url===null){
         $url = "index.php";
         $link = "Home page" ;
     }else{       
     $url = isset( $_SERVER['HTTP_REFERER']) &&  $_SERVER['HTTP_REFERER'] !== ''
      ? $_SERVER['HTTP_REFERER'] : "index.php";
      $link = "Previous page" ;
     }
        echo  $theM ;
        echo "<div class='alert alert-primary' >Will be redirected to the $link in $seconds seconds </div>";

        header("Refresh:$seconds ; url=$url ") ;
        exit() ;
 }
 /*
 ======= This function is used for checking itms in data bases
 ==function  CheckItem() 
 ==$select ==> to selcte the item ex:  user 
 ==$from  ==> from the table 
 ==$Where the condition to select
 ==$value ==> the value selected
 =======
 */ 
   function checkItem($select ,$from, $value ){
            global $con ;
            $stm = $con->prepare("SELECT $select FROM $from WHERE  $select = ? ");
            $stm->execute(array($value));
            $count= $stm->rowCount() ;
           return  $count ;
   }
   /*
   ==================== countItems()
   ==count number of items 
   ==it count the number of rows
   ===========
   */
     function countItems($item , $table  ){
         global $con ;
        $stmt1 = $con->prepare("SELECT COUNT($item) FROM $table  ");
     $stmt1->execute() ;
    return $stmt1->fetchColumn();
     }/*
   ==================== getLatest()
   ==function to get latest items
   ==it brings out all kind of items
   ===========
   */
   function getLatest($select , $table , $order , $limit=5){
       global $con ;
       $stmt3 = $con->prepare("SELECT $select FROM $table  ORDER BY $order DESC LIMIT $limit ") ;
       $stmt3->execute();
       $rows= $stmt3->fetchall();
       return $rows ;
   }


  /* <?php 
                    if($st['Approve']==0){?>
                <a
   href="items.php?do=Approve&itemid=<?php echo $st['item_ID'] ;?>"
    class="btn btn-warning ">  <i class="fas fa-edit"></i> Approve
                </a>

                   <?php }
                    ?>*/