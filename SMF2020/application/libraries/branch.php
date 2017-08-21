<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Branch {
	
	
  public function school_module($id) {
	  
		$this->_ci =& get_instance();
		$this->_ci->load->database();

		$this->_ci->db->select('sch_school');
		$this->_ci->db->where('adminID',$id);
		$query = $this->_ci->db->get('tbl_adminusers');
   		$dataArr = $query->row_array();
        $this->_ci->db->select('sch_modulename,sch_ID');
		$this->_ci->db->where('sch_ID',$dataArr['sch_school']);
		$query = $this->_ci->db->get('tbl_school');
   		$dataArr = $query->row_array();
		return $dataArr;
  }
  
   public function school_moduleteacher($id) {
	  
		$this->_ci =& get_instance();
		$this->_ci->load->database();

		$this->_ci->db->select('inmodule');
		$this->_ci->db->where('inusername',$id);
		$query = $this->_ci->db->get('tbl_ulogin');
   		$dataArr = $query->row_array();
		return $dataArr;
  }
  
  
  public function school_module_id_teacher($modukename) {
	  
		$this->_ci =& get_instance();
		$this->_ci->load->database();

		$this->_ci->db->select('sch_ID');
		$this->_ci->db->where('sch_modulename',$modukename);
		$query = $this->_ci->db->get('tbl_school');
   		$dataArr = $query->row_array();
		return $dataArr;
  }
  
}

?>