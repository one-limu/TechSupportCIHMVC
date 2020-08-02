angular.module("log").service('logService', function($http, $state) {
    this.get_log = function(filter_) {
    	console.log(filter_, 'ini filter')
    	var data = $.param({ filter: JSON.stringify(filter_) })
        
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }

        return $http.post('log/get_log', data, config)

    }

        this.get_report = function(filter_) {
        console.log(filter_, 'ini filter')
        var data = $.param({ filter: JSON.stringify(filter_) })
        
        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        }

        return $http.post('log/get_report', data, config)

    }

    
})