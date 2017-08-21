<?php
class User_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
						
	}
	
	 /**
	*This function 'll get the student details by id
	*
	* @access public
	* @param int student_id
	* @return array resultArr
	*
	*/	
	
	function getStudentDetails($student_id){
		
		$resultArr	=	array();
		$this->db->select('*');
		$this->db->where('std_id',$student_id);
		$query		=	$this->db->get('tbl_student');
		
		if($query->num_rows()>0){
			$resultArr	=	$query->row_array();						
		}
		
		return $resultArr;
	}
	
	//----------------------------------------------------------------------------------------------
	 /**
	*This function 'll get the parents details by id
	*
	* @access public
	* @param int parent_id
	* @return array resultArr
	*
	*/	
	
	function getParentDetails($parent_id){
		
		$resultArr	=	array();
		$this->db->select('*');
		$this->db->where('user_id',$parent_id);
		$query		=	$this->db->get('tbl_user');
				
		if($query->num_rows()>0){
			$resultArr	=	$query->row_array();						
		}
		
		return $resultArr;
		
	}
	
	//----------------------------------------------------------------------------------------------
	 /**
	*This function 'll get the endroll details
	*
	* @access public
	* @return array resultArr
	*
	*/	
	
	function getendroll(){
		
		$resultArr	=	array();
		$this->db->select('*');
		$query		=	$this->db->get('tbl_endrolled');
		
		if($query->num_rows()>0){
			$resultArr	=	$query->result_array();						
		}
		
		return $resultArr;
	}
	
	//----------------------------------------------------------------------------------------------
	/**
	*This function 'll get the BroadCaste Messages
	*
	* @access public
	* @return array resultArr
	*
	*/	
	
	function getBroadCasteMessage(){
		
		$resultArr	=	array();
		$this->db->select('*');
		$query		=	$this->db->get('tbl_broadcaste');
				
		if($query->num_rows()>0){
			$resultArr	=	$query->result_array();						
		}
		
		return $resultArr;
	}

}

?>