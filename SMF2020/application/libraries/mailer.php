<?php
//include("application/third_party/PHPMailer/class.phpmailer.php");
require 'application/third_party/PHPMailer/PHPMailerAutoload.php';
@set_magic_quotes_runtime(false);
ini_set('magic_quotes_runtime', 0);
class Mailer extends PHPMailer {
	
	function __construct() {
		parent::__construct();
	}
	
	function send_mail($detailArr, $bcc=true, $attachement=false,$bccEmail) {
		
		
		$this->IsSMTP();
		
		$this->SMTPAuth = true;
		$this->SMTPSecure = "ssl";                 // sets the prefix to the servier
        $this->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
        $this->Port       = 465;                   // set the SMTP port for the GMAIL server
       	$this->Username   = "jitin@euphontec.com";  // GMAIL username
        $this->Password   = "jitin321"; 
		
          
		
		$this->From = $detailArr['from']; 
		
		$this->FromName = $detailArr['from_name'];
		
		$addr = explode(',',$detailArr['to']);

		foreach ($addr as $ad) {
			$this->AddAddress( trim($ad) );       
		}
		 
		//echo $this->AddAddress($detailArr['to']); die();
		if($detailArr['to_cc'])
		{
			$to_cc = explode(',',$detailArr['to_cc']);

		foreach ($to_cc as $ad) {
			$this->AddCC( trim($ad) );       
		}
	    }
		/*if($bcc==true){
			$this->AddCC('gmobanraj@gmail.com');
			}*/
	  /* if($cc==true){
			$this->AddCC($ccEmail);
		}*/
		/*if($attachement==true){
			$docRoot  = $_SERVER["DOCUMENT_ROOT"];
			$rootFolder =  basename(dirname($_SERVER['SCRIPT_FILENAME']));
			//$path = $docRoot.'/'.$rootFolder.'/courseplan_pdf/';
			$path = 'courseplan_pdf/';
			$pdfName  = $detailArr['attachement'];
			$this->AddAttachment($path.$pdfName);
		   }*/
                        
		
		$this->IsHTML(true);
		
		$this->Subject = $detailArr['subject'];
		
		$this->Body = $detailArr['message'];
		
		$this->AddEmbeddedImage('assets/img/draft_lens18300241module152628152photo_1314097689logo-sample-300x288.png.j.jpg', 'signatureLogo');
		
				
		if(!$this->Send()){
			return FALSE;
		}else{
			return TRUE;
		}
	}
}
?>