<?php class User_m extends CI_Model {

       

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
                $this->load->database();
                $this->load->helper('file');
        }

        public function get_memberarea_setting($data){
        $this->db->where('user_id', $data->user_id);
        $setting = $this->db->get('setting_memberarea_user_view');
        $setting_default = $this->db->get('setting_memberarea');
        ////print_r($setting_default);
        if($setting_default->num_rows() > 0){
          $setting_default =   $setting_default->result();
        foreach ($setting_default as $key) {
            $this->db->where('setting_id', $key->id);
            $opt = $this->db->get('setting_memberarea_options');
            if($opt->num_rows() > 0){
                $opt = $opt->result();
                $optArr = [];
                foreach ($opt as $key2) {
                    array_push($optArr, (object)['id' => $key2->option_value ,'value' => $key2->option_value]);
                }
                $key->option = $optArr;
            }else{
                 $key->option = [];
            }

            

        }
    }else{

    }


   

       // //print_r($setting);
        if($setting->num_rows() > 0){
            return (object)['data' => $setting->result(), 'data_default' => $setting_default];
        }else{
            $temp = $setting_default;
            foreach ($temp as $val) {
                    $val->setting_id = $val->id;
                    $val->value = $val->default_value;
            }
            return (object)['data' => $temp, 'data_default' => $setting_default];
        }
    }

    public function can_access_admin_page($user  = NULL){
        $priv = 'access_admin_panel';
        $hasil = false;
        if($user != NULL){
             $hasil = $this->is_user_has_privilege($priv, $user);
        }else{
             $hasil =  $this->is_user_has_privilege($priv);
        }
       
        return $hasil;
    }

    public function is_user_has_privilege($priv,$user = false){
        
        if(!$user){
            $user = $this->ion_auth->user()->row()->id;
        }

        $pri = $this->db->get_where('users_groups_privileges', array('privileges_name' => $priv));
         if($pri->num_rows() > 0){
            $pri = $pri->row()->id;
        }else{
            $pri = '';
        }
        $pri2 = $this->db->get_where('users_groups_privileges_has', array('id_privileges' => $pri));
          if($pri2->num_rows() > 0){
            $pri2 = $pri2->result();
        }else{
            $pri2 = array();
        }

        $groups = array();

        foreach ($pri2 as $val) {
            array_push($groups, (int)$val->id_group);
        }
       // print_r($groups);
        $cek =  $this->ion_auth->in_group($groups,$user);
        if($cek){
            return true;
        }else{
            return false;
        }

        
    }

    public function get_users_with_certain_privilege($priv){
        $pri = $this->db->get_where('users_groups_privileges', array('privileges_name' => $priv));
        //echo $this->db->last_query(). '<br>';
      //  //print_r($pri->result());
        if($pri->num_rows() > 0){
            $pri = $pri->row()->id;
        }else{
            $pri = '';
        }

        $pri2 = $this->db->get_where('users_groups_privileges_has', array('id_privileges' => $pri));
        //echo $this->db->last_query(). '<br>';

        if($pri2->num_rows() > 0){
            $pri2 = $pri2->result();
        }else{
            $pri2 = array();
        }

        $users = [];

        foreach ($pri2 as $val) {
            //$gr = $this->ion_auth->group($val->id_group);
            $gr = $this->db->get_where('users_groups', array('group_id' => $val->id_group));
            //echo $this->db->last_query(). '<br>' . '<br>';
            //print_r($gr->result());
            if($gr->num_rows() > 0){
                $gr = $gr->result();
            }else{
                $gr = array();
            }


            foreach ($gr as $val2) {
                $us = $this->ion_auth->user($val2->user_id)->row();
                //echo "<br>";
                //echo "<br>";
                //print_r($us);
                $users[$val2->user_id . '__'] = (object)['id' => $us->id, 'full_name' => $us->first_name . ' ' . $us->last_name];
            }
        }


        return $users;



        
    }

    public function isPrivileged($stateName){
        $this->db->where('state',$stateName->state);
        $users_groups_privileges = $this->db->get('users_groups_privileges');

        if(!$this->ion_auth->logged_in()){
             return $this->output
            ->set_content_type('application/json')
            ->set_status_header('401')
            ->set_output(json_encode((object)['messages' => 'Not logged_in']));
        }

        if($users_groups_privileges->num_rows() > 0){
            $users_groups_privileges = $users_groups_privileges->row();
        }else{
           return $this->output
            ->set_content_type('application/json')
            ->set_status_header('403')
            ->set_output(json_encode((object)['messages' => 'invalid privileges | No Group']));
        }

        $group = $this->ion_auth->get_users_groups()->result();
      //  //print_r($group);

        if(empty((array)$group)){
            //return (object)['status' => 500, 'messages' => 'invalid groups'];
            return  $this->output
            ->set_content_type('application/json')
            ->set_status_header('500')
            ->set_output(json_encode((object)['messages' => 'invalid groups']));
        }

        $valid = false;
        foreach ($group as $value) {
            $this->db->where('id_privileges', $users_groups_privileges->id);
            $this->db->where('id_group', $value->id);
            $has = $this->db->get('users_groups_privileges_has');
            if($has->num_rows() > 0){
                //$has = $has->result();
                $valid = true;
            }
           // //echo 'group ' .$value->id . '+ priv ' . $users_groups_privileges->id . ' = ' . $has->num_rows();
        
        }
        //return (object)['status' => ($valid) ? 200 : 403, 'messages' => ($valid) ? 'sukses' : 'notPrivileged'];
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(($valid) ? '200' : '403')
        ->set_output(json_encode((object)['messages' => ($valid) ? 'sukses' : 'notPrivileged']));
        
    }

    public function get_group_access_admin(){
        $item = $this->db->get('users_groups_access_admin');
        $allowed_groups = array();
        if($item->num_rows() > 0){
            $item= $item->result();
            foreach ($item as $val) {
                array_push($allowed_groups, $this->ion_auth->group($val->id_group)->row()->name);
            }

            
        }else{

        }
        ////print_r($allowed_groups);
        return $allowed_groups;
    }

    public function delete_group_access_admin($id){
        $this->db->where('id_group', $id);
        return $this->db->delete('users_groups_access_admin');
    }

    public function is_group_in_access_admin($id){
        $is_in = FALSE;
        $access_admin = $item = $this->db->get('users_groups_access_admin')->result();
        foreach ($access_admin as $val) {
            if($val->id_group == $id){
                $is_in = TRUE;
            }
        }

        return $is_in;
    }

     public function build_menu(){
        $this->db->order_by('name_menu','ASC');
        $nav = $this->db->get('users_groups_privileges');
        if($nav->num_rows() > 0 ){
            $nav = $nav->result();
            $nav_fix = (object)['level_0' => array()];
            foreach ($nav as $val) {
                if($val->parent_id == 0){
                    array_push($nav_fix->level_0, (object)['id' => $val->id,  'icon_class' => $val->icon_class ,  'state' => $val->state,'privileges_name' => $val->privileges_name, 'name' => $val->name_menu,  'parent_id' => $val->parent_id , 'url' => $val->url, 'child' => array()]);
                }
            }
            foreach ($nav as $val) {
                if($val->parent_id != 0){
                    foreach ($nav_fix->level_0 as $val_2) {
                        if($val_2->id == $val->parent_id){
                            array_push($val_2->child,(object)['id' => $val->id, 'icon_class' => $val->icon_class , 'privileges_name' => $val->privileges_name, 'name' => $val->name_menu, 'url' => $val->url, 'child' => array() ,'state' => $val->state]);
                        }
                    }
                }
            }

            return $nav_fix;
        }else{
            return (object)[];
        }

    }

    public function get_dashboard_data(){
        $this->db->where('crm_id', $this->ion_auth->user()->row()->id);
        $this->db->where('status_id', 1);
        $box_tick = $this->db->count_all_results('ticket');
        $box_know = $this->db->count_all_results('post');
        $box_user = $this->db->count_all_results('users');
        $this->db->where('asignee', $this->ion_auth->user()->row()->id);
        $this->db->where('status_id', 1);
        $box_task = $this->db->count_all_results('task');

      //  $this->db->select("count(*) as count, *");
        
        //$this->db->select(' COUNT(*) as total');
        //$this->db->group_by('ticket_id'); 

        $this->db->order_by('tanggal_dibuat','asc');
        $low_date = $this->db->get('ticket')->row()->tanggal_dibuat;
        $this->db->order_by('tanggal_dibuat','desc');
        $high_date = $this->db->get('ticket')->row()->tanggal_dibuat;

        //$this->db->where('tanggal_dibuat' > date_format($low_date,"Y/m/d 00:00:00"));
        //$this->db->where('tanggal_dibuat' < date_format($high_date,"Y/m/d 23:59:59"));
     

        $this->db->select('COUNT(*) as count, YEAR(tanggal_dibuat) as tahun');
        $this->db->group_by('YEAR(tanggal_dibuat)'); 
        $this->db->order_by('tahun asc');
        $line_chart_ticket_tahun = $this->db->get('ticket');
        if($line_chart_ticket_tahun->num_rows() > 0){
            $line_chart_ticket_tahun  = $line_chart_ticket_tahun->result();
        }else{
            $line_chart_ticket_tahun  = (object)[];
        }

        $line_chart_ticket = (object)['series' => array(), 'data' => array()];

        foreach ($line_chart_ticket_tahun as $val) {
            array_push($line_chart_ticket->series, $val->tahun);
            
            $this->db->select('COUNT(*) as count, MONTH(tanggal_dibuat) as bulan, YEAR(tanggal_dibuat) as tahun');
            $this->db->group_by('MONTH(tanggal_dibuat), YEAR(tanggal_dibuat)');
            $this->db->having('tahun',$val->tahun); 
            $this->db->order_by('tahun asc, bulan asc');
            $item_chart  = $this->db->get('ticket');
            if($item_chart->num_rows() > 0){
                $item_chart  = $item_chart->result();
            }else{
                $item_chart  = (object)[];
            }
            $item_chart_2 = array();
            for ($i=0; $i < 12 ; $i++) { 
               array_push($item_chart_2, 0);
            }
            foreach ($item_chart as $val_2) {
                $item_chart_2[$val_2->bulan -1 ] = $val_2->count;
            }
            array_push($line_chart_ticket->data, $item_chart_2);
            
        }

        $pie_chart_ticket = (object)['labels' => array(), 'data' => array()];
        $this->db->order_by('id', 'asc');
        $temp = $this->db->get('tickets_category');
        if($temp->num_rows() > 0){
            $temp = $temp->result();
        }else{
            $temp = (object)[];
        }
        foreach ($temp as $val) {
            array_push($pie_chart_ticket->labels, $val->nama);
        }

        $this->db->select('COUNT(*) as count, nama_kategori');
        $this->db->order_by('kategori_id');
        $this->db->group_by('nama_kategori');
        $item_pie = $this->db->get('view_ticket');
        if($item_pie->num_rows() > 0){
        $item_pie = $item_pie->result();
        }else{
        $item_pie = (object)[];
        }
        $item_pie_2 = array();
        foreach ($item_pie as $val_2) {
        array_push($item_pie_2, $val_2->count);
        }
        $pie_chart_ticket->data = $item_pie_2;




        
        ////print_r($line_chart_ticket);
        return (object)['box_ticket' => $box_tick, 'box_task' => $box_task, 'box_knowledgebase' => $box_know, 'box_user' =>$box_user, 'line_chart_ticket' => $line_chart_ticket, 'pie_chart_ticket' => $pie_chart_ticket];


        
    }

    public function get_user_privileges($user_id = false){
        if(!$user_id){
         $groups = $this->ion_auth->get_users_groups();
        }else{
          $groups = $this->ion_auth->get_users_groups($user_id);
        }
        
        if($groups->num_rows() > 0){
            $groups = $groups->result();
        }else{
            $groups = array();
        }
        $privileges = [];
        foreach ($groups as $val) {
             $this->db->where('id_group', $val->id);
             
             $this->db->from('users_groups_privileges_has as A');
             $this->db->join('users_groups_privileges as B', 'A.id_privileges = B.id');
             $users_groups_privileges_has = $this->db->get()->result();
             foreach ($users_groups_privileges_has as $val2) {
                $obj = (object)['id' => $val2->id_privileges, 'privileges_name' => $val2->privileges_name];

                $privileges[$val2->privileges_name] = $obj;
             }
             
        }
        return $privileges;
    }


    public function privilege_setting_menu(){
         $groups = $this->ion_auth->groups()->result();
         $this->db->order_by('privileges_name', 'ASC');
         $privileges = $this->db->get('users_groups_privileges')->result();
         foreach ($groups as $val) {
             $this->db->where('id_group', $val->id);
             $this->db->from('users_groups_privileges_has as A');
             $this->db->join('users_groups_privileges as B', 'A.id_privileges = B.id');
             $this->db->order_by('B.privileges_name', 'ASC');
             $users_groups_privileges_has = $this->db->get()->result();
             $val->privileges = $users_groups_privileges_has;
             foreach ($val->privileges as  $val2) {
                    $val2->set = 1;
                }   
         }    

         
         return (object)['groups' => $groups, 'privileges' => $privileges];
    }

    public function update_group_role_has($data){
        $data = $data;
        foreach ($data as $key) {
            $this->db->where('id_privileges',$key->id_privileges);
            $this->db->where('id_group',$key->id_group);
            $temp = $this->db->get('users_groups_privileges_has');
            if($temp->num_rows() > 0){
               if(!$key->set){
                    $this->db->where('id_privileges',$key->id_privileges);
                    $this->db->where('id_group',$key->id_group);
                    $temp = $this->db->delete('users_groups_privileges_has');
               }
            }else{
                if($key->set){
                    $this->db->where('id_privileges',$key->id_privileges);
                    $this->db->where('id_group',$key->id_group);
                    $temp = $this->db->insert('users_groups_privileges_has',
                            (object)['id_group' => $key->id_group, 'id_privileges' => $key->id_privileges]);
                }
            }

        }
    }

    public function get_menu_displayed_by_user($user_id = NULL){
        if($user_id == NULL){
            if($this->ion_auth->logged_in()){
                $user_id = $this->ion_auth->user()->row()->id;
            }
        }

        $groups = $this->ion_auth->get_users_groups($user_id);
        $menu = $this->build_menu();
        if(count($menu->level_0) > 0){
            if($groups->num_rows() > 0){
                $groups = $groups->result();
                foreach ($groups as $val) {
                    $this->db->where('id_group', $val->id);
                    $menu_to_group = $this->db->get('users_groups_privileges_has');
                    if($menu_to_group->num_rows() > 0){
                        $menu_to_group = $menu_to_group->result();
                        foreach ($menu_to_group as $val_2) {
                                foreach ($menu->level_0 as $val_3) {
                                    
                                    if($val_2->id_privileges  == $val_3->id){
                                        $val_3->active = TRUE;
                                    }
                                    if(count($val_3->child) > 0){

                                        foreach ($val_3->child as $val_4) {
                                            if($val_2->id_privileges  == $val_4->id){
                                              $val_4->active = TRUE;
                                              $val_3->has_active_child = TRUE;
                                            }
                                        }
                                    }
                                }
                              
                        }
                    }
                }
              return $menu;
            }
        }else{
            return (object)[];
        }

        
        


        if(count($menu->level_0) > 0){

        }

    }

    public function update_memberarea_setting($data){
      //  //print_r($data->data);
        $data_ = $data->data;
        $ret_val = 0;
        if(isset($data_)){
            if(!empty($data_)){
                foreach ($data_ as $value) {
                    ////print_r($value);
                    $value->last_changed = now();
                    $this->db->where('user_id',$value->user_id);
                    $this->db->where('setting_id', $value->setting_id);
                    $tmp = $this->db->get('setting_memberarea_user');
                    ////echo $this->db->last_query() .  " num rows: " . $tmp->num_rows() . "   -----";
                    if($tmp->num_rows() > 0){
                        if($tmp->num_rows() == 1){
                            $tmp = $tmp->row();
                            if($tmp->value == $value->value){
                                
                            }else{
                                $this->db->where('id', $tmp->id);
                                $this->db->update('setting_memberarea_user', $value);
                                
                            }
                            $ret_val = 1;
                        }
                    }else{
                        $this->db->insert('setting_memberarea_user', $value);
                        $ret_val = 1;
                    }
                }
            }else{
                $ret_val = 0;
            }
        }else{
            $ret_val = 0;
        }
    }
}
?>