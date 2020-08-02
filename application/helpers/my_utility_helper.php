<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

/**
 * Get 
 *
 *
 * @access	public
 * @return	integer
 */
if ( ! function_exists('get_ticketCode'))
{
	function get_ticketCode()
	{
		if(function_exists('get_instance'));
        {
            $ci =& get_instance();
        }
        
		$query = $ci->db->get('ticket');
    	$data = $query->num_rows();
    	$count = $data + 1;
		$digit  = 2;
		$key = '';
		$date = date('d');
		$num = str_pad($count,$digit,0,STR_PAD_LEFT);
		//$rand = generateRandomString(6);
		$a = generateRandomString(2);
		$b = generateRandomString(5);	
		$c = generateRandomString(2);
		//$result = $key.$date. "-" .$num. "-" .$rand;
		$result = $a. "-" .$b. "-" .$c;
		return $result;
	}
}


if ( ! function_exists('compare_item'))
{
	function compare_item($col, $val, $db)
	{
		if(function_exists('get_instance'));
        {
            $ci =& get_instance();
        }

        $ci->load->database();
        $ci->db->where($col,$val);
        $item = $ci->db->get($db);
        if($item->num_rows() > 0){
        	return 1;
        }else{
        	return 0;
        }
		
	}
}

if ( ! function_exists('_get_displayed'))
{
    function _get_displayed($data, $total_row, $current_rows = 0)
    {
        if(function_exists('get_instance'));
        {
            $ci =& get_instance();
        }

           $from = ($current_rows == 0 ? $current_rows : 1);
            $to = $total_row;

        $filter = (isset($data->filter) ? (isset($data->filter->limit) ? $data->filter->limit : (object)[] )  : (object)[]);
        //echo (empty((array)$filter));
        if(!empty((array)$filter)){
            $limit = $filter->limit;
            $offset = $filter->offset;
            $from = $offset + 1;  
            $to = ($limit * $offset) / ($limit + 1);
            if($to > $total_row){
                $to = $total_row;
             }
        }

        

        return (object)['from' => $from , 'to' => $to];

    }
}


 

if ( ! function_exists('_count_rows'))
{
    function _count_rows($tblname, $data)
    {
        if(function_exists('get_instance'));
        {
            $ci =& get_instance();
        }


        $status = $data;
        $arr = (array)$status;
        if(!empty($arr)){
           $status->limit = (object) [];
           _get_query($status);
        }



        $o=$ci->db->get($tblname);

        if($o){
            $o = $o->num_rows();
        }else{
            $o = 0;
        }
        //echo $ci->db->last_query();
        
        return $o;

        }
}


if ( ! function_exists('_get_query'))
{
	function _get_query($data)
	{
		if(function_exists('get_instance'));
        {
            $ci =& get_instance();
        }

        $ci->load->database();
         if(!empty((array)$data)){
            if(isset($data->filter)){
                if(!empty((array)$data->filter)) {
                    if(isset($data->filter->like)){
                        if(!empty((array) $data->filter->like)){
                    foreach ($data->filter->like as $key => $value) {
                    if(!empty($value)){
                        $ci->db->like($key,$value);
                    }
                }
                }
                    }
               // $status->like = $data->filter->like;

                if(isset($data->filter->equal)){
                    if(!empty((array) $data->filter->equal)){
                    foreach ($data->filter->equal as $key => $value) {
                    if(!empty($value)){
                        $ci->db->where($key,$value);
                    }
                }    
                }
                }

                
                //$status->like = $data->filter->equal;

               //range:{tanggal_update:{from:{'ww'},to{'dd'}}}
               if(isset($data->filter->range)){
                 if(!empty((array) $data->filter->range)){
                foreach ($data->filter->range as $key => $value) {
                    foreach ($value as $stat => $item) {
                        if($stat == 'from'){
                            if($item != ""){
                                $ci->db->where( $key . ' >= "' . date('Y-m-d 00:00:00',strtotime($item)) . '"');
                            }
                    }

                        if($stat == 'to'){
                            if($item != ""){
                                $ci->db->where( $key . ' <= "' . date('Y-m-d 23:59:59',strtotime($item)) . '"' ) ;
                            }
                    }
                    }
                }
                }
               }
                
                 //$status->range = $data->filter->range;

                    
            }
            
            if(isset($data->limit)){
                if(!empty((array)$data->limit)){
                    $limit['limit'] = "";
                    $limit['offset'] = "";

                foreach ($data->limit as $key => $value) {
                    if(!empty((array)$key)){
                        if($key == 'offset'){
                            $limit['offset'] = $value;
                        }
                        if($key == 'limit'){
                            $limit['limit'] = $value;
                        }
                        
                    }
                    if($limit['limit'] != ""){
                        $ci->db->limit($limit['limit'],$limit['offset']);
                    }
                    
                }
            }

            if(isset($data->order)){
                 if(!empty((array)$data->order)){
                $order['col'] = "";
                $order['val'] ="";
                foreach ($data->order as $key => $value) {
                    if(!empty((array)$key)){
                        if($key == 'col'){
                            $order['col'] = $value;
                        }
                        if($key == 'val'){
                            $order['val'] = $value;
                        }
                    }
                }
                if($order['col'] != "" && $order['val'] != ""){
                    $ci->db->order_by($order['col'],$order['val']);
                }   
            }else{
                $ci->db->order_by("id","DESC");
            }
            }

            }
           
        }
		
	}
}


}



if ( ! function_exists('generateRandomString'))
{

function generateRandomString($length = 10) {
	//abcdefghijklmnopqrstuvwxyz
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString; }

}



//-------------------------