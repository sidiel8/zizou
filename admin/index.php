<?php
   session_start() ;
    $nonavbar = '' ;
    $pagetitel = 'Login';
    $err='';
   if(isset($_SESSION['username'])){
     header('Location: dashboard.php') ;// redirect to dashbored if a session existe 
   }
  include 'init.php' ;
  
 include $tpl.'header.php';
 //if($_SERVER['REQUEST_METHOD']== 'POST'){
  $do = isset($_GET['do']) ? $_GET['do'] : 'Login' ;
  if($do=='Login'){
    if(isset($_POST['submit'])){
   $username = $_POST['username'] ;
   $password = $_POST['password'] ;
   $hashedpass = sha1($password);
   
   // chek if the user exists in the data bases 
   $stmt = $con->prepare("SELECT   UserID , Username , Password 
                            FROM  users
                            WHERE
                                 Username = ? 
                            AND 
                                 Password= ?  
                            AND
                                 GroupID = 1
                            LIMIT 
                                  1     
                                       ");
   $stmt->execute(array($username , $hashedpass));
   $row= $stmt->fetch() ;
    $count = $stmt->rowCount();
    
    if($count > 0 ){
      
      $_SESSION['username'] = $username ;// register the session name
      $_SESSION['ID'] = $row["UserID"];
    header('Location: dashboard.php') ;
    } else{
      $err = " wrong password" ;
    }
 }

  
?>
 <form class="login" action="<?php echo  $_SERVER['PHP_SELF'] ;?>" method="post"> 
    
    <span class="text-center lock">
                      <i class="fab fa-expeditedssl"></i>
    </span>
     <h4 class="text-center"> Login </h4>
    <input class="form-control " type="text" name="username" placeholder="Username" autocomplete ="off" />
    <input class="form-control " type="password" name="password" placeholder="Password"  />
    <?php echo $err; ?>
    <input class="btn btn-primary btn-block" type="submit" name="submit"  value="login"/>
    <a class="btn btn-success  btn-block" href="?do=sign-up" >  Sigh Up</a>
    <a class="forget-pass" href="#" >  Forget password </a>
 </form>

<?php
}elseif($do=='sign-up'){
  ?>
        <form class="Edit form-horizontal" action="  ?do=insert-new-user " method="post"> 
        <h1 class="text-center"> Sign up </h1>
        </div>
 
          </div>
         <div class="form-group">
             
     
    <input class="form-control " type="text" name="username"  placeholder="Username" autocomplete ="off" required="required" />
    <input class="form-control " type="password" name="password" placeholder="Password" autocomplete="new-password" required="required"  />
    <input class="form-control " type="password" name="passwordagain" placeholder="Password again" autocomplete="new-password" required="required"  />

    <input class="form-control " type="email" name="email" placeholder="Email" autocomplete ="off" required="required" />
    <input class="form-control " type="text" name="name"  placeholder="Name" autocomplete ="off" required="required" />
    
             
        
               
             <input class="btn btn-success " type="submit" name="submit"  value="Sign up"/>
             <a class=" Edit btn btn-primary" href="index.php?do=Login" >  Login </a>
             

     </form>
     <?php
}elseif($do='insert-new-user'){
  //===========================================================================================
  
    echo "<h1 class=' Edit text-center'>  Sign up </h1>" ;
    echo ' <div class="container">';
  
   // the varibels from the input
  
   $username    = $_POST['username'] ;
   $password = $_POST['password'] ;
   $passagain = $_POST['passwordagain'] ;
   $email       = $_POST['email'] ;
   $name        = $_POST['name'] ;
   $hashedpass = sha1($_POST['password']);
     
     // ################################################
      //============== Validate the form ==================================
$formArray = array() ;
if($password != $passagain) {
  $formArray[] = ' ppassword dosnt match '  ;
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
         }
     // ################################################
      // after checking all kind of errors  => insert the updates into the databases
      if(empty($formArray)){
     //chek if the item exixts already or not
     $chek = checkItem('Username' ,'users',   $username ) ;
     if($chek==0){
         
    
      
     // insert the data 
   $stmt= $con->prepare(" INSERT INTO users(Username , Password , email , Fullname ,RegStatus , Date)
                           VALUES ( :zuser , :zpass , :zemail , :zname ,0 , now() )");
     $stmt->execute(array( 
     'zuser'   =>  $username ,
     'zpass'   =>  $hashedpass ,
     'zemail'  =>  $email ,
     'zname'   =>  $name 
      
                      ))   ;     
            
$theM = '<div class="alert alert-success">'. $stmt->rowCount(). ' record has been inserted </div> '  ;
redirectTo($theM, 'back' );
         }else{// if the item exixt already
             $theM = '<div class="alert alert-warning"> this username exist already</div> '  ;
         redirectTo($theM  );
     }     
 }                 
  

  echo ' </div>';
  //===========================================================================================
}


 include $tpl.'footer.php';
?>