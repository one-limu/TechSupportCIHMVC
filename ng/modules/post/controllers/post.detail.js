angular.module("post").controller("PostDetails", function(userService,postService,$stateParams,$location) {
  var vm = this
    vm.detail = "";
    console.log('dddddddddddddddd')
    vm.kode = {id: $stateParams.id, slug: $stateParams.slug}
    vm.fetch = function(){
        
        postService.getArtikel(vm.kode).then(function(respone){
          vm.detail = respone.data.post_detail
        })


        postService.getComment(vm.kode.slug).then(function(respone){
             vm.comment = respone.data
           })
          userService.is_logged_in().then(function(respone){
            vm.is_logged_in = respone.data
            userService.get_user().then(function(respone){
              vm.user = respone.data
              console.log(vm.user)
            })
           })

        postService.getCategory().then(function(respone){
          vm.category = respone.data
        })
        postService.getTag().then(function(respone){
          vm.tag = respone.data
        })
    }

    vm.logout = function(){
      $location.path('logout')
    }

    vm.writeComment =  function(){
      var comment = {
            post_id : vm.kode.slug,
            commenter: vm.user.id,
            content: vm.commentPost,

          }

          postService.writeComment(comment).then(function(respone){
            vm.fetch()
            vm.commentPost = ''
              //alert(post_id)
          });
    }
  vm.fetch();


   
});