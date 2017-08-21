<?php
class Admin_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->dbforge();		
	}
	
	
	 /**
	*This function 'll check the username and password
	*
	* @access public
	* @param varchar username 
	* @param varchar password 
	* @return array resultArr
	*
	*/	
	
	function loginProcess($username,$password){	
		
		
        $admn_tbl_main  =   'tbl_adminusers';
        $resultArr		=	array();
		$this->db->select('adminID,sch_type,sch_name');
		$this->db->where('sch_email',$username);
		$this->db->where('sch_password',$password);
		
       
		$query			=	$this->db->get($admn_tbl_main);
		
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			$resultArr['status']	=	true;
			$resultArr['user_id']	=	$result['adminID'];
			$resultArr['type']		=	$result['sch_type'];
			$resultArr['username']		=	$result['sch_name'];
			//$resultArr['school']	=	$result['sch_school'];
		}else{
			$resultArr['status']	=	false;
		}
		
		return $resultArr;
		
	}
	
	
	 /**
	*This function 'll get teacher id from module_teacher table
	*
	* @access public
	* @param varchar email_id 
	* @param varchar table 
	* @return array teacher
	*
	*/
	
	
	function get_id($email_id,$table)
	{
		
		$this->db->select('teaID');
		$this->db->where('tea_email',$email_id);
		$query			=	$this->db->get($table);
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			$teacher['status']	=	true;
			$teacher['id']	=	$result['teaID'];
			
		}else{
			$teacher['status']	=	false;
		}
		
		return $teacher;
		}
	//----------------------------------------------------------

	 /**
	*This function 'll check the teacher id present in slot table or not
	*
	* @access public
	* @param int teacher_id 
	* @param varchar table 
	* @return array chk_id_slot
	*
	*/
	
	function chk_teacher_id($teacher_id,$table)
	{
		$this->db->select('slot_class');		
		$this->db->where('slot_teacher',$teacher_id);
		
		$query			=	$this->db->get($table);
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			$chk_id_slot['status']		=	true;
			$chk_id_slot['class']	=	$result['slot_class'];
			
		}else{
			$chk_id_slot['status']	=	false;
		}
		
		return $chk_id_slot;
		
		}
	
	//------------------------------------------------------------
	
	 /**
	*This function 'll Teacher login check the username and password
	*
	* @access public
	* @param varchar username 
	* @param varchar password 
	* @return array resultArr
	*
	*/	
	
	function teacherLogin($username,$password){	
		
		$resultArr		=	array();
		$this->db->select('inID,inusername,inmodule,intype');		
		$this->db->where('inusername',$username);
		$this->db->where('inpassword',$password);
		//$this->db->where('sch_type',1);
		$query			=	$this->db->get('tbl_ulogin');
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			$resultArr['status']	=	true;
			$resultArr['user_id']	=	$result['inusername'];
			$resultArr['type']		=	$result['intype'];			
			$resultArr['school']	=	$result['inmodule'];
		}else{
			$resultArr['status']	=	false;
		}
		
		return $resultArr;
		
	}
	
	//--------------------------------------------
	
	/**
	*This function 'll insert subadmin
	*
	* @access public
	* @param varchar schoolname 
	* @param varchar name 
	* @param varchar email 
	* @param varchar phone 
	* @param varchar address 
	* @param varchar location 
	*
	*/
	
	function insertSubadmin($name,$email,$phone,$address,$password,$lat,$long) {
		$data	=	array("sch_name"=>$name,"sch_email"=>$email,"sch_phone"=>$phone,"sch_address"=>$address,"sch_latitude"=>$lat,"sch_longitude"=>$long,"sch_password"=>$password,"sch_type"=>2);
		$result	=	$this->db->insert('tbl_adminusers', $data); 
		return $this->db->insert_id();
	}
	
	//-----------------------------------------------------------
	
	/**
	*This function 'll update subadmin
	*
	* @access public
	* @param schoolname,name,email,phone,address,location,id
	*/
	
	function updateSubadmin($data,$id) {
		
		$this->db->where('adminID', $id);
		$result	=	$this->db->update('tbl_adminusers', $data); 
		return $result;
	}
	
	//------------------------------------------------------------
	
	/**
	*This function 'll list all subadmin
	*
	* @access public
	* @param table name
	*/
	function listSubadmin($admin_tbl) {		
		
		$this->db->select('*');		
		//$this->db->join('tbl_school', 'tbl_school.sch_ID = tbl_adminusers.sch_school', 'left');
		$this->db->where('sch_type', 2);
		$this->db->order_by('adminID','asc');
		$query = $this->db->get($admin_tbl);
		return $query->result();
	}
	
	//-------------------------------------------------------------------------
	
	/**
	*This function 'll Check email exist or not
	*
	* @access public
	* @param email
	*/
	
	function checkByemail($email) {
		$this->db->select('*');
		$this->db->where('sch_email', $email);		
		$query	=	$this->db->get('tbl_adminusers');			
		
		$return	=	true;
		
		if($query->num_rows() > 0){
			$return	=	false;
		}
		
		return $return;	
		
	}
	
	function checkByemail_id($email_id,$usr_id){
		$this->db->select('adminID');
		$this->db->where('sch_email',$email_id);
		
		if(is_numeric($usr_id)){
			$this->db->where('adminID <>',$usr_id);
		}
		$query	=	$this->db->get('tbl_adminusers');
		
		$return	=	true;
		
		if($query->num_rows() > 0){
			$return	=	false;
		}
		
		return $return;
	}
	
	/**
	*This function 'll Check email exist or not
	*
	* @access public
	* @param email
	*/
	function checkByemailid($email,$id) {
		$this->db->where('sch_email', $email);
		$this->db->where('adminID !=', $id);
		$this->db->from('tbl_adminusers');
		return $this->db->count_all_results();;
		
	}
	
	/**
	*This function 'll select subadmin by Id
	*
	* @access public
	* @param id
	*/
	function subadminByid($id){
		$this->db->select('*');
		$this->db->where('adminID', $id);
		$query = $this->db->get('tbl_adminusers');		
		return $query->result_array(); 	
	}
	
	/**
	*This function 'll select Branch assigned to admin by adminId
	*
	* @access public
	* @param id
	*/
	function BranchByadminid($id){
		$this->db->select('*');
		$this->db->where('br_ass_ad_id', $id);
		$query = $this->db->get('tbl_branches_assigned');		
		if($query->num_rows()>0) {
		$return =$query->row_array(); 
		return $return['br_ass_branches'];	
		} else {
			return false;
		}
	}
	
	/**
	*This function 'll Delete subadmin by Id
	*
	* @access public
	* @param id
	*/
	function deleteBysubadmin($id) {
		$result	=	$this->db->delete('tbl_adminusers', array('adminID' => $id)); 		
		return $result;
	}
	
	/****************Schools************************************/
	
	/**
	*This function 'll create tables for schools
	*
	* @access public
	* @param None
	*/ 
	function createTable($modulename)
	{
		 
		$activity =	$modulename.'_activities';
		$this->db->query("CREATE TABLE IF NOT EXISTS `$activity` (
		  `actID` int(11) NOT NULL AUTO_INCREMENT,
		  `act_date` date NOT NULL,
		  `act_from` varchar(10) NOT NULL,
		  `act_to` varchar(10) NOT NULL,
		  `act_activity` varchar(255) NOT NULL,
		  `act_school` int(11) NOT NULL,
		  `act_class` varchar(255) DEFAULT NULL,
		  `act_status` int(11) DEFAULT NULL,
		  PRIMARY KEY (`actID`)
		) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;");
		
		
		$class	=	$modulename.'_class';
		$this->db->query("CREATE TABLE IF NOT EXISTS `$class` (
		  `class_id` int(11) NOT NULL AUTO_INCREMENT,
		  `class_name` varchar(50) NOT NULL,
		  `branch_id` int(11) NOT NULL,
		  PRIMARY KEY (`class_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	
		
		$events	=	$modulename.'_events';
		$this->db->query("CREATE TABLE IF NOT EXISTS `$events` (
		  `event_id` int(11) NOT NULL AUTO_INCREMENT,
		  `event_name` varchar(100) NOT NULL,
		  `event_class` varchar(150) NOT NULL,
		  `event_date` date NOT NULL,
		  `event_details` varchar(500) NOT NULL,
		  `event_branch_id` int(11) NOT NULL,
		  `event_radio` int(11) NOT NULL,
		  PRIMARY KEY(`event_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	
		
		$kids	=	$modulename.'_kids';
		$this->db->query("CREATE TABLE IF NOT EXISTS `$kids` (		
		  `kidID` int(11) NOT NULL AUTO_INCREMENT,
		  `kid_name` varchar(50) NOT NULL,
		  `kid_class` varchar(30) NOT NULL,
		  `kid_gender` int(2) NOT NULL,
		  `kid_age` int(3) NOT NULL,
		  `kid_dob` date NOT NULL,
		  `kid_endrolled` int(11) NOT NULL,
		  `kid_image` varchar(255) NOT NULL,
		  `kid_teacher` varchar(50) NOT NULL,
		  `kid_parentID` int(11) NOT NULL,
		  `kid_school` int(11) NOT NULL,
		  `kid_address` varchar(50) NOT NULL,
		  `kid_latitude` text,
  		  `kid_longitude` text,
		  `kid_city` varchar(25) NOT NULL,
		  `kid_state` varchar(25) NOT NULL,
		  `kids_strt_dt` date DEFAULT NULL,
		  `kids_end_dt` date DEFAULT NULL,
		  `kid_bld_gp` varchar(50) DEFAULT NULL,
		  `kid_alergy` text,
		  `kid_medication` text,
		  `kid_medi_condn` text,
		  PRIMARY KEY(`kidID`)
		) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");
		
		
		$kidsattendance	=	$modulename.'_kidsattendance';
		$this->db->query("CREATE TABLE IF NOT EXISTS `$kidsattendance` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `att_kidID` int(11) NOT NULL,
		  `att_status` int(3) NOT NULL,
		  `att_date` date NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;");
	
		$meals	=	$modulename.'_meals';
		$this->db->query("CREATE TABLE IF NOT EXISTS `$meals` (
		  `meals_id` int(11) NOT NULL AUTO_INCREMENT,
		  `meals_date` date NOT NULL,
		  `meals_class` varchar(150) NOT NULL,
		  `meals_bf` varchar(200) NOT NULL,
		  `meals_lunch` varchar(200) NOT NULL,
		  `meals_snacks` varchar(200) NOT NULL,
		  `meals_branch_id` int(11) NOT NULL,
		  `meals_radio` int(11) NOT NULL,
		  PRIMARY KEY(`meals_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		
		
		$payments	=	$modulename.'_payments';
		$this->db->query("CREATE TABLE IF NOT EXISTS `$payments` (
		  `id_payment` int(11) NOT NULL AUTO_INCREMENT,
		  `stud_name` varchar(50) NOT NULL,
		  `stud_id` int(11) DEFAULT NULL,
		  `gender` int(11) DEFAULT NULL,
		  `stud_class` varchar(50) NOT NULL,
		  `payment` varchar(100) NOT NULL,
		  `payment_date` text NOT NULL,
		  `payment_month` text NOT NULL,
		  PRIMARY KEY(`id_payment`)
		) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1; ");
	
		
		$slots	=	$modulename.'_slots';
		$this->db->query("CREATE TABLE IF NOT EXISTS `$slots` (
		  `slotID` int(11) NOT NULL AUTO_INCREMENT,
		  `slot_class` varchar(20) NOT NULL,
		  `slot_teacher` int(11) NOT NULL,
		  `slot_school` int(11) NOT NULL,
		  `slot_class_id` int(11) NOT NULL,
		  PRIMARY KEY(`slotID`)
		) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;");
		
		
		$teacher	=	$modulename.'_teacher';
		$this->db->query("CREATE TABLE IF NOT EXISTS `$teacher` (
		  `teaID` int(11) NOT NULL AUTO_INCREMENT,
		  `tea_school` int(11) NOT NULL,
		  `tea_name` varchar(30) NOT NULL,
		  `tea_gender` int(11) DEFAULT NULL,
		  `tea_email` varchar(30) NOT NULL,
		  `tea_image` varchar(255) DEFAULT NULL,
		  `tea_age` int(11) DEFAULT NULL,
		  `tea_dob` date DEFAULT NULL,
		  `tea_strt_dt` date DEFAULT NULL,
		  `tea_end_dt` date DEFAULT NULL,
		  `tea_phone` varchar(20) NOT NULL,
		  `tea_address` text NOT NULL,
		  `tea_latitude` text NOT NULL,
  		  `tea_longitude` text NOT NULL,
		  `tea_city` varchar(50) NOT NULL,
		  `tea_state` varchar(50) NOT NULL,
		  `tea_password` varchar(100) NOT NULL,
		  `tea_status` int(2) NOT NULL,
		  PRIMARY KEY(`teaID`)
		) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;");
	
		
		$teacherattendance	=	$modulename.'_teacherattendance';
		$this->db->query("CREATE TABLE IF NOT EXISTS `$teacherattendance` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `att_teaID` int(11) NOT NULL,
		  `att_status` int(3) NOT NULL,
		  `late_by` time DEFAULT NULL,
		  `att_date` date NOT NULL,
		  PRIMARY KEY(`ID`)
		) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;");
		
		
		$vacation	=	$modulename.'_vacation';
		$this->db->query("CREATE TABLE IF NOT EXISTS `$vacation` (
		  `vacID` int(11) NOT NULL AUTO_INCREMENT,
		  `school` varchar(50) NOT NULL,
		  `vac_strt_date` date NOT NULL,
		  `vac_end_date` date NOT NULL,
		  `details` varchar(500) NOT NULL,
		  PRIMARY KEY(`vacid`)
		) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;");
		
  
		$pending_payments		=	$modulename.'_pending_payment';
		$this->db->query("
		CREATE TABLE IF NOT EXISTS `$pending_payments` (
		  `pp_id` int(11) NOT NULL AUTO_INCREMENT,
		  `pp_stud_id` int(11) NOT NULL,
		  `pp_stud_class` text NOT NULL,
		  `pp_pend_months` text NOT NULL,
		  PRIMARY KEY(`pp_id`)
		) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;");
		

}
	
	/****************Schools************************************/
	
	/**
	*This function 'll List all school
	*
	* @access public
	* @param None
	*/ 
	function listSchool() {
		$this->db->select('sch_ID,sch_name,sch_country,sch_state,sch_city,sch_email,sch_phone,sch_status,sch_code');
		$this->db->order_by('sch_ID','desc');
		$query = $this->db->get('tbl_school');
		return $query->result();
	}
	
	/**
	*This function 'll rerurn school name where status =1
	*
	* @access public
	* @param None
	*/ 
	function listAllschool() {
		$this->db->select('sch_ID,sch_name');
		$this->db->where('sch_status','1');
		$query = $this->db->get('tbl_school');
		return $query->result_array();
	}
	
	/**
	*This function 'll insert school detail
	*
	* @access public
	* @param schoolname,country,email,phone,address,state,city
	*/ 
	function insertschool($schoolname,$country,$email,$phone,$address,$state,$city,$schoolcode,$lat,$long,$status,$code) {
		$result=0;
		$data	=	array("sch_name"=>$schoolname,"sch_country"=>$country,"sch_state"=>$state,"sch_phone"=>$phone,"sch_email"=>$email,"sch_address"=>$address,"sch_city"=>$city,
		"sch_modulename"=>$schoolcode,"sch_status"=>1,"sch_latitude"=>$lat,"sch_longitude"=>$long,"sch_addr_status"=>$status,"sch_code"=>$code);
		$result	=	$this->db->insert('tbl_school', $data); 
		/*$ret['result']=$result_id;
		$branch_id=$this->db->insert_id();
		$ret['branch_id']=$branch_id;
		*/
		if($result)
		{
		$branch_id=$this->db->insert_id();
		}
		return $branch_id;
	}
	
	//---------------------------------------------------
	
	/**
	*This function 'll Update school detail
	*
	* @access public
	* @param schoolname,country,email,phone,address,state,city
	*/
	 
	function updateSchool($country,$email,$phone,$address,$state,$city,$id,$lat,$long,$status) {
		$data	=	array("sch_country"=>$country,"sch_state"=>$state,"sch_phone"=>$phone,"sch_email"=>$email,"sch_address"=>$address,"sch_city"=>$city,"sch_latitude"=>$lat,"sch_longitude"=>$long,"sch_addr_status"=>$status);
		$this->db->where('sch_ID', $id);
		$result	=	$this->db->update('tbl_school', $data); 
		return $result;
	}
	
	//---------------------------------------------------------------
	
	/**
	*This function 'll select school by id
	*
	* @access public
	* @param id
	*/
	function schoolByid($id){
		$this->db->select('*');		
		$this->db->join('tbl_endrolled', 'tbl_endrolled.enroll_branch_id=tbl_school.sch_ID', 'left');
		$this->db->where('sch_ID', $id);
		$query = $this->db->get('tbl_school');
		return $query->result_array(); 	
	}
	//------------------------------------------------------------
	
	function school_Name_Byid($id){
		$this->db->select('*');		
		$this->db->join('tbl_endrolled', 'tbl_endrolled.enroll_branch_id=tbl_school.sch_ID', 'left');
		$this->db->where('sch_ID', $id);
		$query	=	$this->db->get('tbl_school');
		$result	=	$query->row_array();
		
		if($query->num_rows()>0){			
			
			$branch['name']	=	$result['sch_name'];
		
					
		}else{$branch['name']	=	'';
		}
		
		return $branch;	 	
	}
	
	
	
	/**
	*This function 'll delete school by id
	*
	* @access public
	* @param id
	*/
	function deleteByschool($id) {
		$result	=	$this->db->delete('tbl_school', array('sch_ID' => $id)); 
		return $result;
	}
	
	//----------------------------------------------------------
	
	/**
	*This function 'll drop school tables
	*
	* @access admin
	* @param id
	*/
	/*
	function dropTable($prefix)
	{
		$this->dbforge->drop_table($prefix.'_teacher');
		$this->dbforge->drop_table($prefix.'_kids');
	}*/
	function dropTable($school)
	{
		
		$this->dbforge->drop_table($school.'_activities');
		$this->dbforge->drop_table($school.'_class');
		$this->dbforge->drop_table($school.'_events');
		$this->dbforge->drop_table($school.'_kids');
		$this->dbforge->drop_table($school.'_kidsattendance');	
		$this->dbforge->drop_table($school.'_meals');
		$this->dbforge->drop_table($school.'_payments');
		$this->dbforge->drop_table($school.'_pending_payment');	
		$this->dbforge->drop_table($school.'_slots');
		$this->dbforge->drop_table($school.'_teacher');
		$this->dbforge->drop_table($school.'_teacherattendance');
		$this->dbforge->drop_table($school.'_vacation');
	}
	
	//--------------------------------------------------------
	
	/**
	*This function 'll insert teacher
	*
	* @access public
	* @param varchar schoolname 
	* @param varchar name 
	* @param varchar email 
	* @param varchar phone 
	* @param varchar address 
	* @param varchar city 
	*
	*/
	
	function insertTeacher($schoolname,$name,$email,$phone,$address,$city,$state) {
		$data	=	array("tea_school"=>$schoolname,"tea_name"=>$name,"tea_email"=>$email,"tea_phone"=>$phone,"tea_address"=>$address,"tea_city"=>$city,"tea_state"=>$state,"tea_status"=>1);
		$result	=	$this->db->insert('tbl_teacher', $data); 
		return $result;
	}
	
	/**
	*This function 'll update teacher
	*
	* @access public
	* @param schoolname,name,email,phone,address,city,id
	*/
	
	function updateTeacher($schoolname,$name,$email,$phone,$address,$city,$state,$id) {
		$data	=	array("tea_school"=>$schoolname,"tea_name"=>$name,"tea_email"=>$email,"tea_phone"=>$phone,"tea_address"=>$address,"tea_city"=>$city,"tea_state"=>$state);
		$this->db->where('teaID', $id);
		$result	=	$this->db->update('tbl_teacher', $data); 
		return $result;
	}
	
	
	/**
	*This function 'll List all school
	*
	* @access public
	* @param None
	*/ 
	function listTeacher() {
		$this->db->select('teaID,tea_school,tea_name,tea_email,tea_phone,tea_address,tea_city,tea_state,tea_status,sch_name');
		$this->db->from('tbl_teacher');
		$this->db->join('tbl_school', 'tbl_school.sch_ID = tbl_teacher.tea_school', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	
	/**
	*This function 'll select school by id
	*
	* @access public
	* @param id
	*/
	function teacherByid($id){
		$this->db->select('*');
		$this->db->where('teaID', $id);
		$query = $this->db->get('tbl_teacher');
		return $query->result_array(); 	
	}
	/**
	*This function to get teacher details by email
	*
	* @access public
	* @param email
	*/
	function teacherByemail($table,$email){
		$this->db->select('*');
		$this->db->where('tea_email', $email);
		$query = $this->db->get($table);
		return $query->row_array(); 	
	}
	/**
	*This function 'll fetch teacher by Id
	*
	* @access public
	* @param id
	*/
	/*function getteacherBymodule($moduleID,$table){
		$this->db->select('tea_name,teaID');
		$this->db->where('tea_school',$moduleID);
		$query = $this->db->get($table); 
		return $query->result_array(); 
		
	}*/
	
	/**
	*This function 'll delete teacher by id
	*
	* @access public
	* @param id
	*/
	function deleteByteacher($id) {
		$result	=	$this->db->delete('tbl_teacher', array('teaID' => $id)); 
		return $result;
	}
	
	/**
	*This function 'll list all enrolled
	*
	* @access public
	* @param id
	*/
	function listEnrolled() { 
		$this->db->select('ID,endrolled');
		$query = $this->db->get('tbl_endrolled');
		return $query->result();
	}
	
	/**
	*This function 'll insert teacher
	*
	* @access public
	* @param varchar schoolname 
	* @param varchar name 
	* @param varchar email 
	* @param varchar phone 
	* @param varchar address 
	* @param varchar city 
	*
	*/
	
	function insertStudent($schoolname,$name,$class,$gender,$enrolled,$image) {
		$data	=	array("kid_school"=>$schoolname,"kid_name"=>$name,"kid_classno"=>$class,"kid_gender"=>$gender,"kid_endrolled"=>$enrolled,"kid_image"=>$image);
		$result	=	$this->db->insert('tbl_kids', $data); 
		return $result;
	}
	
	/**
	*This function 'll update teacher
	*
	* @access public
	* @param schoolname,name,email,phone,address,city,id
	*/
	
	function updateStudent($schoolname,$name,$class,$gender,$enrolled,$id) {
		$data	=	array("kid_school"=>$schoolname,"kid_name"=>$name,"kid_classno"=>$class,"kid_gender"=>$gender,"kid_endrolled"=>$enrolled);
		$this->db->where('kidID', $id);
		$result	=	$this->db->update('tbl_kids', $data); 
		return $result;
	}
	
	/**
	*This function 'll list all Student
	*
	* @access public
	* @param id
	*/
	
	function listStudent($table,$entrolled,$classes) {
		$this->db->select('*');
		
		$this->db->join($classes, ''.$classes.'.class_id = '.$table.'.kid_class', 'left');
		$this->db->join($entrolled, ''.$entrolled.'.ID = '.$table.'.kid_endrolled', 'left');
		
		$this->db->order_by(''.$table.'.kidID', "desc"); 
		$query = $this->db->get($table);
		return $query->result();
	}
	
	/**
	*This function 'll select school by id
	*
	* @access public
	* @param id
	*/
	function studentByid($id){
		$this->db->select('*');
		$this->db->where('kidID', $id);
		$query = $this->db->get('tbl_kids');
		return $query->result_array(); 	
	}
	/*
	*
	*
	*/
	function school_branchname_bymodulename($module) {
		$this->db->select('sch_name');
		$this->db->where('sch_modulename',$module);
		$query	=	$this->db->get('tbl_school');
		$data	=	$query->row_array(); 
		return $data['sch_name'];
		
	}
	/**
	*This function 'll delete teacher by id
	*
	* @access public
	* @param id
	*/
	function deleteBystudent($id) {
		$result	=	$this->db->delete('tbl_kids', array('kidID' => $id)); 
		return $result;
	}
	
	
	function school_module($username)
	{
		
		$this->db->select('inmodule');
		$this->db->where('inusername',$username);
		
		$query			=	$this->db->get('tbl_ulogin');
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			$schname['status']	=	true;
			
			$schname['module_name']	=	$result['inmodule'];
			
		}else{
			$schname['status']	=	false;
			
			$schname['module_name']	=	"test";
		}
		
		return $schname;
		
		}
		
		function school_module_branch($username,$branch)
	{
		
		$this->db->select('inmodule');
		$this->db->where('inusername',$username);
		$this->db->where('inmodule',$branch);
		$query			=	$this->db->get('tbl_ulogin');
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			
			$schname['status_branch']	=	true;
			$schname['module_name']	=	$result['inmodule'];
			
		}else{
			
			$schname['status_branch']	=	false;
			$schname['module_name']	=	"test";
		}
		
		return $schname;
		
		}
		
		function absenties($table,$branch_kids,$branch_class)
	{
		/*$this->db->from('branch_module_kids');
		$this->db->join($table, ''.$table.'.ID = branch_module_kids.kidID', 'left');*/
		
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('att_status', 2);
		//$this->db->join('branch_module_kids', 'branch_module_kids.kidID = '.$table.'.att_kidID', 'left');	
		$this->db->join($branch_kids, ''.$branch_kids.'.kidID = '.$table.'.att_kidID', 'left');
		$this->db->join($branch_class, ''.$branch_class.'.class_id = '.$branch_kids.'.kid_class', 'left');	
		$query = $this->db->get();
		return $query->result();
		}
	//-----------------------------------------------------------------------	
		
	/**
	*This function 'll get admin name
	*
	* @access public
	* @param 
	*/
	
	function get_admin_name($admin_id)
	{
		//$get_name = array();
		$this->db->select('sch_name,sch_type');
		$this->db->where('adminID',$admin_id);
        $this->db->where('sch_type',1);
		$query	=	$this->db->get('tbl_adminusers');	   	
		$result	=	$query->row_array();
		if($query->num_rows()>0){			
			
			$get_name['admin_name']	=	$result['sch_name'];
			$get_name['type']		=	$result['sch_type'];			
		}else{$get_name['admin_name']	= '';
             $get_name['type']		= '';}
		
		return $get_name;
	}
	
	//---------------------------------------------
	
	
	 /**
	*This function 'll get total count of message
	*
	* @access public
	* @param id , type
	*/
	
	function total_msg_count($id,$type)
	{
		$this->db->select('msg_subject');		
		$this->db->where('msg_to',$id);
		$this->db->where('type_to',$type);
		$this->db->where('msg_status','0');	
		$query = $this->db->get('message');
		    
		return $query->result();
	}
	
	//-------------------------------------------------
	
   /**
	*This function 'll show names
	*
	* @access public
	* @param 
	*/
	
	function show_names($id,$admin_tbl,$msg_tbl,$type)
	{
		
        $this->db->select('*');		
		$this->db->where('type_to',$type);
        $this->db->where('msg_to',$id);
		$this->db->where('msg_status','0');		
		$this->db->limit('3');
		$this->db->from($msg_tbl);
		$this->db->join($admin_tbl, ''.$admin_tbl.'.adminID = '.$msg_tbl.'.msg_from', 'left');		
		$query = $this->db->get(); 
		return $query->result_array();
		
	}
	
	//------------------------------------------------------------------	
  
  /**
	*This function 'll fetch branch admin list
	*
	* @access public
	* @param admin table name
	*/
	
	function get_admin($admin_tbl){
		$this->db->select('*');
		$this->db->where('sch_name !=','admin');
		$this->db->from($admin_tbl);		
		$query = $this->db->get(); 
		return $query->result_array(); 
		
	}
	
	//--------------------------------------------------	
	
	
	 /**
	*This function 'll insert message
	*
	* @access public
	* @param 
	*/
	
	function insert_msg($msg_to,$msg_from,$subject,$message,$status,$parent_id,$type_from,$type_to)
	{
		$data = array("msg_subject"=>$subject,"msg_body"=>$message,"msg_from"=>$msg_from,"msg_to"=>$msg_to,"msg_parent_id"=>$parent_id,"msg_status"=>$status,"type_from"=>$type_from,"type_to"=>$type_to);		
		$result	=	$this->db->insert('message', $data); 
		return $result;	
		
		}

    //--------------------------------------------------------
	
	 /**
	*This function 'll update message
	*
	* @access public
	* @param 
	*/
	
	function update_msg($msg_id,$status,$msg_tbl)
	{
		$data = array("msg_status"=>$status);
		$this->db->where('msg_id',$msg_id);
		$result	=	$this->db->update($msg_tbl, $data);  
		return $result;	
		
		}

    //--------------------------------------------------------
	
	
	
	 /**
	*This function 'll show all messages
	*
	* @access public
	* @param 
	*/
	
	function show_all_msgs($id,$msg_tbl,$admin_table,$type)
	{
		$this->db->select('*');		
		$this->db->where('msg_parent_id',0);	
                $this->db->where('msg_to',$id);
                $this->db->where('type_to',$type);
		$this->db->from($msg_tbl);		
		$this->db->join($admin_table, ''.$admin_table.'.adminID = '.$msg_tbl.'.msg_from', 'left');
		$this->db->where('sch_name !=','admin');
		$query = $this->db->get(); 
		return $query->result_array();
		
	}
	
	//------------------------------------------------------------------
	
	 /**
	*This function 'll show all messages and reply messages
	*
	* @access public
	* @param 
	*/
	
	function show_msg_reply($msg_id,$msg_tbl,$admin_table)
	{
		$this->db->select('*');		
		$this->db->where('msg_parent_id',$msg_id);		
		$this->db->from($msg_tbl);
		$this->db->join($admin_table, ''.$admin_table.'.adminID = '.$msg_tbl.'.msg_from', 'left');		
		$query = $this->db->get(); 
		return $query->result_array();
		
	}
	
	//-------------------------------------------------------------------
	
   /**
	*This function 'll show messages from message table by Id
	*
	* @access public
	* @param 
	*/
	
	function show_message($msg_id,$msg_tbl)
	{
		$this->db->select('msg_subject,msg_body');
		$this->db->where('msg_id',$msg_id);
		$query			=	$this->db->get($msg_tbl);
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			
			$message['subject']	=	$result['msg_subject'];
			$message['message']	=	$result['msg_body'];
		}else{
				$message['subject']	= '';
				$message['message']	= '';
			}
		
		return $message;
	}
	
	
	//------------------------------------------------------
	
	/**
	*This function 'll get branch admin name
	*
	* @access public
	* @param branch admin id
	*/
	
	function show_branch_ad_name($id)
	{
		$this->db->select('sch_name');

        $this->db->where('adminID',$id);
		
		$query			=	$this->db->get('tbl_adminusers');
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			
			$name['name']	=	$result['sch_name'];
		}else{$name['name']	='';}
		
		return $name;
		
	}
	
	//----------------------------------------------------------------
	
	 /**
	*This function 'll delete message
	*
	* @access public
	* @param 
	*/
	
	function delete_msg($msg_id)
	{
		$result	=	$this->db->delete('message', array('msg_id' => $msg_id)); 
		return $result;
		
	}
	//----------------------------------------------
	
	/**
	*This function 'll get admin type
	*
	* @access admin
	* @param table,id
	*/
	
	function get_type($msg_to)
	{
		$this->db->select('sch_type');
		$this->db->where('adminID',$msg_to);
		$query			=	$this->db->get('tbl_adminusers');
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			
			$type['type']	=	$result['sch_type'];
			
		}else{$type['type'] ='';}
		
		return $type;
		
	}
	
	//--------------------------------------------------------------

	/**
	*This function 'll list all branches
	*
	* @access admin
	* @param none
	*/
	
	function show_schools()
  	{
		$this->db->select('sch_ID,sch_name');
		$query = $this->db->get('tbl_school');
		return $query->result_array();  
  	}
	
   //------------------------------------------------------------
  
  /**
	*This function 'll get branch address
	*
	* @access admin
	* @param admin name
	*/
	
  function get_branch_addr($add)
  {
	$this->db->select('sch_city,sch_address,sch_state,sch_country');
	$this->db->where('sch_ID',$add); 
	$query = $this->db->get('tbl_school');	
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			
			$type['addr_city']	=	$result['sch_city'];
			$type['addr']		=	$result['sch_address'];
			$type['addr_st']	=	$result['sch_state'];
			$type['addr_coun']	=	$result['sch_country'];
			
		}else{
		    $type['addr_city']	=	'';
			$type['addr']		=	'';
			$type['addr_st']	=	'';
			$type['addr_coun']	=	'';
			}
		
		return $type;
  }
  
  //------------------------------------------------------------
  
 /**
	*This function 'll insert enrollment details of a branch
	*
	* @access admin
	* @param branch_id,$enrol_type
	*/
	
  function insertenroldetails($branch_id,$enrol_type)  
  {
	$data	=	array("endrolled"=>$enrol_type,"enroll_branch_id"=>$branch_id);
	$result	=	$this->db->insert('tbl_endrolled', $data); 
	return $result;	  
  }
  
  //-------------------------------------------------------------
  
  /**
	*This function is used to autocomplete
	*
	* @access admin
	* @param search items
  */
	
  public function auto_complete($searchTerm) {    
  
$query ="SELECT * FROM tbl_endrolled WHERE endrolled LIKE '%".$searchTerm."%'  ORDER BY ID ASC LIMIT 5";
$result=$this->db->query($query);
$data=$result->result();
foreach ($data as $key => $value) {
			$enrolldbarray[] = $value->endrolled;
	}

return $enrolldbarray;
//echo json_encode(array_unique($enrolldbarray));

 }
 
 //-----------------------------------------------------------
	
	/**
	*This function 'll get entroll for given branch
	*
	* @access admin
	* @param branch id
	*/
	
   function enrolbyid($id){
				
	$this->db->select('*');
	$this->db->from('tbl_endrolled');
	$this->db->where('enroll_branch_id',$id);		
	$query = $this->db->get();
	return $query->result();		
   }
   
   //-------------------------------------------------------
   
   /**
	*This function 'll will update entrollment details
	*
	* @access admin
	* @param id, type
	*/
	
	function updateenroldetails($id,$enrol_type)	
	{		
		$data = array("endrolled"=>$enrol_type);
		$this->db->where('ID',$id);
		$result	=	$this->db->update('tbl_endrolled', $data);  
		return $result;	
	}
	
	//----------------------------------------------------
	
	/**
	*This function 'll delete entrollment details by id
	*
	* @access admin
	* @param id
	*/
	
	function deleteenroldetails($id){
		
		$result	=	$this->db->delete('tbl_endrolled', array('ID' => $id)); 
		return $result;
	}
	
	//----------------------------------------------------
	
	/**
	*This function 'll list branch admins
	*
	* @access admin
	* @param table name
	*/
  
   function list_br_admins($tbl_brn,$tbl_brh_ass)
   {	
	$this->db->select('*');
	$this->db->where('sch_type',2);    
	//$this->db->join($tbl_brh_ass, ''.$tbl_brh_ass.'.br_ass_ad_id = '.$tbl_brn.'.adminID', 'left');
	$query  =  $this->db->get($tbl_brn); 
	return $query->result_array();
  }
  
  //------------------------------------------------
  
  /**
	*This function 'll list all branches
	*
	* @access admin
	* @param id
	*/
	
  function list_branches($tbl_users)
  {
	$tbl_school = 'tbl_school';
	$this->db->select('*');
	//$this->db->join($tbl_users, ''.$tbl_users.'.adminID = '.$tbl_school.'.sch_ID', 'left');
	
	$query  =  $this->db->get($tbl_school); 
	return $query->result_array();	  
  }
  
  //------------------------------------------------
  
  function insert_br_assigned($br_admin_name,$branch_names)
  {
	$data	=	array("br_ass_ad_id"=>$br_admin_name,"br_ass_branches"=>$branch_names);
		$result	=	$this->db->insert('tbl_branches_assigned', $data); 
		return $result;  
  }
  
  //--------------------------------------------------
  
  function update_br_assigned($br_admin_name,$branch_names,$id)
  {
	$data	=	array("br_ass_ad_id"=>$br_admin_name,"br_ass_branches"=>$branch_names);
		$this->db->where('br_ass_id',$id);
		$result	=	$this->db->update('tbl_branches_assigned', $data); 
		return $result;  
  }
  
  //--------------------------------------------------
 
  function insert_users_assigned($branch_id,$br_admins)
  {
	 $data	=	array("usr_ass_br_id"=>$branch_id,"usr_ass_admins"=>$br_admins);
		$result	=	$this->db->insert('tbl_usrs_assigned', $data); 
		return $result;  	  
  }
  
  //-----------------------------------------------------
  
  
  function update_users_assigned($branch_id,$br_admins,$id)
  {
	 $data	=	array("usr_ass_br_id"=>$branch_id,"usr_ass_admins"=>$br_admins);
		$this->db->where('usr_ass_id',$id);
		$result	=	$this->db->update('tbl_usrs_assigned', $data); 
		return $result;  	  
  }
  
  //-----------------------------------------------------
  
  function list_ass_brns($admin_table,$tbl_br_ass,$tbl_branch)
  {
	  $this->db->select(''.$tbl_branch.'.sch_name AS branch');
	  $this->db->select(''.$admin_table.'.sch_name AS admin');
	  $this->db->select('br_ass_id');	 
	  $this->db->join($admin_table, ''.$admin_table.'.adminID = '.$tbl_br_ass.'.br_ass_ad_id', 'left');
	  $this->db->join($tbl_branch, ''.$tbl_branch.'.sch_ID = '.$tbl_br_ass.'.br_ass_branches', 'left');
	  $query = $this->db->get($tbl_br_ass);
	  return $query->result();
  }
  
  //-----------------------------------------------------
  
  function delete_ass_br($id)
  {
	$this->db->where('br_ass_id',$id); 
	$query = $this->db->delete('tbl_branches_assigned'); 
	 return $query;
  }
  
  //-------------------------------------------------------
  
   function delete_ass_usr($id)
  {
	$this->db->where('usr_ass_id',$id); 
	$query = $this->db->delete('tbl_usrs_assigned'); 
	 return $query;
  }
  
  //-------------------------------------------------------
  
  function list_ass_usr($admin_table,$tbl_usr_ass,$tbl_school)
  {
	   $this->db->select(''.$tbl_school.'.sch_name AS branch');
	  $this->db->select(''.$admin_table.'.sch_name AS admin');
	  $this->db->select('usr_ass_id');
	  $this->db->join($admin_table, ''.$admin_table.'.adminID = '.$tbl_usr_ass.'.usr_ass_admins', 'left');
	  $this->db->join($tbl_school, ''.$tbl_school.'.sch_ID = '.$tbl_usr_ass.'.usr_ass_br_id', 'left');
	  $query = $this->db->get($tbl_usr_ass);
	  return $query->result(); 
	  
  }
  
  //-------------------------------------------------------
  
  
  function br_names_edit($id,$tbl_brn_ass)
  {
	  $this->db->select('br_ass_branches');	
	  $this->db->where('br_ass_id',$id);
	  $query = $this->db->get($tbl_brn_ass);
	  return $query->result_array(); 
	  
  }
  
  //-----------------------------------------------------------
  
  /**
	*This function 'll get assigned users by id
	*
	* @access admin
	* @param user id, table 
	*/
  
  function usr_names_edit($id,$tbl_usr_ass)
  {
	  $this->db->select('usr_ass_admins');	
	  $this->db->where('usr_ass_id',$id);
	  $query = $this->db->get($tbl_usr_ass);
	  return $query->result_array(); 
	  
  }
  
  //---------------------------------------------------------
  
  /**
	*This function 'll check the branch id with the user id
	*
	* @access admin
	* @param user id, branch id
	*/ 
 
  function check_branch($id,$branch)
  {
		
		$this->db->like('br_ass_branches',$branch);	   
		$this->db->where('br_ass_ad_id', $id);									
		$query = $this->db->get('tbl_branches_assigned');
		
		return $query->result();
  }
  
  //--------------------------------------------------------
  
   /**
	*This function 'll check the username and password for branch admin
	*
	* @access public
	* @param varchar username 
	* @param varchar password 
	* @return array resultArr
	*
	*/	
	
	function loginProcess_branch($username,$password){	
		
		$this->db->select('*');
		$this->db->where('sch_email',$username);
		$this->db->where('sch_password',$password);
		$this->db->where('sch_type',2);
		$query			=	$this->db->get('tbl_adminusers');
		
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			$resultArr['status']	=	true;
			$resultArr['user_id']	=	$result['adminID'];	
			$resultArr['username']	=	$result['sch_name'];			
		}else{
			$resultArr['status']	=	false;
			$resultArr['user_id']	=	'';
			$resultArr['username']	=	'';
		}
		
		return $resultArr;
		
	}
	
	//-----------------------------------------------------
	
	/**
	*This function 'll get branch id
	*
	* @access admin
	* @param branch name
	*/
	
	function get_brh_id($brh_name)
	{
		$br_id=array();
		$this->db->select('sch_ID,sch_name');
		$this->db->where('sch_modulename',$brh_name);	
		$query	=	$this->db->get('tbl_school');
		$result	=	$query->row_array();
		if($query->num_rows()>0)
		{
			$br_id['brh_id']	=	$result['sch_ID'];
			$br_id['brh_name']	=	$result['sch_name'];	
		}else{$br_id['brh_id']	=	'';$br_id['brh_name']	=	'';}
		
		return $br_id;
	}
	
	//-------------------------------------------------
    
  /**
	*This function 'll insert branches assigned
	*
	* @access admin
	* @param admin id,branch id
	*/
    
    function insert_branches($brh_admin_id,$branch)
    {
        $data   =   array('br_ass_ad_id'=>$brh_admin_id,'br_ass_branches'=>$branch);       
        $result =   $this->db->insert('tbl_branches_assigned',$data);
    
    }
 
  /**
	*This function 'll insert branches assigned
	*
	* @access admin
	* @param admin id,branch id
	*/
    
    function update_branches($brh_admin_id,$branch)
    {
        $data   =   array('br_ass_branches'=>$branch); 
		$this->db->where("br_ass_ad_id",$brh_admin_id) ;     
        $result =   $this->db->update('tbl_branches_assigned',$data);
    
    }
//----------------------------------------------
	
	 /**
	*This function 'll check if user assigning an existing branch
	*
	* @access admin
	* @param none
	*/
	
	function check_existing_branch($br_admin_name,$branch_name)
	{
		$this->db->select('*');
		$this->db->where("br_ass_ad_id ",$br_admin_name);
		$this->db->where("br_ass_branches",$branch_name);
		$query = $this->db->get('tbl_branches_assigned');	
		if($query->num_rows()>0) {
		 return true;	
		} else {
		return false;
		}
	}  
//----------------------------------------------
	
	 /**
	*This function 'll check if user assigning an existing branch when inserting
	*
	* @access admin
	* @param none
	*/
	
	function check_existing_branch_inserting($branch_name)
	{
		$this->db->select('*');
		$this->db->where("br_ass_branches",$branch_name);
		$query = $this->db->get('tbl_branches_assigned');	
		if($query->num_rows()>0) {
		 return true;	
		} else {
		return false;
		}
	}  
	
	//----------------------------------------------
	
	 /**
	*This function 'll check if user assigning an existing branch in edit
	*
	* @access admin
	* @param none
	*/
	
	function check_existing_branchedit($br_admin_name,$branch_name)
	{
		$this->db->select('*');
		$this->db->where("br_ass_ad_id !=",$br_admin_name);
		$this->db->where("br_ass_branches",$branch_name);
		$query = $this->db->get('tbl_branches_assigned');	
		if($query->num_rows()>0) {
		 return true;	
		} else {
		return false;
		}
	}    
    //----------------------------------------------
	
	 /**
	*This function 'll lisr branches
	*
	* @access admin
	* @param none
	*/
	
	function get_branches()
	{
		$this->db->select('*');
		$query = $this->db->get('tbl_school');	
		return $query->result_array();
	}
	

	//---------------------------------------------------

	//------------------------------------------------
			
			/*@RR
			/*This function 'll get all deta of  a particular branch admin*/
			
			
 	function get_subadmin_details($id,$tbl_branch_admins)
  
  
  	{
	 	$this->db->select('*');	
	  	$this->db->where('br_ad_id',$id);
	  	$query = $this->db->get($tbl_branch_admins);
	  	return $query->result_array(); 
	  
  	}
	
	
	 /**
	*This function 'll check the username and password
	*
	* @access public
	* @param varchar username 
	* @param varchar password 
	* @return array resultArr
	*
	*/	
	
	function recoverProcess($username,$schtype){	
		
		echo 'inside teacher';
        $admn_tbl_main  =   'tbl_adminusers';
        $resultArr		=	array();
		$this->db->select('*');
		$this->db->where('sch_email',$username);
		$this->db->where('sch_type',$schtype);
		
       
		$query			=	$this->db->get($admn_tbl_main);
		
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			$resultArr['status']	=	true;
			$resultArr['user_id']	=	$result['adminID'];
			$resultArr['type']		=	$result['sch_type'];
			$resultArr['password']	=	$result['sch_password'];
			$resultArr['name']		=	$result['sch_name'];
			//$resultArr['school']	=	$result['sch_school'];
		}else{
			$resultArr['status']	=	false;
		}
		
		return $resultArr;
		
	}
	
	 /**
	*This function 'll check the username and password
	*
	* @access public
	* @param varchar username 
	* @param varchar password 
	* @return array resultArr
	*
	*/	
	
	function recoverProcess_teacher($username,$tea_branch){	
		
		
        $teacher_tbl =   $tea_branch;
        $resultArr		=	array();
		$this->db->select('*');
		$this->db->where('tea_email',$username);
		
		
       
		$query			=	$this->db->get($teacher_tbl);
		
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			$resultArr['status']	=	true;
			$resultArr['user_id']	=	$result['teaID'];
			//$resultArr['type']		=	$result['sch_type'];
			$resultArr['password']	=	$result['tea_password'];
			$resultArr['name']		=	$result['tea_name'];
			//$resultArr['school']	=	$result['sch_school'];
		}else{
			$resultArr['status']	=	false;
		}
		
		return $resultArr;
		
	}
	
	//----------------------------------------------------------
	
	/**
	*This function 'll show branch admin by id
	*
	* @access admin
	* @param table name, Id
	*/
  
   function get_br_admin_byId($id,$tbl_brn,$tbl_brh_ass)
   {	
	$this->db->select('*');
	$this->db->where('sch_type',2); 
	$this->db->where('br_ass_id',$id);    
	$this->db->join($tbl_brh_ass, ''.$tbl_brh_ass.'.br_ass_ad_id = '.$tbl_brn.'.adminID', 'left');
	$query  =  $this->db->get($tbl_brn); 
	$result =  $query->row_array();
	
	if($query->row_array()>0)
	{
		$admin['admin_name']	=	$result['sch_name'];
		$admin['admin_id']		=	$result['adminID'];
	}else{$admin['admin_name']	='';
	$admin['admin_id']	='';}
	return $admin;
  }
  
  //------------------------------------------------
 
 function get_branch($id,$tbl_brh_ass,$tbl_school)
 {
	$this->db->select('*');	
	$this->db->where('br_ass_id',$id);    
	$this->db->join($tbl_school, ''.$tbl_school.'.sch_ID = '.$tbl_brh_ass.'.br_ass_branches', 'left');
	$query  =  $this->db->get($tbl_brh_ass);  
	$result =  $query->row_array();
	
	if($query->row_array()>0)
	{
		$branch['branch_name']	=	$result['sch_name'];
	}else{$branch['branch_name']	='';}
	return $branch;
 }	

//------------------------------------------------------

function update_new_pass($admin_id,$enpassword)
	{
		$dataArr	=	array("sch_password"=>$enpassword);
		$this->db->where('adminID', $admin_id);
		
		$result	=	$this->db->update('tbl_adminusers', $dataArr); 
		return $result;		
	}
	
	//-------------------------------------------------
	
	/**
	*This function 'll check the given password with original password
	*
	* @access branch admin
	* @param id,password
	*/
	
	function check_pass($id,$old_pass,$table) {
		
		$this->db->select('*');
		$this->db->where('adminID', $id);
		$this->db->where('sch_password', $old_pass);		
		$query			=	$this->db->get($table);		
		
		$return	=	false;
		
		if($query->num_rows() > 0){
			$return	=	true;
		}
		
		return $return;
	}
	
	//-------------------------------------------------------
	
	/**
	*This function 'll get admin email
	*
	* @access public
	* @param 
	*/
	
	function get_admin_email($admin_id)
	{
		$this->db->select('sch_email,sch_name');
		$this->db->where('adminID',$admin_id);
		$query	=	$this->db->get('tbl_adminusers');	   	
		$result	=	$query->row_array();
		if($query->num_rows()>0){			
			
			$get_email['email']	=	$result['sch_email'];
			$get_email['name']	=	$result['sch_name'];
					
		}else{$get_email['email']	=	'';
		$get_email['name']	= '';}
		
		return $get_email;
	}
	
	
	
	//---------------------------------------------
	/**
	*This function 'll will check whether the email exists or not
	*
	* @access branch admin
	* @param email
	*/
	function checkUsername($email,$table) {
		$this->db->select('*');
		$this->db->where('inusername', $email);
		$query	=	$this->db->get($table);			
		
		$return	=	true;
		
		if($query->num_rows() > 0){
			$return	=	false;
		}
		
		return $return;	
		
	}
	
	//----------------------------------------------------------------
	
	function checkUsername_id($email_id,$usr_id,$tbl){
		$this->db->select('inID');
		$this->db->where('inusername',$email_id);
		
		if(is_numeric($usr_id)){
			$this->db->where('inID <>',$usr_id);
		}
		$query	=	$this->db->get($tbl);
		
		$return	=	true;
		
		if($query->num_rows() > 0){
			$return	=	false;
		}
		
		return $return;
	}
	
	 /**
	*This function 'll check the username and password
	*
	* @access public
	* @param varchar username 
	* @param varchar password 
	* @return array resultArr
	*
	*/	
	
	function recoverProcess_teacher_new($username,$tea_branch){	
		
		
        $teacher_tbl =   $tea_branch;
        $resultArr		=	array();
		$this->db->select('*');
		$this->db->where('inusername',$username);
		
		
       
		$query			=	$this->db->get($teacher_tbl);
		
		$result			=	$query->row_array();
		
		if($query->num_rows()>0){
			$resultArr['status_new']	=	true;
			$resultArr['user_id_new']	=	$result['inID'];
			//$resultArr['type']		=	$result['sch_type'];
			$resultArr['recovery_password']	=	$result['inpassword'];
			
			//$resultArr['school']	=	$result['sch_school'];
		}else{
			$resultArr['status']	=	false;
		}
		
		return $resultArr;
		
	}
	
	//----------------------------------------------------------
	
	 /**
	*This function 'll load the latitude, Address and longitide
	*
	* @access public
	* @param table name
	
	* @return array resultArr
	*
	*/	
	//---------------------------------------------------------------
	
	
	function admin_gps_track($gps_table){
		$this->db->select('*');		
		$query = $this->db->get($gps_table);
		return $query->result_array(); 	
	}
	function get_teaid($email_id,$table)
	{
		
		$this->db->select('*');
		$this->db->where('inusername',$email_id);
		$query			=	$this->db->get($table);
		$result			=	$query->row_array();
		$teaID=0;
		if($query->num_rows()>0){
			
			$teaID	=	$result['inID'];
			
		}else{
			$teaID=0;
		}
		
		return $teaID;
		}
	
	
	
}

?>