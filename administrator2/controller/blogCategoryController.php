<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"delete from  makeoffer_blogs_category where id='".$item_id."'");
	//$_SESSION['msg']=message('deleted successfully',1);
	header('Location:list_blogs_category.php');
	exit();
}

if(isset($_GET['action']) && $_GET['action']=='inactive')
{
	 $item_id=$_GET['cid'];
	 mysqli_query($con,"update makeoffer_blogs_category set status='0' where id='".$item_id."'");
	//$_SESSION['msg']=message('updated successfully',1);
	header('Location:list_blogs_category.php');
	exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"update makeoffer_blogs_category set status='1' where id='".$item_id."'");
	$_SESSION['msg']=message('updated successfully',1);
	header('Location:list_blogs_category.php');
	exit();
}
if((!isset($_REQUEST['submit'])) && (!isset($_REQUEST['action'])))
{

$sql="select * from makeoffer_blogs_category  where 1";
                                                        

 

$record=mysqli_query($con,$sql);


}


if(isset($_REQUEST['submit']))
{

	$name = isset($_POST['name']) ? $_POST['name'] : '';
	
	

	$fields = array(
		'name' => mysqli_real_escape_string($con,$name),
		
		);

		$fieldsList = array();
		foreach ($fields as $field => $value) {
			$fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
		}
					 
	 if($_REQUEST['action']=='edit')
	  {		  
	  $editQuery = "UPDATE `makeoffer_blogs_category` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'";

		if (mysqli_query($con,$editQuery)) {
		
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/categoryimage/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `makeoffer_blogs_category` SET `image`='".$img_name."' WHERE `id` = '" . mysqli_real_escape_string($con,$_REQUEST['id']) . "'");
		}
		
		
			$_SESSION['msg'] = "Category Updated Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while updating Category";
		}

		header('Location:list_blogs_category.php');
		exit();
	
	 }
	 else
	 {
	 
	 $addQuery = "INSERT INTO `makeoffer_blogs_category` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
			
			//exit;
		mysqli_query($con,$addQuery);
		$last_id=mysqli_insert_id($con);
		if($_FILES['image']['tmp_name']!='')
		{
		$target_path="../upload/categoryimage/";
		$userfile_name = $_FILES['image']['name'];
		$userfile_tmp = $_FILES['image']['tmp_name'];
		$img_name =$userfile_name;
		$img=$target_path.$img_name;
		move_uploaded_file($userfile_tmp, $img);
		
		$image =mysqli_query($con,"UPDATE `makeoffer_blogs_category` SET `image`='".$img_name."' WHERE `id` = '" . $last_id . "'");
		}
		 
/*		if (mysqli_query($con,$addQuery)) {
		
			$_SESSION['msg'] = "Category Added Successfully";
		}
		else {
			$_SESSION['msg'] = "Error occuried while adding Category";
		}
		*/
		header('Location:list_blogs_category.php');
		exit();
	
	 }
				
				
}

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_blogs_category` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `makeoffer_blogs_category` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Users have been deleted successfully.';
        
        //die();
        
        header("Location:list_blogs_category.php");
    }

if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `makeoffer_blogs_category` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}
?>
