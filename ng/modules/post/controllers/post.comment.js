angular.module("post").controller("PostComment", function(userService, postService,$stateParams) {
    var vm = this
    vm.thisComment = "";

    history.pushState("", document.title, window.location.pathname)
    vm.slug = $stateParams.slug
    vm.is_logged_in = 0
    vm.commentPost = ""

//alert(vm.post_id )
    vm.init = function(){
           postService.getComment(vm.slug).then(function(respone){
             vm.thisComment = respone.data
           })
          userService.is_logged_in().then(function(respone){
            vm.is_logged_in = respone.data
           })
    }

    vm.writeComment =  function(){
      var comment = {
            post_id : vm.slug,
            commenter: 1,
            content: vm.commentPost,

          }

          postService.writeComment(comment).then(function(respone){
            init()
              //alert(post_id)
          });
    }


init()
    function init(){
      vm.init()
    }
});