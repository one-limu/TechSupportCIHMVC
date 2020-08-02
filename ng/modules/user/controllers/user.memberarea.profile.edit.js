angular.module("user").controller('userProfileMemberareaEdit', function($stateParams,$rootScope,$location,$window,userService,$filter,Upload, userService,$timeout,$mdDialog,my_utility,my_session_thing) {
	var vm = this
	console.log('lol')
	vm.tanggal_lahir = '2000/10/10'

	vm.editState = {
		profile : 0,
		password : 0,
	}
	vm.edit = {}
	vm.editStatus = {}
	vm.loading = {fetch : 1}

	vm.openedit = {
		profile : {
			open : function(){
				vm.editState.profile = 1
			},
			close : function(){
				vm.editState.profile = 0
			}
		}
	}

	vm.saveEdit =function(){
		if(vm.picFile){
			Upload.upload({
        url: 'user/upload_profile_pic',
        data: {file: vm.picFile}
        }).then(function (resp) {
          
          var data = resp.data
          
          //vm.edit.profile_pic = {path: data.path, name: data.name}
          vm.edit.profile_pic = data.path
      		vm.doSaveEdit();
          vm.finishUpload = 1;
           // console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data.newFilename);
        }, function (resp) {
            console.log('Error status: ' + resp.status);
        }, function (evt) {
            vm.picFile.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            console.log(vm.picFile)
            //var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
           // console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
        });
		}else{
			vm.doSaveEdit()
		}
	    
	
	}

	vm.doSaveEdit = function(){
		vm.edit.birth_date = new Date(vm.edit.birth_date)
		    userService.editProfile(vm.edit).then(function(respone){
          		console.log(respone.data)
          		vm.editStatus.value = 1
          		if(respone.data.status == 1){
          			
          			vm.editStatus.status = 1
          			vm.editStatus.message = respone.data.message
          			vm.editStatus.reason = ''
          			vm.fetch()
          		}
          		else{
          			
          			vm.editStatus.status = 0
          			vm.editStatus.reason = respone.data.reason
          			if(vm.editStatus.reason == 'current_password'){
          				vm.editStatus.message = respone.data.message
          			}else if(vm.editStatus.reason == 'password_mismatch'){
          				vm.editStatus.message = respone.data.message
          			}else if(vm.editStatus.reason == 'current_password_empty'){
          				vm.editStatus.message = respone.data.message

          			}
          			else{
          				vm.editStatus.message = ''
          			}

          		}

          		console.log('vm.edit.status', vm.editStatus.reason)
          	
		  })

	}

	vm.fetch = function(){
		userService.is_logged_in().then(function(respone){
        $timeout(function() {
          vm.is_logged_in = respone.data;
          if(vm.is_logged_in){
            my_session_thing.get_user_info({cct:6}).then(function(respone){
              vm.user_id = respone.data.id
              vm.tanggal_lahir = new Date(respone.data.birth_date * 1000)
              vm.userdata = respone.data
              vm.edit = {
              	id: vm.userdata.id,
              	first_name: vm.userdata.first_name,
              	last_name: vm.userdata.last_name,
              	email: vm.userdata.email,
              	website: vm.userdata.website,
              	birth_date: new Date(vm.userdata.birth_date * 1000),
              	profile_pic: vm.profile_pic,
              	password: {}

              }
              console.log('dadadada',vm.user_id)
              //vm.editStatus.value = 0
              	vm.loading.fetch = 0
              })
          }else{
            $location.path('login')
          }
        }, 750);
    
	})	
}

       vm.upload = function (file) {

 
    };
    // for multiple files:
    vm.uploadFiles = function (files,errFiles) {
        vm.picFile = files;
        vm.errFiles = errFiles;
  
        console.log('picFile',vm.picFile)
        vm.attachment = []
      if (vm.picFile && vm.picFile.length) {
        for (var i = 0; i < vm.picFile.length; i++) {
          //Upload.upload({url: 'ticket/upload_image', data: {file: vm.picFile[i]}});
          if(vm.picFile[i] != []){
            vm.upload(vm.picFile[i])
          }
        }
        // or send them all together for HTML5 browsers:
        //Upload.upload({data: {file: files}});
      }
      
    }

    vm.ddd = function(){
    	console.log(vm.picFile)
    }

vm.fetch()


})
