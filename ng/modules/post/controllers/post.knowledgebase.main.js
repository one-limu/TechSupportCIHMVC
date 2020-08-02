angular.module("post").controller("PostKnowledgebaseMain", function(userService, postService,$stateParams) {
	var vm = this

	vm.fetch = function(){
		userService.is_logged_in().then(function(respone){
            vm.is_logged_in = respone.data
            userService.get_user().then(function(respone){
              vm.user = respone.data
              console.log(vm.user)
            })
           })

		postService.getKnowledgebase().then(function(respone){
			vm.latest_respone = respone.data.latest_respone;
			vm.category = respone.data.category;
			vm.latest_article = respone.data.latest_article;
		})

		 postService.getCategory().then(function(respone){
          vm.kategory = respone.data
        })
        postService.getTag().then(function(respone){
          vm.tag = respone.data
        })

	}

	vm.fetch()

})