<?php class Ticket_m extends CI_Model {

       

    var $table = 'ticket_info';
    var $column_order = array(null, 'tanggal_dibuat', 'judul'); //set column field database for datatable orderable
    var $column_search = array('judul', 'tanggal_dibuat'); //set column field database for datatable searchable 
    var $order = array('tanggal_dibuat' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }

            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }















        public function changeStatus($Trr){
        	for ($i=0; $i < sizeof($Trr) ; $i++) {
    	//echo $Trr[$i]->ticket_id; 
    	//echo $Trr[$i]->status_id; 
    		$data = array(
               'status_id' => $Trr[$i]->status_id,
            );
    		 $this->db->where('ticket_id', $Trr[$i]->ticket_id);
    		 $this->db->update('ticket', $data);
    	}
        }

        public function fetch($start, $number, $full = false){
        	$this->db->limit($number,$start);
        	if(!$full){
        		$this->db->where('active',1);
        	}
    		return $this->db->get('ticket')->result();
        }

         public function fetchAll($full = false){
         	if(!$full){
        		$this->db->where('active',1);
        	}
    		return $this->db->get('ticket')->result();
        }

        public function delete($Trr,$real = false){
        	 
        	 
          for ($i=0; $i < sizeof($Trr) ; $i++) {
          	$this->db->where('ticket_id', $Trr[$i]->ticket_id);
          	echo $Trr[$i]->ticket_id;
        	 if ($real) {
        	 	$this->db->delete('ticket');
        	 }else{
        	 	$data = array(
               'active' => 0,
                 );
        	 	$this->db->update('ticket', $data);
        	 }
        }
    }


    public function getTicketWReply($id){
    	$this->db->where('ticket_id', $id);
    	$ticket = $this->db->get('ticket')->result();
    	$this->db->where('ticket_id', $id);
    	$reply = $this->db->get('tickets_reply')->result();

    	return $TY = array('ticket' => $ticket, 'reply' => $reply );

    }

    public function writeReply($data){

        //print_r($data);
    	$this->db->insert('tickets_reply', $data);
    	// echo $this->db->last_query();
    	//print($this->db->last_query);

    }












 }