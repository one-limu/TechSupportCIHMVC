angular.module("user").controller('userAdminHeader', function(uSess,userSession,BACKENDASSET,$state,$rootScope,$location,$window,userService,$filter,Upload, ticketService,$timeout,$mdDialog,my_utility,my_session_thing) {
    var vm  = this;
    vm.loading = {login: 0}
    vm.message = "";
    vm.data = {remember: false}
    vm.BACKENDASSET = BACKENDASSET
    vm.userdata = uSess.user

    vm.uSess = uSess
    console.log(uSess,'ini Usess')
    console.log(userSession,'ini userSession')
        
    vm.fetch = function(){
    		vm.userdata = uSess.user
    }
    vm.fetch()

    $rootScope.$on('refresh_sidebar_profil', function(event,data){
	vm.fetch();
})

    console.log('header kang')
   
    //$rootScope.$broadcast('user_nav_refresh', {myArg: 'Hoho'});
});

