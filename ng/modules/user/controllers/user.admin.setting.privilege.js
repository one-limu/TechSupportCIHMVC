angular.module("user").controller('userAdminSettingPrivilege', function($state,userSession,$rootScope,$location,$window,userService,$filter,Upload, ticketService,$timeout,$mdDialog,my_utility,my_session_thing) {
	var vm = this
	vm.fetch = function(){

		  
						userService.get_data_setting_privilege().then(function(respone){
							vm.groups = respone.data.groups
							vm.privileges = respone.data.privileges

							console.log(vm.groups, "dasd" , vm.privileges)
						})
					
	}

	vm.set_edit = function(item){
		vm.selected_group = item.id
		vm.selected_group_name = item.name
		vm.set_edit_item = item;
		vm.do_edit_do = 0		
	}


	vm.check = function(item){
		item.set = !item.set
		console.log(item.privileges_name, item)
		vm.do_edit_do = 1
	}
	vm.cancel_edit = function(){
		vm.selected_group = ''
		vm.do_edit_do = 0
	}
	vm.do_edit = function(){
		vm.do_edit_do = 1
		vm.privileges_temp = angular.copy(vm.privileges) 
		angular.forEach(vm.privileges_temp, function(val,key){
			val.set = 0
			angular.forEach(vm.set_edit_item.privileges, function(val2,key2){
				if(val.id == val2.id_privileges){
					val.set = 1
				}else{
					//
				}
			})
		})
		vm.set_edit_item = {id: vm.selected_group, name: vm.selected_group_name, privileges : vm.privileges_temp}
		//vm.set_edit({id: vm.selected_group, name: vm.selected_group_name, privileges : vm.privileges_temp})
		console.log('vm.privileges_temp', vm.privileges_temp)
	}

	vm.save_edit = function(){
		var toSave = []
		vm.save_success = 0
		console.log('set_edit_item', 'set_edit_item' , vm.set_edit_item)
		angular.forEach(vm.set_edit_item.privileges, function(val,key){
			toSave.push({id_privileges: val.id, id_group: vm.selected_group, set: val.set})
		})

		userService.updateGroupRoleHas(toSave).then(function(respone){
			vm.fetch()
			vm.do_edit_do = 0
			vm.save_success = 1
			vm.selected_group = 0
			   userSession.authenticate().then(function(respone){
                  vm.fetch()
                  $rootScope.$broadcast('refresh_sidebar_menu', 'Broadcast')
                })

                  
			
		})
	}

	vm.fetch()
})