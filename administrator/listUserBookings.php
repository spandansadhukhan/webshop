<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if(isset($_GET['action']) && $_GET['action']=='delete')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"delete from  hotels_user where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:list_general_user.php');
  exit();
}


if($_REQUEST['action']=='details') {



    $booking_details = mysqli_query($con,"SELECT * FROM `webshop_bookings` WHERE `user_id`='".$_REQUEST['id']."'");

   if(mysqli_num_rows($booking_details) >0){

    while($result=mysqli_fetch_assoc($booking_details)){

      $booking_date = $result['date'];
        $booking_price = $result['price'];
        $booking_total_price = $result['total_price'];
        $tool_id = $result['room_id'];

         $tool_type_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `hotels_rooms` WHERE `id`='".$tool_id."'"));

         $tool_name = $tool_type_details['name'];
         $tool_price = $tool_type_details['price'];
         $tool_start_date = $tool_type_details['start_date'];
         $tool_end_date = $tool_type_details['end_date'];
          
        //echo $booking_date." ".$booking_price." ".$booking_total_price." ".$tool_id." ".$tool_name." ".$tool_price." ".$tool_start_date." ".$tool_end_date;
        //echo "<br>";

     }


   }

//exit;
     
    }
    

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_product` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `hotels_general_user` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'General User have been deleted successfully.';
        
        //die();
        
        header("Location:list_general_user.php");
    }





if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `hotels_user` WHERE `type`='1'"));

}

?>
<?php
if(isset($_POST['ExportCsv']))
{
   
   
   $sql="select * from hotels_user WHERE `type`='1' order by id desc";
   
    
    

   $query=mysqli_query($con,$sql);

  $output='';

    $output .='UserId,First Name,Last Name,City,Address,Email,Contact Number,Status';

    $output .="\n";

    if(mysqli_num_rows($query)>0)
    {
        while($result = mysqli_fetch_assoc($query))
        {
            
            if($result['status']==1)
            {
                $status='Active';
            }
            else
            {
                 $status='Deactive';
            }
      
       
             $user_id=$result['id'];
             $first_name=$result['fname'];
               $last_name=$result['lname'];
               $city=$result['city'];
               $address=$result['address'];
                  $email=$result['email'];
                     $contact_number=$result['phone'];
               
          
           if($user_id!=""){
            $output .='"'.$user_id.'","'.$first_name.'","'. $last_name.'","'.$city.'","'.$address.'","'.$email.'","'.$contact_number.'","'.$status.'"';
            $output .="\n";
            }
        }
    }



    $filename = "GeneralUserList".time().".csv";

    header('Content-type: application/csv');

    header('Content-Disposition: attachment; filename='.$filename);



    echo $output;

    //echo'<pre>';

    //print_r($result);

    exit;
  
  
}
?>









<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_general_user.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_general_user.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_general_user.php?cid="+aa+"&action=active";
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
                   <h3 class="page-title">Bookings list</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Booking list</a>
                        
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
                             <form action="" method="post">
                <!--<i class="fa fa-edit"></i>Editable Table-->
                                 
                     <tr><button type="reset" class="btn blue" onClick="window.location.href='list_user.php'" >Back</button></tr>
                                
                                                            </form>
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
                <th>Image</th>
                <th>SubCategory </th>
                <th>Category </th>
            <!--     <th>Price Paid</th> -->
                <th>Booking Date</th>
                <th>View Supplier </th>
              </tr>
            </thead>
        <tbody>
             <?php
    
             // $booking_details = mysqli_query($con,"SELECT * FROM `hotels_bookings` WHERE `tool_id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."' and status = 1");
              $booking_details = mysqli_query($con,"SELECT * FROM `webshop_bookings` WHERE `user_id`='".$_REQUEST['id']."'");

                                                         
         if(mysqli_num_rows($booking_details) >0)
             {
              while($result=mysqli_fetch_assoc($booking_details))
                                                          
              {

          // $general_user_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`='".$result['user_id']."'"));

         $subcat_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_subcategory` WHERE `id`='".$result['subcat_id']."'"));

          $cat_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_category` WHERE `id`='".$subcat_details['category_type']."'"));

          // $owner_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`='".$result['supplier_id']."'"));

                                                           
    if($subcat_details['image']!='')
    {
    $image_link='../upload/subcategory_image/'.$subcat_details['image'];
    }
    else {
    $image_link='../upload/no.png';
    }

                                                        ?>
              
              <tr>

                 <td>
                 <img src="<?php echo $image_link;?>" height="100" width="100" align="image">
                </td>

                 <td>
                  <?php echo stripslashes($subcat_details['name']);?>
                </td>

                 <td>
                  <?php echo stripslashes($cat_details['name']);?>
                </td>

            <!--      <td>
                  <?php echo stripslashes("$".$result['paid_price']);?>
                </td> -->

                   <td>
                  <?php echo stripslashes($result['date']);?>
                </td>

                  <td>
                  <a  href="owner_bookings.php?id=<?php echo $result['supplier_id'] ?>&action=details">
                  View  Supplier</a>
                </td>


              </tr>
                                                       <?php
                                                        }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                        <tr>
                    <td colspan="8">Sorry, no record found.</td>
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
   <?php  
   if(mysqli_num_rows($booking_details) >0) {

  ?>
   <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
   <?php } ?>
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
