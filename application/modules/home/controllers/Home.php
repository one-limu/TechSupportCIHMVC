<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends FrontendController {

    function __construct() {
        parent::__construct();
		$this->load->model('post/post_model');
    }

    public function index() {
		// Post list data  //
		$data['post_list'] = 
						array(
							"information" => $this->post_model->getall('1')->result(),
							"tutorial" => $this->post_model->getall('2')->result(),
		);
		// End Post List //

		$this->template->set_layout('frontpage_normal');
        $this->load->view('home/home_v',$data);
		
    }

    

}