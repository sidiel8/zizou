<?php 
session_start() ;
 /*
 =====================================================
 === Mange member page
 === You can Add | Edit | delete Members From here
 =====================================================
 */

   $pagetitel = 'Members';
  
   if(isset($_SESSION['username'])){
      include 'init.php';
      $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

       // start Mange page
      if($do == 'Manage' ){// Mange Page //======================== End Mange page##########
                          // #################################################
        $query =''   ;
        if(isset($_GET['page']) &&  $_GET['page']=='pending'){
            $query ='AND RegStatus=0' ;
        }
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID != 1 $query ")    ;
        $stmt->execute()  ;
        $row = $stmt->fetchAll()   ;           
        ?>
          <h1 class="text-center"> Mange Members </h1>
          <div class="container">
          <div class="table-responsive">
          <table class=" main-table mange-members text-center table table-bordered" >
          <tr>
             <td>#ID</td>
             <td>Username</td>
             <td>avatar</td>
             <td>Email</td>
             <td>Full name</td>
             <td>Registred  Date</td>
             <td>Control</td>
          </tr>
           <?php 
            foreach($row as $r){?>

           
          <tr>
             <td><?php echo $r['UserID'] ;?></td>
             <td><?php echo $r['Username'] ;?></td>
             <td><?php 
                     if(!empty($r['img'])){
                    ?>
                 <img src="uploads/avatars/<?php echo $r['img'] ;?> "  />
               <?php } else{ ?>
                <img src="uploads/avatars/default.jpeg "  />
             <?php    } ?>
                </td>
             <td><?php echo $r['email'] ;?></td>
             <td>  <?php  echo $r['Fullname'] ;?></td>
             <td><?php echo $r['Date'] ;?></td>
             <td><a href="members.php?do=Edit&userid=<?php echo $r['UserID'] ;?>" class="btn btn-success"> <i class="fas fa-edit"></i></a>
                 <a href="members.php?do=Delete&userid=<?php echo $r['UserID'] ;?>" class="btn btn-danger confirm">  <i class="fas fa-trash"></i></a>
                    <?php 
                    if($r['RegStatus']==0){?>
                 <a href="members.php?do=Activate&userid=<?php echo $r['UserID'] ;?>" class="btn btn-warning ">  <i class="fas fa-edit"></i> </a>

                   <?php }
                    ?>
                </td>
          </tr>
          <?php }
           ?>
          
          </table>
          
         
        

      <?php } //======================== End Mange page##########
             // #################################################
      elseif($do == 'Add'){//========================Add page
      ?>
        <form class="Edit form-horizontal" action="  ?do=Insert " method="post" enctype="multipart/form-data"> 
        <h3 class="text-center"> Add Member </h3>
        </div>
          <a href="members.php?do=Add" class="Add  btn btn-primary " > <i class="fas fa-plus"></i>  New Member </a>
 
          </div>
         <div class="form-group">
             
     
    <input class="form-control " type="text" name="username"  placeholder="Username" autocomplete ="off" required="required" />
    <input class="form-control " type="password" name="password" placeholder="Password" autocomplete="new-password" required="required"  />
    <input class="form-control " type="email" name="email" placeholder="Email" autocomplete ="off" required="required" />
    <input class="form-control " type="text" name="name"  placeholder="Name" autocomplete ="off" required="required" />
    <input class="form-control " type="file" name="avatar"  placeholder="usere image"   />

             
        
        
             <input class="btn btn-success " type="submit" name="submit"  value="Add"/>
     </form>
     <?php
      }//======================== EnAdd page####################################
       // #############################################################################
       elseif($do == 'Insert'){//============start Insert ###
        if(isset($_POST['submit'])){
           echo "<h3 class=' Edit text-center'>  Add Member </h3>" ;
           echo ' <div class="container">';
           $avatar = $_FILES['avatar'] ;
         
         $avatarName =   $avatar['name'];
          $avatarSize =   $avatar['size'];
          $avatarTmp =   $avatar['tmp_name'];
          $avatarType =   $avatar['type'];
          // the varibels from the input
         $avatarAlloxedExtenssions = array("jpeg"  ,"jpg" , "png" , "gif");
         $avatarexplode =  explode('.' , $avatarName) ;
         $avatarExtension  = strtolower(end($avatarexplode)) ;
    
         
          $username    = $_POST['username'] ;
          $password = $_POST['password'] ;
          $email       = $_POST['email'] ;
          $name        = $_POST['name'] ;
          $hashedpass = sha1($_POST['password']);
           
            // ################################################
             //============== Validate the form ==================================
     $formArray = array() ;
                  if(!empty($avatarName) && !in_array($avatarExtension , $avatarAlloxedExtenssions)){
                    $formArray[] = '  this type of extensions is not valid  '  ;

                                     }
                if(empty($avatarName)){
                    $formArray[] = '  please upload the picture  '  ;
            
                            }
                 if($avatarSize > 4194304){
                                $formArray[] = ' thid image is too heaveay  '  ;
                        
                                      }
               if(strlen($username)< 4) {
                  $formArray[] = '  username can not be less than <strong> 4 </strong> char '  ;
               }
               if(empty($username)){
                  $formArray[] = ' username can not be <strong> Empty </strong> ' ;
               }
               if(empty($password)){
                $formArray[] = ' password can not be <strong> Empty </strong> ' ;
             }
              if(empty($email)){
                  $formArray[] =  ' Email can not be <strong> Empty </strong> ' ;
                   }
              if(empty($name)){
                  $formArray[] = '  Name can not be <strong> Empty </strong> ' ;
                       }
                   // looooooping through the errors     
                foreach($formArray as $error){
                     echo '<div class="alert alert-danger">' .$error.'</div>'  ;
                     
                } //redirectTo($theM ,'back' );
            // ################################################
             // after checking all kind of errors  => insert the updates into the databases
             if(empty($formArray)){
                
                 $img = rand(0 , 1000000).'_'.$avatarName ;
                 move_uploaded_file($avatarTmp ,"uploads\avatars\\".$img ) ;
            //chek if the item exixts already or not
            $chek = checkItem('Username' ,'users',   $username ) ;
           if($chek==0){
                
           
             
            // insert the data 
          $stmt= $con->prepare(" INSERT INTO 
                                        users(
                                             Username ,
                                             Password ,
                                             email ,
                                             Fullname ,
                                             RegStatus ,
                                             Date , 
                                             img )
                                  VALUES ( :zuser , :zpass , :zemail , :zname ,1 , now() ,:zimg )");
            $stmt->execute(array( 
            'zuser'   =>  $username ,
            'zpass'   =>  $hashedpass ,
            'zemail'  =>  $email ,
            'zname'   =>  $name  ,
             ':zimg'  =>  $img
                             ))   ;     
                   
  $theM = '<div class="alert alert-success">'. $stmt->rowCount(). ' record has been inserted </div> '  ;
  redirectTo($theM, 'back' );
                }else{// if the item exixt already
                    $theM = '<div class="alert alert-warning"> this username exist already</div> '  ;
                redirectTo($theM ,'back' );
                }     
        }                 
         } else {
            echo "<h3 class=' Edit text-center'>  Add Member </h3>" ;
             echo '<div class="container">';
          $theM = '<div class="alert alert-danger"> you can not download this page  directly</div>' ;
          redirectTo($theM, 'back' );
          echo '</div>';
          }
      
         echo ' </div>';
        // end elseif for Insert

       }//============End Insert ####
       // #############################################################################
       //==============================================================================
      elseif($do == 'Edit'){ //Edit Page
       $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) 
       ? intval($_GET['userid']) 
          :   ' this is not a number' ;
          $stmt = $con->prepare("SELECT   *
          FROM  users
          WHERE
               UserID = ? 
          LIMIT 
                1     
                     ");
$stmt->execute(array($userid));
$row= $stmt->fetch() ;
$count = $stmt->rowCount();
   if($count > 0){
        
      ?>
       <form class="Edit form-horizontal" action="  ?do=Update " method="post"> 
    <h3 class="text-center"> Edit Member </h3>
     <div class="form-group">
         
 <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
<input class="form-control " type="text" name="username" value="<?php echo $row['Username'] ; ?>" placeholder="Username" autocomplete ="off" required="required" />

<input  type="hidden" name="oldpassword" value=" <?php echo $row['Password'] ; ?>"   />

<input class="form-control " type="password" name="newpassword" placeholder="Password" autocomplete="new-password"  />
         
         
<input class="form-control " type="text" name="email"  value="<?php echo $row['email'] ; ?>"placeholder="Email" autocomplete ="off" required="required" />

         
<input class="form-control " type="text" name="name" value="<?php echo $row['Fullname'] ; ?>" placeholder="Name" autocomplete ="off" required="required" />

         
    
    
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
        $userid      = $_POST['userid'] ;
        $username    = $_POST['username'] ;
        $email       = $_POST['email'] ;
        $name        = $_POST['name'] ;
          // dealing with the passord
           // if  the password is empty
          $pass = '' ;
          $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ;
          // ################################################
           //============== Validate the form ==================================
     $formArray = array() ;
             if(strlen($username)< 4) {
                $formArray[] = ' <div class="alert alert-danger"> username can not be less than <strong> 4 </strong> char </div>'  ;
             }
             if(empty($username)){
                $formArray[] = ' <div class="alert alert-danger"> username can not be <strong> Empty </strong> </div>' ;
             }
            if(empty($email)){
                $formArray[] =  ' <div class="alert alert-danger"> Email can not be <strong> Empty </strong> </div>' ;
                 }
            if(empty($name)){
                $formArray[] = '<div class="alert alert-danger">  Name can not be <strong> Empty </strong> </div>' ;
                     }
                 // looooooping through the errors     
              foreach($formArray as $error){
                   echo $error  ;
              }
          // ################################################
           // after checking all kind of errors  => insert the updates into the databases
           if(empty($formArray)){
           $stmt2 = $con->prepare("SELECT * FROM 
                                              users 
                                            WHERE 
                                                Username = ? 
                                            AND UserID != ?");
            $stmt2->execute(array($username , $userid))   ; 
            $count=$stmt2->rowCount();
            if($count==1){                           
          // update the database
          $theM = '<div class="alert alert-success"> this username already exist</div> '  ;
                 
                 redirectTo($theM, 'back' );
        }else{
         $stmt= $con->prepare(" UPDATE users  SET Username = ?  ,
                                                   Password = ? ,
                                                   Email    = ? ,
                                                   Fullname = ? 
                                 WHERE 
                                      UserID = ?                   
                               ");
          $stmt->execute(array( 
            $username , $pass , $email , $name  , $userid
                           ))   ;    
                 // echo successe 
                 $theM = '<div class="alert alert-success">'. $stmt->rowCount(). ' record has been updated </div> '  ;
                 
                 redirectTo($theM, 'back' );
                
                    
                } 
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
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) 
        ? intval($_GET['userid']) 
           :   ' this is not a number' ;
          $cheks = checkItem('UserID' , 'users' , $userid  ) ;
           /*$stmt = $con->prepare("SELECT   *
          // FROM  users
           WHERE UserID = ? 
             LIMIT 1");
           $stmt->execute( array($userid));
           $row  =$stmt->fetch();
           $count = $stmt->rowCount() ;*/
           
        if($cheks>0){
            $stmt = $con->prepare("DELETE FROM users WHERE UserID = ?");
             //$stmt->bindParam("?", $userid);
            $stmt->execute(array($userid));
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
     elseif($do == 'Activate'){//Activate Members ?>
        <h3 class="text-center"> Activate Members </h3>
          <div class="container">
        
  <?php 
          $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) 
          ? intval($_GET['userid']) 
             :   ' this is not a number' ;
            $cheks = checkItem('UserID' , 'users' , $userid  ) ;
             /*$stmt = $con->prepare("SELECT   *
            // FROM  users
             WHERE UserID = ? 
               LIMIT 1");
             $stmt->execute( array($userid));
             $row  =$stmt->fetch();
             $count = $stmt->rowCount() ;*/
             
          if($cheks>0){
              $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
               //$stmt->bindParam("?", $userid);
              $stmt->execute(array($userid));
              $theM = '<div class="alert alert-success">'. $stmt->rowCount(). ' record has been Updated </div> '  ;
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
