


angular.module("ticket").service('ticketService', function($http) {
 //  this.fetch = function(start,number){
 //   return $http.get("ticket/fetchTicket/" + start + "/" + number)
 // }

this.get_last_insert_ticket = function(searchParam){
  var data = $.param({
                his_token: searchParam['cct'],
                //data: JSON.stringify(searchParam['data']),
                //add_ticket: 1
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket/get_last_insert_ticket",data,config)
  
}

this.get_ticket_category = function(data){
  var data = $.param({
                data: JSON.stringify(data)
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket/get_ticket_category",data,config)
   
}


this.get_ticket_status = function(data){
  var data = $.param({
                data: JSON.stringify(data)
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket/get_ticket_status",data,config)
   
}

this.get_ticket_priority = function(data = null){
  var data = $.param({
                data: JSON.stringify(data)
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket/get_ticket_priority",data,config)
   
}

this.add_task = function(item){
      var data = $.param({
                //his_token: searchParam['cct'],
                data: JSON.stringify(item)
              //  add_ticket: 1
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket/add_task",data,config)
}

this.add_ticket = function(searchParam){


  console.log(searchParam)
    var data = $.param({
                his_token: searchParam['cct'],
                data: JSON.stringify(searchParam['data']),
                add_ticket: 1
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket",data,config)
  }



  this.update_pemesanan_gizi = function(searchParam){
  console.log(searchParam)
    var data = $.param({
                his_token: searchParam['cct'],
                data: JSON.stringify(searchParam['data']),
                update_pemesanan_gizi: 1
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("id/gizi/pemesanan",data,config)
  }

  this.get_list_ticket = function(searchParam){
    console.log(searchParam)
    var data = $.param({
                his_token: searchParam['cct'],
                filter: JSON.stringify(searchParam['data']),
                get_list_ticket: 1
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket",data,config)
  }




 this.fetch = function(start,number,searchParam){
   
     var data = $.param({
                judul: searchParam['se_judul'],
                pesan: searchParam['se_pesan'],
                prioritas: searchParam['se_prioritas'],
                kategori: searchParam['se_kategori'],
                status: searchParam['se_status'],
                tanggal_from: searchParam['se_tanggal_from'],
                tanggal_to: searchParam['se_tanggal_to']
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket/fetchTicket/" + start + "/" + number,data,config)
  }



   this.fetchAll = function(searchParam){


     var data = $.param({
                judul: searchParam['se_judul'],
                pesan: searchParam['se_pesan'],
                prioritas: searchParam['se_prioritas'],
                kategori: searchParam['se_kategori'],
                status: searchParam['se_status'],
                tanggal_from: searchParam['se_tanggal_from'],
                tanggal_to: searchParam['se_tanggal_to']
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }
    return $http.post("ticket/fetchTicketAll",data,config)
  }

  this.changeStatus = function(Arr){
      
     var data = $.param({
                data: JSON.stringify(Arr), 
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

           return $http.post("ticket/changeStatus/", data, config).then(function(respone){
             // alert(respone.data)
            })
           
  }

  this.changeAsignee = function(Arr){
      var data = $.param({
                data: JSON.stringify(Arr), 
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

           return $http.post("ticket/changeAsignee/", data, config).then(function(respone){
             // alert(respone.data)
            })
           

  }
  this.delete = function(Arr){
     var data = $.param({
                jsdata: JSON.stringify(Arr), 
            });
    
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

            return $http.post("ticket/delete/", data, config).then(function(respone){
             // alert(respone.data)
            })
  }

  this.getFromId = function(id,requesters = "", isAdmin = false){
    var data = $.param({
                ticket_code: id, requester:requesters , 'isAdmin' : isAdmin
            });
    
    var config = {
        headers : {
            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
        }
    }

     return $http.post("ticket/getFromId/", data, config)
}

this.writeReply = function(reply){
   
    var data = $.param({
                data:JSON.stringify(reply)

            });
    
    var config = {
        headers : {
            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
        }
    }

     return $http.post("ticket/writeReply/", data, config)
}

this.checkcaptcha = function(captcha){

    var data = $.param({
                captcha: captcha,
                submit: 1
                

            });
    
    var config = {
        headers : {
            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
        }
    }

     return $http.post("captcha/index/", data, config)
}

this.setTicketEventReply = function(item){
      var data = $.param({
                data: JSON.stringify(item)
            });
    var config = {
    headers : {
        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
    }
    }

     return $http.post("ticket/setTicketEvent/", data, config)
}

this.add_ticket_priority = function(item){


  //console.log(searchParam)
    var data = $.param({
               
                data: JSON.stringify(item)
               
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket/add_ticket_priority/",data,config)
  }

  this.edit_ticket_priority = function(item){


  //console.log(searchParam)
    var data = $.param({
               
                data: JSON.stringify(item)
               
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket/edit_ticket_priority/",data,config)
  }


  this.edit_ticket_status = function(item){


  //console.log(searchParam)
    var data = $.param({
               
                data: JSON.stringify(item)
               
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket/edit_ticket_status/",data,config)
  }

    this.edit_ticket_category = function(item){


  //console.log(searchParam)
    var data = $.param({
               
                data: JSON.stringify(item)
               
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket/edit_ticket_category/",data,config)
  }

      this.get_task = function(item){


  //console.log(searchParam)
    var data = $.param({
               
                data: JSON.stringify(item)
               
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

             return $http.post("ticket/get_task/",data,config)
  }


      this.get_task_list = function(filter){


  //console.log(searchParam)
    var data = $.param({
                data: JSON.stringify(filter)
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

            return $http.post("ticket/get_task_list/",data,config)
  }

  this.get_task_open = function(filter){


  //console.log(searchParam)
    var data = $.param({
                data: JSON.stringify(filter)
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

            return $http.post("ticket/get_task_open/",data,config)
  }

  this.add_task_reply = function(data){


  //console.log(searchParam)
    var data = $.param({
                data: JSON.stringify(data)
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

            return $http.post("ticket/add_task_reply/",data,config)
  }


  this. change_status_task = function(data){


  //console.log(searchParam)
    var data = $.param({
                data: JSON.stringify(data)
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

            return $http.post("ticket/change_status_task/",data,config)
  }

 




  });
