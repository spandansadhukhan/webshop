var app = angular.module("angularblank", ['oc.lazyLoad','ncy-angular-breadcrumb','ui.router','ngRoute','ngTouch',
        'ngSanitize','ngFileUpload','ngMap','720kb.datepicker','ngRating','720kb.tooltips','rzModule','angularLoad']);
app.run(['$rootScope', '$state', '$stateParams',
    function ($rootScope, $state, $stateParams,$scope) {
        // Attach Fastclick for eliminating the 300ms delay between a physical tap and the firing of a click event on mobile browsers
      // FastClick.attach(document.body);

        // Set some reference to access them from any scope
        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams;

        // GLOBAL APP SCOPE
        // set below basic information






        $rootScope.serviceurl = "http://localhost/webshop1/webshop/webservice/index.php/frontend/";
        $rootScope.siteurl = "http://localhost/webshop1/webshop/webservice/index.php/frontend/";
        
       //  $rootScope.serviceurl = "http://localhost/webshop1/webshop/webservice/frontend/";
        //$rootScope.siteurl = "http://localhost/webshop1/webshop/webservice/frontend/";

       //$rootScope.serviceurl = "http://localhost/webshop/webservice/frontend/";
        //$rootScope.siteurl = "http://localhost/ webshop/webservice/frontend/";






        $rootScope.app = {
            name: 'Insulationez', // name of your project
            author: '', // author's name or company name
            description:'Insulationez',
            keywords:'Insulationez',
            version: '1.0', // current version
            year: ((new Date()).getFullYear()), // automatic current year (for copyright information)
            isMobile: (function () {// true if the browser is a mobile device
                var check = false;
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                    check = true;
                };
                return check;
            })()
        };

    }]);




//--------------------------------------

app.directive('sliderRange', ['$document',function($document) {

// Move slider handle and range line
  var moveHandle = function(handle, elem, posX) {
    $(elem).find('.handle.'+handle).css("left",posX +'%');
  };
  var moveRange = function(elem,posMin,posMax) {
    $(elem).find('.range').css("left",posMin +'%');
    $(elem).find('.range').css("width",posMax - posMin +'%');
  };

return {
    template: '<div class="slider horizontal">'+
                '<div class="range"></div>'+
                '<a class="handle min" ng-mousedown="mouseDownMin($event)"></a>'+
                '<a class="handle max" ng-mousedown="mouseDownMax($event)"></a>'+
              '</div>',
    replace: true,
    restrict: 'E',
    scope:{
      valueMin:"=",
      valueMax:"="
    },
    link: function postLink(scope, element, attrs) {
        // Initilization
        var dragging = false;
        var startPointXMin = 0;
        var startPointXMax = 0;
        var xPosMin = 0;
        var xPosMax = 0;
        var settings = {
                "min"   : (typeof(attrs.min) !== "undefined"  ? parseInt(attrs.min,10) : 0),
                "max"   : (typeof(attrs.max) !== "undefined"  ? parseInt(attrs.max,10) : 100),
                "step"  : (typeof(attrs.step) !== "undefined" ? parseInt(attrs.step,10) : 1)
            };
        if ( typeof(scope.valueMin) == "undefined" || scope.valueMin === '' ) 
            scope.valueMin = settings.min;
            
        if ( typeof(scope.valueMax) == "undefined" || scope.valueMax === '' ) 
           
        //console.log('hiiii'+$rootScope.amount_max)
        //settings.max=$rootScope.amount_max;
        scope.valueMax = settings.max;
        
            
        // Track changes only from the outside of the directive
        scope.$watch('valueMin', function() {
          if (dragging) return;
          xPosMin = ( scope.valueMin - settings.min ) / (settings.max - settings.min ) * 100;
          if(xPosMin < 0) {
              xPosMin = 0;
          } else if(xPosMin > 100)  {
              xPosMin = 100;
          }
          moveHandle("min",element,xPosMin);
          moveRange(element,xPosMin,xPosMax);
        });

        scope.$watch('valueMax', function() {
          if (dragging) return;
          xPosMax = ( scope.valueMax - settings.min ) / (settings.max - settings.min ) * 100;
          if(xPosMax < 0) {
              xPosMax = 0;
          } else if(xPosMax > 100)  {
              xPosMax = 100;
          }
          moveHandle("max",element,xPosMax);
          moveRange(element,xPosMin,xPosMax);
        });

        // Real action control is here
        scope.mouseDownMin = function($event) {
            dragging = true;
            startPointXMin = $event.pageX;
        
            // Bind to full document, to make move easiery (not to lose focus on y axis)
            $document.on('mousemove', function($event) {
                if(!dragging) return;

                //Calculate handle position
                var moveDelta = $event.pageX - startPointXMin;

                xPosMin = xPosMin + ( (moveDelta / element.outerWidth()) * 100 );
                if(xPosMin < 0) {
                    xPosMin = 0;
                } else if(xPosMin > xPosMax) {
                  xPosMin = xPosMax;
                } else {
                    // Prevent generating "lag" if moving outside window
                    startPointXMin = $event.pageX;
                }
                scope.valueMin = Math.round((((settings.max - settings.min ) * (xPosMin / 100))+settings.min)/settings.step ) * settings.step;
                scope.$apply();
                
                // Move the Handle
                moveHandle("min", element,xPosMin);
                moveRange(element,xPosMin,xPosMax);
            });
        $document.mouseup(function(){
                dragging = false;
                $document.unbind('mousemove');
                $document.unbind('mousemove');
            });
        };

        scope.mouseDownMax = function($event) {
            dragging = true;
            startPointXMax = $event.pageX;
        
            // Bind to full document, to make move easiery (not to lose focus on y axis)
            $document.on('mousemove', function($event) {
                if(!dragging) return;

                //Calculate handle position
                var moveDelta = $event.pageX - startPointXMax;

                xPosMax = xPosMax + ( (moveDelta / element.outerWidth()) * 100 );
                if(xPosMax > 100)  {
                    xPosMax = 100;
                } else if(xPosMax < xPosMin) {
                  xPosMax = xPosMin;
                } else {
                    // Prevent generating "lag" if moving outside window
                    startPointXMax = $event.pageX;
                }
                scope.valueMax = Math.round((((settings.max - settings.min ) * (xPosMax / 100))+settings.min)/settings.step ) * settings.step;
                scope.$apply();
                
                // Move the Handle
                moveHandle("max", element,xPosMax);
                moveRange(element,xPosMin,xPosMax);
            });

            $document.mouseup(function(){
                dragging = false;
                $document.unbind('mousemove');
                $document.unbind('mousemove');
            });
        };
    }
  };
}]);


//image upload




//--------------------------------------






app.directive('countdown', [
    'Util',
    '$interval',
    function(Util,
    $interval) {
      return {
        restrict: 'A',
        scope: {
          date: '@'
        },
        link: function(scope,
    element) {
          var future;
          future = new Date(scope.date);
          $interval(function() {
            var diff;
            diff = Math.floor((future.getTime() - new Date().getTime()) / 1000);
            return element.text(Util.dhms(diff));
          },
    1000);
        }
      };
    }
  ]).factory('Util', [
    function() {
      return {
        dhms: function(t) {
          var days,
    hours,
    minutes,
    seconds;

          days = Math.floor(t / 86400);
          t -= days * 86400;
          hours = Math.floor(t / 3600) % 24;
          t -= hours * 3600;
          minutes = Math.floor(t / 60) % 60;
          t -= minutes * 60;
          seconds = t % 60;
          if(days < 0 ){
//days = 0;
//hours = 0;
//minutes = 0;
return ['Auction has ended !!'].join(' ');
          }else{
            //alert();
             return [days + ' days ,',
    hours + ' hour ,',
    minutes + ' minutes ,',
    seconds + ' seconds '].join(' ');
          }
    //       return [days + ' days ,',
    // hours + ' hour ,',
    // minutes + ' minutes ,',
    // seconds + ' seconds '].join(' ');
        }
      };
    }
  ]);


//angular.module('plunker', ['angular-flexslider']);
angular.module('angularblank').run(['$http',function($http){
   $http.defaults.headers.common.responsetype = 'json';
}])

/* Sweet Alert*/


/* Sweet Alert */

angular.module('angularblank').filter('tel', function () {
    return function (tel) {
        if (!tel) { return ''; }

        var value = tel.toString().trim().replace(/^\+/, '');

        if (value.match(/[^0-9]/)) {
            return tel;
        }

        var country, city, number;

        switch (value.length) {
            case 10: // +1PPP####### -> C (PPP) ###-####
                country = 1;
                city = value.slice(0, 3);
                number = value.slice(3);
                break;

            case 11: // +CPPP####### -> CCC (PP) ###-####
                country = value[0];
                city = value.slice(1, 4);
                number = value.slice(4);
                break;

            case 12: // +CCCPP####### -> CCC (PP) ###-####
                country = value.slice(0, 3);
                city = value.slice(3, 5);
                number = value.slice(5);
                break;

            default:
                return tel;
        }

        if (country == 1) {
            country = "";
        }

        number = number.slice(0, 3) + '-' + number.slice(3);

        return (country + " (" + city + ") " + number).trim();
    };
});


   // angular.module('yourApp', ['rzModule']);
    
    

app.config(['$stateProvider', '$urlRouterProvider', '$controllerProvider', '$compileProvider', '$filterProvider', '$provide', '$ocLazyLoadProvider', 'JS_REQUIRES','$locationProvider',
    function ($stateProvider, $urlRouterProvider, $controllerProvider, $compileProvider, $filterProvider, $provide, $ocLazyLoadProvider, jsRequires,$locationProvider) {

     app.controller = $controllerProvider.register;
     app.directive = $compileProvider.directive;
     app.filter = $filterProvider.register;
     app.factory = $provide.factory;
     app.service = $provide.service;
     app.constant = $provide.constant;
     app.value = $provide.value;

        // LAZY MODULES
        $ocLazyLoadProvider.config({
            debug: false,
            events: true,
            modules: jsRequires.modules
        });

///Remove Hash from URL//////
 //$locationProvider.html5Mode(true).hashPrefix('');
 $locationProvider.hashPrefix('');

    // APPLICATION ROUTES
    // -----------------------------------
    // For any unmatched url, redirect to /app/dashboard
        $urlRouterProvider.otherwise("/home");

    //
    // Set up the states

        $stateProvider
        //Login state
            .state('frontend', {
                url: '',
                templateUrl: 'app/views/app.html',
                abstract :true,
                //resolve: loadSequence('footer')

            })



         .state('frontend.login', {
                url: '/login',
                templateUrl: 'app/views/login.html',
                title: 'Login',
		controller: 'loginCtrl',
                ncyBreadcrumb: {
                    label: 'Login page'
                },
                resolve: loadSequence('login')
            })




            .state('frontend.forgot_password', {
                url: '/forgot_password',
                templateUrl: 'app/views/forgot_password.html',
                title: 'forgot_password',
		controller: 'forgot_passwordCtrl',
                ncyBreadcrumb: {
                    label: 'Forgot Password page'
                },
                resolve: loadSequence('forgot_password')
            })




	         .state('frontend.cms', {
                url: '/cms/:id',
                templateUrl: 'app/views/cms.html',
                title: 'Login',
		controller: 'cmsCtrl',
                ncyBreadcrumb: {
                    label: 'CMS page'
                },
                resolve: loadSequence('cms')
            })


            .state('frontend.notifications', {
                           url: '/notifications',
                           templateUrl: 'app/views/notifications.html',
                           title: 'Notification',
                                           controller: 'notificationsCtrl',
                           ncyBreadcrumb: {
                               label: 'Services page'
                           },
                           resolve: loadSequence('notifications')
                       })

              .state('frontend.notificationSetting', {
                           url: '/notification_settings',
                           templateUrl: 'app/views/notificationSetting.html',
                           title: 'Notification Setting',
                                           controller: 'NotificationSettingCtrl',
                           ncyBreadcrumb: {
                               label: 'Notification Setting'
                           },
                           resolve: loadSequence('notification_settings')
                       })  

                .state('frontend.purchaseSubscription', {
                           url: '/purchaseSubscription',
                           templateUrl: 'app/views/purchaseSubscription.html',
                           title: 'Purchase Subscription',
                            controller: 'purchaseSubscriptionCtrl',
                           ncyBreadcrumb: {
                               label: 'Purchase Subscription'
                           },
                           resolve: loadSequence('purchaseSubscription')
                       })           


            .state('frontend.failure', {
                url: '/failure',
                templateUrl: 'app/views/failure.html',
                title: 'failure',
		controller: 'failureCtrl',
                ncyBreadcrumb: {
                    label: 'failure page'
                },
                resolve: loadSequence('failure')
            })




	         .state('frontend.cart', {
                url: '/cart',
                templateUrl: 'app/views/cart.html',
                title: 'Cart',
		controller: 'cartCtrl',
                ncyBreadcrumb: {
                    label: 'Cart page'
                },
                resolve: loadSequence('cart')
            })


	         .state('frontend.vendordashboard', {
                url: '/vendordashboard',
                templateUrl: 'app/views/vendordashboard.html',
                title: 'Vendor dashboard',
		controller: 'vendordashboardCtrl',
                ncyBreadcrumb: {
                    label: 'Vendordashboard page'
                },
                resolve: loadSequence('vendordashboard')
            })


            .state('frontend.checkout', {
                url: '/checkout',
                templateUrl: 'app/views/checkout.html',
                title: 'checkout',
		controller: 'checkoutCtrl',
                ncyBreadcrumb: {
                    label: 'checkout page'
                },
                resolve: loadSequence('checkout')
            })

             .state('frontend.payment_success', {
                url: '/payment_success',
                templateUrl: 'app/views/payment_success.html',
                title: 'payment_success',
		controller: 'payment_successCtrl',
                ncyBreadcrumb: {
                    label: 'Payment success page'
                },
                resolve: loadSequence('payment_success')
            })

            .state('frontend.order_details', {
                url: '/order_details/:id',
                templateUrl: 'app/views/order_details.html',
                title: 'orderdetails',
		controller: 'order_detailsCtrl',
                ncyBreadcrumb: {
                    label: 'Order details page'
                },
                resolve: loadSequence('order_details')
            })

            .state('frontend.signup', {
                url: '/signup',
                templateUrl: 'app/views/signup.html',
                title: 'Signup',
				controller: 'signupCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('signup')
            })

           .state('frontend.invites', {
                url: '/invites',
                templateUrl: 'app/views/invites.html',
                title: 'My Account',
				controller: 'invitesCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('invites')
            })




            .state('frontend.pay_success', {
                url: '/pay_success',
                templateUrl: 'app/views/pay_success.html',
                title: 'awaiting',
				controller: 'paySuccessCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('pay_success')
            })



             .state('frontend.inbox', {
                url: '/inbox',
                templateUrl: 'app/views/inbox.html',
                title: 'Inbox',
				controller: 'inboxCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('inbox')
            })


             .state('frontend.ListOrderSeller', {
                url: '/ListOrderSeller',
                templateUrl: 'app/views/ListOrderSeller.html',
                title: 'ListOrderSeller',
				controller: 'ListOrderSellerCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('ListOrderSeller')
            })

              .state('frontend.ListOrderBuyer', {
                url: '/ListOrderBuyer',
                templateUrl: 'app/views/ListOrderBuyer.html',
                title: 'ListOrderBuyer',
				controller: 'ListOrderBuyerCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('ListOrderBuyer')
            })
              







           .state('frontend.notification_settings', {
                url: '/notification_settings',
                templateUrl: 'app/views/notification_settings.html',
                title: 'Notification Settings',
				controller: 'NotificationSettingCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('notification_settings')
            })

		   .state('frontend.accepted', {
                url: '/accepted',
                templateUrl: 'app/views/accepted.html',
                title: 'My Account',
				controller: 'acceptedCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('accepted')
            })


		   .state('frontend.contact_us', {
                url: '/contact_us',
                templateUrl: 'app/views/contact_us.html',
                title: 'My Account',
				controller: 'contactUsCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('contact_us')
            })

		   .state('frontend.change_password', {
                url: '/change_password',
                templateUrl: 'app/views/change_password.html',
                title: 'My Account',
				controller: 'changePasswordCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('change_password')
            })


		   .state('frontend.waitlisted', {
                url: '/waitlisted',
                templateUrl: 'app/views/waitlisted.html',
                title: 'My Account',
				controller: 'waitlistedCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('waitlisted')
            })

              .state('frontend.wishlist', {
                url: '/wishlist',
                templateUrl: 'app/views/wishlist.html',
                title: 'My Account',
				controller: 'wishlistCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('wishlist')
            })



		   .state('frontend.reviews', {
                url: '/reviews',
                templateUrl: 'app/views/reviews.html',
                title: 'My Account',
				controller: 'reviewsCtrl',
                ncyBreadcrumb: {
                    label: 'Reviews'
                },
                resolve: loadSequence('reviews')
            })

		   .state('frontend.invoices', {
                url: '/invoices',
                templateUrl: 'app/views/invoices.html',
                title: 'Invoices',
				controller: 'invoicesCtrl',
                ncyBreadcrumb: {
                    label: 'Invoices'
                },
                resolve: loadSequence('invoices')
            })


            .state('frontend.allmessage', {
                url: '/allmessage',
                templateUrl: 'app/views/allmessage.html',
                title: 'All Message',
				controller: 'allmessageCtrl',
                ncyBreadcrumb: {
                    label: 'All Message page'
                },
                resolve: loadSequence('allmessage')
            })


		.state('frontend.message', {
                url: '/message/:id1/:id2',
                templateUrl: 'app/views/message.html',
                title: 'Message',
				controller: 'messageCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('message')
            })

		    .state('frontend.my_account', {
                url: '/my_account',
                templateUrl: 'app/views/my-account.html',
                title: 'My Account',
				controller: 'myAccountCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('my_account')
            })


            .state('frontend.addProduct', {
                url: '/addProduct/:id',
                templateUrl: 'app/views/addProduct.html',
                title: 'Add Product',
				controller: 'addProductCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('addProduct')
            })

            .state('frontend.addProduct2', {
                url: '/addProduct2',
                templateUrl: 'app/views/addProduct2.html',
                title: 'Add Product',
                controller: 'addProductCtrl2',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('addProduct2')
            })

             .state('frontend.addAuction', {
                url: '/addAuction',
                templateUrl: 'app/views/addAuction.html',
                title: 'Add Auction',
                controller: 'addAuctionCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('addAuction')
            })

               .state('frontend.addAuction2', {
                url: '/addAuction2',
                templateUrl: 'app/views/addAuction2.html',
                title: 'Add Auction',
                controller: 'addAuctionCtrl2',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('addAuction2')
            })

            .state('frontend.myProduct', {
                url: '/myProduct',
                templateUrl: 'app/views/myProduct.html',
                title: 'myProduct',
				controller: 'myProductCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('myProduct')
            })

            .state('frontend.myAuction', {
                url: '/myAuction',
                templateUrl: 'app/views/myAuction.html',
                title: 'myAuction',
                controller: 'myAuctionCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('myAuction')
            })


            .state('frontend.home', {
                url: '/home',
                templateUrl: 'app/views/home.html',
                title: 'Home',
				controller: 'homeCtrl',
                ncyBreadcrumb: {
                    label: 'Home page'
                },
                resolve: loadSequence('home')
            })

              .state('frontend.pay_now', {
                url: '/pay_now/:id',
                templateUrl: 'app/views/pay_now.html',
                title: 'Paynow',
				controller: 'payNowCtrl',
                ncyBreadcrumb: {
                    label: 'Payment page'
                },
                resolve: loadSequence('pay_now')
            })


             .state('frontend.searchListing', {
                url: '/searchListing/:brand',
                templateUrl: 'app/views/searchListing.html',
                title: 'searchListing',
				controller: 'searchListingCtrl',
                ncyBreadcrumb: {
                    label: 'Search listing page'
                },
                resolve: loadSequence('searchListing')
            })

            .state('frontend.productDetails', {
                url: '/productDetails/:id',
                templateUrl: 'app/views/productDetails.html',
                title: 'productDetails',
				controller: 'productDetailsCtrl',
                ncyBreadcrumb: {
                    label: 'Product Details page'
                },
                resolve: loadSequence('productDetails')
            })


             .state('frontend.auctionDetails', {
                url: '/auctionDetails/:id',
                templateUrl: 'app/views/auctionDetails.html',
                title: 'auctionDetails',
                controller: 'auctionDetailsCtrl',
                ncyBreadcrumb: {
                    label: 'Auction Details page'
                },
                resolve: loadSequence('auctionDetails')
            })

              .state('frontend.emailverify', {
                url: '/emailverify/:id',
                templateUrl: 'app/views/emailverify.html',
                title: 'emailverify',
                controller: 'emailVerifyCtrl',
                ncyBreadcrumb: {
                    label: 'Email Verify page'
                },
               resolve: loadSequence('emailverify')
            })
          
               .state('frontend.sendForAuction', {
                url: '/sendForAuction/:product_id',
                templateUrl: 'app/views/sendForAuction.html',
                title: 'sendForAuction',
                controller: 'sendForAuctionCtrl',
                ncyBreadcrumb: {
                    label: 'Services page'
                },
                resolve: loadSequence('sendForAuction')
            })

            
            
            //spandan 27_04
            
            .state('frontend.SubscribedList', {
                url: '/SubscribedList',
                templateUrl: 'app/views/SubscribedList.html',
                title: 'Subscribed',
		controller: 'SubscribedListCtrl',
                ncyBreadcrumb: {
                    label: 'SubscribedList page'
                },
                resolve: loadSequence('SubscribedList')
            })
            
             .state('frontend.payment', {
                url: '/payment/:subscription_id',
                templateUrl: 'app/views/payment.html',
                title: 'payment',
		controller: 'paymentCtrl',
                ncyBreadcrumb: {
                    label: 'payment page'
                },
                resolve: loadSequence('payment')
            })
            
            

            .state('frontend.productlisting', {
                url: '/productlisting/:id',
                templateUrl: 'app/views/productlisting.html',
                title: 'productlisting',
				controller: 'productlistingCtrl',
                ncyBreadcrumb: {
                    label: 'Search listing page'
                },
                resolve: loadSequence('productlisting')
            })
            
            .state('frontend.messagelisting', {
                url: '/messagelisting',
                templateUrl: 'app/views/messagelisting.html',
                title: 'messagelisting',
				controller: 'messagelistingCtrl',
                ncyBreadcrumb: {
                    label: 'Message listing page'
                },
                resolve: loadSequence('messagelisting')
            })

             .state('frontend.conatctuser', {
                url: '/conatctuser/:id/:product_id/:from_id',
                templateUrl: 'app/views/conatctuser.html',
                title: 'messagelisting',
				controller: 'conatctuserCtrl',
                ncyBreadcrumb: {
                    label: 'Contact user'
                },
                resolve: loadSequence('conatctuser')
            })
            .state('frontend.messageDetails', {
                url: '/messageDetails/:to_id/:product_id/:from_id',
                templateUrl: 'app/views/messageDetails.html',
                title: 'messageDetails',
				controller: 'messageDetailsCtrl',
                ncyBreadcrumb: {
                    label: 'Message listing page'
                },
                resolve: loadSequence('messageDetails')
            })






            .state('frontend.success', {
                url: '/success/:id/:oid',
                templateUrl: 'app/views/success.html',
                title: 'success',
				controller: 'successCtrl',
                ncyBreadcrumb: {
                    label: 'success page'
                },
                resolve: loadSequence('success')
            })

            .state('frontend.cancel', {
                url: '/cancel/:id',
                templateUrl: 'app/views/cancel.html',
                title: 'success',
				controller: 'cancelCtrl',
                ncyBreadcrumb: {
                    label: 'cancel page'
                },
                resolve: loadSequence('cancel')
            })
            
            .state('frontend.expiredProduct', {
                url: '/expiredProduct',
                templateUrl: 'app/views/expiredProduct.html',
                title: 'myProduct',
				controller: 'expiredProductCtrl',
                ncyBreadcrumb: {
                    label: 'product page'
                },
                resolve: loadSequence('expiredProduct')
            })
            
            
            .state('frontend.userpayment', {
                url: '/userpayment/:pid',
                templateUrl: 'app/views/userpayment.html',
                title: 'userpayment',
		controller: 'userpaymentCtrl',
                ncyBreadcrumb: {
                    label: 'payment page'
                },
                resolve: loadSequence('userpayment')
            })
            
            .state('frontend.successUserpayment', {
                url: '/successUserpayment/:id/:oid',
                templateUrl: 'app/views/successUserpayment.html',
                title: 'success',
				controller: 'successUserpaymentCtrl',
                ncyBreadcrumb: {
                    label: 'success page'
                },
                resolve: loadSequence('successUserpayment')
            })
            
            .state('frontend.auctionpayment', {
                url: '/auctionpayment/:product_id',
                templateUrl: 'app/views/auctionpayment.html',
                title: 'auctionpayment',
		controller: 'auctionpaymentCtrl',
                ncyBreadcrumb: {
                    label: 'auction payment page'
                },
                resolve: loadSequence('auctionpayment')
            })
            
            
            .state('frontend.successAuctionpayment', {
                url: '/successAuctionpayment/:id/:oid',
                templateUrl: 'app/views/successAuctionpayment.html',
                title: 'success',
				controller: 'successAuctionpaymentCtrl',
                ncyBreadcrumb: {
                    label: 'success page'
                },
                resolve: loadSequence('successAuctionpayment')
            })
            
            
            
            .state('frontend.cancelAuctionpayment', {
                url: '/cancelAuctionpayment/:id',
                templateUrl: 'app/views/cancelAuctionpayment.html',
                title: 'success',
				controller: 'cancelAuctionpaymentCtrl',
                ncyBreadcrumb: {
                    label: 'cancel page'
                },
                resolve: loadSequence('cancelAuctionpayment')
            })
            

            .state('frontend.todaysDeals', {
                url: '/todaysDeals',
                templateUrl: 'app/views/todaysDeals.html',
                title: 'todaysDeals',
				controller: 'todaysDealsCtrl',
                ncyBreadcrumb: {
                    label: 'todaysDeals page'
                },
                resolve: loadSequence('todaysDeals')
            })
            
            
            .state('frontend.interestin', {
                url: '/interestin',
                templateUrl: 'app/views/interestin.html',
                title: 'interestin',
				controller: 'interestinCtrl',
                ncyBreadcrumb: {
                    label: 'interestin page'
                },
                resolve: loadSequence('interestin')
            })
            
            
            .state('frontend.interested', {
                url: '/interested',
                templateUrl: 'app/views/interested.html',
                title: 'interested',
				controller: 'interestedCtrl',
                ncyBreadcrumb: {
                    label: 'interested page'
                },
                resolve: loadSequence('interested')
            })
            
            
            
            
            
            .state('frontend.auctionuploadpayment', {
                url: '/auctionuploadpayment/:product_id',
                templateUrl: 'app/views/auctionuploadpayment.html',
                title: 'auctionuploadpayment',
		controller: 'auctionuploadpaymentCtrl',
                ncyBreadcrumb: {
                    label: 'auction payment page'
                },
                resolve: loadSequence('auctionuploadpayment')
            })
            
            
            .state('frontend.successAuctionuploadpayment', {
                url: '/successAuctionuploadpayment/:id/:oid',
                templateUrl: 'app/views/successAuctionuploadpayment.html',
                title: 'success',
				controller: 'successAuctionuploadpaymentCtrl',
                ncyBreadcrumb: {
                    label: 'success page'
                },
                resolve: loadSequence('successAuctionuploadpayment')
            })
            
            
            
            .state('frontend.cancelAuctionuploadpayment', {
                url: '/cancelAuctionuploadpayment/:id',
                templateUrl: 'app/views/cancelAuctionuploadpayment.html',
                title: 'success',
				controller: 'cancelAuctionuploadpaymentCtrl',
                ncyBreadcrumb: {
                    label: 'cancel page'
                },
                resolve: loadSequence('cancelAuctionuploadpayment')
            })
            
            
            .state('frontend.myLoyalty', {
                url: '/myLoyalty',
                templateUrl: 'app/views/myLoyalty.html',
                title: 'myLoyalty',
				controller: 'myLoyaltyCtrl',
                ncyBreadcrumb: {
                    label: 'Loyalty page'
                },
                resolve: loadSequence('myLoyalty')
            })
            
             .state('frontend.loyaltydetails', {
                url: '/loyaltydetails',
                templateUrl: 'app/views/loyaltydetails.html',
                title: 'loyaltydetails',
				controller: 'loyaltydetailsCtrl',
                ncyBreadcrumb: {
                    label: 'Loyalty page'
                },
                resolve: loadSequence('loyaltydetails')
            })
            
            
             .state('frontend.filterbylocation', {
                url: '/filterbylocation',
                templateUrl: 'app/views/filterbylocation.html',
                title: 'filterbylocation',
				controller: 'filterbylocationCtrl',
                ncyBreadcrumb: {
                    label: 'filterbylocation page'
                },
                resolve: loadSequence('filterbylocation')
            })
            
            .state('frontend.adminmessageDetails', {
                url: '/adminmessageDetails/:user_id/:admin_id',
                templateUrl: 'app/views/adminmessageDetails.html',
                title: 'adminmessageDetails',
				controller: 'adminmessageDetailsCtrl',
                ncyBreadcrumb: {
                    label: 'Admin Message page'
                },
                resolve: loadSequence('adminmessageDetails')
            })

            .state('frontend.viewwinauction', {
                            url: '/viewwinauction/:id',
                            templateUrl: 'app/views/viewwinauction.html',
                            title: 'Auction Details',
                            controller: 'viewwinauctionCtrl',
                            ncyBreadcrumb: {
                                label: 'Auction Details Page'
                            },
                            resolve: loadSequence('viewwinauction')
                        })
                        
                           .state('frontend.shoplisting', {
                url: '/shoplisting/:id',
                templateUrl: 'app/views/shoplisting.html',
                title: 'shoplisting',
				controller: 'shoplistingCtrl',
                ncyBreadcrumb: {
                    label: 'Shop listing page'
                },
                resolve: loadSequence('shoplisting')
            })
            .state('frontend.shopDetails', {
                url: '/shopDetails/:id',
                templateUrl: 'app/views/shopDetails.html',
                title: 'productDetails',
				controller: 'shopDetailsCtrl',
                ncyBreadcrumb: {
                    label: 'Shop Details page'
                },
                resolve: loadSequence('shopDetails')
            })
            
            .state('frontend.latestdeal', {
                url: '/latestdeal',
                templateUrl: 'app/views/latestdeal.html',
                title: 'latestdeal',
				controller: 'latestdealCtrl',
                ncyBreadcrumb: {
                    label: 'Latest Deal page'
                },
                resolve: loadSequence('latestdeal')
            })
            
            
            .state('frontend.usertoppayment', {
                url: '/usertoppayment/:pid',
                templateUrl: 'app/views/usertoppayment.html',
                title: 'usertoppayment',
		controller: 'usertoppaymentCtrl',
                ncyBreadcrumb: {
                    label: 'payment page'
                },
                resolve: loadSequence('usertoppayment')
            })
            
            .state('frontend.successUsertoppayment', {
                url: '/successUsertoppayment/:id/:oid',
                templateUrl: 'app/views/successUsertoppayment.html',
                title: 'success',
				controller: 'successUsertoppaymentCtrl',
                ncyBreadcrumb: {
                    label: 'success page'
                },
                resolve: loadSequence('successUsertoppayment')
            })
            
            .state('frontend.cancelUsertoppayment', {
                url: '/cancelUsertoppayment/:id/:oid',
                templateUrl: 'app/views/cancelUsertoppayment.html',
                title: 'cancel',
				controller: 'cancelUsertoppaymentCtrl',
                ncyBreadcrumb: {
                    label: 'cancel page'
                },
                resolve: loadSequence('cancelUsertoppayment')
            })
            .state('frontend.allshopDetails', {
                url: '/allshopDetails/:id',
                templateUrl: 'app/views/allshopDetails.html',
                title: 'allshopDetailsCtrl',
				controller: 'allshopDetailsCtrl',
                ncyBreadcrumb: {
                    label: 'Shop Details page'
                },
                resolve: loadSequence('allshopDetails')
            })
            
            .state('frontend.mobileverify', {
                url: '/mobileverify/:id/:mobileno/:code',
                templateUrl: 'app/views/mobileverify.html',
                title: 'mobileverify',
                controller: 'mobileverifyCtrl',
                ncyBreadcrumb: {
                    label: 'Mobile Number Verify page'
                },
               resolve: loadSequence('mobileverify')
            })
            
            
            
             .state('frontend.successUserpaymentTop', {
                url: '/successUserpaymentTop/:id/:oid',
                templateUrl: 'app/views/successUserpaymentTop.html',
                title: 'success',
				controller: 'successUserpaymentTopCtrl',
                ncyBreadcrumb: {
                    label: 'success page'
                },
                resolve: loadSequence('successUserpaymentTop')
            })
            
            
            
            
            
          /*   .state('frontend.test', {
                url: '/test',
                templateUrl: 'app/views/test.html',
                title: 'Home',
                ncyBreadcrumb: {
                    label: 'test page'
                },
                resolve: loadSequence('home')
            }); */

function loadSequence() {
            var _args = arguments;
            return {
                deps: ['$ocLazyLoad', '$q',
                    function ($ocLL, $q) {
                        var promise = $q.when(1);
                        for (var i = 0, len = _args.length; i < len; i++) {
                            promise = promiseThen(_args[i]);
                        }
                        return promise;

                        function promiseThen(_arg) {
                            if (typeof _arg == 'function')
                                return promise.then(_arg);
                            else
                                return promise.then(function () {
                                    var nowLoad = requiredData(_arg);
                                    if (!nowLoad)
                                        return $.error('Route resolve: Bad resource name [' + _arg + ']');
                                    return $ocLL.load(nowLoad);
                                });
                        }

                        function requiredData(name) {
                            if (jsRequires.modules)
                                for (var m in jsRequires.modules)
                                    if (jsRequires.modules[m].name && jsRequires.modules[m].name === name)
                                        return jsRequires.modules[m];
                            return jsRequires.scripts && jsRequires.scripts[name];  
                        }
                    }]
            };
        }

  }]);






