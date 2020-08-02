angular.module("user").service('userService', function($http, $state, $localStorage) {


    this.is_logged_in = function() {

        return $http.get("user/is_logged_in")

    }
    this.has_privileges = function(priv_name){
        var has = false
        console.log('ini privileges localstorege', $localStorage.privileges)
        angular.forEach($localStorage.privileges,function(val,key){
            if(priv_name == val.privileges_name){
                has = true
            }
            console.log(val.privileges_name, 'ini priv')
        })

        return has;
    }


    this.is_logged_in_admin = function() {

        return $http.get("user/is_logged_in_admin")

    }

    this.get_session = function() {
        return $http.get("user/get_session")
    }

    this.get_user = function(id = undefined) {
        var user = {}
        var data = $.param({ data: '' })
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        if (id != undefined) {
            data = $.param({ data: id })
        }

        return $http.post('user/get_user_info', data, config)
    }

    this.delete_user = function(data) {
        var data = $.param({
            data: JSON.stringify(data)
        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        console.log(data)

        return $http.post("user/delete_user/", data, config)
    }

    this.delete_group = function(data) {
        var data = $.param({
            data: JSON.stringify(data)
        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        console.log(data)

        return $http.post("user/delete_group/", data, config)
    }


    this.add_user = function(data) {
        var data = $.param({
            data: JSON.stringify(data)
        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        console.log(data)

        return $http.post("user/add_user/", data, config)
    }

    this.edit_user = function(data) {
        var data = $.param({
            data: JSON.stringify(data)
        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        console.log(data)

        return $http.post("user/edit_user/", data, config)
    }

    this.get_user_all = function() {
        return $http.post('user/get_user_all')
    }

    this.get_dashboard_data = function() {
        return $http.get('user/get_dashboard_data')
    }

    this.get_data_setting_privilege = function() {
        return $http.get('user/setting_privilege');
    }

    this.updateGroupRoleHas = function(item) {
        var data = $.param({
            data: JSON.stringify(item)
        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        console.log(data)

        return $http.post("user/update_group_role_has/", data, config)
    }

  this.get_users_with_certain_privilege = function(item) {
        var data = $.param({
            data: JSON.stringify(item)
        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        console.log(data)

        return $http.post("user/get_users_with_certain_privilege/", data, config)
    }

    this.get_task_assignee_list = function(){
          var data = $.param({
            //data: JSON.stringify()
        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        console.log(data)

        return $http.post("user/get_task_assignee_list/", data, config)
    }

    this.login = function(data) {

        var data = $.param({
            identity: data.identity,
            password: data.password
        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        console.log(data)

        return $http.post("user/ng_login/", data, config)

    }

    this.get_menu = function() {
        return $http.get("user/get_menu");

    }

    this.login_admin = function(data) {

        var data = $.param({
            identity: data.identity,
            password: data.password
        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        console.log(data)

        return $http.post("user/ng_login_admin/", data, config)

    }

    this.update_memberarea_setting = function(data) {
        if (data != undefined) {
            var data = $.param({
                data: JSON.stringify({ data: data })
            });

            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
            console.log(data)

            return $http.post("user/update_memberarea_setting/", data, config)
        }
    }



    this.getMemberareaSetting = function(id = undefined) {
        if (id != undefined) {
            var data = $.param({
                data: JSON.stringify({ user_id: id })
            });

            var config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
            console.log(data)

            return $http.post("user/getMemberareaSetting/", data, config)
        }
    }

    this.editProfile = function(data) {
        var data = $.param({
            data: JSON.stringify(data)
        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }
        console.log(data)

        return $http.post("user/editProfile/", data, config)
    }

    this.logout = function() {

        var data = $.param({

        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }

        return $http.post("user/ng_logout/", data, config)

    }

    this.isPrivileged = function(data) {
        var cust = { 'state': $state.current.name }
        if (data != undefined) {
            cust.state = data.state
        }
        var data = $.param({
            data: JSON.stringify(cust)
        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }

        return $http.post("user/isPrivileged/", data, config)
    }


    this.logout_admin = function() {

        var data = $.param({

        });

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }

        return $http.post("user/ng_logout/", data, config)

    }

    this.get_group = function(id = 0) {
        var data = $.param({
            data: id
        });


        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }

        return $http.post("user/get_group/", data, config)
    }

    this.add_group = function(data) {
        var data = $.param({
            data: JSON.stringify(data)
        });


        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }

        return $http.post("user/add_groups/", data, config)
    }


    this.edit_group = function(data) {
        var data = $.param({
            data: JSON.stringify(data)
        });


        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }

        return $http.post("user/edit_groups/", data, config)
    }


})