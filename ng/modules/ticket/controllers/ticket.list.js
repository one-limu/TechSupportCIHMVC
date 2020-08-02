angular.module("ticket").controller('TicketTable', function($rootScope,$location,$window,userService,$filter,Upload, ticketService,$timeout,$mdDialog,my_utility,my_session_thing) {
    var vm  = this;
    vm.list_ticket = [];
    //vm.cct = $("input[name=his_token]").val()
    vm.cct = 'his_token';
    vm.user_id = ""
    vm.add_data = {};
    vm.update_data = {};
    vm.detail_data = {};
    vm.filter = {
                      filter:{like: {} , equal:{creator_id:vm.user_id} ,range:{}},
                      limit:{limit:'5' , offset:'0'},
                      order:{col:'tanggal_update',val:'DESC'}
    };
    vm.pagination = {cur_page: '1', total_row:'0'}; //
    vm.loading = {add:'0',update:'0',delete:'0',list:'0'};//tygmmmmmmmmmmmmmmmmmmjkkkadd: 0,update:0,delete:0,list:0
    vm.selected = [];
    vm.displayedPerPage = {
      
    
    }
    vm.picFile = []
    vm.attachment = []
    vm.finishUpload = 0;
    vm.finishAdd = 1;
    vm.inserted_ticket ={}
    vm.is_logged_in = 0;
    vm.saving = 0;
 

    vm.setcheck = function(){
      console.log(vm.list_ticket.list)
    }

    vm.deleteticket = function(){
      
    }

    vm.check = {
      selecting: false,
      allchecked: false,
      checkselecting: {
        do: function(){
            var tru = false;
            angular.forEach(vm.list_ticket.list, function(value, key) {
          if (value.checked) {
            tru =true;
          }
            if(tru){
              vm.check.selecting = true;
            }else{
              vm.check.selecting = false;
            }
        })
        }
      },
    
      all: function(){
        angular.forEach(vm.list_ticket.list, function(value, key) {
          value.checked = true;
          vm.check.selecting = true
        })

      },
      none: function(){
        angular.forEach(vm.list_ticket.list, function(value, key) {
          value.checked = false;
          vm.check.selecting = false
        })
      },
      read: function(){
        angular.forEach(vm.list_ticket.list, function(value, key) {
          if(value.user_read_status == 1){
             value.checked = true;
          }else{
            value.checked = false;
          }

        })
          vm.check.checkselecting.do()

      },
      notread: function(){
        angular.forEach(vm.list_ticket.list, function(value, key) {
          if(value.user_read_status == 0){
             value.checked = true;
          }else{
            value.checked = false;
          }
        })
          vm.check.checkselecting.do()
      },
      finished: function(){
        angular.forEach(vm.list_ticket.list, function(value, key) {
          if(value.status_id == 1){
             value.checked = true;
          }else{
            value.checked = false;
          }
        })
          vm.check.checkselecting.do()
      },
      notfinished: function(){
        angular.forEach(vm.list_ticket.list, function(value, key) {
          if(value.status_id == 0){
             value.checked = true;
          }else{
            value.checked = false;
          }
        })
          vm.check.checkselecting.do()
      }

    }



    
    // upload later on form submit or something similar
   

    // upload on file select or drop
   




    vm.fetch = function(firsttime = false){


      userService.is_logged_in().then(function(respone){
        vm.is_logged_in = respone.data;
           if(vm.is_logged_in){
               vm.loading.list = '1';
         $timeout(function() {
          if(vm.is_logged_in){
              my_session_thing.get_user_info({cct:vm.cct}).then(function(respone){
                vm.filter.filter.equal.creator_id = respone.data.id
                vm.user_id = respone.data.id
          
                     userService.getMemberareaSetting(vm.user_id).then(function(respone){
                    if(firsttime){
                         vm.setting = my_utility.arr_id_as_key(respone.data.data, 'name');
                      vm.setting_default = respone.data.data_default;
                      angular.forEach(vm.setting_default, function(value, key) {
                        if(!angular.isUndefined(vm.setting['id_' + value.name])){
                          value.default_value = vm.setting['id_' + value.name].value
                        }else{
                          value.default_value = value.default_value
                        }
                        
                        switch(value.name){
                          case 'sort_ticket' :
                            vm.filter.order.col = value.default_value
                            break;
                          case 'sort_ticket_val' :
                            vm.filter.order.val = value.default_value
                            break;
                          case 'display_perpage' :
                            vm.displayedPerPage.selected = {id: angular.isUndefined(value.default_value) ? value.default_value : '5', value: angular.isUndefined(value.default_value) ? value.default_value : '5'}
                            vm.displayedPerPage.options = value.option
                            console.log('adasdasd', vm.displayedPerPage)
                            break;

                        }

                      })
                    }
                    
                vm.filter.limit.limit = vm.displayedPerPage.selected.id
                param = {
                    cct: vm.cct,
                    data: {filter: vm.filter}
                }

                ticketService.get_list_ticket(param).then(function successCallback(respone){
                  vm.list_ticket = respone.data['data'];
                  vm.list_ticket.addition.t_category = my_utility.arr_id_as_key(vm.list_ticket.addition.t_category)
                  vm.list_ticket.addition.t_priority = my_utility.arr_id_as_key(vm.list_ticket.addition.t_priority)
                  console.log(vm.list_ticket)
                  vm.pagination.total_row = respone.data['total_row']
                  vm.displayed = respone.data['displayed']
                  vm.loading.list = 0
                  vm.check.checkselecting.do()

             

                 }, function errorCallback(respone, status){
                    console.log('status',respone);

                 })

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

   

    vm.set_order = function(order){
      
      if(vm.filter.order.col == order){
        if(vm.filter.order.val == 'ASC'){
          vm.filter.order.val = 'DESC'
        }else{
          vm.filter.order.val = 'ASC'
        }
      }
      vm.filter.order.col = order;
      vm.fetch()
    }
    vm.tes = function(){
      //console.log(vm.list_ticket.addition.t_category)
    }
    
    vm.toggle = function (item,list) {
     console.log(item)
        var idx = list.indexOf(item);
        if (idx > -1) {
          list.splice(idx, 1);
        }
        else {
          list.push(item);
        }
             console.log(vm.selected);
        
      };

      vm.exists = function (item, list) {
         //console.log(vm.selected)
          return list.indexOf(item) > -1;
       
      };

     vm.pageChanged = function(newPage) {
        vm.pagination.cur_page = newPage
        vm.filter.limit.offset = (vm.filter.limit.limit * (vm.pagination.cur_page - 1))
        vm.fetch()
    };

    vm.changeStatus = function(event_id){
        var arr = []
        var count = 0;
        angular.forEach(vm.list_ticket.list, function(value, key) {
          if(value.checked){
            console.log(value)
            arr.push(value.ticket_id)
          }
          console.log(arr)

          
        })

       for (var i = 0; i < arr.length; i++) {
           vm.setTicketEventReply(event_id,arr[i])
              count++;
              if (count == arr.length) {
                vm.fetch();

              }
       }


    }

    vm.setTicketEventReply = function(id,ticket_id,content=""){
      var item = {
          replier_id: vm.user_id,
          reply_event_id: id,
          ticket_id: ticket_id,
          content:content
      }

      ticketService.setTicketEventReply(item).then(function(respone){

        //vm.fetch()
      })
      
    }

 

    

  vm.fetch(true);

});

