<?php 
include_once("./includes/config.php");
include_once('includes/session.php');
?>

<?php

if(isset($_REQUEST['submit']))
{
   $review = isset($_POST['review']) ? $_POST['review'] : '';
   $rating = isset($_POST['rating']) ? $_POST['rating'] : '';

   $fields = array(
   	 'review' => mysqli_real_escape_string($con,$review),
     'rating' => mysqli_real_escape_string($con,$rating),
    );

   $fieldsList =array();
   foreach($fields as $field => $value){
    $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

   } 
         
         if($_REQUEST['action']=='edit')
    {     
     $editQuery = "UPDATE `webshop_reviews` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";
        // exit;

    if (mysqli_query($con,$editQuery)) {
                    
                   // echo "aa";
                   // exit;
                    
                   // echo "aa".$_FILES['imagee']['tmp_name']; exit;
                    
                    if(!empty($_FILES['imagee']['tmp_name']))
    {
                         //echo "aa";
                  // exit;
    $target_path="../upload/auction_image/";
    $userfile_name = $_FILES['imagee']['name'];
    $userfile_tmp = $_FILES['imagee']['tmp_name'];
    $img_name =$userfile_name;
    $img=$target_path.$img_name;
    move_uploaded_file($userfile_tmp, $img);
    
   $image =mysqli_query($con,"UPDATE `webshop_user` SET `image`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
               // exit;
    }
    $_SESSION['msg'] = "Category Updated Successfully";
    }
    else {
      $_SESSION['msg'] = "Error occuried while updating Category";
    }

    header('Location:list_all_reviews.php');
    exit();
          }
          else
          {
  
     $insertQuery = "INSERT INTO `webshop_auction` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
    
       mysqli_query($con,$insertQuery);
                          $last_id=mysqli_insert_id($con);
                         
                         if($_FILES['imagee']['tmp_name']!='')
    {
    $target_path="../upload/auction_image/";
    $userfile_name = $_FILES['imagee']['name'];
    $userfile_tmp = $_FILES['imagee']['tmp_name'];
    $img_name =$userfile_name;
    $img=$target_path.$img_name;
    move_uploaded_file($userfile_tmp, $img);
    
    $image =mysqli_query($con,"UPDATE `webshop_user` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
    }

       header('Location:list_all_reviews.php');
       exit();
          }
}


if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_reviews` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}

?>

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
                   <h3 class="page-title">
                    Reviews <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?>  Reviews</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#"> Reviews</a>
                           <span class="divider">/</span>
                       </li>
                       
                       <li>
                          <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Reviews</span>
                          
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
                            <h4><i class="icon-reorder"></i>Edit Reviews</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">

                       

                              <div class="control-group">
                                    <label class="control-label">Review</label>
                                    <div class="controls">
                                      <textarea rows="4" cols="50" class="form-control" placeholder="Enter text" name ="review"><?php echo $categoryRowset['review'];?></textarea> 
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Rating</label>
                                    <div class="controls">
                             <select name="rating" required>
                             <option value=''> Select Rating</option>
                                <option value='1'  <?php if('1'== $categoryRowset['rating']){?> selected="selected"<?php }?>>1</option>
                                <option value='2'  <?php if('2'== $categoryRowset['rating']){?> selected="selected"<?php }?>>2</option>
                                <option value='3'  <?php if('3'== $categoryRowset['rating']){?> selected="selected"<?php }?>>3</option>
                                <option value='4'  <?php if('4'== $categoryRowset['rating']){?> selected="selected"<?php }?>>4</option>
                                <option value='5'  <?php if('5'== $categoryRowset['rating']){?> selected="selected"<?php }?>>5</option>
                             </select>
                                    </div>
                                </div>

                               <!--  <div class="control-group">
                                    <label class="control-label">Rating</label>
                                    <div class="controls">
                                    <input type="number" class="form-control" placeholder="Enter rating" value="<?php echo $categoryRowset['rating'];?>" name="rating" required>
                                    </div>
                                </div> -->

         <div class="form-actions">
                                    <button type="submit" class="btn blue" name="submit"><i class="icon-ok"></i> Save</button>
                                    <button type="reset" class="btn"><i class=" icon-remove"></i> Cancel</button>
                                </div>
                            </form>
                            <!-- END FORM-->
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
  <!--  <script src="js/jquery.nicescroll.js" type="text/javascript"></script> -->
   <script type="text/javascript" src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>
   <script type="text/javascript" src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
   <script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>

   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->

   <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
   <script src="js/jquery.sparkline.js" type="text/javascript"></script>
   <script src="assets/chart-master/Chart.js"></script>
   <script src="js/jquery.scrollTo.min.js"></script>


   <!--common script for all pages-->
   <script src="js/common-scripts.js"></script>

   <!--script for this page only-->

   <script src="js/easy-pie-chart.js"></script>
   <script src="js/sparkline-chart.js"></script>
   <script src="js/home-page-calender.js"></script>
   <script src="js/home-chartjs.js"></script>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
