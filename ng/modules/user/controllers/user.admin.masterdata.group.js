angular.module("user").controller('userAdminMasterdataGroup', function(userSession,$state,$anchorScroll,$rootScope,$location,$window,userService,$filter,Upload, ticketService,$timeout,$mdDialog,my_utility,my_session_thing) {
	var vm = this
	vm.open_form = {}
	vm.fetch = function(){
		userService.is_logged_in_admin().then(function(respone){
        $timeout(function() {
          vm.is_logged_in = respone.data;
          if(vm.is_logged_in){
            my_session_thing.get_user_info({cct:6}).then(function(respone){
              vm.user_id = respone.data.id
              vm.userdata = respone.data
             
              userService.get_group().then(function(respone){
                  vm.group = {}
                  vm.group.item = []
                  vm.group.list = my_utility.arr_id_as_key(respone.data.data);
                  angular.forEach(respone.data.data, function(val,key){
                    var item = {id: val.id, name: val.name, description:val.description, count : val.count}
                    vm.group.item.push(item)
                    if(val.id == 2){
                      vm.group.selected = item
                    }
                  })

                  console.log('group', vm.group);
                  
              })

              vm.row.selected = {}
              vm.row.status = 0


          })

               userSession.authenticate().then(function(respone){
                
                  $rootScope.$broadcast('refresh_sidebar_profil','d');
                  $rootScope.$broadcast('refresh_sidebar_menu','d');
                })
        }
    })
	})
}




vm.filter = {
  value : {
    $ : ''
  }
}

vm.itemsPerPage = {
  selected : 8,
  items: [1,5,8,10,15,20,50]
}

vm.confirm_delete = function(){
  console.log('lol')
  var confirm = $mdDialog.confirm()
          .title('Hapus Group ' + vm.row.selected.name)
          .textContent('Group ini akan Di hapus lanjutkan? semua user yang termasuk ke dalam group ini akan di keluarkan')
          .ariaLabel('Lucky day')
          
          .ok('Ya')
          .cancel('Batal');

    $mdDialog.show(confirm).then(function() {
      //$scope.status = 'You decided to get rid of your debt.';
      vm.do_delete()
    }, function() {
     // $scope.status = 'You decided to keep your debt.';
    });
}



vm.form_add = {
  value: 0,
  open : function(){
    this.value = 1
    vm.callout.close()
    vm.add = {}
    vm.add.groups = angular.copy(vm.group.item)
    console.log(vm.add.groups)
    vm.gotoAnchor('bottom')
  },
  close :function(){
    this.value = 0
    vm.callout.close()
    vm.gotoAnchor('top')
  },
  toggle : function(){
    //this.value = !this.value
    if(this.value){
      this.close()
    }else{
      this.open()
    }
   vm.gotoAnchor('bottom')
  }
}

vm.row = {
  status : 0,
  selected : {},
  select : function(row){
    if(this.selected.id == row.id){
      this.unselect()
    }else{
      this.selected = row
      this.status = 1
    }
    console.log(this.selected)
  },
  unselect : function(){
    this.selected = {}
    this.status = 0
  },
  init: function(){
    this.item = this.selected
  }
}

vm.form_edit = {
  value: 0,
  open : function(){
    this.value = 1
    vm.callout.close()
    vm.edit = angular.copy(vm.row.selected)
    var tempgroup = angular.copy(vm.group.item)
    angular.forEach(tempgroup, function(val,key){
      val.set = false
      angular.forEach(vm.edit.groups, function(val2,key2){
        if(val.id == val2.id){
          val.set = true
        }
      })
    })
    vm.edit.groups = tempgroup
    vm.gotoAnchor('bottom')
  },
  close :function(){
    this.value = 0
    vm.edit = {}
    vm.callout.close()
    vm.gotoAnchor('top')
  },
  toggle : function(){
    if(this.value){
      this.close()
    }else{
      this.open()
    }
   vm.gotoAnchor('bottom')

  }
}

vm.check = function(d){
  d.set = !d.set
}

vm.button ={
  edit : vm.row.status,
  add : vm.form_add.value,
  delete : 0
}

vm.callout = {
  value: 0,
  top: '',
  desc : '',
  open : function(){
    this.value = 1
  },
  close :function(){
    this.value = 0
  },
  toggle : function(){
    this.value = !this.value
    
  }
}


vm.gotoAnchor = function(x) {
      var newHash = x;
      $timeout(function() {
           if ($location.hash() !== newHash) {
        // set the $location.hash to `newHash` and
        // $anchorScroll will automatically scroll to it
        $location.hash(x);
        $anchorScroll();
      } else {
        // call $anchorScroll() explicitly,
        // since $location.hash hasn't changed
        $anchorScroll();
      }
      }, 500);

     
    };



vm.field_list = [
  {col : 'id', name: 'ID'},{col : 'name', name : 'Name' },{col : 'description', 'name' : 'Deskripsi'},{col: 'count', name: 'Jumlah User'}
]

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

vm.do_delete = function(){
  userService.delete_group({id: vm.row.selected.id}).then(function(respone){
    console.log(respone.data)
    vm.fetch()
  })
}



  vm.set_dupe_to_nothing = function(id){
    if(id =='1'){
      vm.dupe_name = 0
    }
    if(id =='2'){
      vm.dupe_desc = 0
    }
  }


vm.do_add = function(form){
  
  console.log('dd')
  if(form.$valid){
    vm.add.group_id = vm.group.selected.id
      userService.add_group(vm.add).then(function(respone){
        if(respone.data.status){
              vm.callout.open()
               vm.callout.top = "Berhasil Menambahkan Group baru"
               vm.callout.desc = "Nama Group: " + vm.add.name + " Deskripsi : " + vm.add.description
          vm.add = {}
          vm.fetch()
          vm.form_add.close()
          form.$setUntouched()
          console.log('asdasd')

        }else{
            var d = respone.data;
            vm.dupe_name = d.dupe_name
           // vm.dupe_description = d.description
        }
      })
  }else{
    console.log('!valid')
  }
}

vm.do_edit = function(form){
  
  console.log('dd')
  if(form.$valid){
    //vm.edit.group_id = vm.group.selected.id
      userService.edit_group(vm.edit).then(function(respone){
        if(respone.data.status){
              vm.callout.open()
               vm.callout.top = "Berhasil Mengubah Data Group"
               vm.callout.desc = "Name: " + vm.edit.name + " Deskripsi : " + vm.edit.description
          vm.edit = {}
          vm.fetch()
          vm.form_edit.close()
          form.$setUntouched()
          console.log('asdasd')

        }else{
            var d = respone.data;
            vm.dupe_name = d.name_dupe
           // vm.dupe_email = d.email_dupe
        }
      })
  }else{
    console.log('!valid')
  }
}
//vm.callout.open()
vm.fetch()
})