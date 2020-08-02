angular.module("user").controller('userLogin', function($rootScope,$location,$window,userService,$filter,Upload, ticketService,$timeout,$mdDialog,my_utility,my_session_thing) {
    var vm  = this;
    vm.loading = {login: 0}
    vm.message = "";
    vm.data = {identity: "", password:'', remember: true}
    vm.login = function (){
      vm.loading.login = 1;
        userService.login(vm.data).then(function (respone){
            if(respone.data.status){
              vm.message = respone.data.message;
              $timeout(function() {
                  vm.loading.login = 0
                  //$window.location.href = ''
                  $rootScope.$broadcast('user_nav_refresh', {myArg: 'Hoho'});
                  $location.path('')
              }, 750);
              
            }else{
              console.log('error',respone.data.message)
              vm.message = respone.data.message;
            }
        })
    }
    $rootScope.$broadcast('user_nav_refresh', {myArg: 'Hoho'});
});

