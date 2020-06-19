<?php 
session_start() ;   
$pagetitel = 'Login';
$err ='';
if(isset($_SESSION['user'])){
 header('Location: index.php') ;
}
 include 'init.php';
?>
<?php 
//===================== login
if(isset($_POST['login'])){
   $username = filter_var( $_POST['username'] , FILTER_SANITIZE_STRING) ;
   $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING) ;
   $hashedpass = sha1($password);
   
   // chek if the user exists in the data bases 
   $stmt = $con->prepare("SELECT   UserID , Username , Password 
                            FROM  users
                            WHERE
                                 Username = ? 
                            AND 
                                 Password= ?  
                               
                                       ");
   $stmt->execute(array($username , $hashedpass));
   $row= $stmt->fetch() ;
    $count = $stmt->rowCount();
    
    if($count > 0 ){
      
      $_SESSION['user'] = $username ;// register the session name
      $_SESSION['uid'] = $row["UserID"];
    header('Location: index.php') ;
    } else{
      $err =  '<div class="alert alert-warning"> Wrong password or username</div> '  ;;
    }
 }
 if(isset($_POST['signup'])){
   
  echo "<h1 class=' Edit text-center'>  Sign up </h1>" ;
  echo ' <div class="container">';
  //dealing with the image upload
  $image = $_FILES['image'] ;
   /*print_r($image) ;*/
  $imageName   =   $image['name'];
  $imageSize   =   $image['size'];
  $imageTmp    =   $image['tmp_name'];
  $imageType   =   $image['type'];
     $imageAllowedExtensions = array("jpeg" , "jpg" , "png" , "gif");
     $imgNameExploded = explode('.' ,$imageName) ;
           $imgExtension = end($imgNameExploded);
           
           
           
 // the varibels from the input
 $formArray = array() ;
 $username    = filter_var($_POST['username'], FILTER_SANITIZE_STRING) ;
 $password = filter_var($_POST['password'] ,  FILTER_SANITIZE_STRING) ;
 $passagain = filter_var($_POST['passwordagain'] ,  FILTER_SANITIZE_STRING) ;
 $email   = filter_var(filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL) , FILTER_VALIDATE_EMAIL) ;
 $name        = filter_var($_POST['name'] , FILTER_SANITIZE_STRING) ;
 $hashedpass = sha1($_POST['password']);
   if($email != true){
     $formArray['validemail']= '<div class="alert alert-warning"> 
       this email is not valid </div>' ;
   }
   // ################################################
    //============== Validate the form ==================================

if($password !== $passagain){
$formArray['paasmatch'] = '<div class="alert alert-warning">
password doesn\'t match </div >'  ;
}
if(!empty($imageName) && !in_array($imgExtension , $imageAllowedExtensions )){
  $formArray['imgE'] = '<div class="alert alert-warning"> this type of file is not allowed  </div >';
}
if(empty($imageName)){
  $formArray['imgE'] = '<div class="alert alert-warning"> please upload your picture </div >';
}
      if(strlen($username)< 4) {
         $formArray['username'] = '  <div class="alert alert-warning">
         username can not be less than <strong> 4 </strong> char </div> '  ;
      }
      if(empty($username)){
         $formArray['emptyuser'] = ' <div class="alert alert-warning">
         username can not be <strong> Empty </strong> </div> ' ;
      }
      if(empty($password)){
       $formArray['emptypass'] = ' <div class="alert alert-warning">
       password can not be <strong> Empty </strong> </div> ' ;
    }
     if(empty($email)){
         $formArray['emptyemail'] =  '<div class="alert alert-warning">
          Email can not be <strong> Empty </strong> </div> ' ;
          }
     if(empty($name)){
         $formArray['emptyname'] = '<div class="alert alert-warning">
           Name can not be <strong> Empty </strong> </div> ' ;
              }
          // looooooping through the errors     
     /* foreach($formArray as $error){
            echo '<div class="alert alert-danger">' .$error.'</div>'  ;
       }*/
   // ################################################
    // after checking all kind of errors  => insert the updates into the databases
    if(empty($formArray)){
      $avatar = rand(0 , 1000000).'_'.$imageName ;
      //echo $avatar ;
      move_uploaded_file($imageTmp , "uploads\usersProfiles\\".$avatar);
	  
      //upload the picture to the data base
    
   //chek if the item exixts already or not
   $chek = checkItem('Username' ,'users',   $username ) ;
   if($chek==0){
       
  
    
   // insert the data 
 $stmt= $con->prepare(" INSERT INTO users(Username , Password , email , Fullname ,RegStatus , Date , img)
                         VALUES ( :zuser , :zpass , :zemail , :zname ,0 , now() , :zimg )");
   $stmt->execute(array( 
   'zuser'   =>  $username ,
   'zpass'   =>  $hashedpass ,
   'zemail'  =>  $email ,
   'zname'   =>  $name ,
   'zimg'   =>  $avatar  
    
                    ))   ;     
          
$succ = '<div class="alert alert-success"> Congrgulations  </div> '  ;

       }else{// if the item exixt already
           $theM = '<div class="alert alert-warning"> this username exist already</div> '  ;
       
   }   ///////////////////////////////////////////////////*/  
    }  /*else {
  redirectTo($theM  ,'back');
  exit();
}*/                


echo ' </div>';                 
 }


?>
<divclass="container">
    <!-- ------------------------------ start login ------------------ -->
<form class="login" action="<?php echo  $_SERVER['PHP_SELF'] ;?>" method="post"> 
    
    <span class="text-center lock">
                      <i class="fas fa-unlock"></i>
    </span>
     <h4 class="text-center"> Login </h4>
    <input class="form-control " type="text" name="username" placeholder="Username" autocomplete ="off" required="required" />
    <input class="form-control " type="password" name="password" placeholder="Password" required="required" />
    <p style="color:red"><?php echo $err ; ?>  </p>
   
    <input class="btn btn-primary btn-block" type="submit" name="login"  value="login"/>
    
    <a class="forget-pass" href="#" >  Forget password ?</a>
 </form>
 
        
        </div>
 
          </div>
 <!-- ------------------------------ end login ------------------ -->
 <!-- ------------------------------ start signup ------------------ -->  

 <form class="login form-horizontal" action="<?php echo  $_SERVER['PHP_SELF'] ;?>" method="post" enctype="multipart/form-data">        
 <h1 class="text-center"> Sign up </h1>
 <div class="form-group">
             
 <?php echo  $succ ; ?>
    <input class="form-control " pattern=".{4,8}" title=" Username must be between 4 & 8 chars" type="text" name="username"  placeholder="Username" autocomplete ="off"  />
      <?php echo  $formArray['username'] ; ?>
      <?php echo  $theM ; ?>
    <input class="form-control "  minlength="4" type="password" name="password" placeholder="Password" autocomplete="new-password"   />
    <input class="form-control " minlength="4" type="password" name="passwordagain" placeholder="Password again" autocomplete="new-password"   />
        <?php   echo $formArray['emptypass'] ; ?>
        <?php echo $formArray['paasmatch'] ; ?>
    <input class="form-control " type="email" name="email" placeholder="Email" autocomplete ="off"  />
    
    <?php echo $formArray['validemail'] ;?>
    <input class="form-control " type="text" name="name"  placeholder="Name" autocomplete ="off"  /> 
    <?php   echo $formArray['emptyname'] ; ?>
    <input class="form-control " type="file" name="image"     /> 
    <?php   echo $formArray['imgE'] ; ?>
  <input class="btn btn-success btn-block"  type="submit" name="signup"  value="Sign up"/>
     </form>
</div>
<!-- ------------------------------ End Sign up ------------------ -->
<?php
 include $tpl.'footer.php';
?>