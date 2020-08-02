angular.module("post").controller("PostInformasi", function($scope, postService) {

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