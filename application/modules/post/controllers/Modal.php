<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Modal extends FrontendController {

    function __construct() {
        parent::__construct();
        $this->load->model('post_model');
    }

    public function index() {
       echo "dd";
    }

    public function cek_before_comment(){
        $this->load->library('user_agent');
        $this->session->set_userdata('redirect_back', $this->agent->referrer() ); 
        $this->session->set_userdata('redirect_back_to_id', "comment_field" ); 


        $data = array();
        $this->template->set_layout('blank_template');
        $this->modules->render('post/modal/modal_cek_b_comment_v',$data);
    }

    

}