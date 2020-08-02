angular.module("user").controller('userAdminTaskList', function(userSession, BACKENDASSET, $state, $rootScope, $location, $window, userService, $filter, Upload, ticketService, $timeout, $mdDialog, my_utility, my_session_thing) {
    var vm = this;
    vm.list_task = [];
    //vm.cct = $("input[name=his_token]").val()
    vm.cct = 'his_token';
    vm.user_id = userSession.user.id
    vm.add_data = {};
    vm.update_data = {};
    vm.detail_data = {};
    vm.is_my = $state.is('admin.myTask')
    vm.filter = {
        filter: { like: {}, equal: { asignee:(vm.is_my ? vm.user_id : '') }, range: {} },
        limit: { limit: '5', offset: '0' },
        order: { col: 'create_date', val: 'DESC' }
    };
    vm.today = moment()
    vm.pagination = { cur_page: '1', total_row: '0' }; //
    vm.loading = {
        list: {
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

    vm.has_del = userService.has_privileges('task_delete')
    vm.has_task_assignee = userService.has_privileges('task_assignee')
    vm.has_task_assigner = userService.has_privileges('task_assigner')

    vm.selected = [];
    vm.displayedPerPage = {


    }
    vm.picFile = []
    vm.attachment = []
    vm.finishUpload = 0;
    vm.finishAdd = 1;
    vm.inserted_ticket = {}
    vm.is_logged_in = 0;
    vm.saving = 0;


    vm.setcheck = function() {
        console.log(vm.list_task.list)
    }


    vm.check = {
        selecting: false,
        allchecked: false,
        checkselecting: {
            do: function() {
                var tru = false;
                angular.forEach(vm.list_task.list, function(value, key) {
                    if (value.checked) {
                        tru = true;
                    }
                    if (tru) {
                        vm.check.selecting = true;
                    } else {
                        vm.check.selecting = false;
                    }
                })
            }
        },

        all: function() {
            angular.forEach(vm.list_task.list, function(value, key) {
                value.checked = true;
                vm.check.selecting = true
            })

        },
        none: function() {
            angular.forEach(vm.list_task.list, function(value, key) {
                value.checked = false;
                vm.check.selecting = false
            })
        },
        read: function() {
            angular.forEach(vm.list_task.list, function(value, key) {
                if (value.user_read_status == 1) {
                    value.checked = true;
                } else {
                    value.checked = false;
                }

            })
            vm.check.checkselecting.do()

        },
        notread: function() {
            angular.forEach(vm.list_task.list, function(value, key) {
                if (value.admin_read_status == 0) {
                    value.checked = true;
                } else {
                    value.checked = false;
                }
            })
            vm.check.checkselecting.do()
        },
        finished: function() {
            angular.forEach(vm.list_task.list, function(value, key) {
                if (value.status_id == 0) {
                    value.checked = true;
                } else {
                    value.checked = false;
                }
            })
            vm.check.checkselecting.do()
        },
        notfinished: function() {
            angular.forEach(vm.list_task.list, function(value, key) {
                if (value.status_id == 1) {
                    value.checked = true;
                } else {
                    value.checked = false;
                }
            })
            vm.check.checkselecting.do()
        }

    }




    // upload later on form submit or something similar


    // upload on file select or drop





    vm.fetch = function(firsttime = false) {
        vm.loading.list.start()
        userService.getMemberareaSetting(vm.user_id).then(function(respone) {
            if (firsttime) {
                vm.setting = my_utility.arr_id_as_key(respone.data.data, 'name');
                vm.setting_default = respone.data.data_default;
                angular.forEach(vm.setting_default, function(value, key) {
                    if (!angular.isUndefined(vm.setting['id_' + value.name])) {
                        value.default_value = vm.setting['id_' + value.name].value
                    } else {
                        value.default_value = value.default_value
                    }

                    switch (value.name) {
                        case 'sort_task':
                            vm.filter.order.col = value.default_value
                            break;
                        case 'sort_task_val':
                            vm.filter.order.val = value.default_value
                            break;
                        case 'display_perpage':
                            vm.displayedPerPage.selected = { id: value.default_value, value: value.default_value }
                            vm.displayedPerPage.options = value.option
                            console.log('adasdasd', vm.displayedPerPage)
                            break;

                    }

                })
            }

            vm.filter.limit.limit = vm.displayedPerPage.selected.id
            param  =   vm.filter 
            




            ticketService.get_task_list(param).then(function successCallback(respone) {
                vm.list_task = respone.data;
               // vm.list_task.addition.t_category = my_utility.arr_id_as_key(vm.list_task.addition.t_category)
               // vm.list_task.addition.t_priority = my_utility.arr_id_as_key(vm.list_task.addition.t_priority)
                console.log(vm.list_task)
                vm.pagination.total_row = respone.data['total_row']
                vm.displayed = respone.data['displayed']
                vm.check.checkselecting.do()

                vm.loading.list.stop()

            }, function errorCallback(respone, status) {
                console.log('status', respone);
                vm.loading.list.stop()
            })

        })

    }



    vm.set_order = function(order) {

        if (vm.filter.order.col == order) {
            if (vm.filter.order.val == 'ASC') {
                vm.filter.order.val = 'DESC'
            } else {
                vm.filter.order.val = 'ASC'
            }
        }
        vm.filter.order.col = order;
        vm.fetch()
    }
    vm.tes = function() {
        //console.log(vm.list_task.addition.t_category)
    }

    vm.toggle = function(item, list) {
        console.log(item)
        var idx = list.indexOf(item);
        if (idx > -1) {
            list.splice(idx, 1);
        } else {
            list.push(item);
        }
        console.log(vm.selected);

    };

    vm.exists = function(item, list) {
        //console.log(vm.selected)
        return list.indexOf(item) > -1;

    };

    vm.pageChanged = function(newPage) {
        vm.pagination.cur_page = newPage
        vm.filter.limit.offset = (vm.filter.limit.limit * (vm.pagination.cur_page - 1))
        vm.fetch()
    };

    vm.get_selected_task = function(status_baru = '', cols= '') {
        console.log('ini col =>', cols)
        var arr = []
        var count = 0;
        angular.forEach(vm.list_task.list, function(value, key) {
            if (value.checked) {
                console.log(value)
                var a = {}
                a['task_code'] = value.task_code
                a['assignee_id'] = value.crm_id
                a[cols] = status_baru
                arr.push(a)
                console.log(a)
            }



        })

        console.log(arr)
        return arr;
    }

    vm.claim_ticket = function() {
        arr = vm.get_selected_ticket(vm.user_id, 'assignee_id')
        /*angular.forEach(vm.list_task.list, function(value, key) {
            if (value.checked) {
                console.log(value)
                arr.push({ ticket_code: value.ticket_code, asignee_id: vm.user_id })
            }



        })
        */

       if(arr.length > 0){
         ticketService.changeAsignee(arr).then(function(respone) {
            vm.fetch()
        })
       }
    }


    vm.assign_to_other = function() {
        arr = vm.get_selected_ticket()
        if(arr.length > 0){
          $mdDialog.show({
                controller: DialogController,
                templateUrl: 'ng/modules/ticket/templates/modal/change_asignee.html',
                parent: angular.element(document.html),

                controllerAs: 'vm',
                fullscreen: vm.customFullscreen // Only for -xs, -sm breakpoints.
            })
            .then(function(answer) {
                vm.status = 'You said the information was "' + answer + '".';
            }, function() {
                vm.status = 'You cancelled the dialog.';
            });
        }
    }


    function DialogController($mdDialog) {

        vm.hide_dialog = function() {
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
        dt.selected_ticket = []

        dt.do_assign_to_other  = function(){
          dt.selected_ticket = vm.get_selected_ticket(dt.users.selected.id, 'assignee_id')
          if(dt.selected_ticket.length > 0){
           ticketService.changeAsignee(dt.selected_ticket).then(function(respone) {
              vm.fetch()
              vm.hide_dialog()
          })
         }
        }

        dt.fetch = function() {
            dt.users = {}
            dt.users.selected = { id: '0', full_name: '--------------' }
            userService.get_users_with_certain_privilege({ priv: 'ticket_assignee' }).then(function(response) {
                var list = response.data
                dt.users.list = []
                dt.users.list.push(dt.users.selected)
                angular.forEach(list, function(val, key) {
                    dt.users.list.push(val)
                })


            dt.selected_ticket = vm.get_selected_ticket()
            if(dt.selected_ticket.length == 1){
             // console.log('val :'  , val )
              console.log('dt.selected_ticket ',  dt.selected_ticket[0])
              angular.forEach(dt.users.list, function(val,key){
                if(val.id == dt.selected_ticket[0].assignee_id){
                  console.log('sukses')
                  dt.users.selected = val
                  
                }
              })
            }



            });




            console.log('vm', dt)


        }

        dt.alasan = ""

        dt.fetch()
    }


    vm.deleteticket = function() {
        arr = vm.get_selected_ticket(0, 'active')
        if (!arr.length > 0) {
            console.log('pilih coy')
        } else {
            var confirm = $mdDialog.confirm()
                .title('Lanjutkan menghapus')
                .textContent('Ticket Akan di hapus , lanjutkan?')
                .ariaLabel('Lucky day')

                .ok('Ya')
                .cancel('Batal');

            $mdDialog.show(confirm).then(function() {
                //$scope.status = 'You decided to get rid of your debt.';
                vm.do_delete(arr)
            }, function() {
                // $scope.status = 'You decided to keep your debt.';
            });

        }
    }

    vm.do_delete = function() {
        ticketService.delete(arr).then(function(respone) {
            vm.fetch()
        })
    }



    vm.changeStatus = function(status_baru) {
        var arr = []
        var count = 0;
        angular.forEach(vm.list_task.list, function(value, key) {
            if (value.checked) {
                console.log(value)
                arr.push({ ticket_code: value.ticket_code, status_id: status_baru })
            }



        })

        console.log(arr)
        vm.doChangeStatus(arr)



    }

    vm.doChangeStatus = function(arr) {
        console.log(ticketService)
        ticketService.changeStatus(arr).then(function(respone) {
            vm.fetch()
        })
    }

    vm.setTicketEventReply = function(id, ticket_id, content = "") {
        var item = {
            replier_id: vm.user_id,
            reply_event_id: id,
            ticket_id: ticket_id,
            content: content
        }

        ticketService.setTicketEventReply(item).then(function(respone) {

            //vm.fetch()
        })

    }





    vm.fetch(true);

});