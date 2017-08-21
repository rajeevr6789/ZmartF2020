<?php
class Quickauth
{
	var $CI;
    var $_username;
	var $_language=1;// global variable for handling language
    var $_table = array(
                    'users' 	=> 'tbl_user',
                    'accounts'	=> 'tbl_account'
                    );
	
	function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->helper('email');
        $this->CI->load->helper('string');
	}
	
	function Quickauth()
    {
        self::__construct();
    }
	
	function is_logged_in()
    {
        $session	=	$this->CI->session->userdata('status');
		return $this->CI->session->userdata('status');
    }
	
	function logged_in_user()
    {
        return $this->CI->session->userdata('user_id');
    }
	
	function logged_in_username()
    {
        return $this->CI->session->userdata('ses_username');
    }
	
	function selected_branch()
    {
        return $this->CI->session->userdata('br_name');
    }
	
	
	function logout(){
		$this->CI->session->sess_destroy();
	}
	
	function is_admin(){
		if($this->CI->session->userdata('ses_role_id') == 1){
			return true;	
		}else{
			return false;
		}
	}
}