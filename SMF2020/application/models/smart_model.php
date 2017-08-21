<?php
class Smart_model extends CI_Model{
	
	function __construct(){
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
	



}

?>