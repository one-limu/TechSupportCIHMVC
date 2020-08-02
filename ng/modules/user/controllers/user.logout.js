angular.module("user").controller('userLogout', function(userSession,$rootScope,$location,$window,userService,$filter,Upload, ticketService,$timeout,$mdDialog,my_utility,my_session_thing) {
    var vm  = this;
    
    vm.loading = {}
    vm.logout = function(){
       
    }

    vm.init = function(){
        vm.loading.spinner = 1
        $timeout(function() {
             userService.logout().then(function(respone){
            if(respone.data.status){
            vm.loading.spinner = 0
              $timeout(function() {
                  $rootScope.$broadcast('user_nav_refresh', {myArg: 'Hoho'});
                  userSession.logout()
                $location.path('')
              }, 500);
            }else{
              console.log('error',respone.data.message)
            }
        })

        }, 1000);
    }

    vm.init()
});

