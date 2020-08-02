angular.module("post").service('postService', function($http) {
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

  this.getKnowledgebase = function(){
    return $http.get("post/get_knowledgebase");
  }


  this.getInformasi = function(){
    return $http.get("post/get_informasi");
  }

  this.getArtikel = function(kode){
          return  $http.get("post/o/" + kode.id + "/" + kode.slug)
  }
  this.getCategory = function(){
    return $http.get("post/get_category"); 
  }
  this.getTag = function(){
    return $http.get("post/get_tag"); 
  }
})