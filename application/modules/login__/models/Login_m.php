<?php class Login_m extends CI_Model {

       

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

         function login($username, $password,$RE=FALSE)
        {
                  $identity = $username;
				  $password = $password;
				  $remember = $RE; // remember the user
				  $Status = $this->ion_auth->login($identity, $password, $remember);

                   if($Status)
                   {
                     return TRUE;
                   }
                   else
                   {       
                     return false;
                   }
        }
		
		function logout(){
			$this->ion_auth->logout();
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
	  function getbylevel($id){
                 $data = $this->db->get_where('user', array('user_level'  => $id));
                  return $data->result();
        }
        function getNama($id){
            $data = $this->db->get_where('user', array('user_id'  => $id));
            return $data->row()->user_nama;
        }

     

        function add($data){
            $EC_user;
            $EC_email;
            $cek_user = $this->compareItem('user_nama', $data['user_nama']);

            if(isset($data['user_email'])){
              $cek_email = $this->compareItem('user_email', $data['user_email']);
              if($data['user_email'] == ''){
                $EC_email = true;
              }else{
                $EC_email = false;
              }
            }else{
              $cek_email = false;
              $EC_email = false;
            }

            

            if($data['user_nama'] == ''){
              $EC_user = true;
            }else{
              $EC_user = false;
            }
            
            if(!$cek_user){
              if(!$EC_user){
                if(!$cek_email){
                  if(!$EC_email){
                    $this->db->insert('user', $data);
                    return true;
                  }else{
                    return "Email Harus di isi";
                  }
                }else{
                  return "email telah terdaftar";
                }
              }else{
                return "username harus di isi";
              }
            }else{
              return "username telah terdaftar";
            }


            if(!$cek_user){
              if(!$cek_email){
                  $this->db->insert('user', $data);
                  return true;
              }else{
                return "email telah terdaftar";
              }
            }else{
              return "Username telah terdaftar";
            }
        }

        function delete($data){
              //$this->db->where('user_id', $data['user_id']);
              //$this->db->delete('user');

              $this->db->update('user', array('deleted' =>1), "user_id = ". $data['user_id']);
             // $this->session->set_flashdata('lastINFO', $this->db->last_query());
              return false;
        }



        function update($updated_data){
          $updated_username = $updated_data['user_nama'];
          //$updated_level = $updated_data['user_level'];

          $updated_id = $updated_data['user_id'];

          $curr_data = $this->getByID($updated_id)->result_array();
          
          $curr_username = $curr_data[0]['user_nama'];
          $curr_email = $curr_data[0]['user_level'];
          
          $cek_user = $this->compareItem('user_nama', $updated_username);
          //echo $this->compareItem('user_nama', $updated_username);
          //$cek_email = $this->compareItem('user_email', $data['email']);


          if(($updated_username == $curr_username) or (!$cek_user)){
            if(1){
                $this->db->update('user', $updated_data, "user_id = ". $updated_id);
                return true;

            }
            else{
              return "email telah terpakai";

            }
          }
          else{
            return "username telah terpakai";
          }
        }


        function getByID($id){
            $data = $this->db->get_where('user', array('user_id'  => $id));
            return $data;
        }

        function checkActive($id){
          $data = $this->db->get_where('user', array('user_id'  => $id));
          if($data->num_rows()>0){
            if($data->result_array()[0]['deleted'] == '0'){
              return true;
            }else{
              return false;
            }
          }else{
            return false;
          }

        }

        function check_duplicate($username){
            $this->db->select('user_nama');
            $this->db->from('user');
            $this->db->where('user_nama', $username);
            $this->db->limit(1);

            $query = $this->db->get();
            if($query -> num_rows() == 1){
               return true;
            }
            else{                       
              return false;
            }

        }

        function compareItem($col, $value){
          $this -> db -> select();
          $this -> db -> from('user');
          $this -> db -> where($col, $value);
          $query = $this -> db -> get();
          
          if($query->num_rows() > 0){
            return true;
          }
          else{
            return false;
          }






       }

}
?>