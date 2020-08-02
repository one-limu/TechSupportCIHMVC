angular.module("user").service('userSession', function($localStorage,$http,$state,userService) {
	var data = {};

	

	data.init = function(){
		return userService.get_session()
	}

	data.set_is_logged_in = function(item){
		//data.logged_in = item
		$localStorage.logged_in = item
		data.logged_in = $localStorage.logged_in
	}

	data.set_is_logged_in_admin = function(item){
		//data.logged_in_admin = item
		$localStorage.logged_in_admin = item
		data.logged_in_admin = $localStorage.logged_in_admin
	}

	data.set_user = function(item){
//		data.user = item
		$localStorage.user = item
		data.user = $localStorage.user
	}
	data.set_menu = function(item){
//		data.menu = item
		$localStorage.menu = item
		data.menu = $localStorage.menu
	}
	data.set_privileges = function(item){
//		data.menu = item
		$localStorage.privileges = item
		data.privileges = $localStorage.privileges
	}
	data.set_groups = function(item){
		$localStorage.groups = item
		data.groups = $localStorage.groups
	}
	data.privileges = []
	data.groups = []

//	data.logged_in = $sessionStorage.logged_in
	//data.logged_in_admin = $sessionStorage.logged_in_admin
	//data.user = $sessionStorage.user
	//data.menu = $sessionStorage.menu

	data.logout = function(){
					data.set_is_logged_in(0);
                    data.set_is_logged_in_admin(0);
                    data.set_user(0);
                    data.set_menu(0);
                    data.set_privileges([]);
                    data.set_groups([]);
                    console.log(data)
                    $localStorage.$sync()
                    $localStorage.$apply()
	}

	data.authenticate = function(){
		return data.init().then(function(respone){
                    data.set_is_logged_in(respone.data.logged_in);
                    data.set_is_logged_in_admin(respone.data.logged_in_admin);
                    data.set_user(respone.data.user);
                    data.set_menu(respone.data.menu);
                    data.set_privileges(respone.data.privileges);
                    data.set_groups(respone.data.groups);
                    if(!data.logged_in){
                    	return data.reject()
                    }else{
                    	return 1
                    }
	})
}

data.isPrivileged = function(item){
	return userService.isPrivileged({state:item}).then(function(respone){
		console.log(respone.status,'asdasdas')
		if(respone.status != '200' ){
			return userService.reject(new Error())
		}else{
			return respone.data
		}
	})
}
	//data.init()

	return data


})