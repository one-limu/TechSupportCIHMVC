angular.module("user").controller('userAdminDashboard', function(BACKENDASSET,$rootScope,$state,$location,$window,userService,$filter,Upload, ticketService,$timeout,$mdDialog,my_utility,my_session_thing) {
    var vm  = this;
    vm.loading = {login: 0}
    vm.BACKENDASSET = BACKENDASSET
    console.log('dasdasd',BACKENDASSET)

    vm.fetch = function(){
        
            
            
                        userService.get_dashboard_data().then(function(respone){
                  vm.dashboard = respone.data
                  console.log(vm.dashboard);
                })
                
              
     
    }


    vm.labels = ["January", "February", "March", "April", "May", "June", "July","August", "September", "Oktober", "Novermber", "Desember"];
  vm.series = ['Series A', 'Series B'];
  vm.data = [
    [65, 59, 80, 81, 56, 55, 40],
    [28, 48, 40, 19, 86, 27, 90]
  ];
  vm.onClick = function (points, evt) {
    console.log(points, evt);
  };
  vm.datasetOverride = [{ yAxisID: 'y-axis-1' }, { yAxisID: 'y-axis-2' }];
  vm.options = {
    scales: {
      yAxes: [
        {
          id: 'y-axis-1',
          type: 'linear',
          display: true,
          position: 'left'
        },
        {
          id: 'y-axis-2',
          type: 'linear',
          display: true,
          position: 'right'
        }
      ]
    }
  };

    vm.fetch()

});

