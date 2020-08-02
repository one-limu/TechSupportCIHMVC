var app = angular.module("myApp", ['ngMaterial',"ngAnimate","ngAria", 'ngMessages', 'smart-table']);

app.controller("userInfo", function($scope) {
    $scope.firstName = "John";
    $scope.lastName = "Doe";
});

app.controller("MainCtrl", function($scope) {
    $scope.firstName = "John";
    $scope.lastName = "Doe";
});

app.controller("PostList", function($scope) {
    $scope.firstName = "John";
    $scope.lastName = "Doe";
});

app.controller("PostDetail", function($scope) {
    $scope.firstName = "John";
    $scope.lastName = "Doe";
});

app.controller("PostTutorial", function($scope, postService) {
    $scope.tutorials = "";
   // $scope.informasi = "";

    $scope.init = function(){
        postService.getTutorial().then(function(respone){
          $scope.tutorials = respone.data
        })
        
    }

    init();
      function init(){
          $scope.init()
          //$scope.first()

       }


   
});

app.controller("PostInformasi", function($scope, postService) {

    $scope.informasi = "";

    $scope.init = function(){
        
        postService.getInformasi().then(function(respone){
          $scope.informasi = respone.data
        })
    }

    init();
      function init(){
          $scope.init()
          //$scope.first()

       }


   
});

app.controller("PostComment", function($scope, postService) {
    $scope.thisComment = "";

    history.pushState("", document.title, window.location.pathname)
    $scope.slug = window.location.href.substr(window.location.href.lastIndexOf('/') + 1)
    $scope.commentPost = ""

//alert($scope.post_id )
    $scope.init = function(){
           postService.getComment($scope.slug).then(function(respone){
             $scope.thisComment = respone.data
           })
    }

    $scope.writeComment =  function(){
      var comment = {
            post_id : $scope.slug,
            commenter: 1,
            content: $scope.commentPost,

          }

          postService.writeComment(comment).then(function(respone){
            init()
              alert(post_id)
          });
    }


init()
    function init(){
      $scope.init()
    }
});




app.controller('TicketTable', function($scope, $filter, ticketService,$timeout,$mdDialog) {
           $scope.ticket = "";
           $scope.ticketAll = "";
           $scope.start = 0;
           $scope.number = 5;
           $scope.current = 1;
           $scope.total = 1;
           $scope.displayCollection = "";
           $scope.displayedPageNumber = "";
           $scope.displayedPerPage = [2,3,5,10,20,40,60,80,100]
           $scope.loading = false;
           $scope.showingFrom =  $scope.start + $scope.current;
           $scope.showingTo = $scope.start * $scope.current
           $scope.checkAll = 0;
           $scope.checkAllButton = 0;

           $scope.filter;
           $scope.filterParam = ['ticket_id','judul', 'tanggal_update'];
           $scope.statusCheck = "";

           $scope.statusSet = "1";

           $scope.ticketPoll = [];


           $scope.se_judul ="";
           $scope.se_pesan ="";
           $scope.se_prioritas = "";
           $scope.se_kategori ="";
           $scope.se_status ="";
           $scope.se_tanggal_from ="";
           $scope.se_tanggal_to ="";

           $scope.se_order = ""



           $scope.c_checkAll = function(){
              if(!$scope.checkAll){
                $scope.ticketPoll = [];
              }
              else{
                $scope.ticketPoll = []
                for (var i = 0; i <= $scope.ticket.length; i++) {
                  $scope.ticketPoll.push($scope.ticket[i]);
                  
                }
                
              }
           }

           $scope.c_check_some = function(x){
            if (x == 'all') {
               $scope.ticketPoll = []
                for (var i = 0; i <= $scope.ticket.length; i++) {
                  $scope.ticketPoll.push($scope.ticket[i]);
                }
                $scope.checkAll = 1;
                $scope.checkAllButton = 1
            } else if(x =='none') {
              $scope.ticketPoll = [];
              $scope.checkAll = 0
              $scope.checkAllButton = 0
            } else if(x == 'selesai'){
              $scope.ticketPoll = []
                for (var i = 0; i <= $scope.ticket.length; i++) {
                  if ($scope.ticket[i].status_id == 1){
                    $scope.ticketPoll.push($scope.ticket[i]);
                  }
                }
                $scope.checkAll = 1;
                $scope.checkAllButton = 1
            } else if(x == 'belum selesai'){
              $scope.ticketPoll = []
                for (var i = 0; i <= $scope.ticket.length; i++) {
                  if ($scope.ticket[i].status_id == 2){
                    $scope.ticketPoll.push($scope.ticket[i]);
                  }
                }
               

           }else if(x == 'baca'){
              $scope.ticketPoll = []
                for (var i = 0; i <= $scope.ticket.length; i++) {
                  if ($scope.ticket[i].user_read_status == 1){
                    $scope.ticketPoll.push($scope.ticket[i]);
                  }
                }
                $scope.checkAll = 1;
                $scope.checkAllButton = 1
            } else if(x == 'belum baca'){
              $scope.ticketPoll = []
                for (var i = 0; i <= $scope.ticket.length; i++) {
                  if ($scope.ticket[i].user_read_status == 0){
                    $scope.ticketPoll.push($scope.ticket[i]);
                  }
                }
               

           }
         }

           $scope.changeCheckbox = function(x){
             var index = $scope.ticket.indexOf(x);
            var index2 =""
             if (index !== -1) {
              index2 = $scope.ticketPoll.indexOf(x)
               
              if(index2 !== -1){
                   $scope.ticketPoll.splice(index2, 1)
               
              }else{
                  
                   $scope.ticketPoll.push(x);
              }
             
           } //alert($scope.ticketPoll)
           //alert($scope.ticketPoll)
         }

         $scope.delete = function(){
         
          
            $scope.verifyDelete().then(function(){
                var ttp = $scope.ticketPoll;
            for (var i = 0; i < ttp.length; i++) {
               var index = $scope.ticket.indexOf(ttp[i])
                 if (index !== -1) {
                  $scope.ticket.splice(index, 1)

                 }
                 
            }
              $scope.ticketPoll =[]
                 ticketService.delete(ttp)
                 $scope.fetch();
            })
        
         }

         $scope.verifyDelete =   function () {
    var confirm = $mdDialog.confirm()
        .title('Konfirmasi Penghapusan')
        .content('Yakin akan menghapus Ticket yang telah dipilih?')
        .ariaLabel('Hapus Ticket')
        .ok('Hapus Ticket')
        .cancel('Batal');
          return $mdDialog.show(confirm);
         }

     


           $scope.statusCheckbox = {
                   v1 : true,
                   v2 : true,
                   v11 : 1,
                   v12 : 2,

                 
               };

             $scope.ChangeStatusCheckbox = function(){
                 var Hi = false;
                 if($scope.statusCheckbox.v1){
                     $scope.statusCheck = $scope.statusCheckbox.v11
                     Hi = !Hi
                 }
                 if($scope.statusCheckbox.v2){
                     $scope.statusCheck = $scope.statusCheckbox.v12
                     Hi = !Hi
                 }

                 if (!Hi){
                  $scope.statusCheck = ""
                 }

                 //alert($scope.statusCheck)
             }

             $scope.operateChangeStatus = function(){
                var ttp = $scope.ticketPoll;
                for (var i = 0; i < ttp.length; i++) {
                ttp[i]['status_id'] = $scope.statusSet;
                }
                ticketService.changeStatus(ttp)
                //init()
             }

         

           $scope.fetch = function(){       
             $scope.loading = !$scope.loading
             $scope.ticketPoll = []
                searchParam = []
                searchParam['se_judul'] =$scope.se_judul
                searchParam['se_pesan'] = $scope.se_pesan
                searchParam['se_prioritas'] = $scope.se_prioritas
                searchParam['se_kategori'] = $scope.se_kategori
                searchParam['se_status'] = $scope.se_status
                searchParam['se_tanggal_from'] = $scope.se_tanggalfrom
                searchParam['se_tanggal_to'] = $scope.se_tanggal_to

             $timeout(function() {

              var from = $scope.start + ($scope.number * ($scope.current - 1))
              ticketService.fetch(from, $scope.number, searchParam).then(function(respone){

                   $scope.ticket = respone.data;
                     $scope.displayCollection = [].concat($scope.ticket);
                     
                });

               ticketService.fetchAll(searchParam).then(function(respone){
                     $scope.ticketAll = respone.data.length;
                     $scope.loading = !$scope.loading

                     $scope.displayNumberPage()
                      $scope.showingTo = $scope.number * $scope.current
                      $scope.showingFrom =   $scope.showingTo - $scope.number  +1;
                      if($scope.showingTo > $scope.ticketAll){
                       $scope.showingTo = $scope.ticketAll
              }
                     
                });


              
             }, 750);
              

                

      
           }

             $scope.displayNumberPage = function(){
              var tPagArr = []

              tPagArr[0] = $scope.current - 2
              tPagArr[1] = $scope.current - 1
              tPagArr[2] = $scope.current
              tPagArr[3] = $scope.current + 1
              tPagArr[4] = $scope.current + 2


              $scope.total = parseInt($scope.ticketAll) / parseInt($scope.number);
                    if($scope.total % 1 != 0){
                       $scope.total = parseInt($scope.total) + 1
                    }

            for (var i = 0; i < tPagArr.length; i++) {
               if (tPagArr[i] < 1 || tPagArr[i] > $scope.total){
                tPagArr[i] = 0
               }
              // alert($scope.total +" - " + $scope.ticketAll + " - " + $scope.number)
            }
               
               $scope.displayedPageNumber = tPagArr;

           }    
 
          $scope.changeDisplayedPerPage = function(number){
                $scope.number = number;
                $scope.current = 1;
                $scope.start = 0;
                init()
             
           }

            $scope.changeFilterParam= function(filter){
                $scope.filter = filter;
                
             
           }

           $scope.goTo = function(current){
                if ($scope.current == current){return false}  
                $scope.current = current;
                init()
              
           }

           $scope.next = function(){
              var page = $scope.current + 1
              if(page <= $scope.total){
                 $scope.goTo(page)
              }
 
           }

            $scope.prev = function(){
              var page = $scope.current-1
              if(page != 0){
                $scope.goTo(page)
              }
           }

            $scope.first = function(){
             $scope.goTo(1)
           }

           $scope.last = function(){
            //alert($scope.total)
             $scope.goTo($scope.total);
           }




          

          init();


          function init(){
              $scope.fetch()
              //$scope.first()


           }

       


           

});





app.controller('TicketOpen', function($location, $scope, $filter, ticketService) {
    $scope.thisTicket = ""
    $scope.thisReply = ""
    $scope.replyTicket = ""
    $scope.ticket_id = window.location.href.substr(window.location.href.lastIndexOf('/') + 1)
    $scope.valid = false

       $scope.init = function(){
          ticketService.getFromId($scope.ticket_id).then(function(respone){
          var Poll = respone.data
              $scope.thisTicket = Poll['ticket'];
              $scope.thisReply = Poll['reply'];
               if($scope.thisTicket.length != 0){
                  $scope.valid = true
                }else{
                  $scope.valid = false
                }
       })

      }

      $scope.writeReply = function(){
        //alert( $scope.replyTicket)
          var reply = {
            ticket_id : $scope.thisTicket[0].ticket_id,
            replier: 1,
            content: $scope.replyTicket,

          }

          ticketService.writeReply(reply).then(function(respone){
            init()
          });
      }


      init()

      function init(){
          $scope.init();


      }
})


















app.service('postService', function($http) {
   this.getComment = function(slug){
      return $http.get("post/getComment/" + slug)
   }
   this.writeComment = function(comment){
    var data = $.param({
                post_id: comment['post_id'],
                author: comment['commenter'],
                content: comment['content'],

            });
    
    var config = {
        headers : {
            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
        }
    }

     return $http.post("Post/writecomment/", data, config)
   }
  
  this.getTutorial = function(){
    return $http.get("post/get_tutorial");
  }


  this.getInformasi = function(){
    return $http.get("post/get_informasi");
  }


})


app.service('ticketService', function($http) {
 //  this.fetch = function(start,number){
 //   return $http.get("ticket/fetchTicket/" + start + "/" + number)
 // }

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
                jsdata: JSON.stringify(Arr), 
                
            });
        
            var config = {
                headers : {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                }
            }

            $http.post("ticket/changeStatus/", data, config).then(function(respone){
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

            $http.post("ticket/delete/", data, config).then(function(respone){
             // alert(respone.data)
            })
  }

  this.getFromId = function(id){
    var data = $.param({
                id: id, 
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
                ticket_id: reply['ticket_id'],
                replier: reply['replier'],
                content: reply['content'],

            });
    
    var config = {
        headers : {
            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
        }
    }

     return $http.post("ticket/writeReply/", data, config)
}

  });













app.filter('htmlToPlaintext', function() {
    return function(text) {
      return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
  }
);

app.filter('dateToISO', function() {
  return function(input) {
    return new Date(input).toISOString();
  };
});

