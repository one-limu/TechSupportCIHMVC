<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends FrontendController {

    function __construct() {
        parent::__construct();
        $this->load->model('ticket_m');
    }

    public function index() {
        $data = array();
        $this->template->set_layout('frontpage_normal');
        $this->modules->render('ticket/ticket_list_v',$data);
        
    }


    public function fetchTicket($start, $number){
        echo json_encode($this->ticket_m->fetch($start, $number));
    }

     public function fetchTicketAll(){
        echo json_encode($this->ticket_m->fetchAll());
    }

    public function changeStatus(){
        $Trr = json_decode($_POST['jsdata']);
        $this->ticket_m->changeStatus($Trr);
        
    }

    public function delete(){
        $Trr = json_decode($_POST['jsdata']);
        $this->ticket_m->delete($Trr);
        
    }

    public function o($param){
         $data = array();
        $this->template->set_layout('frontpage_normal');
        $this->modules->render('ticket/ticket_open_v',$data);
    
    }

    public function getFromId(){
        $data = $this->ticket_m->getTicketWReply($this->input->post('id'));
        echo(json_encode($data));


    }

    public function writeReply(){
        $Tp = array(
            'ticket_id' => $this->input->post('ticket_id'),
            'replier_id' => $this->input->post('replier'),
            'content' => $this->input->post('content'),

         );

        $data = $this->ticket_m->writeReply($Tp);
    }


    public function ajax_list(){
        $list = $this->ticket_m->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ticket_m) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ticket_m->judul;
            $row[] = $ticket_m->tanggal_update;
            $row[] = $ticket_m->ticket_status;
            
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->ticket_m->count_all(),
                        "recordsFiltered" => $this->ticket_m->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }   

    

}