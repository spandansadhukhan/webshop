'use strict';
/** 
 * controllers used for the login
 */



app.directive('ngConfirmClick', [
    function(){
        return {
            priority: 1,
            terminal: true,
            link: function (scope, element, attr) {
                var msg = attr.ngConfirmClick || "Are you sure?";
                var clickAction = attr.ngClick;
                element.bind('click',function (event) {
                    if ( window.confirm(msg) ) {
                        scope.$eval(clickAction)
                    }
                });
            }
        };
}])





app.controller('auctionlistCtrl', function ($rootScope, $scope, $http, $location,$timeout, $window, userService, $stateParams) {

    
$scope.data = {};
$scope.user = {};

$window.scrollTo(0, 0);
$scope.getCurrentUserType();




var userInfo = JSON.parse($window.localStorage["userInfo"]);	
$scope.user_id=userInfo.user_id;

userService.getAccountDetails(userInfo.user_id).then(function(response) {
		
	
	if(response.Ack == '1') {
				$scope.user.full_name=response.UserDetails.full_name;
				$scope.user.email=response.UserDetails.email;
                                $scope.user.username=response.UserDetails.username;                                
				$scope.user.address=response.UserDetails.address;
				$scope.user.user_id=response.UserDetails.user_id;
				$scope.user.phone=response.UserDetails.phone;
                                $scope.user.profile_image=response.UserDetails.profile_image;                                
				//$scope.user.location=response.UserDetails.location;
				//$scope.user.address=response.UserDetails.address;
				//$scope.user.license_no=response.UserDetails.license_no;
				//$scope.user.license_expired_on=response.UserDetails.license_expired_on;
				
              }else{
				  
				$scope.user.full_name='';
				$scope.user.email='';
                                $scope.user.username='';
				$scope.user.address='';
				$scope.user.user_id='';
				$scope.user.phone='';
                                $scope.user.profile_image='';
				//$scope.user.location='';
				//$scope.user.address='';
				//$scope.user.license_no='';
				//$scope.user.license_expired_on='';
				  
			  }	
														   
 }, function(err) {
         console.log(err); 
    });




$scope.auctionList = function(){

var userInfo = JSON.parse($window.localStorage["userInfo"]);	
$scope.user_id=userInfo.user_id;


userService.auctionList(userInfo.user_id).then(function(response) {
    
    //console.log('Testing');
   
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.all_auction=response.all_auction;
		//console.log($scope.all_trainer);	
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
    };
    
    
    
    
    
$scope.removeAuction = function(auction_id){
    
	userService.removeAuction(auction_id).then(function(response) {
	
	if(response.Ack == '1') {
	//alert('Data Deleted');	
         $scope.auctionList();
	} else {	
            alert('Error !!!!');			
	}
	
						   
	}, function(err) {
	console.log(err); 
	}); 		
	
};    
    
	
	
	
});

