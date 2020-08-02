angular.module("user").controller('userAdminLogout', function(userSession,$state,$rootScope,$location,$window,userService,$filter,Upload, ticketService,$timeout,$mdDialog,my_utility,my_session_thing) {
    var vm  = this;
    vm.loading = {logout: 0}
    vm.message = "";
    vm.data = {remember: false}
    vm.logout = function (){
      vm.loading.logout = 1;
        userService.logout_admin(vm.data).then(function (respone){
            if(respone.data.status){
              vm.message = respone.data.message;
              userSession.logout();
              $timeout(function() {
                 
                 $state.go('adminLogin')
              }, 750);
              
            }else{
              console.log('error : lol')
               $state.go('adminLogin')
              vm.message = respone.data.message;
            }
        })
    }


    vm.logout()
    //$rootScope.$broadcast('user_nav_refresh', {myArg: 'Hoho'});
});

