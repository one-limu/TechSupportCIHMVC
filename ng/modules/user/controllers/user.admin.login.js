angular.module("user").controller('userAdminLogin', function(userSession,$state,$rootScope,$location,$window,userService,$filter,Upload, ticketService,$timeout,$mdDialog,my_utility,my_session_thing) {
    var vm  = this;
   
    vm.message = "";
    vm.data = {remember: false}
    vm.error = {
      login : {
        val : false
      }
    }

    vm.loading = {
        login: {
            val: 0,
            start: function() {
                this.val = 1
            },
            stop: function() {
                this.val = 0
            },
            toggle: function() {
                if (this.val) {
                    this.stop()
                } else {
                    this.start()
                }
            }

        }
    }

    vm.login = function (){
      vm.loading.login.start()
      vm.error.login.val = false
        userService.login_admin(vm.data).then(function (respone){
          vm.loading.login.stop()
            if(respone.data.status){
              userSession.set_is_logged_in(1)
              userSession.set_is_logged_in_admin(1)
              vm.message = respone.data.message;
              vm.loginsuccess = true
//vm.loading.login = 0
                  //$window.location.href = ''
                  console.log('yey')
                  //$rootScope.$broadcast('user_nav_refresh', {myArg: 'Hoho'});
                  console.log($rootScope.from,'adsasdasdad')
                  userSession.authenticate().then(function(respone){
                    $timeout(function() {
                    if($rootScope.from){
                  
                    $state.go($rootScope.from)
                 }else{
                  
                  $state.go('admin.dashboard')
                 }   
                  }, 250);
                  })
                 
                 
              
              
            }else{
              console.log('error : lol')
              vm.message = respone.data.message;
              vm.error.login.val = true
              vm.loading.login.stop()
            }
        })
    }
    //$rootScope.$broadcast('user_nav_refresh', {myArg: 'Hoho'});
});

