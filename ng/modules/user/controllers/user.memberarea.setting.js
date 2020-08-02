angular.module("user").controller('userSettingMemberarea', function($stateParams,$rootScope,$location,$window,userService,$filter,Upload, userService,$timeout,$mdDialog,my_utility,my_session_thing) {
	var vm = this;
	
	vm.fetch = function(){
		userService.is_logged_in().then(function(respone){
        $timeout(function() {
          vm.is_logged_in = respone.data;
          if(vm.is_logged_in){
            my_session_thing.get_user_info({cct:6}).then(function(respone){
            vm.user_id = respone.data.id;
           	userService.getMemberareaSetting(vm.user_id).then(function(respone){
           		vm.setting = my_utility.arr_id_as_key(respone.data.data, 'name');
				vm.setting_default = respone.data.data_default;
				angular.forEach(vm.setting_default, function(value, key) {
					if(!angular.isUndefined(vm.setting['id_' + value.name])){
						value.default_value = {id: vm.setting['id_' + value.name].value, value: vm.setting['id_' + value.name].value}
						
					}else{
						value.default_value = {id: value.default_value, value: value.default_value}
					}

					console.log(value.name, value)

				})
			})


            })
        }
    })
    })
	}


vm.action_update = function(){
	var data =  []
	angular.forEach(vm.setting_default, function(value,key){
		data.push({user_id: vm.user_id, setting_id : value.id, value: value.default_value.value}) 
	})

	userService.update_memberarea_setting(data).then(function(respone){
		vm.fetch();
	})

	console.log('data bro', data)
}

vm.fetch()
	
})

