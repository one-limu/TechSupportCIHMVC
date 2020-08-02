angular.module("myApp", ['AngularPrint','ngStorage','ui.router','chart.js','home','log','login','post','ticket','user','ngMaterial','ui.bootstrap', 'ui.bootstrap.datetimepicker',"ngAnimate","ngAria", 'ngMessages','ngFileUpload','angularUtils.directives.dirPagination']);

angular.module("home", []);
angular.module("login", []);
angular.module("post", []);
angular.module("ticket", []);
angular.module("user", []);
angular.module("log", []);


angular.module("myApp").run(function($transitions,$state,$rootScope,$localStorage,userSession){
console.log(userSession, 'ini localstorage')

  $transitions.onStart({to: 'adminLogin'}, function(trans){
    console.log($localStorage, 'ini localstorage')
      console.log(trans.$from(), 'from')
      var fromState = trans.$from().name
     if(fromState == 'adminLogout' || fromState == 'adminUnprivileged'){
         $rootScope.from =  '';
     }else{
        if($rootScope.from == 'admin.ticketOpen'){
            $rootScope.from =  '';  
        }else{
          $rootScope.from =  fromState
        }
       
     }
      console.log('ini from ',$rootScope.from)
  })


  $transitions.onStart({to: 'admin.**'}, function(trans){
console.log(userSession, 'ini localstorage')
  var toState = trans.$to().name
  
   // console.log("Entered " + state.name + " module while transitioning to " + trans.to().name)
    var state = trans.router.stateService;
    var userSession = trans.injector().get('userSession')
    var userservice = trans.injector().get('userService')

    if(!userSession.logged_in_admin){
     return userSession.authenticate(toState)
      .catch(function(){
        //$rootScope.from = toState
        console.log('wkwk gk bisa login')
        return state.go('adminLogin')
      })
      .then(function(respone){
        console.log('wkwkw masuk ke 403')
         return userSession.isPrivileged(toState).catch(function(error){
          console.log('wkwkw masuk ke 403 tingkat 2',error.status)

          if(error.status == 401){
            return state.go('adminLogin')
          }else if(error.status == 403){
            return state.go('adminUnprivileged')
          }else{
            return state.go('adminLogin')
          }
        })
      })
    }else{
      return userSession.isPrivileged(toState).catch(function(error){
          console.log('wkwkw masuk ke 403 tingkat 3', error.status)
          
          if(error.status == 401){
            return state.go('adminLogin')
          }else if(error.status == 403){
            return state.go('adminUnprivileged')
          }else{
            return state.go('adminLogin')
          }
        })
    }


   // userservice.isPrivileged({state: trans.to()}).then(function(respone){
   //   console.log('cek privilege', trans.to().name)

  //  })
    console.log('ini on Start', userSession.logged_in)
  })

  $transitions.onEnter({to: 'admin.**'}, function(trans, state){
    console.log("Entered " + state.name + " module while transitioning to " + trans.to().name)
    var userSession = trans.injector().get('userSession')
  console.log('wkwkw')
   
  })

  $transitions.onSuccess({}, function() {
    //  console.log("Entered " + state.name + " module while transitioning to " + trans.to().name)
     // var to = trans.to().name
    //  ;

   //  console.log('userSession', userSession.userInfo)
  //   userSession.authenticate()
  //   console.log(userSession.userInfo)
  var embel = " :: TSS"
  var title = (angular.isDefined($state.current.data) ? $state.current.data.title + embel : 'Admin LTE')
   $rootScope.title = title ;
console.log($rootScope.title)
      
    
     
  })

})

angular.module("myApp").filter('toArray', function () {
  return function (obj, addKey) {
    if (!angular.isObject(obj)) return obj;
    if ( addKey === false ) {
      return Object.keys(obj).map(function(key) {
        return obj[key];
      });
    } else {
      return Object.keys(obj).map(function (key) {
        var value = obj[key];
        return angular.isObject(value) ?
          Object.defineProperty(value, '$key', { enumerable: false, value: key}) :
          { $key: key, $value: value };
      });
    }
  };

});

angular.module("myApp").constant('BACKENDASSET','assets/backend/')


angular.module("myApp").run(['$anchorScroll', function($anchorScroll) {
  $anchorScroll.yOffset = 50;   // always scroll by 50 extra pixels
}])

angular.module("myApp").run(function ($rootScope, $timeout, $window) {
  $rootScope.$on('$routeChangeSuccess', function () {
    $timeout(function () {
      $window.scrollTo(0,0);
    }, 750);
  });
});


angular.module("myApp").filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});

/*
angular.module("myApp").config(function($routeProvider, $locationProvider) {
  $routeProvider
  .when("/", {cache: false,
    templateUrl : "home"
  })
  .when("/memberarea", {cache: false,
    templateUrl : "ng/modules/ticket/templates/ticket_list_v.html"
  })
  .when("/memberarea/ticket", {cache: false,
    templateUrl : "ng/modules/ticket/templates/ticket_list_v.html"
  })
  .when("/memberarea/ticket/:trackingId",{cache: false,
    templateUrl : "ng/modules/ticket/templates/ticket_open_v.html"
  })
  .when("/knowledgebase", {cache: false,
    templateUrl : "ng/modules/post/templates/knowledgebase_main_v.html"
  })
   .when("/knowledgebase/informasi", {cache: false,
    templateUrl : "ng/modules/post/templates/post_informasi_v.html"
  })
  .when("/knowledgebase/tutorial", {cache: false,
    templateUrl : "ng/modules/post/templates/post_tutorial_v.html"
  })
  .when("/artikel/:id/:slug", {cache: false,
    templateUrl : "ng/modules/post/templates/post_detail_v.html"
  })
  .when("/login",{cache: false,
    templateUrl: "ng/modules/user/templates/login_v.html"
  })
  .when("/logout",{cache: false,
    templateUrl: "ng/modules/user/templates/logout_v.html"
  })
  
  
     //$locationProvider.hashPrefix('');

   $locationProvider.html5Mode(true);

  
});


*/

angular.module("myApp").run([          
  '$rootScope','$location','$state','$transitions','$stateParams',/*'$templateCache',*/
function (

  $rootScope,   $location,  $state,$transitions,   $stateParams ) {

    console.log("app run")
 
    
}])




angular.module("myApp").config(function($stateProvider, $urlRouterProvider,$locationProvider) {
      $urlRouterProvider.otherwise('/');
      $locationProvider.html5Mode(true);

    $stateProvider
        // HOME STATES AND NESTED VIEWS ========================================
        .state('/', {
            url: '/',
            templateUrl: 'home'
        })

        .state('memberarea', {
            url: '/memberarea',
            controller: 'TicketAdd as vm',
            templateUrl : "ng/modules/ticket/templates/ticket_v.html",


        })
        .state('memberarea.ticketList', {
            url: '/ticket',
            controller: 'TicketTable as vm',
           templateUrl : "ng/modules/ticket/templates/ticket_list_v.html"
        })

        .state('memberarea.ticketOpen', {
            url: '/ticket/{trackingId}',
            templateUrl : "ng/modules/ticket/templates/ticket_open_v.html"
        })
        .state('knowledgebase', {
            url: '/knowledgebase',
            controller: 'PostKnowledgebaseMain as vm',
            templateUrl : "ng/modules/post/templates/knowledgebase_main_v.html",
                  data: {
                     title: 'knowledgebase'
                  }
        })
        .state('knowledgebaseInformasi', {
            url: '/knowledgebase/informasi',
            templateUrl : "ng/modules/post/templates/post_informasi_v.html",
                  data: {
                     title: 'informasi | knowledgebase'
                  }
        })
        .state('knowledgebaseTutorial', {
            url: '/knowledgebase/tutorial',
            templateUrl : "ng/modules/post/templates/post_tutorial_v.html",
                  data: {
                     title: 'tutorial | knowledgebase'
                  }
        })
        .state('openArtikel', {
            url: '/artikel/:id/:slug',
            templateUrl : "ng/modules/post/templates/post_detail_v.html"
        })
        .state('login', {
            url: '/login',
            controller: 'userLogin as main',
            templateUrl: "ng/modules/user/templates/login_v.html",
                  data: {
                     title: 'Login'
                  }
        })
        .state('logout', {
            url: '/logout',
            templateUrl: "ng/modules/user/templates/logout_v.html",
                  data: {
                     title: 'Logout'
                  }

        })
        .state('memberarea.profile', {
            url: '/profile',
            controller: 'userProfileMemberarea as vm',
            templateUrl: "ng/modules/user/templates/profile_v.html",
             data: {
                     title: 'Profile | Memberarea'
                  }
        })
           .state('memberarea.profileedit', {
            url: '/profile/edit',
            controller: 'userProfileMemberareaEdit as vm',
            templateUrl: "ng/modules/user/templates/profile_edit_v.html",
             data: {
                     title: 'Memberarea Edit Profile'
                  }
        })
            .state('memberarea.setting', {
            url: '/setting',
            controller: 'userSettingMemberarea as vm',
            templateUrl: "ng/modules/user/templates/setting_v.html",
            data: {
                     title: 'Setting | Memberarea '
                  }
        })
             .state('admin', {
              url: '/admin/',
              abstrack:true,
              redirectTo: 'admin.dashboard',
              resolve: {
                uSess : function(userSession){
                  return userSession.init().then(function(respone){
                     
                    userSession.set_is_logged_in(respone.data.logged_in);
                    userSession.set_is_logged_in_admin(respone.data.logged_in_admin);
                    userSession.set_user(respone.data.user);
                    userSession.set_menu(respone.data.menu);
                    
                    return userSession
                  })
                }
                  
                
              },
              views:{
                 'header' :{
                  controller:'userAdminHeader as vm',
                  templateUrl: "ng/modules/user/templates/admin/header_admin_v.html"
                },
                'sidebar':{
                  controller: "userAdminMenu as vm",
                  templateUrl: "ng/modules/user/templates/admin/sidebar_admin_v.html"
                },
                'content':{
                  template: "<div ui-view='content'></div>"
                },
                'control-sidebar':{
                  templateUrl: "ng/modules/user/templates/admin/control_sidebar_admin_v.html"
                }
              }
        })
            .state('admin.dashboard', {
              url: 'dashboard',

               views:{
                'content@admin':{
                  controller: "userAdminDashboard as vm",
                   templateUrl: "ng/modules/user/templates/admin/dashboard_admin_v.html"
                
                }
              },
              data: {
                     title: 'Dashboard Priority | AdminPanel'
                  }
        })

                  .state('admin.settingPrivilege', {
              url: 'setting/privilege',
              views:{
                'content@admin':{
                   controller: "userAdminSettingPrivilege as vm",
                   templateUrl: "ng/modules/user/templates/admin/setting_privilege_admin_v.html"
                
                }
              },
              data: {
                     title: 'Setting Privilege | AdminPanel'
                  }
        })

                     .state('admin.settingProfile', {
              url: 'setting/profile',
              views:{
                'content@admin':{
                   controller: "userAdminSettingProfile as vm",
                   templateUrl: "ng/modules/user/templates/admin/setting_profile_admin_v.html"
                
                }
              },
              data: {
                     title: 'Setting Profile | AdminPanel'
                  }
        })

                    .state('admin.masterdataUser', {
              url: 'masterdata/user',
              views:{
                'content@admin':{
                   controller: "userAdminMasterdataUser as vm",
                   templateUrl: "ng/modules/user/templates/admin/masterdata_user_admin_v.html"
                
                }
              },
              data: {
                     title: 'Master Data User | AdminPanel'
                  }
        })

                      .state('admin.masterdataGroup', {
              url: 'masterdata/group',
              views:{
                'content@admin':{
                   controller: "userAdminMasterdataGroup as vm",
                   templateUrl: "ng/modules/user/templates/admin/masterdata_group_admin_v.html"
                
                }
              },
              data: {
                     title: 'Master Data User Group | AdminPanel'
                  }
        })

                                      .state('admin.ticketList', {
              url: 'ticket/list',
              views:{
                'content@admin':{
                   controller: "userAdminTicketList as vm",
                   templateUrl: "ng/modules/ticket/templates/admin/ticket_list_admin_v.html"
                
                }
              },
              data: {
                     title: 'Ticket List | AdminPanel'
                  }
        })

                              .state('admin.taskList', {
              url: 'task/list',
              views:{
                'content@admin':{
                   controller: "userAdminTaskList as vm",
                   templateUrl: "ng/modules/ticket/templates/admin/task_list_admin_v.html"
                
                }
              },
              data: {
                     title: 'Ticket List | AdminPanel'
                  }
        })

                              .state('admin.myTask', {
              url: 'task/mytask',
              views:{
                'content@admin':{
                   controller: "userAdminTaskList as vm",
                   templateUrl: "ng/modules/ticket/templates/admin/task_list_admin_v.html"
                
                }
              },
              data: {
                     title: 'Ticket List | AdminPanel'
                  }
        })

                                  .state('admin.myTicket', {
              url: 'ticket/myticket',
              views:{
                'content@admin':{
                   controller: "userAdminTicketList as vm",
                   templateUrl: "ng/modules/ticket/templates/admin/ticket_list_admin_v.html"
                
                }
              },
              data: {
                     title: 'Ticket List | AdminPanel'
                  }
        })
                                                                .state('admin.ticketOpen', {
              url: 'ticket/{trackingId}',
              views:{
                'content@admin':{
                   controller: "userAdminTicketOpen as vm",
                   templateUrl: "ng/modules/ticket/templates/admin/ticket_open_admin_v.html"
                
                }
              },
              data: {
                     title: 'Ticket Open  | AdminPanel'
                  }
        })

                                                                 .state('admin.taskOpen', {
              url: 'task/{taskId}',
              views:{
                'content@admin':{
                   controller: "userAdminTaskOpen as vm",
                   templateUrl: "ng/modules/ticket/templates/admin/task_open_admin_v.html"
                
                }
              },
              data: {
                     title: 'Task Open | AdminPanel'
                  }
        })


                      .state('admin.masterdataTicketPriority', {
              url: 'masterdata/ticket/priority',
              views:{
                'content@admin':{
                   controller: "userAdminMasterdataTicketPriority as vm",
                   templateUrl: "ng/modules/user/templates/admin/masterdata_ticket_priority_admin_v.html"
                
                }
              },
                  data: {
                     title: 'Master Data Ticket Priority | AdminPanel'
                  }
        })

                                   .state('admin.report', {
              url: 'report',
              views:{
                'content@admin':{
                   controller: "userAdminReport as vm",
                   templateUrl: "ng/modules/user/templates/admin/report_admin_v.html"
                
                }
              },
                  data: {
                     title: 'Report | AdminPanel'
                  }
        })



              .state('adminLogin', {
            url: '/admin/login',
    
          
                controller: 'userAdminLogin as vm',
                templateUrl: "ng/modules/user/templates/admin/login_admin_v.html",
                 data: {
                     title: 'Login Admin'
                  },
                resolve: {

                }
              
            }

            
        )


              .state('adminLogout', {
            url: '/admin/logout',
           
                controller: 'userAdminLogout as vm',
                //templateUrl: "ng/modules/user/templates/admin/login_admin_v.html"
              
            
            
        })

                    .state('adminUnprivileged', {
              url: '/403',
                   //controller: "userAdminMasterdataUser as vm",
                   templateUrl: "ng/modules/user/templates/admin/unprivileged_admin_v.html"
                
             
        })



                      .state('admin.log', {
              url: 'log',
              views:{
                'content@admin':{
                   controller: "userAdminLog as vm",
                   templateUrl: "ng/modules/user/templates/admin/log_admin_v.html"
                
                }
              },
                  data: {
                     title: 'Logs | AdminPanel'
                  }
        })


                  .state('admintest', {
              url: '/admin/test',
              
                
                   controller: "userAdminLog as vm",
                   templateUrl: "ng/modules/user/templates/admin/log_admin_v.html",
                
              
              
                  data: {
                     title: 'TEst | AdminPanel'
                  }
        })








        
        // ABOUT PAGE AND MULTIPLE NAMED VIEWS =================================
        .state('about', {
            // we'll get to this in a bit       
        });

});


angular.module("myApp").controller("userInfo", function($scope) {
    $scope.firstName = "John";
    $scope.lastName = "Doe";
});

angular.module("myApp").controller("MainCtrl", function($scope) {
    $scope.firstName = "John";
    $scope.lastName = "Doe";
});

angular.module("myApp").controller("PostList", function($scope) {
    $scope.firstName = "John";
    $scope.lastName = "Doe";
});

angular.module("myApp").controller("PostDetail", function($scope) {
    $scope.firstName = "John";
    $scope.lastName = "Doe";
});


angular.module("myApp").config(function(paginationTemplateProvider) {
    paginationTemplateProvider.setPath('ng/common/pagination-html.html');
});

angular.module("myApp").filter('htmlToPlaintext', function() {
    return function(text) {
      return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
  }
);

angular.module("myApp").filter('dateToISO', function() {
  return function(input) {
    return new Date(input).toISOString();
  };
});


angular.module("myApp").service('my_utility', function(){

 this.arr_id_as_key = function(data,col){
    cols = 'id'
    if(col != undefined){
      cols = col
    }

    var d = {};
    //var toBeKey = col
    console.log('my_utility')
    for (var key in data) {                         
      var s = 'id_' + data[key][cols]
      d[s] = data[key]
      //console.log(data[key])
    }
    console.log(d)
    return d
  }
})

angular.module("myApp").service('my_session_thing', function($http){
  this.get_user_info = function(id = {}){
    var data = $.param({
                his_token: id['cct'],
                data: id.id
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
    //var value = []
    return $http.post("user/get_user_info",data,config)
            
  }
})


angular.module("myApp").directive('titlechange', ['$rootScope', '$timeout','$transitions',
  function($rootScope, $timeout,$transitions) {
    return {
      restrict: 'A',
      
      template: '{{title}}' ,
      link : function(scope, element, attrs){
        console.log($rootScope.title);
        $transitions.onSuccess({},function(){
            console.log($rootScope.title);
            scope.title = $rootScope.title
        })
      }
 
    };
  }
]);


angular.module("myApp").directive('captcha',function($http,$sce,$rootScope){
  return {
    restrict: 'E',
    scope: {
      captcha : '@',
      input : '=',
      error: '='

    },
    template: `<div style="display:flex; justify-content:flex-start;" >
                  <input class="form-control" ng-model="input" style="width: 75px;height: 30px;margin-right: 5px;" ng-if="input != undefined" ></input>
                  <div ng-bind-html="img" style="width:122px;display:block"></div>
                  <button style="height:30px;" class="btn btn-success" ng-click="getCaptcha()" >
                      <i class="fa fa-refresh"></i>
                  </button>
                  <input disabled class="form-control" ng-model="error" style=" border:none;width: 200px;height: 30px;margin-left: 5px;" ng-if="(error != undefined) && (error != '' )"></input>

                </div>`,
    link: function(scope){
      scope.getCaptcha = function(){
          var data = $.param({
              imgOnly: '1'

            });
    
          var config = {
              headers : {
                  'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
              }
          }

          $http.post("captcha/index/", data, config).then(function(respone){
              scope.img =  $sce.trustAsHtml(respone.data.data.captchaImg)
              scope.imgName = respone.data.data.captchaName
              console.log(respone.data.data.captchaImg)
          },function(respone){

          })
      }

      scope.getCaptcha();
      $rootScope.$on('captcha_refresh', function(e, eArgs) {
         scope.getCaptcha();
      })
      
    }
  }
})