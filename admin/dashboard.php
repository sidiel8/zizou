<?php
ob_start();
   session_start() ;
   $pagetitel = 'Dashboard';
  
   if(isset($_SESSION['username'])){
      include 'init.php';
     /* --- start dashboard ----- */ 
    
     $thelatest =getLatest('*' ,'users', 'UserID' , 5) ;
     $latestitems = getLatest('*' ,'items', 'item_ID' , 5) ; 
     $latestcomment = getLatest('*' ,'comments', 'C_id' , 5) ; 
     ?>
     <div class="container hom-stat text-center"> 
         <h1 class="text-center"> <strong>Dashboard </strong> </h1>
         <div class="row"> 
             <div class="col-md-3">
<div class="stat members"> 
    <i class="fas fa-users"></i>
    <div class="info">

    Members <span> <a href="members.php"> <?php echo countItems('UserID','users')?> </a>
    </span> 
   </div>
</div>
            </div>
            <div class="col-md-3">
<div class="stat pending">
<i class="fas fa-user-plus"></i>
    <div class="info">
     Pending Members <span><a href="members.php?do=Manage&page=pending"> 
         <?php echo checkItem('RegStatus','users' , 0)?> </a> 
        </span> 
    </div>
            </div> 
            </div> 
            <div class="col-md-3">
                 <div class="stat items">
                 <i class="fas fa-tag"></i>
                        <div class="info">
                      Total Items <span><a href="items.php"> <?php echo  countItems('item_ID' , 'items'  ) ; ?> </a>
                    </span>
                      </div>
                    </div>
                 </div>
            <div class="col-md-3">
                 <div class="stat comments">
                 <i class="fas fa-comments"></i>
                      <div class="info">
                      Total comments<span> <?php 
                      echo  countItems('C_id' , 'comments' ) ;
                      ?></span>
                       </div> 
                     </div>
            </div>
         </div>
     </div>
     <div class="container latest"> 
         <div class="row">
                <div class="col-sm-6">
                 <div class="panel panel-default">
                     <div class="panel-heading"> 
                         <?php $latestusers = 5 ; // number of latest users to show ?>
                      <i class="fas fa-users"> </i> Latest  <?php echo $latestusers ?>  Registred Members
                      <span class="toggle-info pull-right">
                      <i class="fas fa-minus fa-lg"></i>
                      <span>
                     </div>
                     <div class="panel-body"> 
                     <ul class="list-unstyled latest-users">

                     <?php
                     $thelatest =getLatest('*' ,'users', 'UserID' , $latestusers) ;//latest users array
                     foreach($thelatest as $latest){
                        
               echo'<li>'. $latest['Fullname'] .' 
                        <a href="members.php?do=Edit&userid=' .$latest['UserID'].  '" > 
                            <span class="btn btn-success pull-right ">
                            <i class="fas fa-edit"></i> ' ;
                      if($latest['RegStatus']==0){
                          echo '<a href="members.php?do=Activate&userid=' .$latest['UserID'].  '" > 
                          <span class="btn btn-warning pull-right ">
                          <i class="fas fa-check"></i> ' ;
                      }
              echo  '</span>
                        </a>
                    </li>' ;
                    
                    }?>
                          <ul>
                     </div>

                 </div>
             </div>
     
     
             <div class="col-sm-6">
                 <div class="panel panel-default">
                     <div class="panel-heading"> 
                      <i class="fas fa-tag"> </i>   Latest Items
                      <span class="toggle-info pull-right">
                      <i class="fas fa-minus fa-lg"></i>
                      <span>
                     </div>
                     <div class="panel-body"> 
                     <ul class="list-unstyled latest-users">
                     <?php
                     foreach($latestitems as $item){
                         
                         echo '<li>' ;
                         echo $item['Name'] ; if($item['Status']==0){
                         echo '<a href="items.php?do=Approve&itemid=' .$item['item_ID'].  '" > 
                            <span class="btn btn-primary pull-right ">
                            <i class="fas fa-check"></i>  ' ;
                        }
                            echo '</span> </a>' ;
                        echo '<a href="items.php?do=Edit&itemid=' .$item['item_ID'].  '" > 
                            <span class="btn btn-success pull-right ">
                            <i class="fas fa-edit"></i>  ' ;

                            echo '</span> </a>' ;
                            echo '<a href="items.php?do=Delete&itemid=' .$item['item_ID'].  '" > 
                            <span class="btn btn-danger pull-right ">
                            <i class="fas fa-times"></i>' ;

                            echo '</span> </a>' ;
                         echo '</li>' ;
                      
                       
                     }
                      ?> 
                      </ul>
                     </div>

                 </div>
             </div>
             <div class="col-sm-6">
                 <div class="panel panel-default">
                     <div class="panel-heading"> 
                      <i class="fas fa-comments"> </i>   Latest Comments
                      <span class="toggle-info pull-right">
                      <i class="fas fa-minus fa-lg"></i>
                      <span>
                     </div>
                     <div class="panel-body"> 
                     <ul class="list-unstyled latest-users">
                     <?php
                     $ss = $con->prepare("SELECT comments.*, items.Name AS item_name , users.Fullname AS user_name
                     FROM 
                     comments
                     INNER JOIN items
                     ON items.item_ID = comments.item_id
                     INNER JOIN users
                     ON  users.UserID = comments.user_id
                     ORDER BY C_id DESC
                     ")    ;
                     $ss->execute();
                     $comments = $ss->fetchAll()   ;
                     foreach($comments as $comment){
                        echo '<div class="evenli">' ;
                         echo '<li>' ;
                           echo '<div class="comment-box">'  ; 
                         echo '<span class="comment-user"> <strong>'.$comment['user_name'].'</strong></span>' ;     
                         echo '<div class="comment">'.$comment['Comment'];
                           
                            echo '<div class="comment-control">';
                         if($comment['Status']==0){
                         echo '<a href="comments.php?do=Approve&comid=' .$comment['C_id'].  '" > 
                            <span class="btn btn-primary pull-right ">
                            <i class="fas fa-check"></i> ' ;
                                 }
                            echo '</span> </a>' ;
                        echo '<a href="comments.php?do=Edit&comid=' .$comment['C_id'].  '" > 
                            <span class="btn btn-success pull-right ">
                            <i class="fas fa-edit"></i>  ' ;

                            echo '</span> </a>' ;
                            echo '<a href="comments.php?do=Delete&comid=' .$comment['C_id'].  '" > 
                            <span class="btn btn-danger pull-right ">
                            <i class="fas fa-times"></i> ' ;

                            echo '</span> </a>' ;
                            echo '</div>';
                         
                         echo '</div>';
                         echo '</div>';
                         echo '</li>' ;
                         echo '</div>';
                         echo  '<hr>' ;
                     }
                      ?> 
                      </ul>
                     </div>

                 </div>
             </div>
        </div>   
     
     <?php  
     /* --- start dashboard ----- */
      include $tpl.'footer.php';
   } else {
       header('Location: index.php') ;
   }
   ob_end_flush();
   ?>