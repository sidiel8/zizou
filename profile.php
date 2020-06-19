<?php
session_start();
$pagetitel = 'Profile';
include 'init.php' ;

if(isset($_SESSION['user'])){
    $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
    $getUser->execute(array($sessionUsername));
    $infs = $getUser->fetch();
?>
  <h1 class="text-center"> <img class="rounded-circle img-thumbnail " style="width:100px ; margin:auto"  src="uploads/usersProfiles/<?php echo $infs['img'] ; ?>" />  My  Profile
  
</h1>

<div class="information block">
    <div class="container">
        
    <a class=" btn btn-dark btn-sm right" href="newitem.php"> Add item </a>
        <div class="panel panel-primary">
            <div class="panel-heading ">
                Information 
            </div>
            <div class="panel-body">
               <ul class="list-unstyled">
                   <li> <i class="fas fa-user"></i> <span> Name</span>  :  <?php echo $infs['Fullname'];?> </li>
                   <li> <i class="fas fa-unlock-alt"></i> <span>Username</span>  :  <?php echo $infs['Username'];?> </li>
                   <li> <i class="fas fa-envelope"></i> <span>Email</span> :  <?php echo $infs['email'];?> </li>
                   <li><i class="fas fa-calendar"></i> <span> Date</span> :  <?php echo str_replace('-' , '/' , $infs['Date']);?> </li>
                   <li><i class="fas fa-tag"></i> <span> Favorite category </span> :  <?php ?> </li>
                   <a class=" btn btn-primary btn-sm  mybut" href="#"> Edit information </a>
                </ul>
                
            </div>
        </div>   
    </div>       
</div>

<div class="latest-adds block">
    <div class="container">
    
        <div class="panel panel-primary">
            <div class="panel-heading ">
                Latest Items                                         
            </div>
        
        <div class="panel-body">
        <div class="row">
              <?php 
               if(!empty(getItem('Member_ID', $infs['UserID']))){
                foreach(getItem('Member_ID', $infs['UserID']) as $item){?>
        
            <div class="col-sm-6 col-md-3">
               <div class="thumbnail item-box">
                  <span class="price-tag" >
                  <?php  echo  $item['Price'];  ?>
                  </span>
                  <?php if($item['Approve']==0){?>
                    <span class="approve-item" >   <?php echo 'not visible yet'; ?> </span>
                 <?php  } 
                    ?>
                  
                    <div class="img-responsive" >
                       
                    <img  src="im.jpg" />
                  
                   </div>
                   <div class="caption">
                  <h3> <a href="items.php?itemid=<?php  echo  $item['item_ID'];  ?>"><?php  echo  $item['Name'];  ?> </a></h3>
                   <p> <?php  echo  $item['Description'];  ?> </p>
                     <div class="date"><small> <?php  echo  $item['Add_date'];  ?> </small></div>
                  </div>  
            </div>  
        </div>  
        
               <?php  
                                                     }?> </div> 
                                                     
                                                     <?php
                                                     
                                                     }else { ?> <div class="container" style="padding-left:20px;"> <?php
                                                      echo ' There is no items to show
                                                      ' ;
                                                            ?>  </div><?php       }     ?> 
                                                     
           
        </div>   
    </div>       
</div>

<div class="latest-comments block ">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading ">
                Latest Comments
            </div>
            <div class="panel-body">
                <!-- ------------------------------------------------------------ -->
               
               <?php 
                $stmt3 = $con->prepare("SELECT * FROM comments 
                                   WHERE user_id = ?  
                                   ORDER BY C_id DESC  ") ;
                $stmt3->execute(array($_SESSION['uid']));
                $comments = $stmt3->fetchAll();
                if(!empty($comments)){
                foreach($comments as $comment ){
                    echo $comment['Comment'].'<br/> <hr>' ;
                }}else{
                    echo 'empty' ;
                }
                ?>
                    
                <!-- ----------------------------------------------------------- -- -->
            </div>
        </div>   
    </div>       
</div>
 <?php }else {
      header('Location: index.php');
      exit();
  }       
 include $tpl.'footer.php';
?>