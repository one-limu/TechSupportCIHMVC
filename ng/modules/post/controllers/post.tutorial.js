angular.module("post").controller("PostTutorial", function($scope, postService) {
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