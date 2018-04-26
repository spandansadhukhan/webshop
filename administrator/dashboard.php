<!-- Header Start -->
<?php

include_once('includes/session.php');
include_once("includes/config.php");
include_once("includes/functions.php");
$prevnameall=explode(',',$_SESSION['privilege_name']);
?>
<?php include ("includes/header.php"); ?>
<!-- Header End -->
<!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
     
<!-- Sidebar Start -->
    <?php include("includes/left_sidebar.php"); ?>
<!-- Sidebar End -->

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
                     Dashboard
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Webshop Watches</a>
                           <span class="divider">/</span>
                       </li>
                       <li class="active">
                           Dashboard
                       </li>
                       <li class="pull-right search-wrap">
                           <form action="search_result.html" class="hidden-phone">
                               <div class="input-append search-input-area">
                                   <input class="" id="appendedInputButton" type="text">
                                   <button class="btn" type="button"><i class="icon-search"></i> </button>
                               </div>
                           </form>
                       </li>
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                
                <!--BEGIN METRO STATES-->
                <div class="metro-nav">               
                    <?php if(in_array('3', $prevnameall)){ ?>
                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_user WHERE type ='1' AND top_user_vendor='0' and status='1'");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_user.php">
                            <i class="icon-user"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Normal User</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>
            

                     <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_user WHERE type ='1' AND top_user_vendor='1' and status='1'");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_topuser.php">
                            <i class="icon-user"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Certified User</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>
                     <?php
                 }
              ?>
                      <?php if(in_array('4', $prevnameall)){ ?>
                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_user WHERE type ='2' AND top_user_vendor='0' and status='1'");
                        $usercnt=mysqli_fetch_assoc($usernum);
                         $usernum2=mysqli_query($con,"SELECT count(*) as total from webshop_notification WHERE to_id ='0' and type='Normal Vendor Approval Request' and is_read ='0'");

                        $usercnt2=mysqli_fetch_assoc($usernum2);
    
                        ?>
                        <a data-original-title="" href="list_vendor.php">
                            <i class="icon-user"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Normal Vendor</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt2['total']; ?></span>
                    </div>

                     <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_user WHERE type ='2' AND top_user_vendor='1' and status='1'");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        $usernum2=mysqli_query($con,"SELECT count(*) as total from webshop_notification WHERE to_id ='0' and type='Certified Vendor Approval Request' and is_read ='0'");

                        $usercnt2=mysqli_fetch_assoc($usernum2);
                        ?>
                        <a data-original-title="" href="list_topvendor.php">
                            <i class="icon-user"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Certified Vendor</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt2['total']; ?></span>
                    </div>
<?php
                 }
              ?>
                    <?php if(in_array('20', $prevnameall)){ ?>
                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_products where auctioned = 0");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_products.php">
                          <i class="icon-archive"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">List Products</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>
                    <?php
                 }
              ?>
                     <?php if(in_array('15', $prevnameall)){ ?>
                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_products where auctioned = 1");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_auction.php">
                        <i class="icon-usd"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Auctioned Products</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>
  <?php
                 }
              ?>

              <?php if(in_array('9', $prevnameall)){ ?>
                      <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_reviews");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_all_reviews.php">
                            <i class="icon-star"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Reviews</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>
                    <?php
                 }
              ?>
  <?php if(in_array('10', $prevnameall)){ ?>
                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_membership");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_membership.php">
                            <i class="icon-credit-card"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Membership</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>
    <?php
                 }
              ?>
                  <!--   <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_pets");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_pets.php">
                            <i class="icon-adn"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">All Pets</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>
                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_pets WHERE pets_status='1'");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="pets_adopted.php">
                            <i class="icon-adn"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Adopted Pets</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>
                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_pets WHERE pets_status='2'");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="pets_lost.php">
                            <i class="icon-adn"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Lost Pets</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>
                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_pets WHERE pets_status='3'");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="pets_found.php">
                            <i class="icon-adn"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Pets Found</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>

                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_companies");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_business.php">
                            <i class="icon-briefcase"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Business Management</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>

                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_blogs");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_blogs.php">
                            <i class="icon-comments"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Manage Blogs</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>

                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_reportsimages");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="report_image.php">
                            <i class="icon-ban-circle"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Report Image</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>

                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_reports");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="report_user.php">
                            <i class="icon-ban-circle"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Report User</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>

                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_reviews");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_all_reviews.php">
                            <i class="icon-star"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Reviews</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>

                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_bookings");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_all_bookings.php">
                            <i class="icon-truck"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">List Trips</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>

                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_bookings WHERE ride_status='0'");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_pending_bookings.php">
                            <i class="icon-truck"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Pending Trips</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>

                    <div class="metro-nav-block nav-block-orange">
                        <?php
                       $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_bookings WHERE ride_status='2'");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_completed_bookings.php">
                            <i class="icon-truck"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Completed Trips</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div>

                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_bookings WHERE ride_status='1'");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="list_started_bookings.php">
                            <i class="icon-truck"></i>
                            <div class="info"><?php echo $usercnt['total']; ?></div>
                            <div class="status">Started Trips</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div> 

                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_transactions");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="financial_accounts.php">
                            <i class="icon-volume-up"></i>
                             <div class="info"><?php echo $usercnt['total']; ?></div> 
                            <div class="status">Manage Advertisement</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div> 

                    <div class="metro-nav-block nav-block-orange">
                        <?php
                        $usernum=mysqli_query($con,"SELECT count(*) as total from webshop_transactions");
                        $usercnt=mysqli_fetch_assoc($usernum);
                        ?>
                        <a data-original-title="" href="financial_accounts.php">
                            <i class="icon-money"></i>
                             <div class="info"><?php echo $usercnt['total']; ?></div> 
                            <div class="status">List Payments</div>
                        </a>
                        <span class="box-counter"><?php echo $usercnt['total']; ?></span>
                    </div> 
 -->
                     <!-- <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="#">
                           <i class="icon-money"></i>
                       
                            <div class="status">Pending Payments</div>
                        </a>
                        <span class="box-counter">0</span>
                    </div>  -->

                     <!-- <div class="metro-nav-block nav-block-orange">
                        <a data-original-title="" href="#">
                           <i class="icon-exclamation-sign"></i>
                            <div class="status">Complaints</div>
                        </a>
                        <span class="box-counter">0</span>
                    </div> -->  

                </div> 
                <div class="space10"></div>
                <!--END METRO STATES-->
                
                
                
                
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
   <style type="">
   .metro-nav .metro-nav-block{overflow: inherit !important;}
       .box-counter{
        position: absolute;
        right: -10px;
        top: -10px;
        background: #fff;
        color: #f37b53;
        border: #f37b53 2px solid;
        font-weight: 700;
        border-radius: 100% !important;
        width: 32px;
        height: 32px;
        font-size: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
       }
   </style> 
</body>
<!-- END BODY -->
</html>