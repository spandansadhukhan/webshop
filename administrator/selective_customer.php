<?php
error_reporting(ALL);
ob_start();
session_start();
include_once("./includes/config.php");
require_once("includes/class.phpmailer.php");
require 'vendor/autoload.php';



if (isset($_REQUEST['submit'])) {
    $subject = $_POST['subject'];
    $message= $_POST['elm1'];

    if (!empty($_REQUEST['email'])) {
        $email = implode(',', $_REQUEST['email']);
    } 
    $new_email = explode(',', $email);
 //print_r($new_email);
    foreach ($new_email as $email_id) {
        
        //$getusersql = "";
        // $email_id;
        
        $TemplateMessage = '';

        $SQL = "SELECT * FROM `webshop_user` where email='" . $email_id . "'";
        $result = mysqli_query($con,$SQL);
        $row=mysqli_fetch_assoc($result);
       // $row1 = mysqli_fetch_assoc($con,$result);
       
        $messagetoid = $row['id'];
       
        $from_id = '0';
    $add_date = date('Y-m-d');
    $is_read = '0';
    $last_id = '0';
    $product_id ='0';
    $date = date('Y-m-d h:i:s');
    $messagenoti = 'You have a new message from admin';
     $insert_message = mysqli_query($con, "INSERT into webshop_message(from_id,to_id,message,add_date) VALUES ('0','".$messagetoid."','".strip_tags($message)."','".$add_date."')");
     
     $insert_messagenoti = mysqli_query($con, "INSERT into webshop_notification(from_id,to_id,msg,date) VALUES ('0','".$messagetoid."','".strip_tags($messagenoti)."','".$date."')");
    //mysqli_query($insert_message);
    
          $MailTo = $email_id;  
 
     
       $TemplateMessage.="<br/><br />Hi User,";
        $TemplateMessage.="<br>";
        
        $TemplateMessage.="Subject :" . $subject;
        $TemplateMessage.="<br>";
        $TemplateMessage.=$message;
        $TemplateMessage.="<br><br/>Thanks & Regards<br/>";
        $TemplateMessage.="Webshop Watches Team";
        //$TemplateMessage.="Teemedup Team";
        $TemplateMessage.="<br><br><br>This is a post-only mailing.  Replies to this message are not monitored or answered.";

      //echo $TemplateMessage;
   // exit;

    $mail = new PHPMailer(true);  
      
      $IsMailType='SMTP';  
  
  // $MailFrom='info@natit.us';    //  Your email password
  $MailFrom='palashsaharana@gmail.com';
    $MailFromName='Webshop Watches';
  $MailToName='';
                  
    //$YourEamilPassword="Natit2016";   //Your email password from which email you send.
$YourEamilPassword="lsnspyrcimuffblr";
 
  // If you use SMTP. Please configure the bellow settings.
  
  $SmtpHost             = "smtp.gmail.com"; // sets the SMTP server
  $SmtpDebug            = 0;                     // enables SMTP debug information (for testing)
  $SmtpAuthentication   = true;                  // enable SMTP authentication
  $SmtpPort             = 587;                    // set the SMTP port for the GMAIL server
  $SmtpUsername       = $MailFrom; // SMTP account username
  $SmtpPassword       = $YourEamilPassword;        // SMTP account password
  
  $mail->IsSMTP();  // telling the class to use SMTP
  $mail->SMTPDebug  = $SmtpDebug;
  $mail->SMTPAuth   =  $SmtpAuthentication;     // enable SMTP authentication
  $mail->Port       = $SmtpPort;             // set the SMTP port
  $mail->Host       = $SmtpHost;           // SMTP server
  $mail->Username   =  $SmtpUsername; // SMTP account username
  $mail->Password   = $SmtpPassword; // SMTP account password
  
  if ( $MailFromName != '' ) {
  $mail->AddReplyTo($MailFrom,$MailFromName);
  $mail->From       = $MailFrom;
  $mail->FromName   = $MailFromName;
  } else {
  $mail->AddReplyTo($MailFrom);
  $mail->From       = $MailFrom;
  $mail->FromName   = $MailFrom;
  }
  
  if ( $MailToName != '' ) {
  $mail->AddAddress($MailTo,$MailToName);
  } else {
  $mail->AddAddress($MailTo);
  }
  
  $mail->SMTPSecure = 'tls';
  $mail->Subject  = $subject; 
  
  $mail->MsgHTML($TemplateMessage);
        $mail->Send();
        
       
  header('location:selective_customer.php');


        //unlink($full_image_path);
    }
 if (empty($_REQUEST['email'])) {
       $email = 'All';
  }
  
    // $_SESSION['email_sent']="Email has been sent successfully";
                                  header('location:selective_customer.php');
}
?>
<!-- <script language="javascript">
 function submitdata(val)
  {
  //alert("hh");
  document.location.href="newsletter_owner.php";
  }
</script> -->

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
                    Selective Customer
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                     
                        <li>
                           <a href="#">Selective Customer</a>
                          
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
                            <h4><i class="icon-reorder"></i>Selective Customer</h4>
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN FORM-->
                          <form class="form-horizontal"  method="post" action="selective_customer.php">
                            
                            <div class="control-group">
                                    <label class="control-label">Select Language</label>
                                    <div class="controls">
                                     <select name="language" onchange="selectiveCustomers(this.value)" >
                      <option value="">Select One</option>
                      <option value="all">All</option>
                      <option value="Arabic" >Arabic</option>
                       <option value="English" >English</option>
                                            </select>
                                    </div>
                                </div>

                            
<!--                               <div class="control-group">
                                    <label class="control-label">All</label>
                                    <div class="controls">
                                <input type="checkbox" class="form-control" id="sel_user">&nbsp;Select Customer
                                    </div>
                                </div>-->
                            
                             
                                  <div class="control-group">
                            <label class="control-label">Select Customer</label>
                            <div class="controls">
                             <select id="selectError" name="email[]" multiple required>
                             </select>


                            </div>
                        </div>
                               
         
                                <div class="control-group">
                                    <label class="control-label">Subject</label>
                                    <div class="controls">
                                    <input type="text" class="form-control" placeholder="Enter name"  name="subject">
                                    </div>
                                </div>
                            <div class="control-group">
                                    <label class="control-label">Message</label>
                                    <div class="controls">
                                    <textarea rows="5" cols="5" class="ckeditor form-control" id="editor1" name="elm1"  placeholder="Enter message"></textarea>
                                    </div>
                                </div>
                               
                                 <div class="form-actions">
                                     <input type="submit" name="submit" value="Send" class="btn blue">
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
   <!-- <script src="js/jquery.nicescroll.js" type="text/javascript"></script> -->
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
 <script>
    $(document).ready(function (e) {
//        $("#sel_user").click(function () {
//            if ($("#sel_user").is(':checked'))
//            {
//
//                $("#selectError").attr("disabled", false);
//            } else {
//                $("#selectError").attr("disabled", true);
//            }
//        });
    });
</script>
 <script>
   function selectiveCustomers(val) {
  $.ajax({
  type: "POST",
  url: "get_selectivecustomers.php",
  data:'language='+val,
  success: function(data){
    $("#selectError").html(data);
  }
  });
}


   </script>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
