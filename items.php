<?php
session_start();
$pagetitel = 'Item';
include 'init.php' ;
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

    $getItem = $con->prepare("SELECT items.*,
     categories.Name AS 
     cat_name ,
     users.Fullname AS user_name 
     
      FROM items
     INNER JOIN  categories
     ON
       categories.ID= items.Cat_ID
     INNER JOIN  users
     ON
     users.UserID= items.Member_ID
       WHERE item_ID = ?");
    $getItem->execute(array($itemid));
    $count=$getItem->rowCount();
    if($count>0){
    $infs = $getItem->fetch();
        echo'<h1 class="text-center">'. $infs['Name'].'</h1>' ;
        /////////////////////////////////////////////////////////////
      ?>  
<div class="info block">
    <div class="container">
        <div class="row">
                <div class="col-md-3">
                    <div class="thumbnail item-box live-preview">
                        <span class="price-tag" >
                               <?php echo $infs['Price'] ; ?>
                        </span>
                       <div class="img-responsive" >
                          <img  src="item.jpg" />
                       </div>
                    </div>  
                </div>
                <div class="col-md-9">
                    <!-- ------------------------------------ -->
                 <h2> <?php echo $infs['Name'] ; ?> </h2>
                 <p><span> Descriptin   </span> : <?php echo $infs['Description'] ; ?> </p>
                 <ul class="list-unstyled  custom-user-cat">
                 <li> <span> <i class="fas fa-hand-holding-usd"></i>  Price  </span> : <?php echo $infs['Price'] ; ?> </li>
                 <li> <span><i class="fas fa-user"></i>  Posted by  </span> : <a href="#"> <?php echo $infs['user_name'] ; ?> </a> </li>
                 <li> <span><i class="fas fa-tags"></i>  Category  </span> : <a href="categories.php?pageid=<?php echo $infs['Cat_ID'] ; ?>"> <?php echo $infs['cat_name'] ; ?> </a> </li>
                 <li> <span > <i class="fas fa-building"></i>  Made in  </span> : <?php echo $infs['Country_made'] ; ?> </li>
                 <li><span><i class="fas fa-calendar"></i>  Date   </span>: <?php echo $infs['Add_date'] ; ?> </li>
                 </ul>
                    <!-- ------------------------------------ -->
                </div>
              
        </div> 
        <hr class="custom-hr">
        
            <div class="row">
            <div class="col-md-3">
                
            </div>

            <div class="col-md-9">
            <?php  if(isset($_SESSION['user'])){ ?>
                 <div class="add-comment">
                <h5>Add comment </h5>
                <form action="<?php echo  $_SERVER['PHP_SELF'].'?itemid='. $infs['item_ID'] ; ?>" method="POST">
                    <textarea class="form-control"  name="comment" placeholder="comment" required="required" ></textarea>
                
                 <button type="submit" name="submit"  > <i class="fas fa-chevron-circle-right"></i> </button>
                 </form>
                 <?php
                    if(isset($_POST['submit'])){
                        $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING );
                        if(!empty($comment )){
                        $query = $con->prepare("INSERT INTO
                         comments(comment , C_date  ,item_id ,user_id)
                            VALUES( ? , now()  , ? ,?)
                           ");
                           $query->execute(array($comment , $infs['item_ID'] ,$_SESSION['uid'] ));
                           echo $comment ;
                        }//if the comment is empty
                        else{

                        }
                    }
                  ?>
               </div>
               <?php } else{ ?>
              Please <a href="login.php"> Login </a> or <a href="login.php"> Signup </a> to  add a comment
        <?php  } ?>
            </div>

            </div> 
        
        <hr class="custom-hr">
        <div class="row">
        <?php  $q1 = $con->prepare("SELECT comments.*, users.Fullname AS c_user
                    FROM comments
                      INNER JOIN users
                      ON
                       users.UserID = comments.user_id  
                       
                     WHERE item_id = ?
                     ORDER BY C_id DESC
                     ");
                   $q1->execute(array($infs['item_ID']));
                   $cms = $q1->fetchAll();
                   ?>
             
             <div class="col-md-12">
                
                   
                  <?php foreach($cms as $cm){?>
                    <div class="comment-box-item">
                        <!-- ---------------------start coment box --- -->
                        <?php 
                        $stmt3 = $con->prepare("SELECT * FROM users   WHERE UserID = ? ") ;
                        $stmt3->execute(array($cm['user_id']));
                        $rows= $stmt3->fetch();
                        ?>
                        <div class="row">
                          <div class="col-sm-2">
                        <div class="text-center">
                         <img class="rounded-circle img-thumbnail " 
                          src="uploads/usersProfiles/<?php echo $rows['img'] ; ?>" />
                         <a href=""> <?php  echo $cm['c_user'].'<br/>'; ?> </a>
                        </div>
                    </div>
                      <div class="col-sm-10">
                            <p class="lead"> <?php  echo $cm['Comment'].'<br/>'; ?> </p>
                      </div>
                    </div>
                    <!-- ---------------------End coment box --- -->
                    </div>
                  <?php } ?>
                
              </div> 

        </div>  
    </div>
</div>
 
   <?php  /////////////////////////////////////////////////////////////
   }else{
        echo'<h1 class="text-center">Empty</h1>' ;
    }
 include $tpl.'footer.php';
?>