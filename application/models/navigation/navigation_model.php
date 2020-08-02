<?php

{

    public function __construct(){
        parent::__construct();
	}
	public function get_data()
    {
        $ret = array();
        $role = $this->ezrbac->getCurrentUser()->user_role_id;
        $this->db->where('publish',1);
        $query = $this->db->get('system_modules');
        if($query->num_rows() > 0):
            foreach($query->result() as $item):
                $title = unserialize($item->title);
                $access = unserialize($item->access);
                if(in_array($role,$access)):
                $data[$item->id] =array(
                    'alias' => $item->alias,
                    'title' => $title[$this->lang->lang()],
                    'icon' => $item->icon,
                    'sub' => $this->sub($item->id,$item->alias)            
                );
                endif;
            endforeach;
            return $data;
        endif;
        return $ret;
    }
    
    private function sub($id,$uri)
    {
        $ret = array();
        $this->db->where('module_id',$id);
        $query = $this->db->get('menu');
        if($query->num_rows() > 0):
            foreach($query->result() as $item):
                $title = unserialize($item->title);
                $url = site_url($uri."/".$item->alias);
                $data[$item->id] =array(
                    'alias' => $item->alias,
                    'title' => $title[$this->lang->lang()],
                    'icon' => $item->icon,
                    'url' => $url            
                );
            endforeach;
            return $data;
        endif;
        return $ret;
    }
    // get menu data
    public function get_menu()
    {
		$this->db->order_by('ordering','asc');
		$this->db->where('publish',1);
		$result = $this->db->get('site_navigation');
		return $result;
	}
    // get current user data
    public function user_data($id)
    {
        $ret = array();
        $this->db->where('id',$id);
		$query= $this->db->get('system_users');
        if($query->num_rows() > 0):
            foreach($query->result() as $item):
                $data = array(
                    'id' => $item->id,
                    'username' => $item->email,
                    'password' => $item->password,
                    'salt' => $item->salt,
                    'user_role' => $item->user_role_id,
                    'last_login' => $item->last_login,
                    'last_login_ip' => $item->last_login_ip,
                    'verified' => $item->verification_status,
                    'status' => $item->status,
                    'meta' => (!empty($item->pegawai_id) ? $this->pegawai($item->pegawai_id) : $this->meta($item->id) )
                );
            endforeach;
            return $data;
        endif;
		return $ret;
	}
    // get meta data user
    private function meta($id)
    {
        $ret = array();
        $this->db->where('user_id',$id);
        $query = $this->db->get('user_meta');
        if($query->num_rows() > 0):
            foreach($query->result() as $item):
                $photo = (!empty($item->photo) ? "assets/uploads/thumbs/".$item->photo." " : "assets/admin/layout/img/no-photo.png" );
                $data = array(
                    'first_name' => $item->first_name,
                    'last_name' => $item->last_name,
                    'full_name' => $item->first_name." ".$item->last_name,
                    'phone' => $item->phone,
                    'photo' => "<img src='".$photo."' class='img-circle hide1' alt='' />",
                    'address' => $item->address,
                    'provinsi' => $item->provinsi_id,
                    'kecamatan' => $item->kecamatan_id,
                    'kabkot' => $item->kabkot_id,
                    'facebook' => $item->facebook,
                    'twitter' => $item->twitter,
                    'website' => $item->website,
                    'office' => $item->office
                );
            endforeach;
            return $data;
        endif;
        return $ret;
    }
    // get current breadcrumb
    public function breadcrumb()
    {
        $module = $this->uri->segment(2);
        $controller = $this->uri->segment(3);
        $this->db->where('alias',$module);
        $query = $this->db->get('system_modules');
        if($query->num_rows() > 0):
            $module = $query->first_row();
            $this->db->where('module_id',$module->id);
            $this->db->where('alias',$controller);
            $child = $this->db->get('system_controllers');
            $item = $child->first_row();
            $title = unserialize($module->title);
            if(isset($item->title)):
                $description = unserialize($item->title);
            endif;
            $data = array(
                'title' => $title[$this->lang->lang()],
                'description' => isset($item->title) ? $description[$this->lang->lang()] : $controller
            );
        return $data;
        endif;

        $controller = $this->uri->segment(2);
        $this->db->where('alias',$module);
        $query = $this->db->get('system_controllers');
        if($query->num_rows() > 0):
            $item = $query->first_row();
            $data = array(
                'title' => $item->title
            );
        return $data;
        endif;
        $data = array( 'title' => $this->uri->segment(2), 'description' => '');
        return $data;
    }
    
    public function get_module()
    {
        $ret = array();
        $alias = $this->uri->segment(2);
        $this->db->where('publish',1)
                 ->where('alias',$alias);
        $query = $this->db->get('system_modules');
        if($query->num_rows() > 0):
                $item = $query->first_row();
                $title = unserialize($item->title);
                $data =array(
                    'title' => $title[$this->lang->lang()],
                    'icon' => $item->icon,
                    'quick_menu' => $this->quick_menu($item->id,$item->alias)            
                );
            return $data;
        print_out($data);
        endif;
        return $ret;
    }
    
    private function quick_menu($id,$uri)
    {
        $ret = array();
        $this->db->where('module_id',$id);
        $query = $this->db->get('menu');
        if($query->num_rows() > 0):
            foreach($query->result() as $item):
                $title = unserialize($item->title);
                $url = site_url($uri."/".$item->alias);
                $data[$item->id] =array(
                    'title' => $title[$this->lang->lang()],
                    'icon' => $item->icon,
                    'url' => $url            
                );
            endforeach;
            return $data;
        endif;
        return $ret;
    }
}

/* End of file navigation_model.php */
/* Location: ./site/model/navigation/navigation_model.php */