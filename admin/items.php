<?php 
ob_start();
session_start();

$pagetitel = 'Items';
if(isset($_SESSION['username'])){
    include 'init.php' ;
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
      // If the page is a Main Page

      if($do == 'Manage' ){//========= start Mange 

      
        $stmt = $con->prepare("SELECT
                                     items.* ,
            categories.Name AS 
                             category_name , 
             users.Fullname AS 
                             member_name 
                            FROM
                                      items 
      INNER JOIN categories ON
                              categories.ID = items.Cat_ID
      INNER JOIN users ON 
                              users.UserID = items.Member_ID ")    ;
        $stmt->execute()  ;
        $row = $stmt->fetchAll()   ;           
        ?>
          <h1 class="text-center"> Mange Items </h1>
          <div class="container">
          <a href="?do=Add" class="btn btn-primary  btn-sm  newitem"> <i  class="fas fa-plus">
      </i> New Item </a>
          <div class="table-responsive">
           
          <table class=" main-table text-center table table-bordered" >
          <tr>
             <td>#ID</td>
             <td>Name</td>
             <td>Description</td>
             <td>Price</td>
             <td>Date</td>
             <td>Category</td>
             <td>Member</td>
             <td>Control</td>
          </tr>
           <?php 
            foreach($row as $r){
              
              ?>
          <tr>
             <td><?php echo $r['item_ID'] ;?></td>
             <td><?php echo $r['Name'] ;?></td>
             <td><?php echo $r['Description'] ;?></td>
             <div class="ev">
             <td class="price"><?php echo $r['Price'] ;?></td>
            </div>
            <td><?php echo $r['Add_date'] ;?></td>

            <td ><a href="?do=categories&category=<?php echo $r['category_name'] ?>&catid=<?php echo $r['Cat_ID']?>" class="td-a"><?php echo $r['category_name'] ;?></a></td>
            
            <td ><a href="?do=members&member=<?php echo $r['member_name'] ;?>  &memberid=<?php echo $r['Member_ID'] ;?>"
             class="td-a">
             <?php echo $r['member_name'] ;?>
            </a></td>
             
             <td><?php 
                    if($r['Status']==0){?>
                <a
   href="items.php?do=Approve&itemid=<?php echo $r['item_ID'] ;?>"
    class="btn btn-warning ">  <i class="fas fa-check"></i> 
                </a>

                   <?php }?>
             <a href="items.php?do=Edit&itemid=<?php echo $r['item_ID'] ;?>" class="btn btn-success"> <i class="fas fa-edit"></i></a>
                 <a href="items.php?do=Delete&itemid=<?php echo $r['item_ID'] ;?>" class="btn btn-danger confirm">  <i class="fas fa-trash"></i></a>
                </td>
          </tr>
          <?php }
           ?>
          
          </table>
          <?php
       
      }//=================================== End Mange
      elseif($do=='members'){ //============= start members
        $userid = isset($_GET['memberid']) && is_numeric($_GET['memberid'])? intval($_GET['memberid']) 
        :   ' this is not a number' ;
        $member = isset($_GET['member']) ? $_GET['member'] 
        :   ' this member does not exist' ;
        

        $stm = $con->prepare("SELECT
        items.* ,
categories.Name AS 
category_name , 
users.Fullname AS 
member_name 
FROM
         items 
INNER JOIN categories ON
 categories.ID = items.Cat_ID
INNER JOIN users ON 
 users.UserID = items.Member_ID
         WHERE Member_ID = $userid") ;
      $stm->execute();
      $sts = $stm->fetchAll();
       ?>
        <h1 class="text-center"> Mange Items </h1>
        <div class="container">
          
          <?php 
          echo'<span>  All items poste by :  <strong> '. $member.'</strong></span>' ;
          ?>
        <a href="?do=Add" class=" btn btn-primary  btn-sm  newitem"> <i  class="fas fa-plus">
    </i> New Item </a>
      
        <div class="table-responsive">
         
        <table class=" main-table text-center table table-bordered" >
        <tr>
           <td>#ID</td>
           <td>Name</td>
           <td>Description</td>
           <td>Price</td>
           <td>Date</td>
           <td>Category</td>
           <td>Member</td>
           <td>Control</td>
        </tr>
         <?php 
         
          foreach($sts as $st){?>

         
        <tr>
           <td><?php echo $st['item_ID'] ;?></td>
           <td><?php echo $st['Name'] ;?></td>
           <td><?php echo $st['Description'] ;?></td>
           <div class="ev">
           <td class="price"> <?php echo $st['Price'] ;?></td>
          </div>
          <td><?php echo $st['Add_date'] ;?></td>

          <td ><a href="?do=categories&category=<?php echo $st['category_name'] ?>&catid=<?php echo $st['Cat_ID'] ?>" class="td-a"><?php echo $st['category_name'] ;?></a></td>
          
          <td ><a href="?do=members&member=<?php echo $st['member_name'] ;?>  &memberid=<?php echo $st['Member_ID'] ;?>" class="td-a"><?php echo $st['member_name'] ;?>
          </a></td>
           
           <td> 
           <?php 
                    if($st['Status']==0){?>
                <a
   href="items.php?do=Approve&itemid=<?php echo $st['item_ID'] ;?>"
    class="btn btn-warning ">  <i class="fas fa-check"></i>
                </a>

                   <?php }?>
           <a href="items.php?do=Edit&itemid=<?php echo $st['item_ID'] ;?>" class="btn btn-success"> <i class="fas fa-edit"></i></a>
               <a href="items.php?do=Delete&itemid=<?php echo $st['item_ID'] ;?>" class="btn btn-danger confirm">  <i class="fas fa-trash"></i> </a>
              </td>
        </tr>
        <?php }
         
        ?>
        </table>
<?php 
      } //========================================================= end members

      elseif($do =='categories'){ //============= start members
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']) 
        :   ' this is not a number' ;
        $catego = isset($_GET['category']) ? $_GET['category'] 
        :   ' this category does not exist' ;
        

        $stm = $con->prepare("SELECT
        items.* ,
categories.Name AS 
category_name , 
users.Fullname AS 
member_name 
FROM
         items 
INNER JOIN categories ON
 categories.ID = items.Cat_ID
INNER JOIN users ON 
 users.UserID = items.Member_ID
         WHERE Cat_ID = $catid") ;
      $stm->execute();
      $sts = $stm->fetchAll();
       ?>
        <h1 class="text-center"> Mange Items </h1>
        <div class="container">
          
          <?php 
          echo'<span>  the category of :  <strong> '. $catego.'</strong></span>' ;
          ?>
        <a href="?do=Add" class=" btn btn-primary  btn-sm  newitem"> <i  class="fas fa-plus">
    </i> New Item </a>
      
        <div class="table-responsive">
         
        <table class=" main-table text-center table table-bordered" >
        <tr>
           <td>#ID</td>
           <td>Name</td>
           <td>Description</td>
           <td>Price</td>
           <td>Date</td>
           <td>Category</td>
           <td>Member</td>
           <td>Control</td>
        </tr>
         <?php 
         
          foreach($sts as $st){?>

         
        <tr>
           <td><?php echo $st['item_ID'] ;?></td>
           <td><?php echo $st['Name'] ;?></td>
           <td><?php echo $st['Description'] ;?></td>
           <div class="ev">
           <td class="price"> <?php echo $st['Price'] ;?></td>
          </div>
          <td><?php echo $st['Add_date'] ;?></td>

          <td ><a href="?do=categories&category=<?php echo $st['category_name']; ?>&catid=<?php echo $st['Cat_ID']  ;?>" class="td-a"><?php echo $st['category_name'] ;?></a></td>
          
          <td ><a href="?do=members&member=<?php echo $st['member_name'] ;?>  &memberid=<?php echo $st['Member_ID'] ;?>" class="td-a"><?php echo $st['member_name'] ;?>
          </a></td>
           
           <td>
           <?php 
                    if($st['Status']==0){?>
                <a
   href="items.php?do=Approve&itemid=<?php echo $st['item_ID'] ;?>"
    class="btn btn-warning ">  <i class="fas fa-check"></i> 
                </a>

                   <?php }?>
           <a href="items.php?do=Edit&itemid=<?php echo $st['item_ID'] ;?>" class="btn btn-success"> <i class="fas fa-edit"></i></a>
               <a href="items.php?do=Delete&itemid=<?php echo $st['item_ID'] ;?>" class="btn btn-danger confirm">  <i class="fas fa-trash"></i></a>
              </td>
        </tr>
        <?php }
         
        ?>
        </table>
<?php 
      } 
      elseif($do == 'Add'){// start  Add?>
        <h1 class="text-center"> Add Item </h1>

        
      <div class="container">
 <form class="Edit form-horizontal col-sm-10" action="  ?do=Insert " method="post"> 
      <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label ">Name</label>
<input class="form-control col-sm-10 " type="text" name="name"    placeholder="Name of the item"  />
    </div>
 </div>
     
    <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label ">Descri</label>
<input class="form-control col-sm-10 " type="text" name="description" placeholder="Description of the item"  />
    </div>
    </div>
    
    <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label ">Price</label>
<input class="form-control col-sm-10" type="text"  name="price"  placeholder="Price of the item"  />
    </div>
    </div>
     
    <div class="form-group">
        <div class="row">
        <label class="col-sm-2 control-label ">Country</label>
<input class=" col-sm-10 form-control  "  type="text" name="country"  placeholder="Country of made"  />
    </div>
    </div>
     
     <div class="form-group  "> 
         <div class="row st">
    <label class="col-sm-2 control-label ">Status</label>
    <div class="col-sm-10 form-control ">
    <select class="form-control" name="status">
    <option value="0">
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

     <div class="form-group  "> 
         <div class="row st">
    <label class="col-sm-2 control-label ">User</label>
    <div class="col-sm-10 form-control ">
    <select class="form-control" name="user">
    <option value="0">
          ...
       </option>
       <?php 
       $stm = $con->prepare("SELECT * FROM users WHERE GroupID = 0 ");
       $stm->execute() ;
        $users = $stm->fetchAll() ;
        foreach($users as $user){
          ?> 
          <option value=" <?php echo $user['UserID'];?> ">
          <?php
          echo $user['Fullname'];
          ?> 
          </option>
          <?php
        }
       ?>
    </select>
    </div>
    </div>
     </div>

     <div class="form-group  "> 
         <div class="row st">
    <label class="col-sm-2 control-label ">Category</label>
    <div class="col-sm-10 form-control ">
    <select class="form-control" name="category">
    <option value="0">
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

     
   
<input class="btn btn-success btn-sm " type="submit" name="submit"  value="Add item"/>
 </form>
</div>
        
      <?php }// ====================End Add
      elseif($do == 'Insert'){// start Insert
     
        
        if(isset($_POST['submit'])){
        echo '  <h1 class="text-center"> Insert Item </h1>' ;
         $name = $_POST['name'] ;
         $description = $_POST['description'] ;
         $price = $_POST['price'] ;
         $country = $_POST['country'] ;
         $status = $_POST['status'] ;
         $member_id = $_POST['user'] ;
         $cat_id = $_POST['category'];
         $formarray = array();
         if(empty($name)){
          $formarray[] = 'Name can not be Emty' ;
         }
         if(empty($price)){
          $formarray[] = 'Price can not be Emty' ;
         }
         
         echo '<div class="container">'  ;
         foreach($formarray as $error){
          echo '<div class="alert alert-danger">' .$error.'</div>'  ;
                                      }  
         if(empty($formarray)){// if all inputs are filled
         
          $stmt= $con->prepare(" INSERT INTO 
                                        items(
                                          Name ,
                                          Description ,
                                          Price ,
                                          Status ,
                                          Cat_ID ,
                                          Member_ID ,
                                          Add_date ,
                                          Country_made )
                                  VALUES ( 
                                         :zname , 
                                         :zdesc , 
                                         :zprice , 
                                         :zstatus ,
                                         :zcatid,
                                         :zmemberid ,
                                         now() ,
                                         :zcouuntry )");
$stmt->execute(array( 
'zname'   =>  $name ,
'zdesc'   =>  $description ,
'zprice'  =>  $price ,
'zstatus'   =>  $status ,
'zcatid' => $cat_id,
'zmemberid' => $member_id ,
'zcouuntry' => $country  
     ))   ;             
     $theM = '<div class="alert alert-success" > '. $stmt->rowCount() .' record  has been inserted </div>'   ;
       redirectTo($theM , 'back') ;
                             }else{//if there is errors
                                   $theM='';
                                   redirectTo($theM , 'back' , 5 );
                                   echo '</div>';
                                  }
       
      }else{// if there is no submit 
        header('Location: index.php');
      }
    }// ========================End Insert
      elseif($do == 'Edit'){ //=========================start Edit
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? $_GET['itemid'] : 'this id does not exist' ;
       $stm = $con->prepare("SELECT * FROM items WHERE item_ID= ?");
       $stm->execute(array($itemid));
       $items = $stm->fetch();
      ?>
        <h1 class="text-center"> Edite Item </h1>
      <div class="container">
 <form class="Edit form-horizontal col-sm-10" action="  ?do=Update " method="post"> 
      <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label ">Name</label>
            <input  type="hidden" name="itemhidden"  value="<?php echo $items['item_ID'] ; ?>"   />

<input class="form-control col-sm-10 " type="text" name="name"  value="<?php echo $items['Name'] ; ?>" placeholder="Name of the item"  />
    </div>
 </div>
     
    <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label ">Descri</label>
<input class="form-control col-sm-10 " type="text" name="description" value="<?php echo $items['Description'] ; ?>" placeholder="Description of the item"  />
    </div>
    </div>
    
    <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label ">Price</label>
<input class="form-control col-sm-10" type="text" value="<?php echo $items['Price'] ; ?>" name="price"  placeholder="Price of the item"  />
    </div>
    </div>
     
    <div class="form-group">
        <div class="row">
        <label class="col-sm-2 control-label ">Country</label>
<input class=" col-sm-10 form-control  " value="<?php echo $items['Country_made'] ; ?>" type="text" name="country"  placeholder="Country of made"  />
    </div>
    </div>
     
     <div class="form-group  "> 
         <div class="row st">
    <label class="col-sm-2 control-label ">Status</label>
    <div class="col-sm-10 form-control ">
    <select class="form-control" name="status">
    
       <option value="1" <?php if($items['Status']==1){ echo 'selected' ;}?>>
          new
       </option>
       <option value="2" <?php if($items['Status']==2){ echo 'selected' ;}?>>
         like new
       </option>
       <option value="3" <?php if($items['Status']==3){ echo 'selected' ;}?>>
          used
       </option>
       <option value="4" <?php if($items['Status']==4){ echo 'selected' ;}?>>
          old
       </option>
    </select>
    </div>
    </div>
     </div>

     <div class="form-group  "> 
         <div class="row st">
    <label class="col-sm-2 control-label ">User</label>
    <div class="col-sm-10 form-control ">
    <select class="form-control" name="user">
    
       <?php 
       $stm = $con->prepare("SELECT * FROM users WHERE GroupID = 0 ");
       $stm->execute() ;
        $users = $stm->fetchAll() ;
        foreach($users as $user){
          ?> 
          <option value=" <?php echo $user['UserID'];?> " <?php if($items['Member_ID']== $user['UserID']){ echo 'selected' ;}?>>
          <?php
          echo $user['Fullname'];
          ?> 
          </option>
          <?php
        }
       ?>
    </select>
    </div>
    </div>
     </div>

     <div class="form-group  "> 
         <div class="row st">
    <label class="col-sm-2 control-label ">Category</label>
    <div class="col-sm-10 form-control ">
    <select class="form-control" name="category">
    
       <?php 
       $stm = $con->prepare("SELECT * FROM categories ");
       $stm->execute() ;
        $categories = $stm->fetchAll() ;
        foreach($categories as $category){
          ?> 
          <option value="<?php echo $category['ID'];?>"  <?php if($items['Cat_ID'] == $category['ID']){ echo 'selected' ;}?>>
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

     
   
<input class="btn btn-success btn-sm " type="submit" name="submit"  value="Edit item"/>
 </form>
</div>
      <?php
      } //===================================================End Edit
      elseif($do == 'Update'){ //=========================start Update
        ?>
           <h1 class="text-center"> Update Item </h1>
           <div class="container">
        <?php
           if(isset($_POST['submit'])){
        $itemhidden = $_POST['itemhidden'] ;
        $name = $_POST['name'] ;
        $description = $_POST['description'] ;
        $price = $_POST['price'] ;
        $country = $_POST['country'] ;
        $status = $_POST['status'] ;
        $user = $_POST['user'] ;
        $category = $_POST['category'] ;
        $update = $con->prepare(" UPDATE items  SET 
                                        Name  = ?, 
                                        Description  = ? ,
                                        Price   = ?,
                                        Country_made  = ? ,
                                        Status   = ?,
                                        Cat_ID  = ?,
                                        Member_ID = ? ,
                                        Add_date  = now() 
                                  WHERE item_ID = ?       
                                        ");
        $update->execute(array(   $name ,
                                  $description ,
                                  $price ,
                                  $country ,
                                  $status ,
                                  $category ,
                                  $user ,

                                  $itemhidden
                                           )) ;  

         $theM = '<div class="alert alert-success"> '.$update->rowCount().' hasebeen updated </div>';
           redirectTo($theM ) ;

        ?>
        </div>
        <?php
      }else{// in case there is no submit
        echo 'no update available' ;
      }
      }//===================================================End Update
      elseif($do == 'Delete'){ //=======================start Delete ?>
        <h1 class="text-center"> Delete Item </h1>
        <h3 class="text-center"> Delete Member </h3>
        <div class="container">
      
<?php 
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) 
        ? intval($_GET['itemid']) 
           :   ' this is not a number' ;
          $cheks = checkItem('item_ID' , 'items' , $itemid  ) ;
           
           
        if($cheks>0){
            $stmt = $con->prepare("DELETE FROM items WHERE item_ID = ?");
             //$stmt->bindParam("?", $userid);
            $stmt->execute(array($itemid));
            $theM = '<div class="alert alert-success">'. $stmt->rowCount(). ' record has been Deleted </div> '  ;
            redirectTo($theM );
        }else{
        $theM = '<div class="alert alert-danger"> there is no such id </div> '  ;
            redirectTo($theM, 'back' );
        }
         ?> 
         </div>
         <?php
     // end elseif for Delete
     
      }//==============End Delete
      elseif($do == 'Approve'){ //==============start Approve ?>
        <h1 class="text-center"> Approve Item </h1>
      
        <div class="container">
        
        <?php 
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) 
                ? intval($_GET['itemid']) 
                   :   ' this is not a number' ;
                  $cheks = checkItem('item_ID' , 'items' , $itemid  ) ;
                if($cheks>0){
                    $stmt = $con->prepare("UPDATE items SET Status = 1 WHERE item_ID = ?");
                     //$stmt->bindParam("?", $userid);
                    $stmt->execute(array($itemid));
                    $theM = '<div class="alert alert-success">  This item is approved ,it can now be visible</div> '  ;
                    redirectTo($theM);
                }else{
                $theM = '<div class="alert alert-danger"> there is no such id </div> '  ;
                    redirectTo($theM, 'back' );
                }
                 ?> 
                 </div>
                 <?php
        }//==============End Approve


       include $tpl.'footer.php';
    }else{
        //echo ' You can not brows this page directtly' ;
        header('Location: index.php');
    }
ob_end_flush();
?>