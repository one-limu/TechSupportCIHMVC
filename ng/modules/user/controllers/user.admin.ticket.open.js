angular.module("user").controller('userAdminTicketOpen', function(userSession,$stateParams,$location,$rootScope, Upload, $timeout, $mdDialog, userService,
my_session_thing, $filter, ticketService, my_utility) {
    var vm = this
    vm.ticket = []
    vm.reply = []
    vm.ticket_id = $stateParams.trackingId
    vm.user_id = ""
    vm.requester = ""
    vm.replycontent = "tyy"
    vm.captchaErr = ''
    vm.captchaInput= '2'
  vm.adding =  0
     vm.picFile = []
    vm.attachment_ticket = []
    vm.attachment = []
    vm.finishUpload = 0;
    vm.finishAdd = 1;
    vm.inserted_ticket ={}
    vm.is_logged_in = 0;
    vm.loading = {}
    console.log($stateParams)
        vm.loading = {
        add_task: {
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

    vm.fetch = function(firstime = 0){
      vm.loading.add = 1;
      userService.is_logged_in().then(function(respone){
        $timeout(function() {
          vm.is_logged_in = respone.data;
          if(vm.is_logged_in){
            my_session_thing.get_user_info({cct:6}).then(function(respone){
              vm.user_id = respone.data.id
              vm.requester = ""
              if(firstime){
                vm.requester = vm.user_id
              }
              ticketService.getFromId(vm.ticket_id,vm.requester,1).then(function(respone){
                vm.ticket = respone.data.ticket
                vm.reply  = respone.data.reply
                vm.replyLength = vm.reply.length
                vm.reply = my_utility.arr_id_as_key(vm.reply,'reply_id')
               $mdDialog.hide()
               // vm.form_change_status()
                vm.attachment_ticket = respone.data.attachment
               // console.log(vm.attachment)

                ticketService.get_ticket_status({}).then(function(respone){
                vm.ticket_status = {item : []}
                angular.forEach(respone.data, function(val,key){
                  var data = {id : val.id, name: val.name}
                  if(val.id == vm.ticket.status_id){
                    vm.ticket_status.selected = data
                  }
                  vm.ticket_status.item.push(data)
                })
                console.log(vm.ticket_status)
              })

                  ticketService.get_task({ticket_id:vm.ticket.ticket_id}).then(function(respone){
                  vm.task = respone.data
                  console.log(vm.task == true)
                 })



                 ticketService.get_ticket_category({}).then(function(respone){
                vm.ticket_category = {item : []}
                angular.forEach(respone.data.data, function(val,key){
                  var data = {id : val.id, nama: val.nama}
                  if(val.id == vm.ticket.kategori_id){
                    vm.ticket_category.selected = data
                  }
                  vm.ticket_category.item.push(data)
                })
                vm.ticket_category.reference = my_utility.arr_id_as_key(respone.data.data)
                console.log(vm.ticket_category)
              })

           
               
               vm.loading.add = 0
              })

           
            })
          }else{
            $location.path('login')
          }
        }, 750);
    
      })      

      
    }


    vm.setTicketEventReply = function(id,ticket_id,content=""){
      var item = {
          replier_id: vm.user_id,
          reply_event_id: id,
          ticket_id: ticket_id,
          content:content
      }

      ticketService.setTicketEventReply(item).then(function(respone){

        vm.fetch()
      })
      
    }

    vm.FormSetTicketEventReply = function(){
       $mdDialog.show({
          controller: DialogController,
          templateUrl: 'ng/modules/ticket/templates/modal/change_status.html',
          parent: angular.element(document.html),
       
          controllerAs: 'vm',
          fullscreen: vm.customFullscreen // Only for -xs, -sm breakpoints.
        })
    }

    vm.form_change_status = function(ev){
          $mdDialog.show({
          controller: DialogController,
          templateUrl: 'ng/modules/ticket/templates/modal/change_status.html',
          parent: angular.element(document.html),
          targetEvent : ev,
          controllerAs: 'vm',
          //fullscreen: vm.customFullscreen // Only for -xs, -sm breakpoints.
        })

          console.log('asd')
    }

       vm.form_change_category = function(ev){
          $mdDialog.show({
          controller: DialogController,
          templateUrl: 'ng/modules/ticket/templates/modal/change_category.html',
          parent: angular.element(document.html),
          targetEvent : ev,
          controllerAs: 'vm',
          //fullscreen: vm.customFullscreen // Only for -xs, -sm breakpoints.
        })

          console.log('asd')
    }

    vm.form_add_task = function(ev){
       $mdDialog.show({
          controller: DialogController,
          templateUrl: 'ng/modules/ticket/templates/modal/add_task.html',
          parent: angular.element(document.body),
          //targetEvent : ev,
          controllerAs: 'vm',
          //fullscreen: vm.customFullscreen // Only for -xs, -sm breakpoints.
        })
        console.log('asd')
    }

    vm.do_add_task = function(data){
        var to_save = data
        ticketService.add_task(to_save).then(function(respone){
          $mdDialog.hide()
          vm.fetch()

        })
    }

    vm.do_change_status = function(){
      var id = vm.ticket_status.selected.id
      var id_ticket = vm.ticket.ticket_id
      ticketService.edit_ticket_status({'ticket_id': id_ticket, val : id}).then(function(respone){
        vm.fetch()
      })
    }
    vm.do_change_category = function(){
      var id = vm.ticket_category.selected.id
      var id_ticket = vm.ticket.ticket_id
      ticketService.edit_ticket_category({'ticket_id': id_ticket, val : id}).then(function(respone){
        vm.fetch()
      })
    }

    vm.field = {
  list   : [ { col : 'id', name: 'ID'},{col : 'name', name : 'Name' },{col : 'asignee_name', 'name' : 'Penanggung Jawab'},{col: 'create_date', name: 'Tanggal Buat'}, {col: 'status_name', name: 'Status'}],
  source : 'task'
}
vm.order = {
  by : function(col){
    if(col == vm.order.item){
      this.item = '-' + col
      this.minus = 1
      console.log(vm.order)
    }else{
      this.item = col
      this.minus = 0
      console.log(vm.order)
    }
  },
  item: undefined,
  minus : 1

}

vm.filter = {
  value : {
    $ : ''
  }
}

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

    var d = (vm.ticket.status_id == 0) ? 3 : 4;
    vm.event_id = d
    var dt = this
    dt.vm = vm
    dt.task_assignee = {};

  

    dt.ts = {}
    dt.ts.ticket_id = vm.ticket.ticket_id;
    dt.ts.adder = userSession.user.id
    ///dt.ts.assignee_id = ''
    dt.ts.pesan = ''
    dt.ts.name = ''


    dt.do_add_task = function(){
       dt.ts.assignee_id = dt.task_assignee.selected.id
      vm.do_add_task(dt.ts)
    }


    dt.get_task_assignee_list = function(){
      vm.loading.add_task.start()
      userService.get_task_assignee_list().then(function(respone){
          dt.task_assignee.list = respone.data
          vm.loading.add_task.stop()
      })
    }



    dt.get_task_assignee_list();

    console.log('v123123123m', dt.user_id)
  }

      vm.writeReply = function(){
        //alert( vm.replyTicket)
          var reply = {
            ticket_id : vm.ticket.ticket_id,
            replier: vm.user_id,
            content: vm.replycontent,
            captcha: vm.captchaInput,
            attachment: vm.attachment
          }

          if (vm.replycontent != '') {
            vm.adding = 1
            ticketService.writeReply(reply).then(function(respone){
              //vm.fetch()
               var status = respone.data.status
            if(status == '0') {
              console.log('message',respone.data.message)
               
              // vm.loading.add = !vm.loading.add
               vm.captchaErr = respone.data.message
               //vm.saving = 0;
            }else{
              vm.picFile = []
              vm.replycontent = ''
              vm.captchaInput = ''
              vm.attachment_ticket = []
              vm.attachment = []
              vm.fetch()
               vm.captchaErr = ''

            }
            $rootScope.$broadcast('captcha_refresh', {myArg: 'Hoho'});
            vm.adding = 0
            });  
          }
          
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


     vm.fetch(1)


})
