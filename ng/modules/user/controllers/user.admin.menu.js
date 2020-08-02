angular.module("user").controller('userAdminMenu', function(uSess,$interval,$transitions,$state,BACKENDASSET,$rootScope,$location,$window,userService,$filter,Upload, ticketService,$timeout,$mdDialog,my_utility,my_session_thing) {

	var vm = this;
	vm.user = {}
	vm.BACKENDASSET = BACKENDASSET
	vm.state = $state
	vm.groups = uSess.groups
	console.log(vm.groups, 'ini group')
	vm.menu_open = function(item){
		
		angular.forEach(vm.menu, function(value,key){
			if(value.id == item.id){
				item.open = !item.open
				
			}else{
				value.open = 0
			}
		})
		
	}



	vm.fetch = function(){
		
			if(uSess.logged_in_admin){
			
						vm.fetch_menu()
						vm.fetch_profil()
						
			
			}else{
				$state.go('adminLogin')
		}
	}
$interval(function(){
	vm.fetch()
}, 600000);
vm.fetch_menu = function(){
	
							vm.menu = uSess.menu.level_0;
							console.log("menu ", vm.menu)
							vm.check_state()
						
}

vm.fetch_profil = function(){
	vm.user = uSess.user
	vm.groups = uSess.groups
}

$transitions.onSuccess({}, function($state, $transition) {
  vm.fetch_menu()
  console.log('11111')
})

$rootScope.$on('refresh_sidebar_menu', function(event,data){
	vm.fetch_menu();
})
  
$rootScope.$on('refresh_sidebar_profil', function(event,data){
	vm.fetch_profil();
})







	vm.check_state = function(){
		angular.forEach(vm.menu, function(value,key){
			if(value.child.length > 0){
				value.has_active_childs = 0
				angular.forEach(value.child, function(value_2,key_2){
					if(vm.state.is(value_2.state)){
						value.isState = 1
						value_2.isState = 1
						value.has_active_childs = 1
						value.open = 1
					}else{
						if(value.has_active_childs){
							value.isState = 1
							value.open = 1
						}else{
							value.isState = 0
							value.open = 0
						}
						value_2.isState = 0
					}
				})
			}else{
				if(vm.state.is(value.state)){
						value.isState = 1

					}else{
						value.isState = 0
					}
			}
		})
		console.log(vm.menu,'   ', vm.state.is())
	}

	vm.fetch()
})