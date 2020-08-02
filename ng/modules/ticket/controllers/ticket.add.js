  angular.module("ticket").controller('TicketAdd', function($stateParams,$location,$rootScope, Upload, $timeout, $mdDialog, userService,
my_session_thing, $filter, ticketService, my_utility) {
     var vm  = this;
     vm.loading = {}
     vm.filter = {}
     vm.t_category = {}
     vm.t_priority = {}
     vm.add_data = {}
     vm.finishAdd = 1
        vm.filter = {
                      filter:{like: {} , equal:{creator_id:vm.user_id} ,range:{}},
                      limit:{limit:'5' , offset:'0'},
                      order:{col:'tanggal_update',val:'DESC'}
    };
     vm.pagination = {cur_page: '1', total_row:'0'}; //

      vm.fetch = function(){


      userService.is_logged_in().then(function(respone){
        vm.is_logged_in = respone.data;
           if(vm.is_logged_in){
               vm.loading.list = '1';
         $timeout(function() {
          if(vm.is_logged_in){
              my_session_thing.get_user_info({cct:vm.cct}).then(function(respone){
                vm.user_id = respone.data.id
                vm.t_priority.config = {active: 1, all: 0}
                vm.t_category.config = {active: 1, all: 0}
                ticketService.get_ticket_category(vm.t_category.config).then(function(respone){

                  vm.t_category.option = respone.data.data
                  vm.t_category.option = my_utility.arr_id_as_key(vm.t_category.option)
                  console.log('ddddddddd',vm.t_category.option)
                })          
                ticketService.get_ticket_priority(vm.t_priority.config).then(function(respone){
                  vm.t_priority.option = respone.data.data
                    
                  //vm.t_priority.option = my_utility.arr_id_as_key(vm.t_priority.option)
                })          
                })

            
         }else{
          $location.path('login')
         }
            

           
         }, 500);
                 }else{
              $location.path('login')
             }
      })

   


     
      
    } 

    vm.fetch()
 vm.set_kategori = function(a){
      vm.add_data.kategori_id = a;
      console.log(a);
    }

  vm.form_add = function() {
      vm.picFile = {}
      vm.add_data = {}
      vm.selected = []
      vm.captcha = ''
       vm.finishUpload = 0;
      vm.finishAdd = 0;
          vm.selectedBahan =[]
      vm.loading.add = 1;
      $timeout(function() {
          param = {cct: vm.cct}
        
          
       
        vm.loading.add = 0;

        $mdDialog.show({
          controller: DialogController,
          templateUrl: 'ng/modules/ticket/templates/modal/add_ticket.html',
          parent: angular.element(document.body),
       
          controllerAs: 'vm',
          fullscreen: vm.customFullscreen // Only for -xs, -sm breakpoints.
        })
        .then(function(answer) {
          vm.status = 'You said the information was "' + answer + '".';
        }, function() {
          vm.status = 'You cancelled the dialog.';
        });

        
      }, 500);

       
      };


  function DialogController($mdDialog) {

    vm.hide = function() {
      $mdDialog.hide();
    };

    vm.cancel = function() {
      $mdDialog.cancel();
    };

    vm.answer = function(answer) {
      $mdDialog.hide(answer);
    };

     angular.forEach(vm.t_priority.option, function(value,key){
                    value = {id: value.id, nama: value.nama, default: value.default}
                    console.log("dis is value  " + value.id, value)
                    if(value.default  == '1'){

                      vm.t_priority.default = value
                      console.log("yang jadi default " + value.id, vm.add_data.prioritas_id)
                    }
                  })

    var dt = this
    dt.vm = vm
    dt.vm.picFile = []
    console.log('vm', dt)


  }


   vm.upload = function (file) {

        Upload.upload({
            url: 'ticket/upload_attachment',
            data: {file: file}
        }).then(function (resp) {
          
          var data = resp.data
          file.path = data.path
          file.path_tmp = data.path_tmp
          file.size = data.size
          vm.attachment.push({nama:data.name,ext:data.ext,path:data.path,size:data.size,uploader:vm.user_id,path_tmp:data.path_tmp})
          console.log('attachment',vm.attachment)
          vm.finishUpload = 1;
           // console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data.newFilename);
        }, function (resp) {
            console.log('Error status: ' + resp.status);
        }, function (evt) {
            file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            console.log(file)
            //var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
           // console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
        });
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

    vm.deleteQueue =function(file){
      var id = vm.picFile.indexOf(file)
      console.log(id);
      vm.picFile.splice(id,1)
      console.log('picFile',vm.picFile)
      vm.attachment.splice(id,1)
      console.log('attachment',vm.attachment)
    }

   vm.action_add  = function(){
      vm.add_data.creator_id = vm.user_id
      vm.add_data.prioritas_id = vm.t_priority.default.id 
     vm.saving = 1;
      param = {
        cct: vm.cct,
        data: {data:vm.add_data,attachment:vm.attachment,captcha:vm.captcha}
      }
  
      console.log(param)
      vm.loading.add = !vm.loading.add
      $timeout(function() {
        //vm.uploadFiles
        ticketService.add_ticket(param).then(function(respone){
            var status = respone.data.status
            if(status == '0') {
              console.log('message',respone.data.message)
               $rootScope.$broadcast('captcha_refresh', {myArg: 'Hoho'});
               vm.loading.add = !vm.loading.add
               vm.errorMessage = respone.data.message
               vm.saving = 0;
            }else{
                $timeout(function() {
                  vm.errorMessage = ""
            vm.loading.add = !vm.loading.add
            vm.attachment = []
            vm.picFile = []
            vm.add_data = []
            vm.finishAdd = 1
            vm.saving = 0;
              vm.inserted_ticket = respone.data.inserted_ticket
              console.log(vm.inserted_ticket)
              vm.fetch();  
            
            //$mdDialog.hide()
            
          }, 500);
        
            }
     })  }, 500);
   

    }
          vm.close_form = function(){
      vm.finishAdd = 1;
      $mdDialog.hide();
    }
})