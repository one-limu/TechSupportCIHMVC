angular.module("user").controller('userAdminReport', function($interval, userSession, $localStorage, $scope, logService, $state, $anchorScroll, $rootScope, $location, $window, userService, $filter, Upload, ticketService, $timeout, $mdDialog, my_utility, my_session_thing) {
    var vm = this

    vm.filter = {
        value: {
            $: ''
        }
    }


    vm.logtype = { selected: { id: '', name: 'All' } }


    vm.log = []
    vm.loading = {
        log: {
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

    /*Preview dari objek filter
        vm.filter = {
            filter: { like: {}, equal: {}, range: {} },
            limit: { limit: '5', offset: '0' },
            order: { col: 'tanggal_update', val: 'DESC' }
        };
    */

    var date = new Date(),
        y = date.getFullYear(),
        m = date.getMonth();
    var firstDay = new Date(y, m, 1);
    var lastDay = new Date(y, m + 1, 0);


    vm._datepicker_from = {
        value: firstDay,
        option: { maxDate: firstDay, showWeeks: false },
        isOpen: false,
        open: function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('123123')
            this.isOpen = true;
        }
    }
    vm._datepicker_to = {
        value: lastDay,
        option: { minDate: lastDay, showWeeks: false },
        isOpen: false,
        open: function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('123123')
            this.isOpen = true;
        }
    }




    $scope.$watch(angular.bind(vm, function() {
        return vm._datepicker_from;
    }), function(newVal) {
        console.log('From val changed to ' + newVal.value);
        vm._datepicker_to.option.minDate = newVal.value;
    }, true);

    $scope.$watch(angular.bind(vm, function() {
        return vm._datepicker_to;
    }), function(newVal) {
        console.log('to Val changed to ' + newVal.value);
        vm._datepicker_from.option.maxDate = newVal.value;
    }, true);


    vm._perpage = { selected: 10, list: [1, 5, 10, 20, 25, 50, 100] }
    vm._filter = {}
    vm._pagination = { cur_page: '1', total_row: '0' }; //
  

    vm._pageChange = function(newPage) {
        vm._pagination.cur_page = newPage
        vm._fetch_log(false)
    };

    vm._fetch_log = function(resetPage = true) {
        vm.loading.log.start()
        vm._filter = {
            order:{col: vm.order.item_clean, val: (!vm.order.minus ? 'ASC' : 'DESC')},
            limit: { limit: vm._perpage.selected, offset:  resetPage ? 0 : (vm._perpage.selected * (vm._pagination.cur_page - 1)) },
            filter: {
               // equal: { log_type_id: vm.logtype.selected.id },
                range: {
                    time: { from: vm._datepicker_from.value, to: vm._datepicker_to.value }
                }
            }
        }


        logService.get_report(vm._filter).then(function(respone) {
            vm.report = respone.data.report.list
            var _ = respone.data.report.pagination
           // vm._pagination.total_row = _.total_row
            if(resetPage){
                vm._pagination.cur_page = 1
            }
           // vm._pagination.from = _.displayed.from
           // vm._pagination.to = _.displayed.to
            console.log(vm.report, 'ini log')
            console.log(vm._pagination, 'ini pagination')
            vm.logtype.list = [{ id: '', name: 'All' }];
            angular.forEach(respone.data.log_type.list, function(val, key) {
                vm.logtype.list.push(val)
            })
            
            console.log('ini logtype', vm.logtype);

            $timeout(function() {
                vm.loading.log.stop()
            }, 500);

        })
    }

    vm.itemsPerPage = {
        selected: 8,
        items: [1, 5, 8, 10, 15, 20, 50]
    }

    vm.field = {
        list: [{ col: 'id', name: 'ID' }, { col: 'messages_main', name: 'Name' }, { col: 'time', 'name': 'Waktu' }],
        source: 'log'
    }

    vm.order = {
        by: function(col) {
            if (col == vm.order.item) {
                this.item = '-' + col

                this.minus = true
                console.log(vm.order)
            } else {
                this.item = col
                this.minus = false
                console.log(vm.order)
            }
            this.item_clean = col
            vm._fetch_log(false)
        },
        item: undefined,
        minus: true

    }

    vm._fetch_log()


})