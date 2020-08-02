<?php class Ticket_m extends CI_Model {

       

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
                $this->load->database();
                $this->load->helper('file');
                $this->load->model(array('log/log_m','user/user_m'));

              


        }


        public function _count_row($tblname="",$data){
        $status = $data;
        $arr = (array)$status;
        if(!empty($arr)){
           $status->limit = (object) [];
           _get_query($status);
        }

        $o=$this->db->get($tblname)->num_rows();
        
        return $o;

    }

    public function delete($ticket_code,$permanent = false){
           $uid= null;
                if($this->ion_auth->logged_in()){
                    $uid = $this->ion_auth->user()->row()->id;
                }else{
                    return 0;
                }
        $ticket_data = $this->db->get_where('ticket', array('ticket_code' => $ticket_code))->row();

        
        if($permanent){

            if($this->log_m->write_log(LOG_DELETE_TICKET_PERMANENT,$uid,(object)['info_1' => $ticket_code])){
                $this->db->where('ticket_code', $ticket_code);
                $this->db->delete('ticket');
                return 1;
            }else{
                return 0;
            }
        }else{
            if($ticket_data->active == '0'){
                return 0;
            }else{
                $this->db->where('ticket_code', $ticket_code);
                if($this->db->update('ticket', array('active' => '0'))){
                $this->log_m->write_log(LOG_DELETE_TICKET,$uid,(object)['info_1' => $ticket_code]);
                return 1;
            }else{
                return 0;
            }
            }
        }
    }

    public function change_status_ticket($ticket_code, $status_baru){
          $uid= null;
                if($this->ion_auth->logged_in()){
                    $uid = $this->ion_auth->user()->row()->id;
                }else{
                    return 0;
                }


        if($status_baru == 0 ){
            $event_id = TICKET_REPLY_EVT_CLOSE;
        }elseif ($status_baru == 1) {
            $event_id = TICKET_REPLY_EVT_OPEN;
        }elseif ($status_baru == 2) {
             $event_id = TICKET_REPLY_EVT_LOCKED;
        }
        
        $status_lama = $this->db->get_where('ticket', array('ticket_code' => $ticket_code))->row();
        //echo $this->db->last_query();
        //print_r($status_lama);
        $data__ = (object)['ticket_id' => $status_lama->id, 'reply_event_id' => $event_id, 'content' => $status_baru];

        
        if($status_baru != $status_lama->status_id){

            $this->db->where('ticket_code', $ticket_code);
            if($this->db->update('ticket', array('status_id' => $status_baru))){
            
            $info_3 = $this->get_ticket_status($status_baru)->row()->name;
            $info_2 = $this->get_ticket_status($status_lama->status_id)->row()->name;
             $this->log_m->write_log(LOG_CHANGE_TICKET_STATUS,$uid,(object)['info_1' => $ticket_code, 'info_2' => $info_2, 'info_3' => $info_3]);
             //echo $this->db->affected_rows();
             $this->setTicketEvent($data__);
             return 1;
        }
        }else{
            return 1;
        }
    }

    public function changeAsignee($ticket_code, $asignee_baru){
         $uid= null;
                if($this->ion_auth->logged_in()){
                    $uid = $this->ion_auth->user()->row()->id;
                }else{
                    return 0;
                }
        $ticket_lama = $this->db->get_where('ticket', array('ticket_code' => $ticket_code))->row();
        $data__ = (object)['ticket_id' => $ticket_lama->id, 'reply_event_id' => TICKET_REPLY_EVT_ASIGNEE, 'content' => $asignee_baru];

        if($asignee_baru != $ticket_lama->crm_id){
            $this->db->where('ticket_code', $ticket_code);
            if($this->db->update('ticket', array('crm_id' => $asignee_baru))){
            
            $info_3 = $this->ion_auth->users($asignee_baru)->row();
            $info_3 = $info_3->first_name . ' ' . $info_3->last_name;
            
            if($ticket_lama->crm_id != '0'){
                $info_2 = $this->ion_auth->users($ticket_lama->crm_id)->row();
                $info_2 = $info_2->first_name . ' ' . $info_2->last_name;
            }else{
                $info_2 = 'undefined';
            }

             $this->log_m->write_log(LOG_CHANGE_TICKET_ASIGNEE,$uid,(object)['info_1' => $ticket_code, 'info_2' => $info_2, 'info_3' => $info_3]);
             //echo $this->db->affected_rows();
             $this->setTicketEvent($data__);
             return 1;
        }
    }
}   

    public function get_task_list($filter){
        $tblname = 'task';
        _get_query($filter);
        $result = $this->db->get($tblname);
        $result_num_rows = ($result ? $result->num_rows() : 0);
        $total_row = _count_rows($tblname,$filter);
        $_displayed = _get_displayed($filter, $total_row, $result_num_rows );
        
        $rtr = (object) [
                         'list' => $result_num_rows > 0 ? $result->result() : array()
                       , 'total_row' => $total_row
                       , 'displayed' => $_displayed

                       ];
        return $rtr;
    }

    public function get_task_open($id = null){
        if(!$id){
            return array();
        }

       // echo "1";
        $task = $this->db->get_where('task', array('id' => $id));
       // echo "2";
        $reply = $this->db->get_where('task_reply', array('task_id' => $id));
        //echo "3";
        //echo $this->db->last_query();

        if($task){
            //echo "4";
            $task = $task->num_rows() > 0 ? $task->row() : array();
            //echo "5";
                if(!empty($task)){
                    //echo "6";
                    if($reply){
                       // echo "7";
                        $task->reply = $reply->num_rows() > 0 ? $reply->result() : array();
                       // echo "8";
                        $task->reply_num_rows = $reply->num_rows();
                    }else{
                        $task->reply = array();
                      //  echo "9";
                        $task->reply_num_rows = 0;
                      //  echo "10";
                    }
                }
        }else{
//echo "11";
            $task = array();
        }
       // print_r($task);

        return $task;
    }
    
    public function list_ticket($data)
    {   
        $tblname = "view_ticket";

        _get_query($data->filter);
        $this->db->where('active','1');
        $result = $this->db->get($tblname);
        ////echo $this->db->last_query();
        ////print_r($status);

        $status = $data->filter;
        $from = ($status->limit->offset) + 1;  
        $to = $status->limit->limit * ($status->limit->offset / $status->limit->limit + 1);


        $total_row = $this->_count_row($tblname,$status);
        if($to > $total_row){
            $to = $total_row;
        }

        _get_query($data->filter);
        $this->db->where('active','1');
        $this->db->where('user_read_status','0');
        $unread_user = $this->db->get($tblname);
      
       
        
        $rtr = (object) ['data' => 
                            ['list' => $result->result(),
                             'addition' => 
                                    ['t_category' => $this->db->get('tickets_category')->result(),
                                     't_priority' => $this->db->get('tickets_priority')->result()
                                    ]
                            ]
                       , 'total_row' => $total_row
                       , 'displayed' => (object)['from' => $from, 'to' => $to]

                       ];
        ////print_r($rtr);

        return $rtr;
            }



/*

        public function changeStatus($Trr){
            for ($i=0; $i < sizeof($Trr) ; $i++) {
            $data = array(
               'status_id' => $Trr[$i]->status_id,
            );
             $this->db->where('id', $Trr[$i]->ticket_id);
             $this->db->update('ticket', $data);
        }
        }
*/
/*
        public function delete($Trr,$real = false){
             
             
          for ($i=0; $i < sizeof($Trr) ; $i++) {
            $this->db->where('id', $Trr[$i]->ticket_id);
            //echo $Trr[$i]->ticket_id;
             if ($real) {
                $this->db->delete('ticket');
             }else{
                $data = array(
               'active' => 0,
                 );
         /       $this->db->update('ticket', $data);
         //    }
      //  }
    //}
*/
    public function get_ticket($filter){
        //$last_id = $this->db->insert_id();
        //$this->db->where('id',$id);
        //return $this->db->get('ticket')->result();
        _get_query($filter);
        return $this->db->get('view_ticket');
    }
    
    public function add_task($t_id, $a_id,$j, $p, $adder){
        $item = array('name' => $j, 'asignee' => $a_id, 'creator' =>$adder, 'content' => $p, 'ticket_id' => $t_id);

        if($this->user_m->is_user_has_privilege('task_assignee', $a_id)){
             $this->db->insert('task', $item);
            return true;
        }else{
            return false;
        }
    }

    public function add_ticket($data){
        $r = '0';
        $creator_id = $data->data->creator_id;
        $arr = (array)$data->data;
        $last_id = "";
        if(!empty($arr)){
            
            $r = $this->db->insert('ticket',$data->data);
            $last_id = $this->db->insert_id();

            $code = "";
            $unique = 0;
            while (!$unique) {
                $code = get_ticketCode();
                $this->db->where('ticket_code',$code);
                $unique = ($this->db->get('ticket')->num_rows() == 0 ? 1 : 0);
            }
            $this->db->where('id',$last_id);
            $r = $this->db->update('ticket', (object) ['ticket_code' => $code ]);
        }
        if(isset($data->attachment)) {
            if(!empty((array) $data->attachment)){         
            //$id_attachment = []
            foreach ($data->attachment as $key => $val) {
                unset($val->path_tmp);
                ////print_r($val);
                $path = $val->path;
               // //echo $path;
                $data = file_get_contents($path);
             //   //echo FCPATH . 'assets\common\attachment\file\ ';
               // //echo $data;
                if ( ! write_file(FCPATH . 'assets\common\attachment\file\\' . $val->nama, $data))
                {
                       // //echo 'Unable to write the file';
                    
                }
                else
                {       
                    $dd = $path;
                    if(file_exists($dd)){
                        unlink($dd);
                    }   
                        $val->path = "assets/common/attachment/file/";
                        $this->db->insert('attachments',$val);
                        $this->db->insert('tickets_attachment',(object)['id_ticket'  => $last_id, 'id_attachment' => $this->db->insert_id()]);
                }
           


            }
        }
    }
        ////echo $this->db->last_query();
        $inserted_ticket = $this->db->get_where('view_ticket', array('ticket_id' => $last_id));
        ////echo json_encode();   
        //header('Content-Type: application/json');
        ////echo json_encode);
        ////echo $creator_id;
        $item = (object)[
            'replier_id' => $creator_id,
            'reply_event_id' => 2,
            'ticket_id' => $last_id
            ];
         $this->setTicketEvent($item);

        $OK = (object)['message' => 'Data Berhasil di Simpan', 'status' => 1, 'inserted_ticket' => $inserted_ticket->result()];
        $NO = (object)['message' => 'Data Gagal di Simpan', 'status' => 0];

        if($r){
            //tulis log
            $user_id = $this->ion_auth->user()->row()->id;
            $this->log_m->write_log(LOG_CREATE_TICKET,$user_id,(object)['info_1' => $last_id]);
        }

        return (($r) ? $OK : $NO );
    }


    public function getTicketWReply($id, $requester = "", $isAdmin = FALSE){
        $this->db->where('ticket_code', $id);
        $ticket = $this->db->get('view_ticket')->row();

       // //echo $this->db->last_query();
       // //print_r($ticket);
        $this->db->where('ticket_id', $ticket->ticket_id);
        $reply = $this->db->get('tickets_reply');
        if($reply->num_rows() > 0){
            $reply = $reply->result();

            foreach ($reply as $item) {
                $this->db->where('id', $item->replier_id);
                $replier_data = $this->db->get('users');
                if($replier_data->num_rows() > 0) {
                    $item->profile_pic = $replier_data->row()->profile_pic;
                    $item->replier_name = $replier_data->row()->first_name . ' ' . $replier_data->row()->last_name;
                }else{
                    $item->profile_pic = '';
                }
                $item->date_made = strtotime($item->date_made);

                $this->db->where('id_reply', $item->reply_id);
                $ad = $this->db->get('tickets_reply_attachment');
                if($ad->num_rows() > 0){
                    $ad = $ad->result();
                    $item->attachment = array();
                    foreach ( $ad as $item2) {
                        $this->db->where('id', $item2->id_attachment);
                        $a_id = $this->db->get('attachments');
                        if ($a_id->num_rows() > 0) {
                            $a_id = $a_id->row();

                            $a = (object)[];
                            $a->nama = $a_id->nama;
                            $a->path = $a_id->path;
                            $a->ext = $a_id->ext;
                            array_push($item->attachment, $a);
                        }
                    }
                }
            }
        }else{
            $reply = $reply->result();
        }

        $this->db->where('id_ticket', $ticket->ticket_id);
        $attachment = $this->db->get('tickets_attachment')->result();
        foreach ($attachment as $key) {
            $this->db->where('id', $key->id_attachment);
            $item = $this->db->get('attachments');
            if ($item->num_rows() > 0) {
                $item = $item->row();
                $key->nama = $item->nama;
                $key->path = $item->path;
                $key->ext = $item->ext;
            }

        }

        $num_replier = $this->db->get_where('tickets_reply', array('ticket_id' => $ticket->ticket_id, 'reply_event_id' => '1'), 'DESC');
        ////echo $this->db->last_query();
        $ticket->num_replier = $num_replier->num_rows();
        $ticket->tanggal_dibuat = strtotime($ticket->tanggal_dibuat);
        $ticket->tanggal_update = strtotime($ticket->tanggal_update);
        $id_last_replier = '0';

        if($num_replier->num_rows() > 0){
         $name = $this->ion_auth->user($num_replier->row()->replier_id)->row();
         $id_last_replier =   $num_replier->row()->replier_id;
         $ticket->last_replier = $name->first_name . ' ' . $name->last_name;
        }else{
            $ticket->last_replier = '-';
        }
        

        if($requester == $id_last_replier){

        }else{
            if($isAdmin){
                $this->set_ticket_admin_read_status($ticket->ticket_id, TRUE);
            }else{
                $this->set_ticket_user_read_status($ticket->ticket_id, TRUE);
            }
        }
           
            
        
   

        return $TY = array('ticket' => $ticket, 'reply' => $reply , 'attachment' => $attachment);

    }

    private function set_ticket_user_read_status($id,$status = FALSE){
        if($status){
            $status = 1;
        }else{
            $status = 0;
        }

        $this->db->where('id', $id);
        return $this->db->update('ticket', array('user_read_status' => $status));
        
    }

    private function set_ticket_admin_read_status($id,$status = FALSE){
        if($status){
            $status = 1;
        }else{
            $status = 0;
        }

        $this->db->where('id', $id);
        return $this->db->update('ticket', array('admin_read_status' => $status));
       
    }


    public function setTicketEvent($data){
        $item = array(
            'replier_id' => $this->ion_auth->user()->row()->id,
            'reply_event_id' => $data->reply_event_id,
            'ticket_id' => $data->ticket_id,
            'content' => (isset($data->content) ? $data->content : '')
            );
       
        if($data->reply_event_id == TICKET_REPLY_EVT_CREATE){
            $this->db->insert('tickets_reply', $item);
        }
        elseif ($data->reply_event_id == TICKET_REPLY_EVT_CLOSE) {
            $this->db->where('id', $data->ticket_id);
            ////echo $data->ticket_id;
            $current_status = $this->db->get('ticket')->row()->status_id;
            //if($current_status != $data->content){
                $this->db->insert('tickets_reply', $item);
            //}
            
        }elseif($data->reply_event_id == TICKET_REPLY_EVT_OPEN){
            $this->db->where('id', $data->ticket_id);
            $current_status = $this->db->get('ticket')->row()->status_id;
            //if($current_status != $data->content){
                $this->db->insert('tickets_reply', $item);
            //}
         }elseif($data->reply_event_id == TICKET_REPLY_EVT_LOCKED){
            $this->db->where('id', $data->ticket_id);
            $current_status = $this->db->get('ticket')->row()->status_id;
            //if($current_status != $data->content){
                $this->db->insert('tickets_reply', $item);
           // }
         }elseif($data->reply_event_id == TICKET_REPLY_EVT_CATEGORY){
            $this->db->where('id', $data->ticket_id);
            $current_kategori = $this->db->get('ticket')->row()->kategori_id;
            if($current_kategori != $data->category_id){
                $this->db->insert('tickets_reply', $item);
            
            }
        }elseif($data->reply_event_id == TICKET_REPLY_EVT_ASIGNEE){
            $this->db->insert('tickets_reply', $item);
        }

        if ($this->db->affected_rows() == 1) {
            return 1;
        }else{
            return 0;
        }

    }

    public function writeReply($data,$attachment){

        ////print_r($data);
        $r = $this->db->insert('tickets_reply', $data);
        $last_id = $this->db->insert_id();
        if(!empty((array) $attachment)){
                foreach ($attachment as $key => $val) {
                //  //print_r($val);
                unset($val->path_tmp);
                ////print_r($val);
                $path = $val->path;
                ////echo $path;
                $data_attachment = file_get_contents($path);
             //   //echo FCPATH . 'assets\common\attachment\file\ ';
               // //echo $data_attachment;
                if ( ! write_file(FCPATH . 'assets\common\attachment\file\\' . $val->nama, $data_attachment))
                {
                       // //echo 'Unable to write the file';
                    
                }
                else
                {       
                    $dd = $path;
                    if(file_exists($dd)){
                        unlink($dd);
                    }   
                        $val->path = "assets/common/attachment/file/";
                         ////print_r($val);
                        $this->db->insert('attachments',$val);
                        $attachment_id = $this->db->insert_id();
                        $this->db->insert('tickets_reply_attachment',(object)['id_reply'  => $last_id, 'id_attachment' => $attachment_id]);
                }
           


            }
        }


        $this->db->where('id',$data['ticket_id']);
        $t = $this->db->get('ticket')->row();
      
        if($r && ($data['replier_id'] != $t->creator_id)){
            $this->db->where('id',$data['ticket_id']);
            $da = array('user_read_status' => '0');
            $this->db->update('ticket',$da);
            ////print_r($data);
        }else{
              $this->db->where('id',$data['ticket_id']);
            $da = array('admin_read_status' => '0');
            $this->db->update('ticket',$da);
        }
    // //echo $this->db->last_query();
        //print($this->db->last_query);
/*  
              $is =  $data['replier_id'] == $t->creator_id;
            if($is){
                $this->set_ticket_admin_read_status($data['ticket_id'], FALSE);
                
            }else{
                $this->set_ticket_user_read_status($data['ticket_id'], FALSE);
                
            }
*/
    


    }

    public function get_ticket_category($active = TRUE, $all = FALSE){
        
        if(!$all){
            $this->db->where('active', $active);
        }
        $cat_t = $this->db->get('tickets_category');
        if($cat_t){
            if($cat_t->num_rows() > 0){
                $cat_t = (object) ['data' => $cat_t->result()];
                return $cat_t;
            }else{
                return (object)[];
            }
        }else{
            return (object)[];
        }
    }

     public function get_ticket_priority($active = TRUE, $all = FALSE, $id = FALSE){
        if($active){
            $this->db->where('active', $active);
        }

        if($id != FALSE){
            $this->db->where('id', $id);
            $pri_t = $this->db->get('tickets_priority');
            if($pri_t->num_rows() > 0){
                return (object)['data' => $pri_t];    
            }else{
                return (object)[];
            }
            
        }

        //$this->db->where('active', $active);
        $pri_t = $this->db->get('tickets_priority');
       // //echo $this->db->last_query();
        if($pri_t){
            if($pri_t->num_rows() > 0){
                $pri_t = (object) ['data' => $pri_t->result()];
                return $pri_t;
            }else{
                return (object)[];
            }
        }else{
            return (object)[];
        }
    }

       public function get_ticket_status($id,$active = TRUE){
        if($active){
            $this->db->where('active', $active);
        }

        
            if($id != false){
                $this->db->where('id', $id);
            }
        
        $pri_t = $this->db->get('tickets_status');
        //echo $this->db->last_query();
        
        return $pri_t;    
      

    }


    public function set_ticket_priority_default($id){
        $this->db->update('tickets_priority', array('default' => 0));
        $this->db->where('id', $id);
        $this->db->update('tickets_priority', array('default' => 1));
    }

    public function add_ticket_priority($data){
        $s =  $this->db->insert('tickets_priority', $data);
         $insert_id = $this->db->insert_id();
        if($s){
             if($data['default']){
               
               $this->set_ticket_priority_default($insert_id);

        }
              return $insert_id;
        }else{
            return false;
        }

       
        
    }

    public function edit_ticket_priority($data){
        $this->db->where('id', $data['id']);
        $s =  $this->db->update('tickets_priority', $data);
             if($s){
                $insert_id = '';
             if($data['default']){
                $insert_id = $data['id'];
               $this->set_ticket_priority_default($insert_id);
        }
           return true;
         
        }else{
            return false;
        }


    }

    public function edit_ticket_status($data){
     
        if($data->status_id == 0 ){
            $event_id = TICKET_REPLY_EVT_CLOSE;
        }elseif ($data->status_id == 1) {
            $event_id = TICKET_REPLY_EVT_OPEN;
        }elseif ($data->status_id == 2) {
             $event_id = TICKET_REPLY_EVT_LOCKED;
        }
        

        $data__ = (object)['ticket_id' => $data->id, 'reply_event_id' => $event_id, 'content' => $data->status_id];
        $this->setTicketEvent($data__);

        $this->db->where('id', $data->id);
        $toDB = $this->db->update('ticket', $data);


        return $toDB;
    }


    public function edit_ticket_category($data){
           
        $event_id = TICKET_REPLY_EVT_CATEGORY;

            $event_data = (object)['ticket_id' => $data->id,'content' => $data->kategori_id , 'reply_event_id' => $event_id, 'category_id' => $data->kategori_id];
            $this->setTicketEvent($event_data);

        $this->db->where('id', $data->id);
        $toDB = $this->db->update('ticket', $data);
       // //echo $this->db->last_query();

    
        return $toDB;
    }

    public function get_task($data){

        if(isset($data->id)){
            $this->db->where('id', $data->id);
        }
        if(isset($data->ticket_id)){
            $this->db->where('ticket_id', $data->ticket_id);
        }
        if(isset($data->asignee)){
            $this->db->where('asignee', $data->asignee);
        }

        $get = $this->db->get('task');
        if($get->num_rows() > 0){
            $get = $get->result();
            foreach ($get as $val) {
                $asignee = $this->ion_auth->user($val->asignee)->row();
                $val->asignee_name = $asignee->first_name . ' ' . $asignee->last_name;
                $status = $this->db->get_where('task_status', array('id' => $val->status_id))->row();
                $val->status_name = $status->name;
            }
        }else{
            $get = array();
        }
        return $get;
    }

    public function _get_ticket($data){
        if(isset($data->ticket_id)){
            if(!empty($data->ticket_id)){
                $this->db->where('id', $data->ticket_id);
            }
        }
        if(isset($data->ticket_code)){
            if(!empty($data->ticket_code)){
                $this->db->where('ticket_code', $data->ticket_code);
            }
        }

        if(isset($data->crm_id)){
            if(!empty($data->crm_id)){
                $this->db->where('crm_id', $data->crm_id);
            }
        }

        if(isset($data->prioritas_id)){
            if(!empty($data->prioritas_id)){
                $this->db->where('prioritas_id', $data->prioritas_id);
            }
        }

        if(isset($data->status_id)){
            if(!empty($data->status_id)){
                $this->db->where('status_id', $data->status_id);
            }
        }

          if(isset($data->creator_id)){
            if(!empty($data->creator_id)){
                $this->db->where('creator_id', $data->creator_id);
            }
        }


    }



 }