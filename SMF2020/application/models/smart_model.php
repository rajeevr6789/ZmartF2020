<?php
class Smart_model extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
						
	}
	
	
	 /**
	*This function 'll check the user credentials
	*
	* @access public
	* @param varchar username 
	* @param varchar password 
	* @return array resultArr
	*
	*/	
	
	function loginProcess($username,$password,$smart_login_table){	
		
		$resultArr		=	array();
		$this->db->select('*');
		$this->db->where('user_name',$username);
		$this->db->where('user_pass',$password);
		$query			=	$this->db->get($smart_login_table);
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			$resultArr['status']	=	true;
			$resultArr['user_id']	=	$result['user_id'];
			$resultArr['user_name']	=	$result['user_name'];
			$resultArr['user_role']	=	$result['user_role'];
			$resultArr['user_status']	=	$result['user_status'];
		}else{
			$resultArr['status']	=	false;
		}
		
		return $resultArr;
		
	}
	
	//----------------------------------------------------------------------------------------------
	
	function add_form_data($table_name,$data_array)
	{
		//$data	=	array("usr_ass_br_id"=>$branch_id,"usr_ass_admins"=>$br_admins);
		$result	=	$this->db->insert($table_name, $data_array); 
		return $result;  
	}

	function select_form_data($table_name,$searchTerm)
	{
		$this->db->select('*');
		$this->db->where('part_name', $searchTerm);
		$query = $this->db->get($table_name);
		return $query->row_array(); 	
		
	}
	
	function smart_procdes_form_update($table_name,$form_array,$id) {
		
		$this->db->where('part_id', $id);
		$result	=	$this->db->update($table_name,$form_array); 
		return $result;
	}
	
	
	function getCount($userIP)
	{
		/*SELECT    * FROM      tbl_user_count ORDER BY  Ucount DESC LIMIT     1;*/
		//$this->db->select('Ucount');
		$this->db->select('*');
		$this->db->where('Ipaddress', $userIP);
		$query = $this->db->get('tbl_user_count');
		if ($query->row_array() == 0 )
		{
			$datarr = array ("Ipaddress"=>$userIP);
			$result	=	$this->db->insert('tbl_user_count',$datarr); 
		}
		$this->db->select('Ucount');
		$que = $this->db->get('tbl_user_count');
		//$que= $this->db->query("SELECT Ucount FROM tbl_user_count;");
		//$query = $this->db->get('tbl_user_count');
		//$finalresult = $que->row_array();
		return $que->num_rows();
	}

}

?>