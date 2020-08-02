<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends FrontendController {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation','user_agent'));
		$this->load->helper(array('url','language','file'));
		 $this->load->model('user_m');


		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	public function get_user_info(){
		$id = json_decode($this->input->post('data'));
		//echo "id: " . $id;
		if($id != ""){
			$data = $this->ion_auth->user($id)->row();
			$groups = $this->ion_auth->get_users_groups($id)->result();
			$data->groups = $groups;
			echo json_encode($data);	
		}else{
			$data = $this->ion_auth->user()->row();
			$groups = $this->ion_auth->get_users_groups()->result();
			$data->groups = $groups;
			echo json_encode($data);	
		}
		
	}



public function get_users_with_certain_privilege(){
	$data = json_decode($this->input->post('data'));
	$priv = $data->priv;
	//$priv = 'ticket_assignment';
	$item = $this->user_m->get_users_with_certain_privilege($priv);
	foreach ($item as $key => $value) {
		# code...
	}
	echo json_encode($item);

}

	public function isPrivileged(){
		$data = json_decode($this->input->post('data'));
		//echo json_encode($this->user_m->isPrivileged($data));
		$this->user_m->isPrivileged($data);
	}

	public function add_groups(){
		$data = json_decode($this->input->post('data'));
		$name = $data->name;
		$description = $data->description;

		$this->db->where('name', $name);
		$name_check = $this->db->get('groups');
		$tes = ($name_check->num_rows() > 0 ? true : false);

		if(!$tes){
			$group_id = $this->ion_auth->create_group($name,$description);
			echo json_encode((object)['status' => 1, 'group_id' => $group_id]);		
		}else{
			$error = (object)['status' => 0];
			
			$error->dupe_name = $tes;
			echo json_encode($error);
		}

	}

	public function add_user(){
		$data = json_decode($this->input->post('data'));
		$username = $data->username;
		$password = $data->password;
		$email = $data->email;
		$additional_data = 
			array(
				 	'first_name' => $data->first_name,
					'last_name' => $data->last_name);
					
		$group = array();
		foreach ($data->groups as $val) {
			if($val->set){
				array_push($group, $val->id);		
			}
		}


		$username_check = $this->ion_auth->username_check($username);
		$email_check = $this->ion_auth->email_check($email);

		$cek = !$username_check && !$email_check;

		if($cek){
			$user_id = $this->ion_auth->register($username,$password,$email,$additional_data,$group);
			if($user_id){
				echo json_encode((object)['status' => 1, 'user_id' => $user_id]);		
			}else{
				echo json_encode((object)['status' => 0, 'unknown' => 'unknown' ]);	
			}
			
		}else{
			$error = (object)['status' => 0];
			
				$error->username_dupe = $username_check;
				$error->email_dupe = $email_check;
			
			echo json_encode($error);
		}

		



	}

	public function delete_user(){
		$data = json_decode($this->input->post('data'));
		echo $this->ion_auth->delete_user($data->id);
	}

	public function delete_group(){
		$data = json_decode($this->input->post('data'));
		if($this->ion_auth->delete_group($data->id)){
			$this->db->where('id_group', $data->id);
			$d = $this->db->delete('users_group_privileges_has');
			$this->user_m->delete_group_access_admin($data->id);
			echo json_encode($d);
		}else{
			echo json_encode('0');
		}
	}

	public function edit_groups(){
		$data = json_decode($this->input->post('data'));
		$id = $data->id;
		$name = $data->name;
		$description = $data->description;

		$this->db->where('name', $name);
		$name_check = $this->db->get('groups');

		$this->db->where('id', $id);
		$name_db = $this->db->get('groups')->row()->name;

		$tes = ($name_check->num_rows() > 0 && $name != $name_db ? true : false);
		
		if(!$tes){
				$group = $this->ion_auth->update_group($id,$name,$description);
				echo json_encode((object)['status' => 1, 'group' => $group]);	
		}else{
				$error = (object)['status' => 0];
			
				$error->name_dupe = $tes;
				//$error->email_dupe = $email_check;
			
			echo json_encode($error);
		}
		

	}

	public function edit_user(){
		$data = json_decode($this->input->post('data'));
		$id = $data->id;
		$username = $data->username;
		
		$email = $data->email;
		$add_groups = array();
		$remove_groups = array();
		$to_insert = 
			array(
				 	'first_name' => $data->first_name,
					'last_name' => $data->last_name,
					'username' => $username,
					'email' => $email
					);
		if(isset($data->password_baru)){
			if(!empty((array)$data->password_baru)){
			$to_insert['password'] = $data->password_baru;
		}	
		}
		
		//print_r($to_insert);
		//$group = array($data->group_id);


		foreach ($data->groups as $val) {
			if($val->set){
				array_push($add_groups, $val->id);		
			}else{
				array_push($remove_groups, $val->id);		
			}
		}

		$this_user = $this->ion_auth->user($id)->row();

		$username_check = $this->ion_auth->username_check($username) && $this_user->username != $username ;
		$email_check = $this->ion_auth->email_check($email) && $this_user->email != $email;

		$cek = !$username_check && !$email_check;

		if($cek){
			$user_id = $this->ion_auth->update($id, $to_insert);
			if($user_id){
				$this->ion_auth->remove_from_group($remove_groups, $id);
				$this->ion_auth->add_to_group($add_groups, $id);
				echo json_encode((object)['status' => 1, 'user_id' => $user_id]);		
			}else{
				echo json_encode((object)['status' => 0, 'unknown' => 'unknown' ]);	
			}
			
		}else{
			$error = (object)['status' => 0];
			
				$error->username_dupe = $username_check;
				$error->email_dupe = $email_check;
			
			echo json_encode($error);
		}

		



	}

	public function get_task_assignee_list(){
		$users = $this->user_m->get_users_with_certain_privilege('task_assignee');
		//print_r($users);
		echo json_encode($users);
	}



	public function get_group(){
		$id = $this->input->post('data');
		if($id){
			echo json_encode((object)['data' => $this->ion_auth->group($id)->row()]);
		}else{
			$group = $this->ion_auth->groups()->result();
			foreach ($group as $val) {
				$this->db->where('group_id', $val->id);
				$d = $this->db->get('users_groups');
				$val->count = $d->num_rows();
			}
			echo json_encode((object)['data' => $group]);
		}
	}


	public function update_memberarea_setting(){
		$data = json_decode($this->input->post('data'));
		//print_r($data);
		echo json_encode($this->user_m->update_memberarea_setting($data));
	}

	public function upload_profile_pic(){
		 $json = array();
		$temp_path = '/assets/common/profile_pic/';

    $config['upload_path']          = dirname($_SERVER["SCRIPT_FILENAME"]) . $temp_path;
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
            'path_tmp' => base_url() . $temp_path . $upload_details['file_name'],
            'path' => '.' .$temp_path . $upload_details['file_name'],
            'ext' => $upload_details['file_ext'],
            'size'=> $upload_details['file_size'],
            'name' => $upload_details['file_name']
            );
    }
   // print_r($config);
    echo json_encode($json);
	}
	

	// redirect if needed, otherwise display the user list

	private function remove_temp_pic ($path){
		 $data = file_get_contents($path->path);
                if ( ! write_file(FCPATH . 'assets\common\profile_pic\\' . $path->name, $data))
                {
                	return "";
                }
                else
                {       
                    $dd = $path->path;
                    if(file_exists($dd)){
                        unlink($dd);
                    }

                    return "./assets/common/profile_pic/" . $path->name;

                }
	}

	public function testing(){
		//print_r($this->user_m->build_menu());
		//$this->user_m->privilege_setting_menu();
		//print_r($this->user_m->get_user_privileges());
		//echo json_encode($this->user_m->get_user_privileges());
		//$this->get_users_with_certain_privilege();
		$this->get_task_assignee();
	}

	public function setting_privilege(){
		echo json_encode($this->user_m->privilege_setting_menu());
	}

    public function update_group_role_has(){
        $data = json_decode($this->input->post('data'));
        echo json_encode($this->user_m->update_group_role_has($data));
    }

	public function get_menu(){
		echo json_encode($this->user_m->get_menu_displayed_by_user());	
	}

	public function get_user_all(){
		if($this->ion_auth->logged_in()){
			$user  = $this->ion_auth->users();
			if($user->num_rows() > 0){
				$user = $user->result();
				foreach ($user as $value) {
					$value->full_name = $value->first_name . ' ' . $value->last_name;
					$group = $this->ion_auth->get_users_groups($value->id);
					if($group->num_rows() > 0){
						$value->groups = $group->result();	
					}else{
						$value->groups = (object)[];
					}
					
				}
			}else{
				$user = (object)[];
			}
			echo json_encode($user);
		}else{
			echo json_encode((object)[]);
		}
	}

	public function editProfile(){
		$data = json_decode($this->input->post('data'));
		$data->birth_date = strtotime($data->birth_date);
		if(!empty((array) $data->password)){
			if ($this->ion_auth->hash_password_db($data->id, $data->password->current) === TRUE)
				{
					$password = $data->password;
					if(isset($password->new) || isset($password->confirm) ){
						if((isset($password->new) ? $password->new : '' ) == (isset($password->confirm) ? $password->confirm : '')){
							$data->password = $password->new;
							if(isset($data->profile_pic)){
							//$data->profile_pic = $this->remove_temp_pic($data->profile_pic);
						}

							$status = $this->ion_auth->update($data->id, (array) $data);
							echo json_encode( (object) ['status' => '1', 'reason' => 'success', 'message' => 'Profil berhasil di simpan']);
						}else{
							echo json_encode( (object) ['status' => '0', 'reason' => 'password_mismatch', 'message' => 'Konfirmasi password tidak cocok']);	
						}
					}else{
						unset($data->password);
						if(isset($data->profile_pic)){
							//$data->profile_pic = $this->remove_temp_pic($data->profile_pic);
						}
						$status = $this->ion_auth->update($data->id, (array) $data);
						echo json_encode( (object) ['status' => 1, 'reason' => 'success', 'message' => 'Profil berhasil di simpan']);	
					}
				}else{
					echo json_encode((object) ['status' => '0', 'reason' => 'current_password', 'message' => 'Password sekarang tidak cocok' ]);
				}
		}else{
			echo json_encode((object) ['status' => '0', 'reason' => 'current_password_empty', 'message' => 'Password sekarang belum di isi' ]);
		}
	}

	public function is_logged_in(){
		if($this->ion_auth->logged_in()){
		//header('Content-Type: application/json');
		echo 1;
		return 1;
		}else{
			header('Content-Type: application/json');
			echo 0;
			return 0;
		}
	}

	public function get_dashboard_data(){
		echo json_encode($this->user_m->get_dashboard_data());
	}

	public function get_session(){
		
		$is_logged_in = $this->ion_auth->logged_in() ? 1 : 0;
		$is_logged_in_admin = 0;
		$menu = [];
		$privileges=[];
		$groups = [];
		$current_user = (object)[];
		if($is_logged_in){
			//$group = $this->user_m->get_group_access_admin();
			//if($this->ion_auth->in_group($group)){
			//	$is_logged_in_admin = 1;
			//}
			$is_logged_in_admin = $this->user_m->can_access_admin_page();

			$current_user = $this->ion_auth->user()->row();
			if($is_logged_in_admin){
				$menu = $this->user_m->get_menu_displayed_by_user();
 			}

 			$groups = $this->ion_auth->get_users_groups()->result();

 			$privileges = $this->user_m->get_user_privileges();
		}

		$obj = (object)['logged_in' => $is_logged_in, 'logged_in_admin' => $is_logged_in_admin , 'user' => $current_user, 'menu' => $menu, 'privileges' => $privileges, 'groups' => $groups];
		echo json_encode($obj);
	}

	public function is_logged_in_admin(){
		if($this->ion_auth->logged_in()){
				
				//$group = $this->user_m->get_group_access_admin();
			$group = $this->user_m->can_access_admin_page();
				if($group){
					header('Content-Type: application/json');
					echo json_encode(TRUE);
				}else{
					header('Content-Type: application/json');
					echo json_encode(FALSE);
				}
		}else{
			header('Content-Type: application/json');
			echo json_encode(FALSE);
		}
	}


	public function getMemberareaSetting(){
    $data = json_decode($this->input->post('data'));
    echo json_encode($this->user_m->get_memberarea_setting($data));
}



	public function ng_logout()
	{
		

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		$data = (object)['status' => 1 ,'messages' => $this->ion_auth->messages()];
		echo json_encode($data);
	}

	public function ng_login(){
			//echo $this->input->post('identity')

		//validate form input
	
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$data = (object)['status' => 1 ,'messages' => $this->ion_auth->messages()];
				echo json_encode($data);
				
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				$data = (object)['status' => 0 ,'messages' => $this->ion_auth->errors()];
				echo json_encode($data);
				//redirect('user/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
	
}

	public function ng_login_admin(){
			//echo $this->input->post('identity')

		//validate form input
	
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page

				//$group = $this->user_m->get_group_access_admin();

				//if($this->ion_auth->in_group($group)){
				//$priv = 'access_admin_panel';
				$has_access_to_admin_page = $this->user_m->can_access_admin_page();
				if($has_access_to_admin_page){
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					$data = (object)['status' => 1 ,'messages' => $this->ion_auth->messages()];
					echo json_encode($data);
				}else{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						$data = (object)['status' => 0 ,'messages' => 'tidak termasuk group'];
						echo json_encode($data);
				}
				
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				$data = (object)['status' => 0 ,'messages' => $this->ion_auth->errors()];
				echo json_encode($data);
				//redirect('user/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
	
}

	public function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('user/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			// set the flash data error message if there is one
			//$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			//$this->data['users'] = $this->ion_auth->users()->result();
			//foreach ($this->data['users'] as $k => $user)
			//{
			//	$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			//}
			//if($this->agent->referrer() != ""){

			//}
			//print_r($_HTTP);
    		//$this->session->set_userdata('redirect_back',$this->agent->referrer()  ); 

	    	//$data = array();
	        //$this->template->set_layout('frontpage_normal');
	        //$this->modules->render('login/login_v',$data);
	        if($this->session->userdata('redirect_back') != "" ) {
				    $redirect_url = $this->session->userdata('redirect_back');  // grab value and put into a temp variable so we unset the session value
				    $to_id = $this->session->userdata('redirect_back_to_id');
				    ($to_id !="") ? $redirect_url = $redirect_url. "#" . $to_id : "";
				    ($to_id !="") ? $this->session->unset_userdata('redirect_back_to_id') : "";
				    $this->session->unset_userdata('redirect_back');

				    redirect( $redirect_url, 'refresh' );
				    //echo "000";
				}else{
					redirect('/', 'refresh');
				}
		}
	}

	// log the user in
	public function login()
	{
		$this->data['title'] = $this->lang->line('login_heading');

		//validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				//echo $this->session->userdata('redirect_back');
				// user is authenticated, lets see if there is a redirect:
				$redirect_url = $this->session->userdata('redirect_back');  // grab value and put into a temp variable so we unset the session value
				if($redirect_url != "" || $redirect_url == base_url().'login' ) {
 
				    $to_id = $this->session->userdata('redirect_back_to_id');
				    ($to_id !="") ? $redirect_url = $redirect_url. "#" . $to_id : "";
				    ($to_id !="") ? $this->session->unset_userdata('redirect_back_to_id') : "";
				    $this->session->unset_userdata('redirect_back');

				    redirect( $redirect_url, 'refresh' );
				    //echo "000";
				}else{
					redirect('/', 'refresh');
				}
				
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('user/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			/*
			$this->data['identity'] = array('name' => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			/);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			);

			$this->_render_page('login', $this->data);
			*/
			/*
			$data['page'] = $this->config->item($this->_view_dir . "_" .  "login");
			$data['module'] = "login";
			$this->load->view($this->_container, $data);
			*/
			//$this->load->library('user_agent');  // load user agent library
   		 // save the redirect_back data from referral url (where user first was prior to login)
    		$user_agent = $this->agent->referrer();
			if($user_agent != "" || $user_agent != base_url().'login' ){
				$this->session->set_userdata('redirect_back',$user_agent); 
		    }else {
				# code...
			}
				$data = array();
		        $this->template->set_layout('frontpage_normal');
		        //$this->modules->render('/login_v',$data);
		         $this->load->view('/login_v',$data);
			//print_r($_HTTP);
    	
			}
	}

	// log the user out
	public function logout()
	{
		$this->data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect($this->agent->referrer(), 'refresh');
	}
	
	public function logout_admin()
	{
		$this->data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('admin/login', 'refresh');
	}
	

	// change password
	public function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name'    => 'new',
				'id'      => 'new',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name'    => 'new_confirm',
				'id'      => 'new_confirm',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			// render
			$this->_render_page('auth/change_password', $this->data);
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	// forgot password
	public function forgot_password()
	{
		// setting validation rules by checking whether identity is username or email
		if($this->config->item('identity', 'ion_auth') != 'email' )
		{
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() == false)
		{
			$this->data['type'] = $this->config->item('identity','ion_auth');
			// setup the input
			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
			);

			if ( $this->config->item('identity', 'ion_auth') != 'email' ){
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('auth/forgot_password', $this->data);
		}
		else
		{
			$identity_column = $this->config->item('identity','ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if(empty($identity)) {

	            		if($this->config->item('identity', 'ion_auth') != 'email')
		            	{
		            		$this->ion_auth->set_error('forgot_password_identity_not_found');
		            	}
		            	else
		            	{
		            	   $this->ion_auth->set_error('forgot_password_email_not_found');
		            	}

		                $this->session->set_flashdata('message', $this->ion_auth->errors());
                		redirect("auth/forgot_password", 'refresh');
            		}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	// reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				$this->_render_page('auth/reset_password', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("auth/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	// activate the user
	public function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	// deactivate the user
	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('auth/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	// create a new user
	public function create_user()
    {
        $this->data['title'] = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'name'  => 'company',
                'id'    => 'company',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->_render_page('auth/create_user', $this->data);
        }
    }

	// edit a user
	
	// create a new group
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		}
		else
		{
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);

			$this->_render_page('auth/create_group', $this->data);
		}
	}

	// edit a group


	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}

}
