<?php class Log_m extends CI_Model {

       

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
                $this->load->database();
                $this->load->helper('file');

        }

        public function get_report(){
        $tblname = "ticket";
        $filter = isset($data->filter) ? $data->filter : (object)[];
        _get_query($filter);
        $ticket_total = $this->db->get($tblname);

        _get_query($filter);
        $this->db->where('status_id', 1);
        $ticket_open = $this->db->get($tblname);

        _get_query($filter);
        $this->db->where('status_id', 0);
        $ticket_closed = $this->db->get($tblname);





        $tblname = "task";
        $filter = isset($data->filter) ? $data->filter : (object)[];
        _get_query($filter);
        $task_total = $this->db->get($tblname);

        _get_query($filter);
        $this->db->where('status_id', 1);
        $task_open = $this->db->get($tblname);

        _get_query($filter);
        $this->db->where('status_id', 2);
        $task_closed = $this->db->get($tblname);


                
       

        ////print_r($list);
        //$pagination = $this->pagination($filter,$tblname);
        //return (object)['list' => $list, 'pagination' => $pagination];
        return (object)[
        'ticket' => ['ticket_all' => $ticket_total->num_rows(), 'ticket_open' => $ticket_open->num_rows(), 'ticket_closed' => $ticket_closed->num_rows()],
        'task' => ['task_all' => $task_total->num_rows(), 'task_open' => $task_open->num_rows(), 'task_closed' => $task_closed->num_rows()],

        ];
        }

       
    public function get_log($data)
    {   
        $tblname = "log_view";
        ////print_r($data);
        $filter = isset($data->filter) ? $data->filter : (object)[];
        ////print_r($filter);
        _get_query($filter);
        $list = $this->db->get($tblname);
       ////echo $this->db->last_query();
        if($list->num_rows() > 0){
            $list = $list->result();
               foreach ($list as $val) {
                $messages = $val->messages_main;
              $logger = $this->ion_auth->user($val->logger)->row();
              $logger = $logger->first_name . ' ' . $logger->last_name;
              
                preg_match_all('#\((.*?)\)#', $messages, $match);
               // //print_r($match[0]) ;
               // //echo '<br>';
                //str_replace('(' . 'logger' . ')', replace, subject)
                foreach ($match[0] as $key => $value) {
                   if($key > 0){ //not logger
                    ${$match[1][$key]} = $val->{$match[1][$key]};
                   // //echo $match[1][$key] . '<br>';
                   }
                   $messages =  str_replace($value, ${$match[1][$key]}, $messages);
                  //  //echo $value . 'ini value <br>';
                  //  //echo $val->{$match[1][$key]} . ' ini {$match[1][$key]} <br>';
                   // //echo $messages;
                }

                $val->messages_main = $messages;

                ////print_r($messages);
               // //echo '<br>';
                
            }
        }else{
            $list = array();
        }

        ////print_r($list);
        $pagination = $this->pagination($filter,$tblname);
        return (object)['list' => $list, 'pagination' => $pagination];
    }

    public function pagination($data,$tblname){
        $total_row = _count_rows($tblname,$data);
        $displayed = _get_displayed($data, $total_row);

        return (object)['total_row' => $total_row, 'displayed' => $displayed];
    }

    public function get_log_type($data = array() ){
        $tblname = "log";
        $filter = isset($data->filter) ? $data->filter : (object)[];
        _get_query($filter);
        $list = $this->db->get($tblname);
        if($list->num_rows() > 0){
            $list = $list->result();
        }else{
            $list = array();
        }
        $pagination = $this->pagination($data,$tblname);
        return (object)['list' => $list, 'pagination' => $pagination];   
    }

    public function write_log($id,$user_id,$info){
        //echo $id;
        $info_ = array('id_log' => $id, 'logger' => $user_id);
        //get log messages
        $log_messages = $this->db->get_where('log_messages', array('id_log' => $id))->row();
        //print_r($log_messages);
         foreach ($info as $key => $value) {
            //print_r($key);
            //echo '<br>';
            //echo $key . ' : ' . $value . ' INI key value <br>';
            //echo $log_messages->{$key . '_table'} . ' INI log messages key _table <br>';
            //echo $log_messages->{$key . '_field'} . ' INI log messages key _field <br>';
            if(!empty($value)){
                    $table = (isset($log_messages->{$key . '_table'}) ? $log_messages->{$key . '_table'} : '__--__--__--__');
                    $field = (isset($log_messages->{$key . '_field'}) ? $log_messages->{$key . '_field'} : '_--__---___-____');
                    //echo 'ini table : ' . $table . '<br>';
                    //echo 'ini field : ' . $field . '<br>';
                    if ($this->db->field_exists($field, $table)){
                        //echo 'table : ' . $table . ' field :' . $field . ' value : ' . $value . '<br>';
                        $v  = $this->db->get_where($table, array( $field => $value ));
                        if($v->num_rows() > 0){
                            $v = $v->row()->{$field};
                        }else{
                            $v = 'undefined';
                        }
                        //echo $this->db->last_query() . '<br>';
                       //print_r($v);
                        $info_[$key] = $v;    
                    }
                        
                }

        }

        $this->db->insert('log_list', $info_);
        ////echo $this->db->last_query();
        return 1;
    }




 }