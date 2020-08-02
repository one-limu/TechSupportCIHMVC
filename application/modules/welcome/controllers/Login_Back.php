<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Back extends BackendController {

    function __construct() {
        parent::__construct();
    }

    public function index() {
         $data['page'] = $this->_view_dir . "_" ."login";
        $this->load->view($this->_container, $data);
		echo $data['page'];
    }

    

}