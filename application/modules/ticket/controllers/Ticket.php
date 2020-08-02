<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends FrontendController {

    function __construct() {
        parent::__construct();
        $this->load->model('ticket_m');
        $this->load->helper('captcha');

    }

    public function index() {
        $data = array();
        $this->template->set_layout('frontpage_normal');
        if ($this->ion_auth->logged_in()) :

            $list = $this->input->post('get_list_ticket');
            $add = $this->input->post('add_ticket');
            $update = $this->input->post('update_ticket');

            if($list){
                $filter = json_decode($this->input->post('filter'));
                $data = $this->ticket_m->list_ticket($filter);
                echo json_encode($data);
            }elseif ($add) {
                $data = json_decode($this->input->post('data'));
                $inputcaptcha = (isset($data->captcha)) ? strtolower($data->captcha) : '';
                $sesscaptcha = strtolower($this->session->userdata('captchaCode'));

                //echo $inputcaptcha . " " . $sesscaptcha;


               // print_r($data);
                if($inputcaptcha == $sesscaptcha){
                    $status = $this->ticket_m->add_ticket($data);
                    header('Content-Type: application/json');
                    echo json_encode($status);    
                }else{
                    header('Content-Type: application/json');
                    echo json_encode((object)['message' => 'Kode Captcha Tidak Cocok, Coba lagi', 'status' => 0]);   
                }
                
            }elseif ($update) {
                $data = json_decode($this->input->post('data'));
                $status = $this->ticket_m->update_ticket($data);
                echo json_encode($status);
            }else{
             
                    $this->load->view('ticket/ticket_list_v',$data);     
                               
               // echo get_ticketCode();
            }
        else:
            $this->session->set_flashdata('message', "Silahkan login terlebih dahulu");
            $this->session->set_userdata('redirect_back', base_url('ticket') ); 
            redirect('/login','refresh');
		endif;
    }

   // public function get_last_insert_ticket(){
        //echo json_encode($this->ticket_m->get_last_insert_ticket());
  //  }

    public function changeStatus(){
    	$Trr = json_decode($this->input->post('data'));
        $valid = true;
        foreach ($Trr as $val) {
            $ticket_code = $val->ticket_code;
            $status_baru = $val->status_id;
            if(!$this->ticket_m->change_status_ticket($ticket_code, $status_baru)){
                $valid = false;
            }
        }
        $this->output
        ->set_content_type('application/json')
        ->set_status_header(($valid) ? '200' : '500')
        ->set_output(json_encode((object)['messages' => ($valid) ? 'sukses' : 'Gagal']));
    	
    }

    public function add_task(){
        $data  = json_decode($this->input->post('data'));
        $ticket_id = $data->ticket_id;
        $adder = isset($data->adder) ? $data->adder : $this->ion_auth->users()->row()->id;
        $assignee_id = $data->assignee_id;
        $pesan = $data->pesan;
        $name = $data->name;

        $h = $this->ticket_m->add_task($ticket_id,$assignee_id, $name ,$pesan,$adder);
        
            $this->output
        ->set_content_type('application/json')
        ->set_status_header(($h) ? '200' : '403')
        ->set_output('');

    }

    public function get_task_open(){
        $post = json_decode($this->input->post('data'));
        $task_id = isset($post->task_id) ? $post->task_id : '0';
        $list = $this->ticket_m->get_task_open($task_id);

        if(count((array) $list)  > 0){
            $name = $this->ion_auth->user($list->asignee)->row();
            $list->nama_assignee = ($list->asignee == '0' ? '--' : $name->first_name  .  ' '  .  $name->last_name);
            $name = $this->ion_auth->user($list->creator)->row();
            $list->nama_creator = ($list->creator == '0' ? '--' : $name->first_name  .  ' '  .  $name->last_name);
            $ticket = $this->db->get_where('ticket', array('id' => $list->ticket_id));
            $list->tracking_id = ($ticket ? ($ticket->num_rows() > 0 ? $ticket->row()->ticket_code : '##') : '##');

            if(count((array) $list->reply)  > 0){
                foreach ($list->reply as $val) {
                        $name = $this->ion_auth->user($val->replier_id)->row();
                        $val->nama_replier = ($val->replier_id == '0' ? '--' : $name->first_name  .  ' '  .  $name->last_name);
                        $val->profile_pic = $name->profile_pic;

                }
                $arr = (array)$list->reply;
                //print_r(end($arr));
                $list->last_reply = end($arr);
            }

        }

        $this->output
        ->set_content_type('application/json')
        ->set_status_header('200')
        ->set_output(json_encode($list));


    }

    public function change_status_task(){
        $data  = json_decode($this->input->post('data'));
        $task_id = isset($data->task_id) ? $data->task_id : null;
        $status_id = isset($data->status_id) ? $data->status_id : null;

        $this->db->where('id', $task_id);
        $ret = $this->db->update('task', array('status_id' => $status_id));
         $this->output
        ->set_content_type('application/json')
        ->set_status_header($ret ? 200 : 502);


    }

    public function add_task_reply(){
         $data  = json_decode($this->input->post('data'));
         $task_id = isset($data->task_id) ? $data->task_id : null;
         $replier = isset($data->replier) ? $data->replier : null;
         $content = isset($data->content) ? $data->content : null;
        // echo !is_null($task_id) &&  !is_null($replier)  && !is_null($content) ;

         if(1 ){
                $insert =  $this->db->insert('task_reply', array('task_id' =>  $task_id, 'replier_id' => $replier, 'content' => $content));

            //    echo $this->db->last_query();
         }  

          $this->output
        ->set_content_type('application/json')
        ->set_status_header($insert ? 200 : 502);
        
    }

    public function get_task_list(){
        $data  = json_decode($this->input->post('data'));
        $filter = $data;

        //print_r($data);

        $list = $this->ticket_m->get_task_list($filter);
       // print_r($list->list);
        foreach ($list->list as $val) {
            $name = $this->ion_auth->user($val->asignee)->row();
            $val->nama_assignee = ($val->asignee == '0' ? '--' : $name->first_name  .  ' '  .  $name->last_name);
            $name = $this->ion_auth->user($val->creator)->row();
            $val->nama_creator = ($val->creator == '0' ? '--' : $name->first_name  .  ' '  .  $name->last_name);
            $ticket = $this->db->get_where('ticket', array('id' => $val->ticket_id));
            $val->tracking_id = ($ticket ? ($ticket->num_rows() > 0 ? $ticket->row()->ticket_code : '##') : '##');
        }

           $this->output
        ->set_content_type('application/json')
        ->set_status_header('200')
        ->set_output(json_encode($list));

    }



    public function changeAsignee(){

        $Trr = json_decode($this->input->post('data'));
        $valid = true;
        foreach ($Trr as $val) {
        $ticket_code = $val->ticket_code;
        $assignee_id = (isset($val->assignee_id) ? $val->assignee_id : false);
        
            if(!$this->ticket_m->changeAsignee($ticket_code, $assignee_id)){
                //$valid = false;
            }
        }
        $this->output
        ->set_content_type('application/json')
        ->set_status_header(($valid) ? '200' : '500')
        ->set_output(json_encode((object)['messages' => ($valid) ? 'sukses' : 'Gagal']));
    }

    public function delete(){
    	

        $Trr = json_decode($this->input->post('jsdata'));
        $valid = true;
        foreach ($Trr as $val) {
        $ticket_code = $val->ticket_code;
        $permanent = (isset($val->permanent) ? $val->permanent : false);
        
            if(!$this->ticket_m->delete($ticket_code, $permanent)){
                $valid = false;
            }
        }
        $this->output
        ->set_content_type('application/json')
        ->set_status_header(($valid) ? '200' : '500')
        ->set_output(json_encode((object)['messages' => ($valid) ? 'sukses' : 'Gagal']));

    	
    }

    public function test(){
       // $ticket_code = 'TK24-026-HoAvJ';
        //$status_baru = 1;
       // $asignee = 2;
       // $this->ticket_m->change_status_ticket($ticket_code, $status_baru);
       // $this->ticket_m->delete($ticket_code, true);
       // $this->ticket_m->changeAsignee($ticket_code,$asignee);
        //$obj = (object)['filter' => (object)['equal' => (object) ['id' => '1'] ] ];
        //print_r($obj);
      // echo json_encode($this->ticket_m->get_task_list($obj)) ;
        //echo json_encode($this->ticket_m->get_task_open(1));
        $this->get_task_open();
    }

    public function o(){
    	 $data = array();
         
        $this->template->set_layout('frontpage_normal');
       // $this->modules->render('ticket/ticket_open_v',$data);
        $this->load->view('ticket/ticket_open_v',$data);
    
    }

    public function getFromId(){
    	$data = $this->ticket_m->getTicketWReply($this->input->post('ticket_code'),$this->input->post('requester'),$this->input->post('isAdmin'));
    	echo(json_encode($data));


    }

    public function setTicketEvent(){
        $data = json_decode($this->input->post('data'));
        return $item = $this->ticket_m->setTicketEvent($data);

    }

    public function get_ticket_category(){
        $data = json_decode($this->input->post('data'));
        $active  = (bool) (isset($data->active) ? $data->active : 0);
        $all = (bool) (isset($data->all) ? $data->all : 1);

        echo json_encode($this->ticket_m->get_ticket_category($active,$all));
    }

    public function get_ticket_status(){
        $data = json_decode($this->input->post('data'));
        $active  = (bool) (isset($data->active) ? $data->active : 0);
        $all = (bool) (isset($data->all) ? $data->all : 0);
        $id = (bool) (isset($data->id) ? $data->id : false);

        echo json_encode($this->ticket_m->get_ticket_status($id,$active)->result());
    }


    public function get_ticket_priority(){
        $data = json_decode($this->input->post('data'));
        $active  = (bool) (isset($data->active) ? $data->active : 0);
        $all = (bool) (isset($data->all) ? $data->all : 0);
//print_r($data);
        //echo $all;
        echo json_encode($this->ticket_m->get_ticket_priority($active,$all));
    }

    public function writeReply(){
        $data = json_decode($this->input->post('data'));
    	$Tp = array(
    		'ticket_id' => $data->ticket_id,
    		'replier_id' => $data->replier,
    		'content' => $data->content,
    	 );
        $attachment = $data->attachment;

         $inputcaptcha = (isset($data->captcha)) ? strtolower($data->captcha) : '';
                $sesscaptcha = strtolower($this->session->userdata('captchaCode'));
                if($inputcaptcha == $sesscaptcha){
                    $data = $this->ticket_m->writeReply($Tp,$attachment);

                    header('Content-Type: application/json');
                    //echo json_encode($status);    
                    echo json_encode((object)['message' => 'Suskes', 'status' => 1]);   
                }else{
                    header('Content-Type: application/json');
                    echo json_encode((object)['message' => 'Kode Captcha Tidak Cocok, Coba lagi', 'status' => 0]);   
                }

    	
    }
    public function upload_attachment()
{

    $json = array();

    $config['upload_path']          = dirname($_SERVER["SCRIPT_FILENAME"]).'/assets/common/attachment/temp/';
    $config['allowed_types']        = 'gif|jpg|png|pdf|doc|docx|txt|ppt|pptx|vsd|vsdx|zip|rar|7z'; //config attachment
    $config['encrypt_name']                 = TRUE;

    $this->load->library('upload', $config);

    $this->upload->initialize($config);

    if ( ! $this->upload->do_upload('file') )
    {
        $json = array('error' => true, 'message' => $this->upload->display_errors());
    }
    else
    {
        $upload_details = $this->upload->data();

        $json = array('success' => true, 'message' => 'File transfer completed', 'name'=> $upload_details['file_name'],
            'path_tmp' => base_url() .'assets/common/attachment/temp/'. $upload_details['file_name'],
            'path' => './assets/common/attachment/temp/'. $upload_details['file_name'],
            'ext' => $upload_details['file_ext'],
            'size'=> $upload_details['file_size']
            );
    }
   // print_r($config);
    echo json_encode($json);
}	


public function add_ticket_priority(){
    $data = json_decode($this->input->post('data'));
    $nama = $data->nama;
    $default = (isset($data->default) ? $data->default : 0);



    $to_Save = array('nama' => $nama, 'default' => $default);

    if( !compare_item('nama', $data->nama, 'tickets_priority')) {
        $st = $this->ticket_m->add_ticket_priority($to_Save);
        if($st){
            echo json_encode((object)['status' => '1', 'priority_id' => $st]);
        }else{
            echo json_encode((object)['status' => 0]);
        }
    }else{
        echo json_encode((object)['status' => 0, 'dupe_name' => 1]);
    }

}

public function edit_ticket_status(){
    $data = json_decode($this->input->post('data'));
    $ticket_id = $data->ticket_id;
    $val = $data->val;
   // echo 'asdadas' . $ticket_id;
  //  print_r($this->input->post())
    $hasil = $this->ticket_m->edit_ticket_status((object)['id' => $ticket_id, 'status_id' => $val]);
   // echo $this->db->last_query();
    echo json_encode($hasil);
}

public function edit_ticket_category(){
    $data = json_decode($this->input->post('data'));
    $ticket_id = $data->ticket_id;
    $val = $data->val;
   // echo 'asdadas' . $ticket_id;
  //  print_r($this->input->post())
    $hasil = $this->ticket_m->edit_ticket_category((object)['id' => $ticket_id, 'kategori_id' => $val]);
    echo json_encode($hasil);
}



public function edit_ticket_priority(){
    $data = json_decode($this->input->post('data'));
    $nama = $data->nama;
    $default = $data->default;
    $active = $data->active;
    $id = $data->id;

    $data_before = $this->ticket_m->get_ticket_priority(0,0,$id)->data->row()->nama;

//print_r($data_before); 
    $to_Save = array('id' => $id,'nama' => $nama, 'default' => $default, 'active' => $active);

    $cek =  !(compare_item('nama', $data->nama, 'tickets_priority') &&  $nama != $data_before); 
    

    if($cek) {
        $st = $this->ticket_m->edit_ticket_priority($to_Save);
        if($st){
            echo json_encode((object)['status' => '1', 'priority_id' => $st]);
        }else{
            echo json_encode((object)['status' => 0]);
        }
    }else{
        echo json_encode((object)['status' => 0, 'dupe_name' => 1]);
    }

}

public function get_task(){
    $data = json_decode($this->input->post('data'));
    $id = (isset($data->id) ? ($data->id != '' ? $data->id : FALSE) : FALSE);
    $ticket_id = (isset($data->ticket_id) ? ($data->ticket_id != '' ? $data->ticket_id : FALSE) : FALSE);
    $id = (isset($data->asignee) ? ($data->asignee != '' ? $data->asignee : FALSE) : FALSE);
    //print_r($data);

    $value = $this->ticket_m->get_task($data);

    echo json_encode($value);
}


    
}