<!DOCTYPE html >
<html>
  <head>
    <meta charset="utf-8" />
      <title><?php  getTitel() ; ?></title>
     <link rel="stylesheet" href="layout/css/bootstrap.css" />
     <link rel="stylesheet" href="layout/fonts/css/fontawesome-all.css" />
     <link rel="stylesheet" href="layout/css/front.css" />
    </head>
<body>
<div class="upper-bar">

  <?php   if(!isset($_SESSION['user'])){?>
 
  <div class="upper-bar-login">
    <a  class="pull-right-login" href="login.php">Login/Signup</a>
    </div>
    <?php }  ?>
    </div>
 
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php"><?php echo lang('HOME_ADMIN') ;?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse " id="navbarSupportedContent">

      <?php  
          $categories = getCat() ;  
          foreach($categories as $category){?>
       
            <a class="nav-link" href="
             categories.php?pageid=<?php echo $category['ID'] ; ?>">
             <?php echo $category['Name'] ;?></a>
             <?php } ?>
  
      </div>

      <?php   if(isset($_SESSION['user'])){
           $stmt3 = $con->prepare("SELECT * FROM users   WHERE UserID = ? ") ;
           $stmt3->execute(array($_SESSION['uid']));
           $rows= $stmt3->fetch();
        ?>
           
      <div class=" navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav mr-auto">
      <img class="rounded-circle img-thumbnail " 
      style="width:50px ; height:50px" 
       src="uploads/usersProfiles/<?php echo $rows['img'] ; ?>" /> 
      <li class="nav-item dropdown">

        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php  echo $rows['Fullname'] ; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="index.php">Visit Shop</a>
            <a class="dropdown-item" href="newitem.php">New Item</a>
          <a class="dropdown-item" href="profile.php">My Profile</a>
          <a class="dropdown-item" href="logout.php"><?php echo lang('LOGOUT') ;?></a>
        </div>
      </li>
      
    </ul>
    
  </div>
      <?php } ?>  
</nav>