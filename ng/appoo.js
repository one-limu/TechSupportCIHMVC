var app = angular.module("myApp", ['ngMessages', 'smart-table']);

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

app.controller("PostComment", function($scope) {
    $scope.firstName = "John";
    $scope.lastName = "Doe";
});




app.controller('TicketTable', function($scope, $filter, ticketService) {
           $scope.ticket = "";
           $scope.ticketAll;
           $scope.start = 0;
           $scope.number = 2;
           $scope.current = 1;
           $scope.total = 1;
           $scope.displayCollection = "";
           $scope.displayedPageNumber = "";
           $scope.displayedPerPage = [2,3,5,10,20,40,60,80,100]


        

          $scope.displayNumberPage = function(){
              var tPagArr = []

              tPagArr[0] = $scope.current - 2
              tPagArr[1] = $scope.current - 1
              tPagArr[2] = $scope.current
              tPagArr[3] = $scope.current + 1
              tPagArr[4] = $scope.current + 2

            for (var i = 0; i < tPagArr.length; i++) {
               if (tPagArr[i] < 1 || tPagArr[i] > $scope.total){
                tPagArr[i] = 0
               }
               alert(tPagArr[i] + " "  + $scope.total)
            }
               
               $scope.displayedPageNumber = tPagArr;
               //alert(tPagArr)

           }    

           $scope.fetch = function(){       
               var data = ticketService.fetch($scope.start, $scope.number)

               $scope.ticketAll = data['unlimited'].length
               $scope.ticket = data['limited']
               $scope.total =  $scope.ticket / $scope.number
               alert($scope.total)

               $scope.displayNumberPage();
           }


       
          
           
          $scope.changeDisplayedPerPage = function(number){
                $scope.number = number;
                $scope.current = 1;
                $scope.start = 0;
                init();
           }

           $scope.goTo = function(current){
                if ($scope.current == current){return false}  
                ticketService.fetch($scope.start + ($scope.number * (current - 1)) , $scope.number).then(function(respone){

                $scope.ticket = respone.data;
                $scope.current = current;
                $scope.displayCollection = [].concat($scope.ticket);
                $scope.displayNumberPage()
                //alert($scope.current);
                });
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






app.service('ticketService', function($http) {
  this.fetch = function(start,number){
    var data = []
    $http.get("ticket/fetchTicket/" + start + "/" + number).then(function(respone){
        data['limited'] = respone.data

     })

    $http.get("ticket/fetchTicketAll").then(function(respone){
        data['unlimited'] = respone.data
     })
          alert(data)

    return data

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

