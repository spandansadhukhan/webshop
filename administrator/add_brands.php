<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
//echo $_SESSION['myy'];

CRYPT_BLOWFISH or die ('No Blowfish found.');




if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

 $sql="select * from webshop_brands  where id<>''";
 

$record=mysqli_query($con,$sql);


}

if(isset($_REQUEST['submit']))
{
    
 
  $name = isset($_POST['name']) ? $_POST['name'] : '';
 
	

	$fields = array(
    'name' => mysqli_real_escape_string($con,$name)
		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
					 
	 if($_REQUEST['action']=='edit')
	  {		  
	  $editQuery = "UPDATE `webshop_brands` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";

    

      mysqli_query($con,$editQuery_user);

		if (mysqli_query($con,$editQuery)) {
		
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/brand_image/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `webshop_brands` SET `image`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
		}
		
		
			$_SESSION['msg'] = "Tool Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occurred while updating Tool";
		}

		header('Location:list_brands.php');
		exit();
	
	 }





	 else
	 {
	 
 $addQuery = "INSERT INTO `webshop_brands` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";

  mysqli_query($con,$addQuery);
   $last_id=mysqli_insert_id($con);

	
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/brand_image/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `webshop_brands` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
		}
		 
		header('Location:list_brands.php');
		exit();
	
	 }
				
				
}

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_brands` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));
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
                   Brand <small><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Brand</small>
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Brand</a>
                           <span class="divider">/</span>
                       </li>
                       
                       <li>
                          <span><?php echo $_REQUEST['action']=='edit'?"Edit":"Add";?> Brand</span>
                          
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
                            <h4><i class="icon-reorder"></i>Add Brand</h4>
                              <!-- <a style="float:right;" class="btn blue" href="sampledownload.csv">Download Sample</a> -->
                            <!--   <a style="float:right;" class="btn blue" href="upload_csv.php">Upload Csv</a> -->
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                            <form class="form-horizontal" method="post" action="add_brands.php" enctype="multipart/form-data">

                          <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>" />
                          <input type="hidden" name="action" value="<?php echo $_REQUEST['action'];?>" />  
                           
                           <div class="control-group">
                                    <label class="control-label">Brand Name</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter text" value="<?php echo $categoryRowset['name'];?>" name="name" required>
                                    </div>
                                </div>

                                 <div class="control-group">
                                    <label class="control-label">Image Upload</label>
                                    <div class="controls">
                                        <input type="file" name="image" class=" btn blue"  ><?php if($categoryRowset['image']!=''){?><br><a href="../upload/brand_image/<?php echo $categoryRowset['image'];?>" target="_blank">View</a><?php }?>
                                        
                                    </div>
                                </div>
                              
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
    <script src="assets/ckeditor/ckeditor.js" type="text/javascript"></script>

   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
