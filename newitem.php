<?php
session_start();
$pagetitel = 'Add Item';
include 'init.php' ;

if(isset($_SESSION['user'])){
    //===========================start inser fomr========================//
    if(isset($_POST['submit'])){
      /// delaing with the image
          $image = $_FILES['image'];
           $imageName =  $image['name'];
          $imageSize =  $image['size'];
          $imageTmp  =  $image['tmp_name'];
          $imageType =  $image['type'];
           $imageEploded = explode('.' ,$imageName);
            $imageExtension = end($imageEploded);
          $allowedExtensions = array("jpeg" , "jpg" ,"png" , "gif") ;


         $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING) ;
         $description = filter_var($_POST['description'],  FILTER_SANITIZE_STRING);
         $price = filter_var($_POST['price'] , FILTER_SANITIZE_NUMBER_INT)  ;
         $country = filter_var($_POST['country']  , FILTER_SANITIZE_STRING);
         $status = filter_var($_POST['status']  , FILTER_SANITIZE_NUMBER_INT) ;
         $member_id = filter_var($_SESSION['uid']  , FILTER_SANITIZE_NUMBER_INT) ;
         $cat_id = filter_var($_POST['category']  , FILTER_SANITIZE_NUMBER_INT);
         $formarray = array();
         if(!in_array($imageExtension , $allowedExtensions) &&!empty($imageName)){
          $formarray['novalidimg'] = ' <div class="alert alert-warning">this type of files is not allowed </div>' ;
         }
         if(empty($imageName)){
          $formarray['emptyimg'] = ' <div class="alert alert-warning">please upload the picture </div>' ;
         }
         if(empty($name) || strlen($name)<2){
          $formarray['emptyname'] = ' <div class="alert alert-warning">Name can not be Empty or less than 2 chars </div>' ;
         }
         if(empty($price)){
          $formarray['emptyprice'] = '<div class="alert alert-warning">Price can not be Empty </div>' ;
         }
         if(empty($status)){
            $formarray['emptystatus'] = '<div class="alert alert-warning">Status can not be Empty </div>' ;
           }
           if(empty($cat_id)){
            $formarray['emptycat'] = '<div class="alert alert-warning">Category can not be Empty </div>' ;
           }
         
         echo '<div class="container">'  ;
         /*foreach($formarray as $error){
          echo '<div class="alert alert-danger">' .$error.'</div>'  ;
                                      } */ 
         if(empty($formarray)){// if all inputs are filled
               $avatar = rand(0, 10000000).'_'.$imageName ;
               echo $avatar ;
               move_uploaded_file($imageTmp , "uploads\itemsphoto\\".$avatar) ;
     


          $stmt= $con->prepare(" INSERT INTO 
                                        items(
                                          Name ,
                                          Description ,
                                          Price ,
                                          Status ,
                                          Cat_ID ,
                                          Member_ID ,
                                          Add_date ,
                                          Country_made ,
                                          Image )
                                  VALUES ( 
                                         :zname , 
                                         :zdesc , 
                                         :zprice , 
                                         :zstatus ,
                                         :zcatid,
                                         :zmemberid ,
                                         now() ,
                                         :zcouuntry ,
                                         :zimage )");
$stmt->execute(array( 
'zname'   =>  $name ,
'zdesc'   =>  $description ,
'zprice'  =>  $price ,
'zstatus'   =>  $status ,
'zcatid' => $cat_id,
'zmemberid' => $member_id ,
'zcouuntry' => $country  ,
'zimage' => $avatar 
     ))   ;             
     $theM = '<div class="alert alert-success" > item added successfuly </div>'   ;
     header("Refresh: 5 ; newitem.php ") ;
    }else{//if there is errors
         $theM='<div class="alert alert-warning" > failed to add item </div> ';
         header("Refresh: 5 ; newitem.php ") ;                       
                                   
        }
       
      }
      //==================================end inser form============================//
?>
  <h1 class="text-center"> Add New Item </h1>
<div class="information block">
    <div class="container">
        <?php  echo $theM ;
       
        ?>
    <a class=" btn btn-dark btn-sm right" href="newitem.php"> Add item </a>
        <div class="panel panel-primary">
            <div class="panel-heading ">
                Add New item <?php echo $imageName ; ?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                    <!-- ------------------------------------ -->
                    <form class="Edit form-horizontal col-sm-10" action=" <?php echo $_SERVER['PHP_SELF'] ; ?> " method="post" enctype="multipart/form-data"> 
                    <div class="form-group">
                     <div class="row">
                        <label class="col-sm-3 control-label ">Name</label>
                        <input class="form-control col-md-9 live-name " type="text" name="name"    placeholder="Name of the item"   />
                       
                    </div>
                    
                    </div>
                    <?php echo $formarray['emptyname'] ; ?>
                    <div class="form-group">
                      <div class="row">
                       <label class="col-sm-3 control-label ">Description</label>
                        <input class="form-control col-sm-9 live-desc " type="text" name="description" placeholder="Description of the item"  />
                      </div>
                    </div>
                    <?php echo $formarray['emptdesc'] ; ?>
                    <div class="form-group">
                      <div class="row">
                       <label class="col-sm-3 control-label ">Price</label>
                       <input class="form-control col-sm-9 live-price " type="text"  name="price"  placeholder="Price of the item"   />
                     </div>
                    </div>
                    <?php echo $formarray['emptyprice'] ; ?>
                    <div class="form-group">
                      <div class="row">
                       <label class="col-sm-3 control-label ">Image</label>
                       <input class="form-control col-sm-9 live-price " type="file"  name="image"     />
                     </div>
                     <?php echo $formarray['novalidimg'] ; ?>
                     <?php echo $formarray['emptyimg']  ; ?>
                    </div>
                    <div class="form-group">
                     <div class="row">
                        <label class="col-sm-3 control-label ">Country</label>
                        <input class=" col-sm-9 form-control  "  type="text" name="country"  placeholder="Country of made"  />
                     </div>
                    </div>
     
                  <div class="form-group  "> 
                    <div class="row st">
                    <label class="col-sm-3 control-label ">Status</label>
                    <div class="col-sm-9 form-control ">
                    <select class="form-control" name="status" >
                      <option value="">
                         ...
                      </option>
                      <option value="1">
                         new
                      </option>
                      <option value="2">
                      like new
                      </option>
                     <option value="3">
                      used
                      </option>
                     <option value="4">
                     old
                     </option>
                     </select>
                     </div>
                      </div>
                        </div>
                        <?php echo $formarray['emptystatus'] ; ?>
   

     <div class="form-group  "> 
         <div class="row st">
    <label class="col-sm-3 control-label ">Category</label>
    <div class="col-sm-9 form-control ">
    <select class="form-control" name="category" >
    <option value="">
          ...
       </option>
       <?php 
       $stm = $con->prepare("SELECT * FROM categories ");
       $stm->execute() ;
        $categories = $stm->fetchAll() ;
        foreach($categories as $category){
          ?> 
          <option value="<?php echo $category['ID'];?>">
          <?php
          echo $category['Name'];
          ?> 
          </option>
          <?php
        }
       ?>
    </select>
    </div>
    </div>
     </div>

     <?php echo $formarray['emptycat'] ; ?>
   
<input class="btn btn-success btn-sm right " type="submit" name="submit"  value="Add item"/>
 </form>
                    <!-- ------------------------------------ -->
                    </div>
                    <div class="col-md-4">
                    <div class="thumbnail item-box live-preview">
                  <span class="price-tag" >
                     0
                  </span>
                    <div class="img-responsive" >
                    <img  src="im.jpg" />
                    <hr>
                 </div>
               <div class="caption">
                  <h3> Test </h3>
                   <p> Titel </p>
               </div>  
            </div>  
                    </div>
                </div>    
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