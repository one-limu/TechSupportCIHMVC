<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Gateway extends BackendController {

    function __construct() {
        parent::__construct();
    }

    public function index() {
       	$this->template->set_layout('frontpage_normal_2');
        $this->modules->render('welcome/welcomepage');
    }

    public function admin() {
       	$this->template->set_layout('backend_normal');
        $this->modules->render('welcome/welcomepage');
    }

       public function admin_login() {
       	$this->template->set_layout('backend_login');
        $this->modules->render('welcome/welcomepage');
    }

    

}