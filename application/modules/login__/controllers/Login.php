



<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends FrontendController {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	public function index() {
    	    $this->load->library('user_agent');  // load user agent library
    // save the redirect_back data from referral url (where user first was prior to login)
    		$this->session->set_userdata('redirect_back', $this->agent->referrer() ); 

    	$data = array();
        $this->template->set_layout('frontpage_normal');
        $this->modules->render('login/login_v',$data);
    }
	

}
