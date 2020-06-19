<?php 



echo "<h1 class=' Edit text-center'>  Update Category</h1>" ;
    echo ' <div class="container">';
  if(isset($_POST['submit'])){
   // the varibels from the input

       $name        = $_POST['name'] ;
       $description = $_POST['description'] ;
       $ordering    = $_POST['ordering'] ;
       $visible     = $_POST['visibility'] ;
       $comments    = $_POST['commenting'] ;
       $add         = $_POST['allowadds'] ;
       $c         = $_POST['catid'] ;
     // dealing with the passord
      // if  the password is empty
      $formArray = array() ;
      if(strlen($name)< 4) {
         $formArray[] = '  name can not be less than <strong> 4 </strong> char '  ;
      }
      if(empty($name)){
         $formArray[] = ' username can not be <strong> Empty </strong> ' ;
      }
      
          // looooooping through the errors     
       foreach($formArray as $error){
            echo '<div class="alert alert-danger">' .$error.'</div>'  ;
       }
   // ################################################
    // after checking all kind of errors  => insert the updates into the databases
    if(empty($formArray)){
   //chek if the item exixts already or not
   $chek = checkItem('name' ,'categories',   $name ) ;
   if($chek==0){
   // insert the data 
 $stmt= $con->prepare(" UPDATE  categories SET Name = ?, Description = ?, Ordering = ? ,
  Visibility = ? ,Allow_comment = ?, Allow_adds = ?  WHERE ID = $c");
   $stmt->execute(array( 
   $name ,
     $description ,
    $ordering,
     $visible ,
    $comments,
     $add 
    ))   ;     
                   
$theM = '<div class="alert alert-success">'. $stmt->rowCount(). ' record has been updated </div> '  ;
redirectTo($theM, 'back' );
       }
  } else {
   $theM = ' <div class="alert alert-danger"> you cant download this page directly </div>' ;
   redirectTo($theM, 'back' );
        
  echo ' </div>'; 
  }}