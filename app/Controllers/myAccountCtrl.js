'use strict';
/** 
 * controllers used for the My Account
 */
app.controller('myAccountCtrl', function ($rootScope, $scope, $http, $location,$timeout, $q, userService,$window,Upload) {
 
    $window.scrollTo(0, 0);
$scope.data = {};
$scope.user = {};
$scope.pass = {};
$scope.mobileno = {};
// $scope.latlng = [-25.363882,131.044922];
// 
// 
//  $scope.getpos = function(event){
$scope.phonecheck='';
$scope.checkverify=false;
//  };

if($window.localStorage["currency"] != ''){
   $scope.usersSelectedCurrency = $window.localStorage["currency"] ;
}else{
    $scope.usersSelectedCurrency = 'KWD';
}
$scope.getCurrentUserType();   
//console.log($scope.current_user_type);

//alert($scope.user_id);
  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
        
       
        
//        if($scope.user_id == undefined){
//            $window.location.href='google.com';
//        }else{
//          alert();
//        }
       
        var name = 'Arun Banik';

        if ($window.localStorage["userInfo"] != '') {
            alert('yes');
        }
        else{
            alert('no');
    }
         userService.checkuserlogin($scope.user_id).then(function(response) {
       // alert('OK');
        //exit;
	
	
	if(response.Ack=='1'){
		
		//console.log('brandsList',response);
		alert('yes');
		
                
		}
		else{
 		alert('no');
		}
	
	
																  
	}, function(err) {
         console.log(err); 
    });
	//console.log("spandan",userInfo);  

	
   userService.getAccountDetails(userInfo.user_id).then(function(response) {
	
	console.log("arunava",response);  
	if(response.Ack == '1') {
				$scope.user.fname=response.UserDetails.fname;
				$scope.user.lname=response.UserDetails.lname;
				$scope.user.gender=response.UserDetails.gender;
				$scope.user.email=response.UserDetails.email;
				$scope.user.address=response.UserDetails.address;
				$scope.user.user_id=response.UserDetails.user_id;
				$scope.user.phone=response.UserDetails.phone;
                                $scope.pass.mobile=response.UserDetails.phone;
                                //$scope.user.phone =
                                $scope.phonecheck = response.UserDetails.phone;
				$scope.user.location=response.UserDetails.location;
                                $scope.user.business_type=response.UserDetails.business_type;
				$scope.user.city=response.UserDetails.city;
				$scope.user.state=response.UserDetails.state;
				$scope.user.country=response.UserDetails.country;
				$scope.user.zip=response.UserDetails.zip;
                                $scope.user.secret_key=response.UserDetails.secret_key;
                                $scope.user.publish_key=response.UserDetails.publish_key;
				$scope.user.address=response.UserDetails.address;
                                $scope.user.ibanno=response.UserDetails.ibanno;
                                $scope.user.bankname=response.UserDetails.bankname;
                                $scope.user.language_preference=response.UserDetails.language_preference;
                                //$scope.user.civilid1=response.UserDetails.civilid1;
                                //$scope.user.civilid2=response.UserDetails.civilid2;
                                let imagesArray=response.UserDetails.images;
                                $scope.user.image=[];
                                if(imagesArray && imagesArray.length && imagesArray.length>0)
                                {
                                    for(let i=0;i<imagesArray.length;i++)
                                    {
                                        if(imagesArray[i])
                                        {
                                            $scope.user.image.push(imagesArray[i]);
                                        }
                                    }
                                }
                                $scope.user.country_preference=response.UserDetails.country_preference;
                                $scope.user.currency_preference=response.UserDetails.currency_preference;
                                
                                $scope.state($scope.user.country);
                                $scope.city($scope.user.state);
				
              }else{
				  
				$scope.user.fname='';
				$scope.user.lname='';
				$scope.user.gender='';
				$scope.user.email='';
				$scope.user.address='';
				$scope.user.user_id='';
				$scope.user.phone='';
				$scope.user.location='';
				$scope.user.city="";
				$scope.user.state="";
				$scope.user.country="";
				$scope.user.zip="";
				$scope.user.address='';
                                $scope.user.secret_key="";
				$scope.user.publish_key='';
                                $scope.user.ibanno='';
                                $scope.user.bankname='';
                                $scope.user.language_preference='';
				
				
				  
			  }
	
	
	
														   
 }, function(err) {
         console.log(err); 
    }); 
	
	
   
        
        
	
    $scope.updateProfile = function (user) {

        //console.log('hellouser',user); return false;
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        $scope.user_id = userInfo.user_id;

        //alert(user.my_latitude);
        
        user.my_latitude = angular.element('#lat').val();
        user.my_longitude = angular.element('#long').val();
        user.address = angular.element('#address').val();
        userService.updateProfile(user, $scope.user_id).then(function (response) {

            console.log(response);

            if (response.Ack == '1') {
                
                
                
                
                swal("Profile Updated!", "", "success");
                //alert('Profile Updated');
                //user.fname='';
            } else {

                swal("Profile Can not Be Updated!", "", "error");
            }





        }, function (err) {
            // console.log(err); 
        });

    }; 	
	
	

userService.listcountry().then(function(response) {
           
		$scope.isExists=1;
		if(response.Ack == '1') {
                  
                    $scope.isExists=1;
                  
		$scope.countrylist=response.countrylist;
              
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
				   
	}, function(err) {
	console.log(err); 
	});



    $scope.state = function (c_id) {
        
        userService.liststate(c_id).then(function (response) {
           
            $scope.isExists = 1;
            if (response.Ack == '1') {
                console.log(response);
               
                $scope.isExists = 1;
               
                $scope.statelist = response.statelist;
              

            } else {
                console.log('ppp');
                $scope.isExists = 0;
            }

        }, function (err) {
            console.log(err);
        });

    }

    $scope.city = function (s_id) {

        userService.listcity(s_id).then(function (response) {

            $scope.isExists = 1;
            if (response.Ack == '1') {
                console.log(response);

                $scope.isExists = 1;

                $scope.citylist = response.citylist;


            } else {
                console.log('ppp');
                $scope.isExists = 0;
            }

        }, function (err) {
            console.log(err);
        });

    }
    
    
    
    userService.listcurrency().then(function (response) {

        console.log(response.Ack);
        $scope.isExists = 1;
        if (response.Ack == '1') {

            $scope.isExists = 1;

            $scope.currencylist = response.currencylist;


        } else {
            console.log('ppp');
            $scope.isExists = 0;
        }




    }, function (err) {
        console.log(err);
    });
    
    
    
   $scope.deleteFile = function(idx,filename) {
//    alert(filename);
//    alert(idx);
     //var filename = idx;
     $scope.image = $scope.user.image.splice(idx, 1);
     console.log('delete',$scope.user.image);
//     if (filename) {
//          $http.delete('/api/files/'+file.id).then(function(response){
//               if (response.status == 200) {
//                    $scope.files.splice(idx, 1);
//               }
//         });
//      } else {
//           $scope.files.splice(idx, 1);
//      }

 userService.deleteimage(filename).then(function (response) {

            $scope.isExists = 1;
            if (response.Ack == '1') {
                console.log(response);

               // $scope.getAccountDetails();


            } 

        }, function (err) {
            console.log(err);
        }); 

} 


$scope.verifyotp = function(mobileno) {
    //alert(mobileno.mobile);
    if(mobileno.mobile && mobileno.mobile !='undefined' && mobileno.mobile != $scope.phonecheck){
        
        userService.resend1($scope.user_id,mobileno.mobile).then(function(response) {
           // alert(response.Ack);
        if(response.Ack == '1'){
             $('#check_otp').modal('hide');
            	 $('#check_otp1').modal('show');
                //$scope.checkverify=true;
                
        }else{
            swal("Please Check Your Mobile Number Along With Your Country .", "", "error")
              
        }
   														   
 }, function(err) {
         console.log(err); 
    });
        
        
        
        
       
    }
}
$scope.openverifymodal = function(phoneno) {
     if(phoneno && phoneno !='undefined' && phoneno != $scope.phonecheck){
    $('#check_otp').modal('show');
    $scope.pass.mobile=phoneno;
    $scope.mobileno.mobile=phoneno;
     }
}
/*
$scope.openverifymodal = function(phoneno) {
   $scope.pass.mobile=phoneno;
   $('#check_otp1').modal('show');
}*/
 $scope.check_otp = function(pass){
        
       
         
        pass.password=pass.password;
        //alert($scope.user_id);
       // alert($scope.user.phone);
        //console.log("pass",pass.password); 
        //var userInfo = JSON.parse($window.localStorage["userInfo"]);
        //pass.user_id=userInfo.user_id; 
        
        userService.tomobileverifying($scope.user_id,pass.password,$scope.user.phone).then(function(response) {
	
	//console.log("zzzdfdzsxfdz",response);  
	 if(response.Ack == '1'){
				  
			//$scope.msg='There is problem in verifying your email.';
				
			 swal("Successfully Verified Your Mobile No.", "", "success")
                .then((value) => {
                    if(value == true){

                            $('#check_otp1').modal('hide');
                    }

                });	

                 }else{

                 swal("Please Enter Correct OTP", "", "error")
                

                 }
	
	
	
														   
 }, function(err) {
         console.log(err); 
    }); 
    
        
       
 }


$scope.resendotp = function(phoneno) {

    
        
        userService.resend1($scope.user_id).then(function(response) {
           // alert(response.Ack);
        if(response.Ack == '1'){
            	 $('#check_otp').modal('show');
        }else{
            swal("There is problem to send OTP to your Mobile.Please try again", "", "error")
              
        }
   														   
 }, function(err) {
         console.log(err); 
    });
        
  
}
});

