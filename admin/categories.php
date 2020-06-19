<?php
ob_start();
session_start() ;
/*
========================= categories page 
===========================================
*/

$pagetitel = 'Categories';
if(isset($_SESSION['username'])){

    include 'init.php';
 $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
   if($do =='Manage'){
       $sort ='ASC';
       $sort_array = array('ASC','DESC');
       if(isset($_GET['sort']) && in_array($_GET['sort'] ,$sort_array)){
        $sort= $_GET['sort'] ;
       }
      $stmt4 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort ");
      $stmt4->execute();
      $cats =  $stmt4->fetchAll() ;?>
      <div class="container" >
        
      <h1 class="text-center"> Add Category </h1>
         

 <div class=" categories">

         <div class="panel panel-default">
             <div class="panel-heading">
             <i class="fas fa-edit"></i>  Manger Categories
                 <div class="ordering pull-right">
                 <i class="fas fa-sort"></i> Ordered By : [
                     <a class="<?php if( $sort == 'ASC'){ echo 'active' ;}?>" href="?sort=ASC"> Asc </a> |
                     <a class="<?php if( $sort == 'DESC'){ echo 'active' ;}?>"href="?sort=DESC"> Desc </a>
                                   ]
                <i class="fas fa-eye"></i> View : [ <span class="active" data-view="full"> Full </span> |
                            <span data-view="classic"> Classic </span> ]
                </div>
             </div>
             <div class="panel-body">
                <?php 
                foreach($cats as $cat){
                    ?>
                    <div class="cat">
                        <div class="hidden-btns">
    <a  href="categories.php?do=Edit&catid=<?php echo $cat['ID'] ; ?>" class=" btn btn-primary"> <i class="fas fa-edit"></i> Edit</a>
    <a   href="categories.php?do=Delete&catid=<?php echo $cat['ID'] ; ?>" class=" btn btn-danger confirm"> <i class="fas fa-trash"></i> Delete</a>
                        </div>   
                    <?php
                    echo '<h3>'.$cat['Name'] .'</h3>' ;
                    ?>  <div class="full-view">
                    <p>  <?php if( $cat['Description']==''){
                         echo 'there is no description' ;}else{
                             echo  $cat['Description'] ;
                         }  ?> </p> <?php
             if($cat['Visibility']==1){echo '<span class="visible"> 
                <i class="fas fa-eye"></i> Hidden </span>' ;}
             if($cat['Allow_comment']==1){ echo'<span class="comment"> 
                <i class="fas fa-times"></i> Comments Disabled</span>';
                     } else{
                          }
             if($cat['Allow_adds']==1){  echo '<span class="adds">
                <i class="fas fa-times"></i> Adds Disabled</span>' ;}
                    ?>
                   <!--  <hr> -->
                    </div>
                   
                    </div>
                    <?php
                }
                ?>
             </div>  
         </div>
               <a href="categories.php?do=Add" class="Add-cat  btn btn-primary " > <i class="fas fa-plus"></i>  New Category </a>

</div>
      <?php 
   }
   elseif($do =='Add'){
    ?>
    <h1 class="text-center"> Add Category </h1>
<div class="container">
 <form class="Edit form-horizontal" action="  ?do=Insert " method="post"> 
    
    <div class="form-group">
        <input class="form-control " type="text" name="name"  placeholder="Name of the ctegory" autocomplete ="off" required="required" />
        <input class="form-control " type="text" name="description" placeholder="Description"   />
        <input class="form-control " type="text" name="ordering" placeholder="Ordering"  />
    </div>
    <div class="form-group form-group-lg">
      <div class="row">  
        <label class="col-sm-2 control-label ">Visibility</label>
        <div class="col-sm-10 col-md-6 ">
            <div>
               <input type="radio" id="vis-yes" name="visibility" value="0" checked />
               <label for="vis-yes"> Yes </label>
            </div>
            <div>
               <input type="radio" id="vis-no" name="visibility" value="1"  />
               <label for="vis-no"> No </label>
            </div>
        </div>
      </div> 
    </div>
    <div class="form-group form-group-lg">
    <div class="row">
       <label class="col-sm-2 control-label">Commenting</label>
        <div class="col-sm-10 col-md-6 ">
            <div>
               <input type="radio" id="com-yes" name="commenting" value="0" checked />
               <label for="com-yes"> Yes </label>
            </div>
            <div>
               <input type="radio" id="com-no" name="commenting" value="1"  />
               <label for="com-no"> No </label>
            </div>
        </div>
        </div>
    </div> 
    <div class="form-group form-group-lg">
    <div class="row">   
       <label class="col-sm-2 control-label">allow adds</label>
        <div class="col-sm-10 col-md-6 ">
            <div>
               <input type="radio" id="add-yes" name="allowadds" value="0" checked />
               <label for="add-yes"> Yes </label>
            </div>
            <div>
               <input type="radio" id="add-no" name="allowadds" value="1"  />
               <label for="add-no"> No </label>
            </div>
        </div>
        </div>
    </div>  
   
    
    
  <input class="btn btn-success " type="submit" name="submit"  value="Add"/>
 </form>
</div>
 <?php

   }
   elseif($do=='Insert'){

    if(isset($_POST['submit'])){
        echo "<h1 class=' Edit text-center'>  Add Category </h1>" ;
        echo ' <div class="container">';
      
       // the varibels from the input
      
       $name        = $_POST['name'] ;
       $description = $_POST['description'] ;
       $ordering    = $_POST['ordering'] ;
       $visible     = $_POST['visibility'] ;
       $comments    = $_POST['commenting'] ;
       $add         = $_POST['allowadds'] ;
       
     
         
         // ################################################
          //============== Validate the form ==================================
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
       $stmt= $con->prepare(" INSERT INTO categories(Name , Description , Ordering , Visibility ,Allow_comment, Allow_adds)
                               VALUES ( :zname , :zdesc , :zord , :zvis ,:zcom , :zadds )");
         $stmt->execute(array( 
         'zname'   =>  $name ,
         'zdesc'   =>  $description ,
         'zord'    =>  $ordering,
         'zvis'    =>  $visible ,
         'zcom'    =>  $comments,
         'zadds'   =>  $add ,
          
                          ))   ;     
                         
$theM = '<div class="alert alert-success">'. $stmt->rowCount(). ' record has been inserted </div> '  ;
redirectTo($theM, 'back' );
             }else{// if the item exixt already
                 $theM = '<div class="alert alert-warning"> this name exist already</div> '  ;
             redirectTo($theM ,'back' );
         }     
     }                 
      } else {
         echo "<h1 class=' Edit text-center'>  Category </h1>" ;
          echo '<div class="container">';
          
       $theM = '<div class="alert alert-danger"> you can not download this page  directly</div>' ;
       redirectTo($theM, 'back' );
       echo '</div>';
      }
   
      echo ' </div>';
     // end elseif for Insert
       
   }
   elseif($do=='Edit'){// ======================================== start edit
       $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) 
       ? intval($_GET['catid']) 
          :  0 ;
          $stmt = $con->prepare("SELECT   *
          FROM  categories
          WHERE
               ID = ? 
              ");
$stmt->execute(array($catid));
$cat= $stmt->fetch() ;
$count = $stmt->rowCount();
   if($count > 0){
        
      ?>
         <h1 class="text-center">Edit Category </h1>
          <div class="container">
              
 <form class="Edit form-horizontal" action="?do=Update" method="post"> 
    
    <div class="form-group">
        <input type="hidden" name="catid" value="<?php echo $catid; ?>" />
        <input class="form-control " type="text" name="name"  placeholder="Name of the ctegory" value="<?php echo $cat['Name'] ;  ?>"  required="required" />
        <input class="form-control " type="text" name="description" placeholder="Description" value="<?php echo $cat['Description'] ;  ?>"   />
        <input class="form-control " type="text" name="ordering" placeholder="Ordering" value="<?php echo $cat['Ordering'] ;  ?>"  />
    </div>
    <div class="form-group form-group-lg">
      <div class="row">  
        <label class="col-sm-2 control-label ">Visibility</label>
        <div class="col-sm-10 col-md-6 ">
            <div>
               <input type="radio" id="vis-yes" name="visibility" value="0" <?php
                if($cat['Visibility']== 0){ echo 'checked' ;}
               ?> />
               <label for="vis-yes"> Yes </label>
            </div>
            <div>
               <input type="radio" id="vis-no" name="visibility" value="1" <?php
                if($cat['Visibility']== 1){ echo 'checked' ;}
               ?>  />
               <label for="vis-no"> No </label>
            </div>
        </div>
      </div> 
    </div>
    <div class="form-group form-group-lg">
    <div class="row">
       <label class="col-sm-2 control-label">Commenting</label>
        <div class="col-sm-10 col-md-6 ">
            <div>
               <input type="radio" id="com-yes" name="commenting" value="0" <?php
                if($cat['Allow_comment']== 0){ echo 'checked' ;}
               ?> />
               <label for="com-yes"> Yes </label>
            </div>
            <div>
               <input type="radio" id="com-no" name="commenting" value="1" <?php
                if($cat['Allow_comment']== 1){ echo 'checked' ;}
               ?>  />
               <label for="com-no"> No </label>
            </div>
        </div>
        </div>
    </div> 
    <div class="form-group form-group-lg">
    <div class="row">   
       <label class="col-sm-2 control-label">allow adds</label>
        <div class="col-sm-10 col-md-6 ">
            <div>
               <input type="radio" id="add-yes" name="allowadds" value="0" <?php
                if($cat['Allow_adds'] == 0){ echo 'checked' ;}
               ?> />
               <label for="add-yes"> Yes </label>
            </div>
            <div>
               <input type="radio" id="add-no" name="allowadds" value="1" <?php
                if($cat['Allow_adds']== 1){ echo 'checked' ;}
               ?> />
               <label for="add-no"> No </label>
            </div>
        </div>
        </div>
    </div>  
   
    
    
  <input class="btn btn-success " type="submit" name="submit"  value="Edit"/>
 </form>
</div>
   <?php }else  {// thier is no id
        $theM =  '<div class="alert alert-danger ">there is no such id </div>' ;
        redirectTo($theM, 'back' );
           }
       
   }// ============================================= end edit
   // =============================================##########################Start Update
   elseif($do =='Update'){
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
  // $chek = checkItem('Name' ,'categories',   $name ) ;
  // if($chek==0){
   // insert the data 
 $stmt= $con->prepare(" UPDATE  categories SET Name = ?, Description = ?, Ordering = ? ,
  Visibility = ? ,Allow_comment = ?, Allow_adds = ?  WHERE ID = $c");
   $stmt->execute(array(  $name ,$description ,$ordering,$visible ,$comments,$add ))   ;     
                   
$theM = '<div class="alert alert-success">'. $stmt->rowCount(). ' record has been updated </div> '  ;
redirectTo($theM, 'back' );
       /*}else{
        echo 'bad' ;
    }*/
  }
} else {
   $theM = ' <div class="alert alert-danger"> you cant download this page directly </div>' ;
   redirectTo($theM, 'back' );
         

  echo ' </div>';}
   // =============================================##########################End Update
   // =============================================##########################End Update
 }elseif($do=='Delete'){ 
  // =============================================##########################start Delet
   ?>
    <h1 class="text-center"> Delete Category </h1>
        <div class="container">
      
<?php 
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) 
        ? intval($_GET['catid']) 
           :   ' this is not a number' ;
          $cheks = checkItem('ID' , 'categories' , $catid  ) ; 
        if($cheks>0){
            $stmt = $con->prepare("DELETE FROM categories WHERE ID = ?");
            $stmt->execute(array($catid));
            $theM = '<div class="alert alert-success">'. $stmt->rowCount(). ' record has been Deleted </div> '  ;
            redirectTo($theM ,'back' );
        }else{
        $theM = '<div class="alert alert-danger"> there is no such id </div> '  ;
            redirectTo($theM, 'back' );
        }
         ?> 
         </div>
         <?php
       
      }
    include $tpl.'footer.php' ;
}else {
    header('Location: index.php');
    exit();
       }
ob_end_flush();
?>
