<?php 
include_once("./includes/config.php");
include_once('includes/session.php');
?>

<?php

if(isset($_REQUEST['submit']))
{

  $name = isset($_POST['name']) ? $_POST['name'] : '';
  $price = isset($_POST['price']) ? $_POST['price'] : ''; 
  
  $duration = isset($_POST['duration']) ? $_POST['duration'] : '';
  

  $add_date = date('Y-m-d'); 

	 $fields = array(
    'price' => mysqli_real_escape_string($con,$price),
    'name' => mysqli_real_escape_string($con,$name),
    'duration' => mysqli_real_escape_string($con,$duration),
    'add_date' =>mysqli_real_escape_string($con,$add_date),
    'subscription_for' => 3       
           
	 	);

	 $fieldsList =array();
	 foreach($fields as $field => $value){
	 	$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";

	 } 
         
         if($_REQUEST['action']=='edit')
	  {		  
	$editQuery = "UPDATE `webshop_subscription` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";
         //exit;

		if (mysqli_query($con,$editQuery)) {
		$_SESSION['msg'] = "Subscription Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occured while updating Subscription";
		}

		header('Location:list_top_subscription.php');
		exit();
          }
          else
          {
  
     $insertQuery = "INSERT INTO `webshop_subscription` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
    
			 mysqli_query($con,$insertQuery);

       header('Location:list_top_subscription.php');
       exit();
          }
}


if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_subscription` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

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
                   Top Product Subscription <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Top Product Subscription</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Subscription</a>
                           <span class="divider">/</span>
                       </li>
                       
                       <li>
                          <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Top Product Subscription</span>
                          
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
                            <h4><i class="icon-reorder"></i>Add Top Product Subscription</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                        <form class="form-horizontal" method="post">
         

                                <div class="control-group">
                                    <label class="control-label"> Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter name" value="<?php echo $categoryRowset['name'];?>" name="name" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Price</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter price" value="<?php echo $categoryRowset['price'];?>" name="price" required>
                                    </div>
                                </div>

                                 


                                 <div class="control-group">
                                    <label class="control-label">Duration (Days)</label>
                                    <div class="controls">
                                    <input type="number" class="form-control" placeholder="Enter day. eg. 28" value="<?php echo $categoryRowset['duration'];?>" name="duration" required>
                                    </div>
                                </div>
                               
                            
                            
                            
                           
                            
                            
                            
                               
         <div class="form-actions">
                                    <button type="submit" class="btn blue" name="submit"><i class="icon-ok"></i> Save</button>
                                    <button type="reset" class="btn"><i class=" icon-remove"></i> Reset</button>
                                </div>
                            </form>
                            <a href="list_top_subscription.php"><button class="btn"> Back</button></a>
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
   <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
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
