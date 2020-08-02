<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

   
    function __construct() {
        parent::__construct();
       
    }

}

class CommonController extends CI_Controller
{
	
	var $_container;
    var $_modules;
	var $_layout_dir;
	var $_view_dir;
	
    public function __construct()
    {
        parent::__construct();
		// Load Base CodeIgniter files
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('typography');

		// Load Base Bootsshop config file(s)
		$this->load->config('tssconfig');
		$this->load->library('ion_auth');
    }
	
}

class FrontendController extends CommonController
{

    function __construct() {
        parent::__construct();

        // Set container variable
		$this->_view_dir = 'tss_template_dir_front';
		$this->_layout_dir = $this->config->item($this->_view_dir);
        $this->_container = $this->_layout_dir . "layout.php";
		
		log_message('debug', 'CI Bootsshop : MY_Controller class loaded');
		//echo $this->_container;
		//echo "\nmodules :". $this->_modules;

    }
	
}

class BackendController extends CommonController
{

    function __construct() {
        parent::__construct();

        // Set container variable
		$this->_view_dir = 'tss_template_dir_back';
		$this->_layout_dir = $this->config->item($this->_view_dir);
        $this->_container = $this->_layout_dir . "layout.php";
		
        //$this->_modules = $this->config->item('modules_locations');

        log_message('debug', 'CI Bootsshop : MY_Controller class loaded');
		//echo $this->_view_dir;
		//echo "\nmodules :". $this->_modules;
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */

