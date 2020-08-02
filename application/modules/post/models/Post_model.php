<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

	}
	
	public function get_post($id){
		// if no id was passed use the current users id
		
		$this->db->where('id',$id);
		$ret = $this->db->get('post_info');
		return $ret;
	}

	public function get_knowledgebase(){
		$category = $this->db->get('posts_categories');
		if($category->num_rows() > 0){
			$category = $category->result();
			foreach ($category as $value) {
				$this->db->where('category', $value->id);
				$category_post = $this->db->get('post');
				if($category_post->num_rows() > 0){
					$value->total_item = $category_post->num_rows();
					$value->item = $category_post->result();
				}else{
					$value->total_item = 0;
					$value->item = (object)[];
				}
			}
		}else{
			$category = (object)[];
		}

	   $this->db->order_by('create_time', 'DESC');
	   $this->db->limit(6,0);	
	   $latest_respone = $this->db->get('posts_comments');
	   if($latest_respone->num_rows() > 0){
	   		$latest_respone = $latest_respone->result();
	   		foreach ($latest_respone as $value) {
	   			$this->db->where('id', $value->post_id);
	   			$res_post = $this->db->get('post');
	   			if($res_post->num_rows() > 0){
	   				$res_post = $res_post->row();
	   				$value->post_title = $res_post->title;
	   				$value->post_url = 'artikel/' . $res_post->id . '/' . $res_post->slug;
	   				$this->db->where('id', $res_post->category);
	   				$res_post_cat = $this->db->get('posts_categories');
	   				if($res_post_cat->num_rows() > 0 ){
	   					$res_post_cat = $res_post_cat->row();
	   					$value->post_category = $res_post_cat->name;
	   					$value->post_category_url = $res_post_cat->url;
	   				}else{
	   					$value->post_category = "unknown";
	   					$value->post_category_url = '#';
	   				}
	   			}else{
	   				$value->post_title = 'unknown';
	   				$value->post_category = "unknown";
	   				$value->post_category_url = '#';
	   			}
	   		}


	   }else{
	   		$latest_respone = (object)[];
	   }


	   $this->db->order_by('create_time', 'DESC');
	   $this->db->limit(6,0);	
	   $latest_article = $this->db->get('post_info');
	   if($latest_article->num_rows() > 0){
	   		$latest_article = $latest_article->result();
	   }else{
	   		$latest_article= (object)[];
	   }

	   $data = (object)['category' => $category, 'latest_article' => $latest_article, 'latest_respone'  => $latest_respone];
	   return $data;


	}

	public function get_post_w_slug($arr){
		
		$this->db->where('slug',$arr['slug']);
		$this->db->where('id',$arr['id']);
		$s = $this->db->get('post_info');
		$ret = 0;
		if($s->num_rows() > 0){
			$ret = $s->row();
			$this->db->where('post_id', $ret->id);
			$tag = $this->db->get('posts_tags_has');
			//print_r($ret->id);
			if($tag->num_rows() > 0){
				$tag = $tag->result();
				foreach ($tag as $value) {
					$this->db->where('id', $value->tag_id);
					$tag_item = $this->db->get('posts_tags');
					if($tag_item->num_rows() > 0){
						$tag_item = $tag_item->row();
						$value->name = $tag_item->name;
						$value->url = $tag_item->url;
					}else{
						$value->name = 'unknown_tag';
						$value->url = '#';
					}
				}
				$ret->tag = $tag;
			}else{
				$ret->tag = (object)[];
			}

		}
		else{
			$ret = '404';
		}
		
		
		
		return $ret;
	}
	
	public function getall($category = NULL){
		
		if($category == NULL)
		{
			return $this->db->get('post_info');
		}
		else{
			$this->db->where('category', $category);
			return $this->db->get('post');
		}
		
	}


	public function get_comment($id){
		$this->db->where('post_id',$id);
		$ret = $this->db->get('post_comment_info');
		
		
		return $ret;
	}

	public function get_comment_w_slug($slug){
		$ID = $this->getIDFromSlug($slug);
		$this->db->where('post_id',$ID);

		$ret = $this->db->get('post_comment_info');
		if($ret->num_rows() > 0){
			$ret = $ret->result();
			foreach ($ret as $value) {
				$this->db->where('id', $value->author);
				$t = $this->db->get('users');
				if($t->num_rows() > 0){
					$t = $t->row();
					$value->profile_pic = $t->profile_pic;
				}
			}
		}

		return $ret;
	}

	public function get_category(){
		$data = $this->db->get('posts_categories');
		if($data->num_rows() > 0){
			$data = $data->result();
			foreach ($data as $value) {
				$this->db->where('category', $value->id);
				$data2 = $this->db->get('post');
				$value->total = $data2->num_rows();
			}
			return $data;
		}
		else{
			return (object)[];
		}
	}

	public function get_tag(){
		$data = $this->db->get('posts_tags');
		if($data->num_rows() > 0){
			$data = $data->result();
			return $data;
		}
		else{
			return (object)[];
		}
	}

	public function getIDFromSlug($slug){
		$this->db->where('slug',$slug);
		$ID = $this->db->get('post_info');
		
		if(!empty($ID->result())) {
			return $ID->row(1)->id;	
		}else{
			return '404';
		}
		 

	}

	public function writeComment($arr){
		$dd = $arr;
		$dd['post_id'] = $this->getIDFromSlug($dd['post_id']);
        $this->db->insert('posts_comments',$dd);
        echo $this->db->last_query();
	}

	public function get_tutorial(){
	  $this->db->where('category','2');
      $ret = $this->db->get('post_info');
		//print_r($ret);
		return $ret;
	}

	public function get_informasi(){
	  $this->db->where('category','1');
      $ret = $this->db->get('post_info');

		//print_r($ret);
		return $ret;
	}
	


}
	// 
	
