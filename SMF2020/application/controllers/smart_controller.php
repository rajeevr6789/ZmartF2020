<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Smart_Controller extends CI_Controller {
	
 private $module,$smart_login_table,$moduleID,$tablestudent,$tableteacher,$tableschool,$endrolled,$tableattend,$tableactivity,$tableslots,$module_name,$logged_in,$tableclass,$brn_ass,$pass=1234,$test_val;
	 
	function __construct(){		
		
		parent::__construct();
		
		$module_school		=	array();
		$header				=	array();
		$this->smart_login_table="tbl_user_login";
		$this->tableschool	=	"tbl_school";
		$this->endrolled	=	"tbl_endrolled";
		$this->brn_ass		=	"tbl_branches_assigned";
		$this->brn_admins	=	"tbl_branch_admins";
		$this->usr_ass		=	'tbl_usrs_assigned';
		$this->school		=	'tbl_school';		
        $this->endrolled	=	"tbl_endrolled";
		$this->admin_tbl	=	'tbl_adminusers';		
		$this->tablestudent	=	$this->module."_kids";
		$this->tableclass	=	$this->module."_class";	
		$this->test_val		=	10;	
		$this->load->model('smart_model');			
	}
	
	//------------------------------------------------------------
	 /**
		*This function is used to load admin login page
		*@ access admin
		*@ return view to admin/login.php
	 */
	 
	function index()
	{

			
			redirect(base_url('smart_controller/smart_login'));
		
		
	}
	//------------------------------------------------------------
	
	 /**
		*This function is used to check username and password for authetication
		*@ access admin
		*@ return view to admin/home page
	 */
	 
	function login_process()
	{
		$username							= $this->input->post('username');	
		$password							= $this->input->post('password');
		//$account							= $this->input->post('account');
		
		//if($username=="admin"&&$password=="1234")
	//{
		//redirect(base_url('smart_controller/smart_home'));
	//}
	//else
		
	
	//{
		//redirect('smart_controller/smart_logout');
	//}
	/*if($account==3)
	{
		$this->session->set_flashdata('err', 'Cannot acces Students');
	    redirect('admin/login');
	}
	*/
	
	    $enpassword								= $this->en_de_password('encrypt',$password);
		$loginArr['login']					= $this->smart_model->loginProcess($username,$enpassword,$this->smart_login_table);
		$this->session->set_userdata($loginArr['login']);
		$this->session->set_userdata("ses_status",$loginArr['login']['status']);
		$this->session->set_userdata("ses_user_id",$loginArr['login']['user_id']);
		$this->session->set_userdata("ses_user_email",$loginArr['login']['user_name']);
		$this->session->set_userdata("ses_user_role",$loginArr['login']['user_role']);
		$this->session->set_userdata("ses_user_status",$loginArr['login']['user_status']);
		if ($loginArr['login']['status']==false)
		
		{
			$this->session->set_flashdata('err', 'Invalid Username or Password');
			redirect(base_url('smart_controller/smart_login'));
				
		}
		else
		
		{
			redirect(base_url('smart_controller/smart_home'));
		}
		//$schoolID							= $loginArr['login']['school'];
		//$this->session->set_flashdata('err', 'Please Select Branch Administrator!');
	

	
 }
	
	//------------------------------------------------------------
	 /**
		*This function is used to load admin dashboard
		*@ access admin
		*@ return view to admin/home page
	 */
	function smart_login()
	{ 
		
		//$errmessages			=	array();
		//$errmessages['login']	=	$this->session->flashdata('err');
		$this->load->view('smart_login');
	}
	
	//------------------------------------------------------------
	
	
		//------------------------------------------------------------
	
	/**
		*This temporary function is used to load smart dashboard
		*@ access smart_controller
		*@ return view to smart_dashboard
	 */
	function smart_home()
	{ 
		if (!$this->session->userdata('ses_status'))
		
		{
			$this->session->set_flashdata('err', 'Please Log in to continue');
			redirect(base_url('smart_controller/login'));
				
		}
		$errmessages			=	array();
		$errmessages['login']	=	$this->session->flashdata('err');
		$this->load->view('smart_dashboard');
	}
	
	
	 /**
		*This function is used to get realtime values from a file
		*@ access smart_controller
		*@ return view to smart_dashboard
	 */
	 
	 
	 function Get_chart_data()
	 {
		 $y = $this->test_val;
		 $y+=10;
		 //$y+=10;
		 //$y = mt_rand()/10000000;
		//echo $y;
		 //echo json_encode($y);
	//$handle = read_file('C:/Users/Public/Documents/datafile.txt');
		 	// Set the JSON header
	//header("Content-type: text/json");
	
	$file = 'C:/Users/Public/Documents/datafile.txt'; // Setting the path of data file.
	$handle = fopen("C:/Users/Public/Documents/datafile.txt", "r"); // opening the required file from file_open.php file

	$pos = sizeof($handle) - 23;// Setting the position of the file pointer for reading the last updated values in the file.
	fseek($handle, $pos, SEEK_END);

	$userinfo = 
	fscanf($handle,"%f\t%f\t%f\t%f\t%f\t%f\t%f\n"); // Read contents of file

	{
    	list ($a,$b,$c,$d,$e,$f,$g) = $userinfo; // Putting the read datas to corresponding arrays.
				
			echo json_encode($a); // Passing required data to charts for displaying.

	};


	fclose($handle); //closing the required file from file_close.php file
	}
	
	//------------------------------------------------------------
	 /**
		*This function is used to load Process design and simulation form
		*@ access smart_controller
		*@ return view to smart_dashboard/Smart Forms
	 */
	 
	 	function add_student1($id=0){
		
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$header['page']			=	"student";
		$header['student']		=	array();
		$header['school']		=	$this->admin_model->listAllschool($this->tableschool);
		$header['enrolled']		=	$this->admin_model->listEnrolled($this->endrolled);
		$header['sess']			=	$this->session->flashdata('err');
		$header['day']			=	"";
		$header['month']		=	"";
		$header['year']			=	"";
		
		if($id) { 
			$header['student']		=	$this->admin_model->studentByid($this->tablestudent,$id);
			$dob					=	explode("-",$header['student'][0]['kid_dob']);
			$header['year']			=	$dob[0];
			$header['month']		=	$dob[1];
			$header['day']			=	$dob[2];
			}
		$header['teacher']		=	$this->admin_model->getteacherBymodule($this->moduleID,$this->tableteacher);		
		$this->load->view('add_student',$header);
	}
	 
	 
	//------------------------------------------------------------
	 /**
		*This function is used to recover_password
		*@ access admin
		*@ return view to admin/home page
	 */
	 
	 //------------------------------------------------------------
	 
	 
	 
	 
	 
	function recover()
	{ 
		
		$recoverArr['login']=array();
		$email=$this->input->post('mailid');
		if(stripos($email,'@')&&stristr($email,'.')!==false)
		{
			
			
		
		$account=$this->input->post('account');
		$branch=$this->input->post('branch');
		$branch= strtolower($branch);
		$teacher_table=$branch.'_'.'teacher';
		if($email&&$account==1&&$branch=='null')
		{
		
		$recoverArr['login']					= $this->admin_model->recoverProcess($email,$account);
		$password								= $recoverArr['login']['sch_password'];
		echo "Admin recovery";	
		}
		else if($email&&$account==2)
		{
		
		$recoverArr['login']					= $this->admin_model->recoverProcess($email,$account);	
		$password								= $recoverArr['login']['password'];
		$enpassword								= $this->en_de_password('decrypt',$password);
		$password								=$enpassword;
		$name									=$recoverArr['login']['name'];
		}
		else if($email&&$account==3&&$branch!='null')
		{
		
		echo 'teacher recovery';
		$recoverArr['login']					= $this->admin_model->recoverProcess_teacher($email,$teacher_table);
		$teacher_table='tbl_ulogin';
		$recoverArr['login_new']				= $this->admin_model->recoverProcess_teacher_new($email,$teacher_table);	
		$password								= $recoverArr['login_new']['recovery_password'];
		//$enpassword								= $this->en_de_password('decrypt',$password);
		//$password								= $enpassword;
		$name									= $recoverArr['login']['name'];	
			
		}
		
		else
		
		{
		$recoverArr['login']['status']=false;
		$this->session->set_flashdata('err', 'Recovery failed!');	
			
		}
		}
		if(!empty($recoverArr)&&$recoverArr['login']['status']==true)
		{
			
			
            $user_email = $email;
			
			
			
			
			/*$message = '<html>';
		    $message.='<body style="font-family:Tahoma, Geneva, sans-serif !important; size:10px !important;">';
			$message.='<font style="font-family:Tahoma, Geneva, sans-serif;" size="2">
<!--[if (!mso 14)&(!mso 15)]><!--><font style="font-family: Tahoma, Geneva, sans-serif;"><!--<![endif]-->';
		    $message.='<p style="font-family:Tahoma, Geneva, sans-serif !important;">HI '.$name.', Your<br/><br/>';
			$message.=' Username ='.$email.'<br/>'.'Password = '.
			$password.'<br/><br/>';
			 
			//$message.=' Assigned schools are'.$admin_school.'<br/>';
			$message.='<!--[if (!mso 14)&(!mso 15)]><!--></font><!--<![endif]-->
       		 </font>';
		    $message.='</p></body></html>';*/
			
			/*New Message template*/
			
			$message = '		
				<html>
				
				<body>
				
				 <div style="margin-left:30px;margin-right:30px;background-color:#fff;border:1px solid #cc2800;border-radius:5px;">
				 <div style="height:100px;;width:100%;background-color:#cc2800;"> 
				  <div style="float:left;padding-top:10px;">
					<img src="cid:signatureLogo" class="img-circle" width="90" height="70" align="left" style="border-radius:100px;">
				 </div>
				  <div style="float:left;padding-top:10px; color:#fff;margin-left:8px;">
					 <h2>Password Recovery</h2>
				 </div>
				  <div style="color:#fff;font-size:13px;float:right;padding-top:15px;margin-right:10px;">  
				  <div><b style="margin-left:16px;">   '.'</b></div>
				  <div><b style="margin-left:13px;">   '.'</b></div>
				  <div><b style="margin-left:5px;">  '.'</b></div>
				 </div>
				</div>
				 <div style="margin-left:30px;margin-right:30px;">
				 
				 <div style="text-align:center;font-size:20px;">
					 <br><br><p><b>Hello <b style="color:blue;">'.$name.'</b></p>
					  <p><b>Your password recovered successfully.</b></p>
				  </div> 
					 <hr style="border-color:#cc2800;">
					
					 <div style="color:#808080;font-size:16px;font-size:18px;margin-left:150px;">     
					  <p><b><u>Your Authentication Details</u></b></p>
					  <div>
						<div>Username : '.$email.'</div>
						<div style="text-indent:4px;">Password : '.$password.'</div>
					  </div>
					  </div>
					  
					   <br><hr style="border-color:#cc2800;">
					  
					  <div style="color:#808080;text-align:center;font-size:16px;">	       
					  <p><i>Please do not reply directly to this message.</i><p>
					  <p><i>For help, please visit</i><b><a href="#"> daycare help section</a></b>.</p>
					  </div>					 
					
					 <div style="color:#808080;text-align:center;">
					  <br><br><br><br>
					 <p style="font-size:12px;">@ 2015- DayCare registered </p>
					  </div> 
				 
				</div>
				</div>
				
				</body>
				</html>';
			
			
			
					$emailArr	=	array(
										'to'		=>	$email,
										'from'      =>  'jitin@euphontec.com',
										'from_name' =>  'DayCare', 
										'subject'	=>	'DayCare | Username & Password',
										'message'	=>	$message,
										
										);
										
				// send mail by php mailer		
						
					
				$send_mail	=	$this->mailer->send_mail($emailArr,$bcc=false,$attachment=false,$bccEmail='');		        
				$this->mailer->ClearAllRecipients();
				$this->mailer->ClearAttachments();
				$this->session->set_flashdata('err', 'Mail has been sent!');
				return true;
				//redirect('admin/login');
			
        
			
		}
		else
		{
				$this->session->set_flashdata('err', 'Recovery failed!');
				return false;
				//redirect('admin/login');
				//return false;	
		}
		
	}
	
	//------------------------------------------------------------
	
	 /**
		*This function is used to logout
		*@ access admin
		*@ return view to admin/login page
	 */
	 
	function smart_logout(){
		//if (! $this->session->userdata('status')){redirect(base_url('admin/login'));}
		$this->session->sess_destroy();
		redirect(base_url('smart_controller/smart_login'));
	}
	
	//------------------------------------------------------------
	
	 /**
		*This function is used to list all subadmin
		*@ access admin
		*@ return view to admin/subadmin list page
	 */
	 
	function subadmin(){
		if (! $this->session->userdata('status')){redirect(base_url('admin/login'));}
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		
		$header['page']				=	"subadmin";
		$header['sess']				=	$this->session->flashdata('err');
		$header['succ']				=	$this->session->flashdata('suc');
		//$get_branch_ids			=	$this->admin_model->get_branch_ids();
		$header['suadminArr']		=	$this->admin_model->listSubadmin($admin_tbl); 
		/*echo '<pre>';
		print_r($header['suadminArr']);die();*/
		$this->load->view('admin/subadmin',$header);
	}
	
	//------------------------------------------------------------
	
	 /**
		*This function is used to create subadmin
		*@ access admin
		*@ return view to admin/create_subadmin form 
	 */
	 
	function create_subadmin($id=0){
		
       // echo $id;die();
		$admin_id					=	$this->quickauth->logged_in_user();		
        $header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$header['page']			=	"subadmin";
		$header['subadmin']		=	array();
		$header['school']		=	$this->admin_model->listAllschool();
		/*echo '<pre>';
		print_r($header['school']);die();*/
		$header['sess']			=	$this->session->flashdata('err');
		$header['subadminbranch']	="";
		if($id) { 
		$header['subadmin']			=	$this->admin_model->subadminByid($id);
		$header['subadminbranch']	=	$this->admin_model->BranchByadminid($id);
        }
		$header['br_admin_id']        =   $id;
		$this->load->view('admin/create_subadmin',$header);
	}
	
	//------------------------------------------------------------
	
	 /**
		*This function is used to check whether the branch admin email already exists or not
		*@ access admin
		*@ return true/false
	 */
	 
	function check_email_exists()
	{
		$final_result=false;
		$usr_id			=	$this->input->post('user_id');
		$email			=	$this->input->post('email_id');
		$email_db			=	$this->input->post('email_db');
		$teacher_table  =	'tbl_ulogin';
		if($usr_id)
		{ 
			$check_mail	=	$this->admin_model->checkByemail_id($email,$usr_id);
			$teaID_db		=  	$this->admin_model->get_teaid($email_db,$teacher_table);
			$teaID_new		=  	$this->admin_model->get_teaid($email,$teacher_table);
			
			//echo $teaID;die();
			$check_email		=	$this->admin_model->checkUsername_id($email,$teaID_new,$teacher_table);
			if($teaID_new!=0&&$teaID_db!=$teaID_new)
			{
			$check_email=false;
			}
		}else{
			$check_mail	=	$this->admin_model->checkByemail($email);
			$check_email		=	$this->admin_model->checkUsername($email,$teacher_table);
			}
			
		if($check_mail==true&&$check_email==true)
		{$final_result=true;}
		else
		{$final_result=false;}
			
		echo json_encode($final_result);
	}
	
	//------------------------------------------------------
	
	 /**
		*This function is used to insert subadmin
		*@ access admin
		*@ return view to admin/subadmin listing page 
	 */
	 
	function subadmin_post() {
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$id			=	 $this->input->post('id');
		$schoolname	="";
		$name="";
		$email="";
		$phone="";
		$address="";
		$school_name=array();
		$admin_school="";
		$schoolname	=	 $this->input->post('mul_branches');
		foreach($schoolname as $schools) { $admin_school	=	$admin_school.$schools.",";}		
		$name		=	 $this->input->post('name');
		$email		=	 $this->input->post('email');
		$phone		=	 $this->input->post('phone');
		$address	=	 $this->input->post('address');
		$latitude	=	 $this->input->post('lat');
		$longitude	=	 $this->input->post('long');
		$emailhid	=	 $this->input->post('emailhid');
		$brid		=	 $this->input->post('brid');
		$password	=	 $this->generate_password(); 
		/*$branch_address = $this->admin_model->branch_address();
		echo $branch_address['branch_address'];		
		echo $branch_address['branch_ph'];
		echo $branch_address['branch_email'];die();*/
		//send mail with username & password 
		$this->session->set_userdata('sess_school_name', $schoolname);
		$this->session->set_userdata('sess_name', $name);
		$this->session->set_userdata('sess_email_id', $email);
		$this->session->set_userdata('sess_phone', $phone);
		$this->session->set_userdata('sess_address', $address);
		if($id)
		{
		$this->session->unset_userdata('sess_name');
		$this->session->unset_userdata('sess_school_name');
		$this->session->unset_userdata('sess_email_id');
		$this->session->unset_userdata('sess_phone');
		$this->session->unset_userdata('sess_address');		
		
		
		}
		
		$empty_name		=false;
		$empty_school	=false;
		$empty_email	=false;
		$empty_address	=false;
		$empty_phone	=false;
		$invalid_school	=false;
		$invalid_email	=false;
		$invalid_phone	=false;
		$dup_email		=false;
		
		if(!$id)
		{
		if($this->is_emptyval($schoolname)==false)
		{
		echo 1;
		$empty_school=true;
		
		$this->session->set_flashdata('flash_school_req', 'Required');
		}
	}
		if($this->is_emptyval($email)==false)
		{
			$empty_email=true;
			echo 2;
		
		$this->session->set_flashdata('flash_email_req', 'Required');
		}
		
		/*if($this->check_email_exists_validation($email,$id)==false&&$this->is_emptyval($name))
		{
			$dup_email=true;
		
		$this->session->set_flashdata('flash_email_dup', 'Already Exists');
		}*/
		
		
		if($this->is_emptyval($name)==false)
		{
			$empty_name=true;
			echo 3;
		
		$this->session->set_flashdata('flash_name_req', 'Required');
		}
		
		if($this->is_special($name)==false&&$this->is_emptyval($name))
		{
			$invalid_name=true;
			echo 4;
		
		$this->session->set_flashdata('flash_name_valid', 'No special characters or numbers');
		}
		
		
		
		
		if($this->is_emptyval($phone)==false)
		{
			$empty_phone=true;
			echo 5;
	
		$this->session->set_flashdata('flash_phone_req', 'Required');
		}
		if($this->is_emptyval($address)==false)
		{
		$empty_address=true;
		echo 6;
		
		$this->session->set_flashdata('flash_address_req', 'Required');
		}
		if(!$id)
		{
		if($this->is_special($schoolname)==false&&$this->is_emptyval($schoolname))
		{
		$invalid_school	=true;
		echo 7;
		
		$this->session->set_flashdata('flash_school_special', 'No Special Characters or numbers');
		}
		}
		
		if($this->is_mno($phone)==false&&$this->is_emptyval($phone))
		{
			
			$invalid_phone	=true;
			echo 8;
			
		
		$this->session->set_flashdata('flash_phone_mno', 'Not a valid number');
		}
		if($this->is_email($email)==false&&$this->is_emptyval($email))
		{
			$invalid_email	=true;
			echo 9;
		
		$this->session->set_flashdata('flash_email_valid', 'Not a valid email');
		}
		die();
		if($empty_school||$empty_address||$empty_email||$empty_phone||$invalid_school||$invalid_email||$invalid_phone)
		{
			
		if($id)	
		{
			redirect(base_url('admin/create_subadmin/'.$id));	
		}
		redirect(base_url('admin/create_subadmin'));	
		
			
		}
        
      
		$enpassword		=	 $this->en_de_password('encrypt',$password);
		$emailcheck		=	 $this->admin_model->checkByemail($email);
		$emailcheckid	=	 $this->admin_model->checkByemailid($email,$id);
		if($id) {
		if(!empty($latitude))
		{
		  $lat		=	$latitude;
		  $long		=	$longitude;
		  //$status	=	1;
		}else{
			 $lat		=	'Null';
			 $long		=	'Null';	
			// $status	=	0;
		} 	
		$updatevalues	=	array("sch_name"=>$name,"sch_email"=>$email,"sch_phone"=>$phone,"sch_address"=>$address,"sch_password"=>$enpassword,"sch_latitude"=>$lat,"sch_longitude"=>$long);	
		$updatedb	=	 $this->admin_model->updateSubadmin($updatevalues,$id);
		if($updatedb) {
			$this->session->unset_userdata('sess_name');
		$this->session->unset_userdata('sess_school_name');
		$this->session->unset_userdata('sess_email_id');
		$this->session->unset_userdata('sess_phone');
		$this->session->unset_userdata('sess_address');		
		 foreach($schoolname as $row){
					$check_existing	=	$this->admin_model->check_existing_branchedit($id,$row);
					if($check_existing) {
						$this->session->set_flashdata('err', "Branch already assigned!");
                    	redirect(base_url('admin/create_subadmin/'.$id));
					}
                    $insert_school = $this->admin_model->update_branches($id,$row);
                }
				if($emailhid!=$email || !in_array($brid,$schoolname)) {
				 $message = '		
				<html>
						
				<body>
				
				 <div style="margin-left:30px;margin-right:30px;background-color:#fff;border:1px solid #cc2800;border-radius:5px;">
				 <div style="height:100px;;width:100%;background-color:#cc2800;"> 
				  <div style="float:left;padding-top:10px;">
					<img src="cid:signatureLogo" width="90" height="70" align="left" style="border-radius:100px;">
				 </div>
				  <div style="float:left;padding-top:10px; color:#fff;margin-left:8px;">
					 <h2>Branch updated</h2>
				 </div>
				  <div style="color:#fff;font-size:15px;float:right;padding-top:10px;margin-right:10px;"> 
				  <div>Email <b style="margin-left:16px;">:   contact@daycare.com</b></div>
				  <div>Ph.No <b style="margin-left:13px;">:   04869-320220</b></div>
				 
				 </div>
				</div>
				 <div style="margin-left:30px;margin-right:30px;">
				 
				 <div style="text-align:center;font-size:20px;">
					 <br><br><p><b>Hello <b style="color:blue;">'.$name.'</b></p>
					  <p>Your branch administration changed.</p>
				  </div> 
					 <hr style="border-color:#cc2800;">
					
					 <div style="color:#808080;font-size:16px;font-size:18px;margin-left:150px;">     
					  <p><b><u>Authentication Details</u></b></p>
					  <div>
						<div>Username : '.$email.'</div>
						<div style="text-indent:4px;">Password : '.$password.'</div>
					  </div>
					  </div>
					  
					   <br><hr style="border-color:#cc2800;">
					  
					  <div style="color:#808080;text-align:center;font-size:16px;">	       
					  <p><i>Please do not reply directly to this message.</i><p>
					   <p><i>For help, please visit</i><b><a href="#"> daycare help section</a></b>.</p>
					  </div>					
					 <div style="color:#808080;text-align:center;">
					  <br><br><br><br><p style="font-size:12px;">@ 2015- DayCare registered </p>
					  </div> 
				 
				</div>
				</div>
				
				</body>
				</html>';
		
			
			
			
					$emailArr	=	array(
										'to'		=>	$email,
										'from'      =>  'jitin@euphontec.com',
										'from_name' =>  'DayCare', 
										'subject'	=>	'DayCare | Username & Password',
										'message'	=>	$message,
										
										);
										
				// send mail by php mailer		
						
					
				$send_mail	=	$this->mailer->send_mail($emailArr,$bcc=false,$attachment=false,$bccEmail='');		        
				$this->mailer->ClearAllRecipients();
				$this->mailer->ClearAttachments();
				}
		$this->session->set_flashdata('suc', "Subadmin updated!");	
		redirect(base_url('admin/subadmin'));
		} else {
		$this->session->set_flashdata('err', "Database Update error!");	
		redirect(base_url('admin/create_subadmin/'.$id));	
		}
		} else {
           
                if(!empty($latitude))
				{
				  $lat		=	$latitude;
				  $long		=	$longitude;
				 // $status	=	1;
				}else{
					 $lat		=	'Null';
					 $long		=	'Null';	
					 //$status	=	0;
				}
		$this->session->unset_userdata('sess_name');
		$this->session->unset_userdata('sess_school_name');
		$this->session->unset_userdata('sess_email_id');
		$this->session->unset_userdata('sess_phone');
		$this->session->unset_userdata('sess_address');		
				$insertdb	    =	 $this->admin_model->insertSubadmin($name,$email,$phone,$address,$enpassword,$lat,$long);
                if(!empty($insertdb))
				{
		
			  //echo $insertdb;die();
                foreach($schoolname as $row){
					$check_existing	=	$this->admin_model->check_existing_branch_inserting($row);
					if($check_existing) {
						$this->session->set_flashdata('err', "Branch already assigned!");
                    	redirect(base_url('admin/create_subadmin/'.$insertdb));
					}
                    $insert_school = $this->admin_model->insert_branches($insertdb,$row);
                }
				
			$message = '		
				<html>
						
				<body>
				
				 <div style="margin-left:30px;margin-right:30px;background-color:#fff;border:1px solid #cc2800;border-radius:5px;">
				 <div style="height:100px;;width:100%;background-color:#cc2800;"> 
				  <div style="float:left;padding-top:10px;">
					<img src="cid:signatureLogo" width="90" height="70" align="left" style="border-radius:100px;">
				 </div>
				  <div style="float:left;padding-top:10px; color:#fff;margin-left:8px;">
					 <h2>Welcome To DayCare</h2>
				 </div>
				  <div style="color:#fff;font-size:15px;float:right;padding-top:10px;margin-right:10px;"> 
				  <div>Email <b style="margin-left:16px;">:   contact@daycare.com</b></div>
				  <div>Ph.No <b style="margin-left:13px;">:   04869-320220</b></div>
				 
				 </div>
				</div>
				 <div style="margin-left:30px;margin-right:30px;">
				 
				 <div style="text-align:center;font-size:20px;">
					 <br><br><p><b>Hello <b style="color:blue;">'.$name.'</b></p>
					  <p><b>Thank you for your registration.</b></p>
				  </div> 
					 <hr style="border-color:#cc2800;">
					
					 <div style="color:#808080;font-size:16px;font-size:18px;margin-left:150px;">     
					  <p><b><u>Authentication Details</u></b></p>
					  <div>
						<div>Username : '.$email.'</div>
						<div style="text-indent:4px;">Password : '.$password.'</div>
					  </div>
					  </div>
					  
					   <br><hr style="border-color:#cc2800;">
					  
					  <div style="color:#808080;text-align:center;font-size:16px;">	       
					  <p><i>Please do not reply directly to this message.</i><p>
					   <p><i>For help, please visit</i><b><a href="#"> daycare help section</a></b>.</p>
					  </div>					
					 <div style="color:#808080;text-align:center;">
					  <br><br><br><br><p style="font-size:12px;">@ 2015- DayCare registered </p>
					  </div> 
				 
				</div>
				</div>
				
				</body>
				</html>';
			
			
					$emailArr	=	array(
										'to'		=>	$email,
										'from'      =>  'jitin@euphontec.com',
										'from_name' =>  'DayCare', 
										'subject'	=>	'DayCare | Username & Password',
										'message'	=>	$message,
										
										);
										
				// send mail by php mailer		
						
					
				$send_mail	=	$this->mailer->send_mail($emailArr,$bcc=false,$attachment=false,$bccEmail='');		        
				$this->mailer->ClearAllRecipients();
				$this->mailer->ClearAttachments();
			}
				
				
				
           
		  } 
        $this->session->set_flashdata('suc', "Subadnmin created successfully!");
        redirect(base_url('admin/subadmin/'));
	}
	
	//------------------------------------------------------------
	
	 /**
		*This function is used to generate random password
		*@ access admin
		*@ return 8 char password
	 */
	 
	function generate_password( $length = 8 ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*()_-=+;:?";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}
	
	function en_de_password ($action,$string) {
		$output = false;
		   $key = '$b@bl2I@?%%4K*mC6r273~8l3|6@>D';
		   $iv = md5(md5($key));
		   if( $action == 'encrypt' ) {
			   $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
			   $output = base64_encode($output);
		   }
		   else if( $action == 'decrypt' ){
			   $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
			   $output = rtrim($output, "");
		   }
		   return $output;
	}
	//------------------------------------------------------------
	
	 /**
		*This function is used to delete subadmin
		*@ access admin
		*@ return view to admin/subadmin listing page 
	 */
	 
	function delete_subadmin($id=0)
	{
		$del	=	$this->admin_model->deleteBysubadmin($id);
		if($del) {
		$this->session->set_flashdata('err', "Subadmin deleted!");
		} else {
		$this->session->set_flashdata('err', "Database error!");	
		}
		redirect(base_url('admin/subadmin'));
	}
	
	//------------------------------------------------------------
	
	
	
	 /**
		*This function is used to list all school
		*@ access admin
		*@ return view to admin/subadmin list page
	 */
	 
	function school(){
		
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$header['page']				=	"school";
		$header['sess']				=	$this->session->flashdata('err');
		$header['succ']				=	$this->session->flashdata('suc');
		$header['suadminArr']		=	$this->admin_model->listSchool();
		
		$this->load->view('admin/school',$header);
	}
	
	
	//------------------------------------------------------------
	
	 /**
		*This function is used to create school
		*@ access admin
		*@ return view to admin/create_subadmin form 
	 */
	 
	function create_school($id=0){
		
		$admin_id					=	$this->quickauth->logged_in_user();
		
		$header['page']				=	"school";
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		$updid=$id;
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		
		$header['school']		=	array();		
		$header['sess']			=	$this->session->flashdata('err');
		//$header['enrollist']	=0;
		if($id) { 
		 $header['school']		=	$this->admin_model->schoolByid($id);
		
		 //$header['enrollist']	=	$this->admin_model->enrolbyid($id);
		
		
		}
		$header['branch_id']	=	$id;
		$this->load->view('admin/create_school',$header);
	}
	
	//------------------------------------------------------------
	
	/**
		*This function is used to generate branch code
		*@ access admin
		*@ return branch code
	 */
	
	  function generate_branch_code($letters,$length = 3) {		
		$chars = "0123456789";
		$code = substr( str_shuffle( $chars ), 0, $length );
		$new_code	= $letters.'-'.$code;
		return $new_code;
	  }
	  
	 //-----------------------------------------------------
	  
	 /**
		*This function is used to insert new school
		*@ access admin
		*@ return view to shool list page
	 */
	
	function school_post() {
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$id="";
		$schoolname="";
		$branch_code="";
		$country="";
		$state="";
		$email="";
		$phone="";
		$latitude="";
		$longitude="";
		
		$id				=	 $this->input->post('id');
		$schoolname		=	 $this->input->post('schoolname');
		
		

		//$string = str_replace('-', ' ', $schoolname);
		$string_school = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); 	
		//$string1		=	preg_replace('/\s+/', '_', $schoolname);
		
		//$words = explode(" ", $string1);
		$words = explode("_", $string_school);
		//echo 	$string1;die();		

		$string = str_replace('-', ' ', $schoolname);
		$stringwith_space = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); 		
		$words = explode(" ", $stringwith_space);		

		$letters = "";
		foreach ($words as $value) {
			$letters .= substr($value, 0, 1);
		}
		$branch_code	=	 $this->generate_branch_code($letters);
		//echo $branch_code.'<br>';

		//$schoolcode		=	 $this->remove_special_chars($schoolname);
		//echo $schoolcode;die();

		$schoolcode	=	$this->seo_friendly_url($stringwith_space);

		$slected_country=	$this->input->post('selected_country');
		$country_select	=	 $this->input->post('select_country');
		if($country_select!='Select Country')
		{
			$country  = $country_select;	
		}else{
			$country  = $slected_country;	
		}
		
		$state			=	 $this->input->post('state');
		$email			=	 $this->input->post('email');
		$phone			=	 $this->input->post('phone');
		$address		=	 $this->input->post('address');
		$latitude		=	 $this->input->post('lat');
		$longitude		=	 $this->input->post('long');		
		$enrollment_type=	 $this->input->post('field_name');
		$this->session->set_userdata('sess_school_name', $schoolname);
		$this->session->set_userdata('sess_email_id', $email);
		$this->session->set_userdata('sess_phone', $phone);
		$this->session->set_userdata('sess_address', $address);
		if($id)
		{
		$this->session->unset_userdata('sess_name');
		$this->session->unset_userdata('sess_school_name');
		$this->session->unset_userdata('sess_email_id');
		$this->session->unset_userdata('sess_phone');
		$this->session->unset_userdata('sess_address');		
		
		
		}
		
		if(!$id)
		{
		if($this->is_emptyval($schoolname)==false)
		{
		$empty_school=true;
		
		$this->session->set_flashdata('flash_school_req', 'Required');
		}
	}
		if($this->is_emptyval($email)==false)
		{
			$empty_email=true;
		
		$this->session->set_flashdata('flash_email_req', 'Required');
		}
		if($this->is_emptyval($phone)==false)
		{
			$empty_phone=true;
	
		$this->session->set_flashdata('flash_phone_req', 'Required');
		}
		if($this->is_emptyval($address)==false)
		{
		$empty_address=true;
		
		$this->session->set_flashdata('flash_address_req', 'Required');
		}
	if(!$id){
		if($this->is_special($schoolname)==false&&$this->is_emptyval($schoolname))
		{
		$invalid_school	=true;
		
		$this->session->set_flashdata('flash_school_special', 'No Special Characters or numbers');
		}
	}
		
		
		if($this->is_mno($phone)==false&&$this->is_emptyval($phone))
		{
			
			$invalid_phone	=true;
		
		$this->session->set_flashdata('flash_phone_mno', 'Not a valid number');
		}
		if($this->is_email($email)==false&&$this->is_emptyval($email))
		{
			$invalid_email	=true;
		
		$this->session->set_flashdata('flash_email_valid', 'Not a valid email');
		}
		if($empty_school||$empty_address||$empty_email||$empty_phone||$invalid_school||$invalid_email||$invalid_phone)
		{
			
		if($id)	
		{
			redirect(base_url('admin/create_school/'.$id));	
		}
		redirect(base_url('admin/create_school'));	
		
			
		}
		
		$moreenrolment_type=0;
		/*if(!empty($this->input->post('addfield_name')))
		{
		$moreenrolment_type	=$this->input->post('addfield_name');
		$enrollment_type	=array_unique(array_merge($enrollment_type,$moreenrolment_type));
		//print_r($enrollment_type);	
		}*/
		//print_r($enrollment_type);
		
		
		$enrolid		=		$this->input->post('enrolid');
		$updid=$id;
		$header['enrollist']	=	$this->admin_model->enrolbyid($id);
		$dbenrolarray=$header['enrollist'];
		$enrolldbarray = array();
		foreach ($dbenrolarray as $key => $value) {
    	$enrolldbarray[] = $value->endrolled;
		}
		echo '==>dbarray:';
		print_r($enrolldbarray);
		echo '   ==>form array:';
		print_r($enrollment_type);
		//array_filter($enrollment_type);
		$newenrol=0;
		//if($enrollment_type){
		$newenrol=array_diff($enrollment_type,$enrolldbarray);
		//}
		echo 'new arr       :';
		print_r($newenrol);
		echo '==>dbarray:';
		print_r(count($dbenrolarray));
		echo '   ==>form array:';
		print_r(count($enrollment_type));
		
		
		
		//echo $address ;die();
		$city		=	 $this->input->post('city');
		
		
		if($id) {
			
		$this->session->unset_userdata('sess_school_name');
		$this->session->unset_userdata('sess_email_id');
		$this->session->unset_userdata('sess_phone');
		$this->session->unset_userdata('sess_address');
			
			if($moreenrolment_type)
			{
				$cnt=count($enrollment_type);
				for ($i = 0; $i < $cnt; $i++){
    			$enrol_type=$enrollment_type[$i];
				$newid	   =$enrolid[$i];
				$updatedb2	=	 $this->admin_model->updateenroldetails($newid,$enrol_type);
					}
					
				foreach($moreenrolment_type as $enrol_type)
					{
					
				$newenrollmentupd	=	 $this->admin_model->insertenroldetails($id,$enrol_type);	
				
					}
		}
		
		if(!empty($latitude))
		{
		  $lat		=	$latitude;
		  $long		=	$longitude;
		  $status	=	1;
		}else{
			 $lat		=	'Null';
			 $long		=	'Null';	
			 $status	=	0;
		}
		$updatedb1	=	 $this->admin_model->updateSchool($schoolname,$country,$email,$phone,$address,$state,$city,$id,$lat,$long,$status);
		$cnt=count($enrollment_type);
		//if(count($enrollment_type)==count($dbenrolarray)){
			$cnt=count($enrollment_type);
		//foreach($enrollment_type as $enrol_type){
			for ($i = 0; $i < $cnt; $i++){
    		$enrol_type=$enrollment_type[$i];
			$newid	   =$enrolid[$i];
		
		$updatedb2	=	 $this->admin_model->updateenroldetails($newid,$enrol_type);
			
		}
		
		if($updatedb1) {
			$this->session->set_flashdata('suc', "Branch updated!");
			redirect(base_url('admin/school'));
		}
		
		
		else {
		$this->session->set_flashdata('err', "Database Update error!");	
		redirect(base_url('admin/create_school/'.$id));	
		}
		} 
		
		else {
		
		if(!empty($latitude))
		{
		  $lat		=	$latitude;
		  $long		=	$longitude;
		  $status	=	1;
		}else{
			 $lat		=	'Null';
			 $long		=	'Null';	
			 $status	=	0;
		}
		$this->session->unset_userdata('sess_school_name');
		$this->session->unset_userdata('sess_email_id');
		$this->session->unset_userdata('sess_phone');
		$this->session->unset_userdata('sess_address');
		
		$insertdb		=	 $this->admin_model->insertSchool($schoolname,$country,$email,$phone,$address,$state,$city,$schoolcode,$lat,$long,$status,$branch_code);
		
		if($insertdb)
		foreach($enrollment_type as $enrol_type){
		$enrollment	=	 $this->admin_model->insertenroldetails($insertdb,$enrol_type);
		}
		if($insertdb) {
			$profile	=	"assets/img/".$schoolcode;
				if(!is_dir($profile)) //create the folder if it's not already exists
				{ 
				  mkdir($profile,0755,TRUE);
				} 
			$path	=	'application/modules/'.$schoolcode;
				if(!is_dir($path)) //create the folder if it's not already exists
				{ 
				  mkdir($path,0755,TRUE);
				} 
			 $Createtables	=	$this->admin_model->createTable($schoolcode);
			 $this->modulecopy('application/modules/branch_module', 'application/modules/'.$schoolcode );
			 $this->session->set_flashdata('suc', "Branch created successfully!");
			 redirect(base_url('admin/school'));
		} else { 
			$this->session->set_flashdata('err', "Database insertion error!");
			redirect(base_url('admin/create_school'));
		} }
	}
	
	
	//------------------------------------------------------------------------------
	
	
	function clean($string) {
   				$string = str_replace(' ', '_', $string); // Replaces all spaces with underscore.
				$string = str_replace('-', '_', $string);
   			return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
	}
	
	function seo_friendly_url($string){
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
    $string = strtolower(trim($string, '-'));
	$string = str_replace('-', '_', $string);
	return $string;
}
	//------------------------------------------------------------
	
	 /**
		*This function is used to delete school
		*@ access admin
		*@ return view to admin/subadmin listing page 
	 */
	 
	function delete_school($id)
	{
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$school	=	$this->admin_model-> school_Name_Byid($id); //print_r($school);
		$del	=	$this->admin_model->deleteByschool($id);
		$schoolcode		=	 $this->clean($school['name']);
		$path	=	'application/modules/'.$schoolcode;
		//echo $schoolcode;die();
		//$drop	=	$this->admin_model->dropTable($school[0]['sch_name']);
		
		if($del) {
		$drop	=	$this->admin_model->dropTable($schoolcode);
		$this->DelDir($path);
		$this->session->set_flashdata('err', "Branch deleted!");
		} else {
		$this->session->set_flashdata('err', "Database error!");	
		}
		redirect(base_url('admin/school'));
	}
	//------------------------------------------------------------
	
	 
	function DelDir($target) {
    if(is_dir($target)) {
        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

        foreach( $files as $file )
        {
            $this->DelDir( $file );      
        }

        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );  
    }
}
		 
	//---------------------------------------------------
	 
	 /**
		*This function is used to copy and paste newly created school module
		*@ access admin
		*@ return view to admin/subadmin listing page 
	 */
	 
	function modulecopy( $source, $target ) {
    if ( is_dir( $source ) ) {
        @mkdir( $target );
        $d = dir( $source );
        while ( FALSE !== ( $entry = $d->read() ) ) {
            if ( $entry == '.' || $entry == '..' ) {
                continue;
            }
            $Entry = $source . '/' . $entry; 
            if ( is_dir( $Entry ) ) {
                $this->modulecopy( $Entry, $target . '/' . $entry );
                continue;
            }
            copy( $Entry, $target . '/' . $entry );
        }

        $d->close();
    }else {
        copy( $source, $target );
    }
	}
	//--------------------------------------------------------------------
		
	/**
		*This function is used to select branch
		*@ access admin
		*@ return view to admin/student page 
	 */
	 
	function student()
	{		
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		
		$header['page']			=	"student";
		$header['school']		=	$this->admin_model->listAllschool($this->tableschool);	
		/*echo '<pre>';
		print_r($header['school']);die();*/
					
		$this->load->view('admin/student',$header);
		}
	//------------------------------------------------------------------
		
	 /**
		*This function is used to add student
		*@ access admin
		*@ return view to admin/add_student form 
	 */
	 
	function add_student($id=0){
		
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$header['page']			=	"student";
		$header['student']		=	array();
		$header['school']		=	$this->admin_model->listAllschool($this->tableschool);
		$header['enrolled']		=	$this->admin_model->listEnrolled($this->endrolled);
		$header['sess']			=	$this->session->flashdata('err');
		$header['day']			=	"";
		$header['month']		=	"";
		$header['year']			=	"";
		
		if($id) { 
			$header['student']		=	$this->admin_model->studentByid($this->tablestudent,$id);
			$dob					=	explode("-",$header['student'][0]['kid_dob']);
			$header['year']			=	$dob[0];
			$header['month']		=	$dob[1];
			$header['day']			=	$dob[2];
			}
		$header['teacher']		=	$this->admin_model->getteacherBymodule($this->moduleID,$this->tableteacher);		
		$this->load->view('add_student',$header);
	}
	
	//---------------------------------------------------------------------------------
	
	/**
		*This function is used to list out student details
		*@ access admin
		*@ return view to student_list  
	 */
	 	
	function student_list()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$branch_name_module			=	$this->module;
		$branch_name				=	$this->input->post('branch_name');
		$new_brnch					=	 $this->clean($branch_name);
		//$branch_name				=	preg_replace('/\s+/', '_', $branch_name);
		//echo "<pre>";
		//echo $branch_name;
		//die();
		//if(!$branch_name)	
		if(!$new_brnch)	
		{
		//die();
		redirect(base_url('admin/student'));
		}
		//echo $branch_name;die(); 	
		//$new_brnch					=	 $this->clean($branch_name);
		$branch_name				=	preg_replace('/\s+/', '_', $new_brnch);
		$new_brnch					=$branch_name;
		//echo "<pre>";
		//echo $new_brnch;
		//die();
		$header['branch_name']		=	$new_brnch;
		$this->session->set_userdata("br_name",$new_brnch);					
		$attendance_table			=	$new_brnch.'_kidsattendance';
		$branch_kids				=	$new_brnch."_kids";
		$branch_class				=   $new_brnch."_class";		
		$header['page']				=	"student";
		$header['sess']				=	$this->session->flashdata('err');
		$header['absenties']		=	$this->admin_model->absenties($attendance_table,$branch_kids,$branch_class);	
		$header['studentArr']		=	$this->admin_model->listStudent($branch_kids,$this->endrolled,$branch_class);

		//echo '<pre>';
		//print_r($branch_kids);
		//print_r($this->module);
		//print_r($header['studentArr']);die();

		

	 	$this->load->view("admin/student/student_list",$header);
	}
   //-------------------------------------------------------------------------------
   
   /**
		*This function is used to disply student profile
		*@ access admin
		*@ return view to student profile
	 */
	 		
	function studentprofile($id=0){		
		
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$header['page']			=	"student";
		$header['sess']			=	"";
		$header['student']		=	array();
		$header['school']		=	$this->admin_model->listAllschool($this->tableschool);
		$header['enrolled']		=	$this->admin_model->listEnrolled($this->endrolled);
		
		if($id) { 
			$header['student']		=	$this->admin_model->studentByid($this->tablestudent,$id);
		} else { $header['sess']			="Something is wrong, Please try again!";}
			$this->load->view('admin/student_profile',$header);
	}
 //--------------------------------------------------------------------------------------
 
 	/**
		*This function is used to listout students 
		*@ access admin
		*@ return view to student list
	 */
	 
	function student_list_new()
	{
			
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		
		$sess_br_name			 	= 	$this->quickauth->selected_branch();		
		$attendance_table			=	$sess_br_name.'_kidsattendance';
		$branch_kids				=	$sess_br_name."_kids";
		$branch_class				=	$sess_br_name."_class";		
		$header['page']				=	"student";
		$header['sess']				=	$this->session->flashdata('err');		
		$header['studentArr']		=	$this->admin_model->listStudent($branch_kids,$this->endrolled,$branch_class);
	 	$this->load->view("admin/student/student_list",$header);
	}	
  //------------------------------------------------------------------------------
  
  	/**
		*This function 'll display student absent list
		*@ access admin
		*@ return view to absentees page
	 */
	 	
	function student_abs()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$sess_br_name			 	= 	$this->quickauth->selected_branch();
		$attendance_table			=	$sess_br_name.'_kidsattendance';
		$branch_kids				=	$sess_br_name."_kids";
		$branch_class				=	$sess_br_name."_class";		
		$header['page']				=	"student";
		$header['sess']				=	$this->session->flashdata('err');
		$header['absenties']		=	$this->admin_model->absenties($attendance_table,$branch_kids,$branch_class);		
	 	$this->load->view("admin/student/student_abs",$header);
	}
	//---------------------------------------------------------------------
	
	/**
		*This function 'll display student starting this week
		*@ access admin
		*@ return to view 
	 */	
		
	function student_stWk()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$sess_br_name			 	= 	$this->quickauth->selected_branch();
		$attendance_table			=	$sess_br_name.'_kidsattendance';
		$branch_kids				=	$sess_br_name."_kids";		
		$branch_class				=	$sess_br_name."_class";		
		$header['page']				=	"student";
		$header['sess']				=	$this->session->flashdata('err');		
		$header['studentArr']		=	$this->admin_model->listStudent($branch_kids,$this->endrolled,$branch_class);
	 	$this->load->view("admin/student/student_stWk",$header);
	}
	//-------------------------------------------------------------------------
	
	/**
		*This function 'll display student ending this week
		*@ access admin
		*@ return to view 
	 */	
		
	function student_endWk()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$sess_br_name			 	= 	$this->quickauth->selected_branch();
		$attendance_table			=	$sess_br_name.'_kidsattendance';
		$branch_kids				=	$sess_br_name."_kids";		
		$branch_class				=	$sess_br_name."_class";	
		$header['page']				=	"student";
		$header['sess']				=	$this->session->flashdata('err');		
		$header['studentArr']		=	$this->admin_model->listStudent($branch_kids,$this->endrolled,$branch_class);
	 	$this->load->view("admin/student/student_endWk",$header);
	}	
	//-----------------------------------------------------------------------
	
	/**
		*This function 'll display student b'day this week
		*@ access admin
		*@ return to view 
	 */		
		
	function student_bdWk()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$sess_br_name			 	= 	$this->quickauth->selected_branch();
		$attendance_table			=	$sess_br_name.'_kidsattendance';
		$branch_kids				=	$sess_br_name."_kids";		
		$branch_class				=	$sess_br_name."_class";	
		$header['page']				=	"student";
		$header['sess']				=	$this->session->flashdata('err');		
		$header['studentArr']		=	$this->admin_model->listStudent($branch_kids,$this->endrolled,$branch_class);
	 	$this->load->view("admin/student/student_bdWk",$header);
	}
	
	//---------------------------------------------------------------------------
	
	/**
		*This function 'll display student starting next week
		*@ access admin
		*@ return to view 
	 */		
		
	function student_stNwk()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$sess_br_name			 	= 	$this->quickauth->selected_branch();
		$attendance_table			=	$sess_br_name.'_kidsattendance';
		$branch_kids				=	$sess_br_name."_kids";		
		$branch_class				=	$sess_br_name."_class";
		$header['page']				=	"student";
		$header['sess']				=	$this->session->flashdata('err');		
		$header['studentArr']		=	$this->admin_model->listStudent($branch_kids,$this->endrolled,$branch_class);
	 	$this->load->view("admin/student/student_stNwk",$header);
	}
	//-----------------------------------------------------------------------
	
	/**
		*This function 'll display student ending next week
		*@ access admin
		*@ return to view 
	 */	
		
	function student_endnwk()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$sess_br_name			 	= 	$this->quickauth->selected_branch();
		$attendance_table			=	$sess_br_name.'_kidsattendance';
		$branch_kids				=	$sess_br_name."_kids";		
		$branch_class				=	$sess_br_name."_class";	
		$header['page']				=	"student";
		$header['sess']				=	$this->session->flashdata('err');		
		$header['studentArr']		=	$this->admin_model->listStudent($branch_kids,$this->endrolled,$branch_class);
	 	$this->load->view("admin/student/student_endnwk",$header);
	}
	//----------------------------------------------------------------------
	
	/**
		*This function 'll display student b'day next week
		*@ access admin
		*@ return to view 
	 */		
		
	function student_bd_nwk()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		$sess_br_name			 	= 	$this->quickauth->selected_branch();
		$attendance_table			=	$sess_br_name.'_kidsattendance';
		$branch_kids				=	$sess_br_name."_kids";		
		$branch_class				=	$sess_br_name."_class";	
		$header['page']				=	"student";
		$header['sess']				=	$this->session->flashdata('err');		
		$header['studentArr']		=	$this->admin_model->listStudent($branch_kids,$this->endrolled,$branch_class);
	 	$this->load->view("admin/student/student_bdNwk",$header);
	}
		
	//---------------------------------------------------------------------
	
	
	/**
		*This function is used to compose message
		*@ access admin
		*@ return view to compose messsage
	 */
	 
	function compose_msg()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		
		$header['page']				=	"compose";
		$header['sess']				=	$this->session->flashdata('err');
		$header['get_admin_names']	=	$this->admin_model->get_admin($admin_tbl);	 	
		$this->load->view("compose_msg",$header);
	}

	 //------------------------------------------------------------
	
	 
	 /**
		*This function is used to post message
		*@ access admin
		*@ return view to dashboard
	 */
	 
	function msg_post($msg_id=0,$id_parent=0)
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		
		
		$header['page']				=	"msg post";
		$header['sess']				=	$this->session->flashdata('err');		
		$type						=	$this->input->post('type');
		$msg_to						=	$this->input->post('branch_admin');		
		$get_type					=	$this->admin_model->get_type($msg_to,$admin_tbl);
		$type_to					=	$get_type['type'];
		$msg_from					=	$this->input->post('admin_name');		
		$subject					=	$this->input->post('subject');		
		$message					=	$this->input->post('message');		
		$reply_msg					=	$this->input->post('reply');
		
		
		
		if($msg_id !=0)
		{
		 	 			
			 $subject					=	'no subject';
			 $status					=	0;	
			 if($id_parent ==0)
			 {
			 	$parent_id				=	$msg_id;
			 }else{
				 $parent_id				=	$id_parent;
			 }
			 $msg_insert				=	$this->admin_model->insert_msg($msg_to,$msg_from,$subject,$reply_msg,$status,$parent_id,$type,$type_to);
			 $status					=	1;
			 $msg_update				=	$this->admin_model->update_msg($msg_id,$status,$msg_tbl);
		}else{
			$status						=	0;
			$parent_id					=	0;
			
			$msg_insert					=	$this->admin_model->insert_msg($msg_to,$msg_from,$subject,$message,$status,$parent_id,$type,$type_to);
		}
	    if($msg_insert) {
		$this->session->set_flashdata('suc', "Your message has been sent!");		
		}else{
			$this->session->set_flashdata('err', "Error in sending message");	
			}
	
		redirect(base_url('/admin/message_list'));
	}


	 //------------------------------------------------------------
	
	
	 /**
		*This function is used to post reply msg
		*@ access admin
		*@ return view to reply page
	 */
	 
	 function reply($id=0,$msg_id=0,$parent_id=0)
	 {
		
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		
		
		$get_branch_ad_name 		=	$this->admin_model->show_branch_ad_name($id);
		$header['branch_ad_name']   =   $get_branch_ad_name['name'];		
		$header['message']			=	$this->admin_model->show_message($msg_id,$msg_tbl);		
		$get_msg_body				=	$header['message']['message'];	   
		$get_msg_subject			=	$header['message']['subject'];		
		$header['msg_body']		    =	$get_msg_body;
		$header['msg_subject']		=	$get_msg_subject;		
		$header['page']				=	"Reply";
		$header['sess']				=	$this->session->flashdata('err');
		$header['branch_ad_id']		=	$id;
		$header['message_id']		=	$msg_id;
		$header['parent_id']		=	$parent_id;
		
		$this->load->view("reply_msg",$header);
		
	 }
	 
	 //----------------------------------------------------------------------
	 
	 
	 /**
		*This function is used to display all messages
		*@ access admin
		*@ return view to dashboard
	 */
	 
	 function message_list()
	 {
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		$all_msgs					=	array();
		$get_all_msgs				=	$this->admin_model->show_all_msgs($admin_id,$msg_tbl,$admin_tbl,$header['type']);
		
		foreach($get_all_msgs as $key=>$row) {
			
			$parent_msg		 =	$get_all_msgs[$key];					
			array_push($all_msgs,$parent_msg);
			$message_id	 =	$get_all_msgs[$key]['msg_id'];				
			$reply_msgs	 = 	$this->admin_model->show_msg_reply($message_id,$msg_tbl,$admin_tbl);			
			foreach($reply_msgs as $key=>$row) {
			   
			   $parent_msg_reply =	$reply_msgs[$key];
			   array_push($all_msgs,$parent_msg_reply);
			}
		}
		$header['display_all_msgs']	=	$all_msgs;		
		$header['display_all_msgs']	=	$all_msgs;		
		$header['page']				=	"message list";
		$header['sess']				=	$this->session->flashdata('err');
		$header['succ']				=	$this->session->flashdata('suc');
		$header['sch_module']		=	$this->module;
		$this->load->view('message_list',$header);
		 
	 }
	//----------------------------------------------------------------------------
	
	 /**
		*This function will delete message
		*@ access admin
		*@ return view to dashboard
	 */
	
	function delete_msg($msg_id)
	{
		
		  $delete_msg		=	$this->admin_model->delete_msg($msg_id);		
		 
		  if( $delete_msg)
		  {
		  	$this->session->set_flashdata('err', "Message deleted!");
		  }else{
		    $this->session->set_flashdata('err', "Problem in deletion");
		  }
		  redirect(base_url('/admin/message_list'));
	}
	//------------------------------------------------------------
	
	/**
		*This function will display comming soon msg
		*@ access admin
		*@ param none
	 */
	 
	function coming_soon()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		$header['page']				=	"message list";
		$header['sess']				=	$this->session->flashdata('err');
		$header['sch_module']		=	$this->module;
		$this->load->view('coming_soon',$header);	
	}
	
	//------------------------------------------------------------
	
	
	/**
		*This function will select address of school
		*@ access admin
		*@ param none
	 */
	 
	function select_address()
	{
		
		$add = $this->input->post('school_id');
		$get_address = $this->admin_model->get_branch_addr($add);
		
		echo json_encode($get_address['addr_city'].','.$get_address['addr'].','.$get_address['addr_st'].','.$get_address['addr_coun']);
	}
	
	//------------------------------------------------------------
	
	
	/**
		*This function will check the given email present online or not
		*@ access admin
		*@ param none
	 */	
	 
	function email_check()
	{
		require_once('smtp_validateEmail.class.php');
		
		// the email to validate
		$email = $this->input->post('email_id');//'gmobanraj@gmail.com';
		//echo $email;die();
		// an optional sender
		$sender = 'moban@euphontec.com';
		// instantiate the class
		$SMTP_Validator = new SMTP_validateEmail();		
		// do the validation
		$results = $SMTP_Validator->validate(array($email));
		// view results
		echo json_encode($email.' is '.($results[$email] ? 'valid' : 'invalid')."\n");
		
		// send email? 
		/*if ($results[$email]) {
		  //mail($email, 'Confirm Email', 'Please reply to this email to confirm', 'From:'.$sender."\r\n"); // send email
		} else {
		  echo 'The email addresses you entered is not valid';
		}*/
	}
	//-------------------------------------------------------
	
	/**
		*This function will show an option to assign branches
		*@ access admin
		*@ param id
	 */	
	 
	function assign_branches($id=0)
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		if($id)
		{
			$header['br_names_edit']=	$this->admin_model->br_names_edit($id,$this->brn_ass);		
			
		}
		
		$header['list_br_admins']	=	$this->admin_model->list_br_admins($admin_tbl,$this->brn_ass);	
		
		$header['list_branches']	=	$this->admin_model->list_branches($admin_tbl);		
		
		$header['page']				=	"assign branch";
		$header['sess']				=	$this->session->flashdata('err');
		$header['id']				=	$id;
		$this->load->view('assign_branches',$header);		
	}
	
	//-------------------------------------------------------------
	
	
	/**
		*This function is used to assign branches to an user
		*@ access admin
		*@ param id
	 */	
	 
	function assign_branches_post($id=0)
	{
		$br_admin_name	=	$this->input->post('br_admin_name');	
		//echo $br_admin_name;die();
		$branch_name	=	$this->input->post('br_name');
		
		if($id)
		{
			$br_admin_name	=	$this->input->post('admin_name');	
			$branch_name	=	$this->input->post('branch_name');
			$check_existing	=	$this->admin_model->check_existing_branch($br_admin_name,$branch_name);
			if($check_existing) {
						$this->session->set_flashdata('err', "Same branch already assigned to this person!");
                    	redirect(base_url('admin/assign_branches_list'));
					}
			$update_br_assigned	=	$this->admin_model->update_br_assigned($br_admin_name,$branch_name,$id);
			
			$this->session->set_flashdata('suc', "Updated Successfully!");
			redirect(base_url('admin/assign_branches_list'));	
				
		}else{
			
             foreach($branch_name as $row){
					$check_existing	=	$this->admin_model->check_existing_branch($br_admin_name,$row);
					if($check_existing) {
						$this->session->set_flashdata('err', "Same branch already assigned to this person!");
                    	redirect(base_url('admin/assign_branches_list'));
					}
				    $insert_school = $this->admin_model->insert_branches($br_admin_name,$row);
                }
                    $this->session->set_flashdata('suc', "Branches Assigned Successfully!");
                    redirect(base_url('admin/assign_branches_list'));
			
		}
	}
	
	//----------------------------------------------------------
	
	/**
		*This function will show an option to users to a branch
		*@ access admin
		*@ param id
	 */	
	 
	function assign_users($id=0)
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		
		if($id)
		{
			$header['usr_names_edit']=	$this->admin_model->usr_names_edit($id,$this->usr_ass);
				
		}
		
		$header['list_br_admins']	=	$this->admin_model->list_br_admins($admin_tbl,$this->brn_ass);		
		$header['list_branches']	=	$this->admin_model->list_branches($this->usr_ass);	
		$header['page']				=	"assign user";
		$header['sess']				=	$this->session->flashdata('err');
		$header['id']				=	$id;
		$this->load->view('assign_users',$header);		
	}
	
	//-------------------------------------------------------
	
	/**
		*This function is used to assign users
		*@ access admin
		*@ param id
	 */	
	 
	function assign_users_post($id=0)
	{
		
		$br_admin_name	=	$this->input->post('br_admin_name');		
		$branch_id		=	$this->input->post('br_name');
		/*echo "<pre>";
		print_r($br_admin_name);
		print_r($branch_id);*/
		
		$br_admins = '';
		$br_admins = implode(",",$br_admin_name);
		
		
		if($id)
		{
			$update_usr_assigned	=	$this->admin_model->update_users_assigned($branch_id,$br_admins,$id);
			if($update_usr_assigned)
			{
				$this->session->set_flashdata('suc', "Updated Successfully!");
				redirect(base_url('admin/assign_users_list'));	
			}	
		}else{
			
			foreach($br_admin_name as $row){
                $insert_usr_assigned	=	$this->admin_model->insert_users_assigned($branch_id,$row);
            }
            if($insert_usr_assigned){		
			$this->session->set_flashdata('suc', "Users assigned to a branch successfully!");
			redirect(base_url('admin/assign_users_list'));
			}
		}
	}
	
	//--------------------------------------------------------------
	
	/**
		*This function will list out all assigned branches
		*@ access admin
		*@ param none
	 */	
	 
	function assign_branches_list()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		$header['page']				=	"assign Brach List";
		$header['sess']				=	$this->session->flashdata('err');
		$header['succ']				=	$this->session->flashdata('suc');
		$header['list_ass_brns']	=	$this->admin_model->list_ass_brns($admin_tbl,$this->brn_ass,$this->tableschool);		
		/*echo '<pre>';
		print_r($header['list_ass_brns']);die();*/
		
		$this->load->view('assign_branches_list',$header);	
	}
	
	//--------------------------------------------------------------------
	
	/**
		*This function is used to delete assigned branches
		*@ access admin
		*@ param id
	 */	
	 
	function assign_branches_delete($id=0)
	{
		if($id >0 )
		{
			$delete_ass_br	=	$this->admin_model->delete_ass_br($id);
			if($delete_ass_br)
			{
				$this->session->set_flashdata('err', "Deleted!");
				redirect(base_url('admin/assign_branches_list'));	
			}	
		}
	}
	//------------------------------------------------------------------
	
	/**
		*This function will listout all assigned users
		*@ access admin
		*@ param none
	 */	
	 
	function assign_users_list()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		$header['page']				=	"assign Brach List";
		$header['sess']				=	$this->session->flashdata('err');
		$header['succ']				=	$this->session->flashdata('suc');
		$header['list_ass_usr']		=	$this->admin_model->list_ass_usr($admin_tbl,$this->usr_ass,$this->school);
		/*echo '<pre>';
		print_r($header['list_ass_usr']);die();*/
		$this->load->view('assign_users_list',$header);	
	}
	
	//-------------------------------------------------------------------
	
	/**
		*This function is used to delete assigned users
		*@ access admin
		*@ param id
	 */	
	 
	function assign_users_delete($id=0)
	{
		if($id >0 )
		{
			$delete_ass_usr	=	$this->admin_model->delete_ass_usr($id);
			if($delete_ass_usr)
			{
				$this->session->set_flashdata('err', "Deleted!");
				redirect(base_url('admin/assign_users_list'));	
			}	
		}
	}
	
	//-----------------------------------------------------

   /**
		*This function is used for auto complete
		*@ access admin
		*@ param none
		
		public prefix commented
	 */	
   
   function getenrol(){
      
	 	
		$searchTerm=$this->input->get('term');
		$data=$this->admin_model->auto_complete($searchTerm);
	    echo json_encode(array_unique($data));
	 
    }
			
//-------------------------------------------------------------

	function assign_branches_edit($id=0)
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		
		
		$list_br_admins				=	$this->admin_model->get_br_admin_byId($id,$admin_tbl,$this->brn_ass);	
		$header['admin_name']		=	$list_br_admins['admin_name'];
		$header['admin_id']			=	$list_br_admins['admin_id'];	
		$get_branch					=	$this->admin_model->get_branch($id,$this->brn_ass,$this->tableschool);
		$header['branch_name']				=	$get_branch['branch_name'];
		$header['list_branches']	=	$this->admin_model->list_branches($admin_tbl);		
		
		$header['page']				=	"assign branch";
		$header['sess']				=	$this->session->flashdata('err');
		$header['id']				=	$id;
		$this->load->view('assign_branches_edit',$header);			
	}
	
	//------------------------------------------------------------------
	
	function change_password()
	{
		$admin_id					=	$this->quickauth->logged_in_user();
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);		
		
		$header['page']				=	"change password";
		$header['sess']				=	$this->session->flashdata('err');
		$header['succ']				=	$this->session->flashdata('suc');
		
		$this->load->view('change_password',$header);
			
	}	
	
	//---------------------------------------------------------------
	
	function check_old_pass()
	{
		$admin_id			=	$this->quickauth->logged_in_user();
		$old_pass			=	$this->input->post('old_pass');
		$enpassword			= 	$this->en_de_password('encrypt',$old_pass);
		$check_pass			=	$this->admin_model->check_pass($admin_id,$enpassword,$this->admin_tbl);
		echo json_encode($check_pass);
	}
	
	function change_password_post()
	{
		 $new_pass		=	$this->input->post('new_pass');
		 $admin_id		=	$this->input->post('admin_id');
		 $enpassword	=	 $this->en_de_password('encrypt',$new_pass);
		 
		 $get_admin_email	=	$this->admin_model->get_admin_email($admin_id);
		 $email			=	$get_admin_email['email'];
		 $name			=	$get_admin_email['name'];
		 
		 if($this->check_old_pass_valid()==false)
		 {
		 
		 $this->session->set_flashdata('err', "Wrong password or no password entered!");		  		
				redirect(base_url('admin/change_password'));
		 
		 }
		// $branch_details   =  $this->admin_model->get_branch_details($this->moduleID);
		 $update_pass	=	$this->admin_model->update_new_pass($admin_id,$enpassword);
		 if($update_pass)
		 {		 
		  $message = '		
				<html>
				
				<body>
				
				 <div style="margin-left:30px;margin-right:30px;background-color:#fff;border:1px solid #cc2800;border-radius:5px;">
				 <div style="height:100px;;width:100%;background-color:#cc2800;"> 
				  <div style="float:left;padding-top:10px;">
					<img src="cid:signatureLogo" width="90" height="70" align="left" style="border-radius:100px;">
				 </div>
				  <div style="float:left;padding-top:10px; color:#fff;margin-left:8px;">
					 <h2>Password Change Notification</h2>
				 </div>
				 
				</div>
				 <div style="margin-left:30px;margin-right:30px;">
				 
				 <div style="text-align:center;font-size:20px;">
					 <br><br><p><b>Hello <b style="color:blue;">'.$name.'</b></p>
					  <p><b>Your password changed successfully.</b></p>
				  </div> 
					 <hr style="border-color:#cc2800;">
					
					 <div style="color:#808080;font-size:16px;font-size:18px;margin-left:150px;">     
					  <p><b><u>Your New Authentication Details</u></b></p>
					  <div>
						<div>Username : '.$email.'</div>
						<div style="text-indent:4px;">Password : '.$new_pass.'</div>
					  </div>
					  </div>
					  
					   <br><hr style="border-color:#cc2800;">
					  
					  <div style="color:#808080;text-align:center;font-size:16px;">	       
					  <p><i>Please do not reply directly to this message.</i><p>
					  <p><i>For help, please visit</i><b><a href="#"> daycare help section</a></b>.</p>
					  </div>					 
					
					 <div style="color:#808080;text-align:center;">
					 
					 <p style="font-size:12px;">@ 2015- DayCare registered </p>
					  </div> 
				 
				</div>
				</div>
				
				</body>
				</html>';//echo $message;die();
				
					$emailArr	=	array(
										'to'		=>	$email,
										'from'      =>  'jitin@euphontec.com',
										'from_name' =>  'DayCare', 
										'subject'	=>	'DayCare | Password Change Notification',
										'message'	=>	$message,
										
										);
										
				// send mail by php mailer		
						
					
				$send_mail	=	$this->mailer->send_mail($emailArr,$bcc=false,$attachment=false,$bccEmail='');		        
				$this->mailer->ClearAllRecipients();
				$this->mailer->ClearAttachments();
				
				$this->session->set_flashdata('suc', "Password changed successfully, please check your email!");		  		
				redirect(base_url('admin/change_password'));
			}else{
				$this->session->set_flashdata('err', "Error in changing password");
		  		redirect(base_url('admin'));
				
				 }	
	}
	
	//-----------------------------------------------------------------
	
	function admin_gps_track(){
		$id=1;
		$gps_table					=	'admin_gps_tracking';
		$admin_id					=	$this->quickauth->logged_in_user();
		
		$header['page']				=	"gps_track";
		$header['admin_id']			=	$admin_id;		
		$header['get_name']			=	$this->admin_model->get_admin_name($admin_id);		
		$header['admin_name']		=	$header['get_name']['admin_name'];
		$header['type']				=	$header['get_name']['type'];	
		$total_msg					=	$this->admin_model->total_msg_count($admin_id,$header['type']);		
		$header['total_msg']		=	count($total_msg);		
		$msg_tbl					=	'message';
		$admin_tbl					=	'tbl_adminusers';				
		$header['branch_admin_names']	=	$this->admin_model->show_names($admin_id,$admin_tbl,$msg_tbl,$header['type']);
		$updid=$id;
		
		//Authentication
		if(!$this->quickauth->is_logged_in())
		{
			redirect(base_url('admin/login'));
		}
		
		$header['school']		=	array();		
		$header['sess']			=	$this->session->flashdata('err');
		
		
		 $header['school']		=	$this->admin_model->admin_gps_track($gps_table);
		
		
		
		
		
		$header['branch_id']	=	$id;
		$this->load->view('admin/admin_gps_tracking',$header);
	}
	
	//-----------------------------------------------------

   /**
		*This function is used for removing special characters
		*@ access admin
		*@ param string
		return string
	 */	
	
	
	
	function remove_special_chars($string){
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
    $string = strtolower(trim($string, '-'));
	$string = str_replace('-', '_', $string);
	return $string;
}


function show_data(){$_REQUEST['year']='2016';
$_REQUEST['month']='02';
	if (!empty($_REQUEST['year']) && !empty($_REQUEST['month'])) {
    $year = intval($_REQUEST['year']);
    $month = intval($_REQUEST['month']);
    $lastday = intval(strftime('%d', mktime(0, 0, 0, ($month == 12 ? 1 : $month + 1), 0, ($month == 12 ? $year + 1 : $year))));
    $dates = array();
    for ($i = 0; $i <= (rand(4, 10)); $i++) {
        $date = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, $lastday), 2, '0', STR_PAD_LEFT);
        $dates[$i] = array(
            'date' => $date,
            'badge' => ($i & 1) ? true : false,
            'title' => 'Example for ' . $date,
            'body' => '<p class="lead">Information for this date</p><p>You can add <strong>html</strong> in this block</p>',
            'footer' => 'Extra information',
        );
        if (!empty($_REQUEST['grade'])) {
            $dates[$i]['badge'] = false;
            $dates[$i]['classname'] = 'grade-' . rand(1, 4);
        }
        if (!empty($_REQUEST['action'])) {
            $dates[$i]['title'] = 'Action for ' . $date;
            $dates[$i]['body'] = '<p>The footer of this modal window consists of two buttons. One button to close the modal window without further action.</p>';
            $dates[$i]['body'] .= '<p>The other button [Go ahead!] fires myFunction(). The content for the footer was obtained with the AJAX request.</p>';
            $dates[$i]['body'] .= '<p>The ID needed for the function can be retrieved with jQuery: <code>dateId = $(this).closest(\'.modal\').attr(\'dateId\');</code></p>';
            $dates[$i]['body'] .= '<p>The second argument is true in this case, so the function can handle closing the modal window: <code>myFunction(dateId, true);</code></p>';
            $dates[$i]['footer'] = '
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="dateId = $(this).closest(\'.modal\').attr(\'dateId\'); myDateFunction(dateId, true);">Go ahead!</button>
            ';
        }
    }
    echo json_encode($dates);
} else {
    echo json_encode(array());
}
}

function is_mno($string)
{
if (is_numeric($string)) {
   return true;
}
   else
   {
	 return false;  
   }
	
}
function is_email($string)
{
if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $string))
 {
 return false;
 }
 else
 {
 return true;
 }	
}
function is_special($string)
{

if (ctype_alpha(str_replace(' ', '', $string)) === false) {
  return false;
  
}
else
{
return true;	
}
}
function is_emptyval($string)
{
if(empty($string))
{
return false;
	
}
else
{
return true;	
}

}
function check_email_exists_validation($emailid,$id=0)
	{
		$final_result=false;
		$usr_id			=	$id;
		$email			=	$emailid;
		$teacher_table  =	'tbl_ulogin';
		if($usr_id)
		{ 
			$check_mail	=	$this->admin_model->checkByemail_id($email,$usr_id);
			$check_email		=	$this->admin_model->checkUsername_id($email,$usr_id,$teacher_table);
		}else{
			$check_mail	=	$this->admin_model->checkByemail($email);
			$check_email		=	$this->admin_model->checkUsername($email,$teacher_table);
			}
			
		if($check_mail==true&&$check_email==true)
		{$final_result=true;}
		else
		{$final_result=false;}
			
		return $final_result;
	}
	
	function check_old_pass_valid()
	{
		$admin_id			=	$this->quickauth->logged_in_user();
		$old_pass			=	$this->input->post('old_pass');
		$enpassword			= 	$this->en_de_password('encrypt',$old_pass);
		$check_pass			=	$this->admin_model->check_pass($admin_id,$enpassword,$this->admin_tbl);
		return $check_pass;
	}









	
}
?>