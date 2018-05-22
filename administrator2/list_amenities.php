<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if(isset($_GET['action']) && $_GET['action']=='delete')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"delete from  webshop_amenities where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:list_amenities.php');
  exit();
}



if (isset($_REQUEST['submit'])) {


   $name = isset($_POST['name']) ? $_POST['name'] : '';
  

    $fields = array(
        'name' => mysqli_real_escape_string($con,$name),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if ($action == 'add' || $action == '') {


       
       
  
       
       
       echo $addQuery = "INSERT INTO `webshop_amenities` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
         
      

        $res = mysqli_query($con,$addQuery);
        echo $last_id = mysqli_insert_id($con);
        
        
      

        if ($last_id != "" || $last_id != 0) {
        
           header("location:list_amenities.php");
            $_SESSION['MSG'] = 3;
            exit();
        } else {
           // header("location:list_admin.php");
            $_SESSION['MSG'] = 4;
            exit();
        }
    } else if ($action == 'edit') {

        $last_id = $_REQUEST['id'];
    $editQuery = "UPDATE `webshop_amenities` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$last_id) . "'";


        $res = mysqli_query($con,$editQuery);
        if ($res) {

                   
          
            }



            header("location:list_amenities.php");
            $_SESSION['MSG'] = 1;
            exit();
        } else {
           header("location:list_amenities.php?id=" . $last_id . "&action=edit");
            $_SESSION['MSG'] = 2;
            exit();
        }
        
         
    }
    

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_product` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `webshop_amenities` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Amenities have been deleted successfully.';
        
        //die();
        
        header("Location:list_amenities.php");
    }





if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_amenities` WHERE `status`='1'"));

}

?>









<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_amenities.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_amenities.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_amenities.php?cid="+aa+"&action=active";
   } 

   </script>
 <!-- Header Start -->
<?php include ("includes/header.php"); ?>
<!-- Header End -->
 <!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
      <!-- BEGIN SIDEBAR -->

    <?php include("includes/left_sidebar.php"); ?>

      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">
                   <!-- BEGIN THEME CUSTOMIZER-->
                   <div id="theme-change" class="hidden-phone">
                       <i class="icon-cogs"></i>
                        <span class="settings">
                            <span class="text">Theme Color:</span>
                            <span class="colors">
                                <span class="color-default" data-style="default"></span>
                                <span class="color-green" data-style="green"></span>
                                <span class="color-gray" data-style="gray"></span>
                                <span class="color-purple" data-style="purple"></span>
                                <span class="color-red" data-style="red"></span>
                            </span>
                        </span>
                   </div>
                   <!-- END THEME CUSTOMIZER-->
                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                   <h3 class="page-title">Amenities list</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Amenities list</a>
                        
                       </li>
                        
                       
                     
                       

                       
                       
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORMPORTLET-->
                    <div class="widget green">
                        <div class="widget-title">
                             
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN Table-->
                              <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>
                          <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                     <thead>
                            <tr>
                                                            
                <th>Amenities Name</th>
                <th>Property Type</th>
                <!-- <th>Landlord Email</th> -->
                
                               
                <th>Quick Links</th>
                <!--<th>Edit</th>-->
                <th>Delete</th>
              </tr>
            </thead>
        <tbody>
                            <?php
                                                        $fetch_property_type=mysqli_query($con,"select * from webshop_amenities WHERE `status`='1'");
                                                        
                                                        $num=mysqli_num_rows($fetch_property_type);
                                                        if($num>0)
                                                        {
                                                        while($property_type=mysqli_fetch_array($fetch_property_type))
                                                        {
                                                          $property_id= $property_type['property_type'];
                                                          $property_type_name=mysqli_query($con,"select * from webshop_property_type WHERE `id`='".$property_id."' ");
                                                          $property_name=mysqli_fetch_array($property_type_name);
                                                          $prop_name=$property_name['name'];
                                                          //echo $prop_name;
                                                          //exit;
                                                          
                                                                                                                  ?>
              
              <tr>
                                                             <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $product['id'] ; ?>"/></td>-->
                
                
                
                <td>
                  <?php echo stripslashes($property_type['name']);?>
                </td>
                
                
                <td>
                  <?php echo stripslashes($prop_name);?>
                </td>
                
                
                <!--<td>
                  <?php //echo stripslashes($product['admin_password']); ?>
                </td>-->
                
                <!-- <td>
                  <?php echo stripslashes($landlord['email']); ?>
                </td> -->
                
                
                
                
                
                
                <td>
                  <a  href="add_amenities.php?id=<?php echo $property_type['id'] ?>&action=edit">
                  Edit </a>
                </td>
                
                
                
                <!--<td>
                  <a  href="add_new_admin.php?id=<?php echo $product['id'] ?>&action=edit">
                  Edit </a>
                </td>-->
                <td>
                  <a onClick="javascript:del('<?php echo $property_type['id']; ?>')">
                  Delete </a>
                </td>
              </tr>
                                                       <?php
                                                        }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                        <tr>
                    <td colspan="4">Sorry, no record found.</td>
                  </tr>
                                                        
                                                        <?php
                                                        }
                                                       ?>

                                     </tbody>
                                 </table>
                                  <?php if ($innerPrivileges->listproductcat_delete == '1') { ?>
                                <!--<input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/>-->
                            <?php } ?>
                             </form>

                            <!-- END Table-->
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                   
                </div>
            </div>

            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
   <!-- END CONTAINER -->

   <!-- Footer Start -->

   <?php include("includes/footer.php"); ?>

   <!-- Footer End -->

    <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="js/jquery-1.8.3.min.js"></script>
   <!--<script src="js/jquery.nicescroll.js" type="text/javascript"></script>-->
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="js/jquery.blockui.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
   <script src="js/jquery.scrollTo.min.js"></script>


   <!--common script for all pages-->
   <script src="js/common-scripts.js"></script>

   <!--script for this page only-->
   <script src="js/editable-table.js"></script>

   <!-- END JAVASCRIPTS -->
   <script>
       jQuery(document).ready(function() {
           EditableTable.init();
       });
   </script>
</body>
<!-- END BODY -->
</html>
