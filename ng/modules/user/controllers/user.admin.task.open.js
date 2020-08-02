angular.module("user").controller('userAdminTaskOpen', function(userSession,$stateParams,$location,$rootScope, Upload, $timeout, $mdDialog, userService,
my_session_thing, $filter, ticketService, my_utility) {
    var vm = this
  
    vm.task_id = $stateParams.taskId
    vm.task = []
    vm.add = {}

    console.log('ini task id', vm.task_id)

    vm.do_add_reply = function(){
      vm.add.task_id = vm.task_id
      vm.add.replier = userSession.user.id
        ticketService.add_task_reply(vm.add).then(function(res){
          vm.add = {}
          vm.fetch();
        })
    }

    vm.fetch = function(){
      ticketService.get_task_open({task_id: vm.task_id}).then(function(res){
          //console.log(res.data)
          vm.task = res.data;
          vm.reply = vm.task.reply
          console.log(vm.task)
      })
    }


    vm.formChangeTaskStatus = function(){
       $mdDialog.show({
          controller: DialogController,
          templateUrl: 'ng/modules/ticket/templates/modal/change_status_task.html',
          parent: angular.element(document.html),
       
          controllerAs: 'vm',
          fullscreen: vm.customFullscreen // Only for -xs, -sm breakpoints.
        })
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

    
    
    var dt = this
    dt.vm = vm

    dt.status = {
      selected : [],
      list : [{id: 1 , name: 'Open' },{id: 2 , name: 'Close'}] 
    }

    if(vm.task.status_id == 1){
      dt.status.selected = dt.status.list[0]
    }else{
      dt.status.selected = dt.status.list[1]
    }

    dt.do_change_status_task = function(){
      ticketService.change_status_task({task_id: vm.task_id, status_id : dt.status.selected.id}).then(function(res){
        vm.fetch()
        $mdDialog.hide()
      })
    }

    console.log(dt.status.selected,'adasdasd')

    

    
  }

    vm.fetch()
 

})
