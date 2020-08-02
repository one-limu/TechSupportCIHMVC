<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends FrontendController {

    function __construct() {
        parent::__construct();
        $this->load->model('post_model');
    }

    public function index() {
       
    }

    //halaman "/tutorial"
    public function tutorial(){

        $data = array('tutorial' => $this->post_model->get_tutorial()->result()) ;
        $this->template->set_layout('frontpage_normal');
        $this->load->view('post/post_tutorial_v',$data);
    }

    public function get_category(){
        echo json_encode($this->post_model->get_category());
    }
     public function get_tag(){
        echo json_encode($this->post_model->get_tag());
    }
     public function get_knowledgebase(){
        $data = $this->post_model->get_knowledgebase();
        echo json_encode($data);
    }
    // halaman informasi
    public function informasi(){
        $data = array('informasi' => $this->post_model->get_informasi()->result());
        $this->template->set_layout('frontpage_normal');
        $this->load->view('post/post_informasi_v',$data);
    }

     // halaman knowledgebase
    public function knowledgebase(){
            $data = array(
                'tutorial' => $this->post_model->get_tutorial()->result(),
                'informasi' => $this->post_model->get_informasi()->result()
                );
            $this->template->set_layout('frontpage_normal');
            $this->load->view('post/knowledgebase_main_v',$data);
    }

    // ambil comment dari post
    public function getcomment($slug){
        $post_comment = $this->post_model->get_comment_w_slug($slug);
        echo json_encode($post_comment);
    }

    // mengambil dan menampilkan detail post
    public function o($id=NULL,$slug = NULL){
        if($slug == NULL){
            redirect('home','refresh');
        }else{

        $arr = array('id' => $id,'slug' => $slug );

        $post_detail = $this->post_model->get_post_w_slug($arr);
        
        if($post_detail == '404'){
            redirect('/home');
        } 

        $data = (object)["post_detail" => $post_detail];
        echo json_encode($data);
        }
    }
   
	// menulis komentar di post 
    public function writecomment(){
           $Tp = array(
            'post_id' => $this->input->post('post_id'),
            'author' => $this->input->post('author'),
            'content' => $this->input->post('content'),

         );

      print_r($Tp);
        $data = $this->post_model->writeComment($Tp);
    }
    

}