<?php
session_start();
$pagetitel = 'Home page';
  include 'init.php' ;
 $allItem = getAll('items'); ?>
 <div class="container">
   <div class="main-page">
   <div class="row">
<?php 
  if(!empty($allitem)){
  foreach($allItem as $item){?>
  
    <div class="col-sm-6 col-md-3 " >
            <div class="thumbnail item-box " style="cursor:pointer">
                 <span class="price-tag" >
                 $<?php  echo  $item['Price'];  ?>
                 </span>
                         
                    <div class="img-responsive img-thumbnail" >
                    <img  src="uploads/itemsphoto/<?php echo $item['Image'] ;  ?> " /> 
                    </div>
               <div class="caption">
                  <h3> <a href="items.php?itemid=<?php  echo  $item['item_ID'];  ?>"><?php  echo  $item['Name'];  ?> </a></h3>
                   <p> <?php  echo  $item['Description'];  ?> </p>
               </div>
               <div class="date"><small> <?php  echo  $item['Add_date'];  ?> </small></div>
  
            </div>  
            </div>
            
 <?php } } else { ?>
                                                      <div class="empty-cat">
                                                      <i class="fas fa-exclamation-circle " ></i>
                                                           <h1> Empty </h1>
                                                      </div>
                                                           <?php       }     ?>
 
 </div> 
 </div>
 </div>          
 <?php                    
 include $tpl.'footer.php';
?>