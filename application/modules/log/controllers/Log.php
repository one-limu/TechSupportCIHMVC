<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends FrontendController {

    function __construct() {
        parent::__construct();
        $this->load->model('log_m');
        

    }

    public function index(){
        //$item = $
    }

    public function get_log(){
        $filter = json_decode($this->input->post('filter'));
        $log = $this->log_m->get_log((object)['filter' => $filter]);
        $log_type = $this->log_m->get_log_type();
        $logs = (object)[];
        $logs->log = $log;
        $logs->log_type = $log_type;
        echo json_encode($logs);
    }

    public function test(){
       // $this->log_m->write_log(LOG_CREATE_TASK,2,(object)['info_1' => 'Task#1','info_2' => 'TK24-026-jnXvz']);
        //$this->get_log();
       echo json_encode($this->log_m->get_report((object)['filter' => []])); 
    }

    public function get_report(){
        $filter = json_decode($this->input->post('filter'));
        $report = $this->log_m->get_report((object)['filter' => $filter]);
        //$log_type = $this->log_m->get_log_type();
        $reports = (object)[];
        $reports->report = $report;
        //$logs->log_type = $log_type;
        echo json_encode($reports);
    }

    public function write_log($id,$user_id,$info = array()){

        foreach ($info as $key => $value) {
            if($key == 'info_1'){
                $info_1 = $value;
            }
            if($key == 'info_2'){
                $info_2 = $value;
            }
            if($key == 'info_3'){
                $info_3 = $value;
            }
            if($key == 'info_4'){
                $info_4 = $value;
            }
            if($key == 'info_6'){
                $info_6 = $value;
            }
        }
    }


    
}