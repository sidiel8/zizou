<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN') ;?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    
        <a class="nav-link" href="categories.php"><?php echo lang('CATEGORIES') ;?></a>
        <a class="nav-link" href="items.php"><?php echo lang('ITEMS') ;?></a>
        <a class="nav-link" href="members.php"><?php echo lang('MEMBERS') ;?></a>
       
        <a class="nav-link" href="comments.php"><?php echo lang('COMMENTS') ;?></a>
        
      
      </div>
      <div class=" navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
         
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo lang('USER') ;?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="../index.php">Visit Shop</a>
          <a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ; ?>"><?php echo lang('Edit') ;?></a>
          <a class="dropdown-item" href="#"><?php echo lang('SETTINGS') ;?></a>
          <a class="dropdown-item" href="logout.php"><?php echo lang('LOGOUT') ;?></a>
        </div>
      </li>
      
    </ul>
    
  </div>
</nav>