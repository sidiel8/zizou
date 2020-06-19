<?php 
session_start() ;
 /*
 =====================================================
 === Mange comments page
 === You can Add | Edit | delete Members From here
 =====================================================
 */

   $pagetitel = 'Comments';
  
   if(isset($_SESSION['username'])){
      include 'init.php';
      $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

       // start Mange page
      if($do == 'Manage' ){// Mange Page //======================== End Mange page##########
                          // #################################################
        
        $stmt = $con->prepare("SELECT comments.*, items.Name AS item_name , users.Fullname AS user_name
                                     FROM 
                                     comments
                                     INNER JOIN items
                                     ON items.item_ID = comments.item_id
                                     INNER JOIN users
                                     ON  users.UserID = comments.user_id
                                     ")    ;
        $stmt->execute()  ;
        $row = $stmt->fetchAll()   ;           
        ?>
          <h1 class="text-center"> Mange Comments </h1>
          <div class="container">
          <div class="table-responsive">
          <table class=" main-table text-center table table-bordered" >
          <tr>
             <td>#ID</td>
             <td>Comment</td>
             <td>User Name</td>
             <td>iItem Name</td>
             <td>Added Date</td>
             <td>Control</td>
          </tr>
           <?php 
            foreach($row as $r){?>

           
          <tr>
             <td><?php echo $r['C_id'] ;?></td>
             <td><?php echo $r['Comment'] ;?></td>
             <td><?php echo $r['user_name'] ;?></td>
             <td><?php echo $r['item_name'] ;?></td>
             <td><?php echo $r['C_date'] ;?></td>
             <td><a href="comments.php?do=Edit&comid=<?php echo $r['C_id'] ;?>" class="btn btn-success"> <i class="fas fa-edit"></i> </a>
                 <a href="comments.php?do=Delete&comid=<?php echo $r['C_id'] ;?>" class="btn btn-danger confirm">  <i class="fas fa-trash"></i> </a>
                    <?php 
                    if($r['Status']==0){?>
                 <a href="comments.php?do=Approvee&comid=<?php echo $r['C_id'] ;?>" class="btn btn-warning ">  <i class="fas fa-check"></i> </a>

                   <?php }
                    ?>
                </td>
          </tr>
          <?php }
           ?>
          
          </table>
          
         
        

      <?php } //======================== End Mange page##########
             // #################################################
     
       // #############################################################################
       //==============================================================================
      elseif($do == 'Edit'){ //Edit Page
       $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) 
       ? intval($_GET['comid']) 
          :   ' this is not a number' ;
          $stmt = $con->prepare("SELECT comments.*, items.Name AS item_name , users.Fullname AS user_name
                                     FROM 
                                     comments
                                     INNER JOIN items
                                     ON items.item_ID = comments.item_id
                                     INNER JOIN users
                                     ON  users.UserID = comments.user_id
          WHERE
               C_id= ? 
            
                     ");
$stmt->execute(array($comid));
$row= $stmt->fetch() ;
$count = $stmt->rowCount();
   if($count > 0){
        
      ?>
       <form class="Edit form-horizontal" action="  ?do=Update " method="post"> 
    <h3 class="text-center"> Edit comment </h3>
     <div class="form-group">
         
 <input type="hidden" name="comid" value="<?php echo $comid; ?>" />
<textarea class="form-control "  name="comment"> <?php echo $row['Comment'] ; ?> </textarea>


         
         

         

         
    
    
         <input class="btn btn-success " type="submit" name="submit"  value="Edit"/>
 </form>
        
   <?php }else  {// thier is no id
        $theM =  '<div class="alert alert-danger ">there is no such id </div>' ;
        redirectTo($theM, 'back' );
           }
     
    } // end elseif for Edit
    // #############################################################################
    //==============================================================================
      elseif($do== 'Update'){// start if do== update
         echo "<h3 class=' Edit text-center'>  Update Member </h3>" ;
         echo ' <div class="container">';
       if(isset($_POST['submit'])){
        // the varibels from the input
        $comid      = $_POST['comid'] ;
        $comment    = $_POST['comment'] ;
        
          // dealing with the passord
           // if  the password is empty
         
          // ################################################
           //============== Validate the form ==================================
     $formArray = array() ;
             
            
            if(empty($comment)){
                $formArray[] = '<div class="alert alert-danger"> comment can not be <strong> Empty </strong> </div>' ;
                     }
                 // looooooping through the errors     
              foreach($formArray as $error){
                   echo $error  ;
              }
          // ################################################
           // after checking all kind of errors  => insert the updates into the databases
           if(empty($formArray)){
           
          // update the database
         $stmt= $con->prepare(" UPDATE comments  SET Comment = ?  
                                                   
                                 WHERE 
                                      C_id = ?                   
                               ");
          $stmt->execute(array( 
            $comment, $comid 
                           ))   ;     
                 // echo successe 
                 $theM = '<div class="alert alert-success">'. $stmt->rowCount(). ' record has been updated </div> '  ;
                 
                 redirectTo($theM);
                }                      
       } else {
        $theM = ' <div class="alert alert-danger"> you cant download this page directly </div>' ;
        redirectTo($theM, 'back' );
       }
    
       echo ' </div>';
      }// end elseif for Update
      // start elseif for Delete
     elseif($do == 'Delete'){//Delete Members ?>
      <h3 class="text-center"> Delete Member </h3>
        <div class="container">
      
<?php 
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) 
        ? intval($_GET['comid']) 
           :   ' this is not a number' ;
          $cheks = checkItem('C_id' , 'comments' , $comid  ) ;
          
        if($cheks>0){
            $stmt = $con->prepare("DELETE FROM comments WHERE C_id = ?");
             //$stmt->bindParam("?", $userid);
            $stmt->execute(array($comid));
            $theM = '<div class="alert alert-success">'. $stmt->rowCount(). ' record has been Deleted </div> '  ;
            redirectTo($theM ,'back' );
        }else{
        $theM = '<div class="alert alert-danger"> there is no such id </div> '  ;
            redirectTo($theM, 'back' );
        }
         ?> 
         </div>
         <?php
     }// end elseif for Delete
     //############################################################################
     // start elseif for Activate
     elseif($do == 'Approve'){//Activate Members ?>
        <h3 class="text-center"> Activate Members </h3>
          <div class="container">
        
  <?php 
          $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) 
          ? intval($_GET['comid']) 
             :   ' this is not a number' ;
             $cheks = checkItem('C_id' , 'comments' , $comid  ) ;
           
          if($cheks>0){
              $stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE C_id = ?");
               //$stmt->bindParam("?", $userid);
              $stmt->execute(array($comid));
              $theM = '<div class="alert alert-success">this comment  has been Approved </div> '  ;
              redirectTo($theM);
          }else{
          $theM = '<div class="alert alert-danger"> there is no such id </div> '  ;
              redirectTo($theM, 'back' );
          }
           ?> 
           </div>
           <?php
       }// end elseif for Activate
       //############################################################################
     
      
      include $tpl.'footer.php';
   }
   // #############################################################################
    //==============================================================================
    else {
       header('Location: index.php') ;
   }