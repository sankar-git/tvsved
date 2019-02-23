<?php
ob_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require_once APPPATH."/third_party/Atompay-ci/Atompay/sample.php";
class Payment extends CI_Controller {
	
	
	 private $user_name='';
	 private $user_fullname='';
	 private $user_role = 0;
	 private $user_email='';
	 private $user_id='';
	 
	 public function __construct()
     {
             parent::__construct();
			$this->load->database();
			$this->load->library('session');
			$this->load->library('encrypt');
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->library('email');
			$this->load->model('fees_model');
			$this->load->library('image_lib');
			$this->load->model('common_model');
			$this->load->model('newsession_model');
			$this->load->helper('email');
			$this->load->model('newsession_model');
			$this->load->model('user_model');
			$this->load->model('type_model');
			$this->load->model('Master_model');
			$this->load->model('Discipline_model');
			$this->load->library('permission_lib');
			$this->load->model('Result_model');
			$this->load->model('Process_model');
			$this->load->model('Generate_model');
			$this->load->model('Payment_model');
			$this->load->library('excel');
			//$this->load->library('atom');
			$this->load->library('TransactionRequest');
			$this->load->library('TransactionResponse');
			$sessdata= $this->session->userdata('sms');
		    if(empty($sessdata)){
				$this->load->view('admin/session_time_out_view');
			    redirect('authenticate', 'refresh');
		    }
		
	}
	function testPayment($type='')
	{  
		//p($_POST); exit;
	    $sessdata= $this->session->userdata('sms');
		//p($sessdata); exit;
		$user_id=$this->input->post('user_id');	
		$role_id=$this->input->post('role_id');	
		$amount=$this->input->post('amount');	
		$program_id=$this->input->post('program_id');	
		$semester_id=$this->input->post('semester_value');	
		$payment_type=ucwords(str_replace("_"," ",$this->input->post('report_card')));	
		
		//$payment_type='';
		//if($type == 1)
			//$payment_type = 'Duplicate Certificate Fee';
		//if($type == 2)
			//$payment_type = 'Re-Evaluation Certificate Fee';
		$datenow = date("d/m/Y h:m:s");
		$transactionDate = str_replace(" ", "%20", $datenow);

		$transactionId = rand(1,1000000);
		$this->session->set_userdata('transations',$transactionId);
		
		$transactionRequest = new TransactionRequest();
        //$thankyou=$this->getThankyou();
		
		$returl=base_url()."payment/responseme";
		//p($returl); exit;
		//Setting all values here
		$transactionRequest->setMode("test");
		$transactionRequest->setLogin(197);//197
		$transactionRequest->setPassword("Test@123");
		$transactionRequest->setProductId("NSE");
		$transactionRequest->setAmount($amount);
		$transactionRequest->setTransactionCurrency("INR");
		$transactionRequest->setTransactionAmount($amount);
		$transactionRequest->setReturnUrl($returl);
		//$transactionRequest->setReturnUrl("http://localhost/~work/Atompay/response.php");
		$transactionRequest->setClientCode(123);
		$transactionRequest->setTransactionId($transactionId);
		$transactionRequest->setTransactionDate($transactionDate);
		//$transactionRequest->setCustomerName($sessdata[0]->first_name.' '.$sessdata[0]->last_name);
		//$transactionRequest->setCustomerEmailId($sessdata[0]->email);
		//$transactionRequest->setCustomerMobile($sessdata[0]->contact_number);
		$transactionRequest->setCustomerName("Test Name");
		$transactionRequest->setCustomerEmailId("test@test.com");
		$transactionRequest->setCustomerMobile("9999999999");
		$transactionRequest->setCustomerSemester($semester_id);
		$transactionRequest->setCustomerProgram($program_id);
		$transactionRequest->setPaymentType($payment_type);
		$transactionRequest->setLoginUser($user_id);
		$transactionRequest->setCustomerBillingAddress("Mumbai");
		$transactionRequest->setCustomerAccount("639827");
		$transactionRequest->setReqHashKey("KEY123657234");
		


		$url = $transactionRequest->getPGUrl();

		header("Location: $url");
	 
	}
	function success(){
		
		$sessdata= $this->session->userdata('sms');
		$transaction_id= $this->session->userdata('transations');
		if(!empty($sessdata[0]->id))
	    {
			$data['transactions']=$this->Payment_model->get_save_payment_data($transaction_id);
		}
		$this->load->view('admin/thankyou_view',$data);
		
	}
	
	function reEvaluation()
	{
		//p($_POST); exit;
	    
		$user_id=$this->input->post('user_id');	
		$role_id=$this->input->post('role_id');	
		$amount=$this->input->post('amount');	
			
			  $datenow = date("d/m/Y h:m:s");
		$transactionDate = str_replace(" ", "%20", $datenow);

		$transactionId = rand(1,1000000);
		$this->session->set_userdata('transations',$transactionId);
		$transactionRequest = new TransactionRequest();
        //$thankyou=$this->getThankyou();
		
		$returl=base_url()."payment/re_evaluation";
		//p($returl); exit;
		//Setting all values here
		$transactionRequest->setMode("test");
		$transactionRequest->setLogin(197);//197
		$transactionRequest->setPassword("Test@123");
		$transactionRequest->setProductId("NSE");
		$transactionRequest->setAmount($amount);
		$transactionRequest->setTransactionCurrency("INR");
		$transactionRequest->setTransactionAmount($amount);
		$transactionRequest->setReturnUrl($returl);
		//$transactionRequest->setReturnUrl("http://localhost/~work/Atompay/response.php");
		$transactionRequest->setClientCode(123);
		$transactionRequest->setTransactionId($transactionId);
		$transactionRequest->setTransactionDate($transactionDate);
		$transactionRequest->setCustomerName("Test Name");
		$transactionRequest->setCustomerEmailId("test@test.com");
		$transactionRequest->setCustomerMobile("9999999999");
		$transactionRequest->setCustomerBillingAddress("Mumbai");
		$transactionRequest->setCustomerAccount("639827");
		$transactionRequest->setReqHashKey("KEY123657234");
		


		$url = $transactionRequest->getPGUrl();

		header("Location: $url");
	}
	
	function re_evaluation()
	{
		$transactionResponse = new TransactionResponse();
		$transactionResponse->setRespHashKey("KEYRESP123657234");

		if($transactionResponse->validateResponse($_POST)){
		//p($_POST); exit;
		   //echo "Transaction Processed <br/>";
		   $sessdata = $this->session->userdata('sms');
		   $user_id=$sessdata[0]->id;
		  
		  // print_r($_POST);
		   $save['mmp_txn']=$_POST['mmp_txn'];
		   $save['mer_txn']=$_POST['mer_txn'];
		   $save['amt']=$_POST['amt'];
		   $save['prod']=$_POST['prod'];
		   $save['date']=$_POST['date'];
		   $save['bank_txn']=$_POST['bank_txn'];
		   $save['f_code']=$_POST['f_code'];
		   $save['clientcode']=$_POST['clientcode'];
		   $save['bank_name']=$_POST['bank_name'];
		   $save['auth_code']=$_POST['auth_code'];
		   $save['ipg_txn_id']=$_POST['ipg_txn_id'];
		   $save['merchant_id']=$_POST['merchant_id'];
		   $save['desc']=$_POST['desc'];
		   $save['udf9']=$_POST['udf9'];
		   $save['discriminator']=$_POST['discriminator'];
		   $save['surcharge']=$_POST['surcharge'];
		   $save['CardNumber']=$_POST['CardNumber'];
		   $save['udf1']=$_POST['udf1'];
		   $save['udf2']=$_POST['udf2'];
		   $save['udf3']=$_POST['udf3'];
		   $save['udf4']=$_POST['udf4'];
		   $save['udf5']=$_POST['udf5'];
		   $save['udf6']=$_POST['udf6'];
		   $save['signature']=$_POST['signature'];
		   $save['user_id']=$user_id;
		   //p($save); exit;
		   $save_user=$this->Payment_model->save_response($save);
		   $data['payment_row']=$this->Payment_model->get_save_payment_by_id($user_id,$save['mer_txn']);
		   $data['userinfo']=$this->Payment_model->get_student_details($user_id);
		   $data['payment_type']='Re-evluation Fee';
		   $data['mail_flag']=true;
		   //sending mail here
		    @$this->email->set_mailtype("html");
            @$html_email_user = $this->load->view('admin/thankyou_view',$data, true);
            //echo "<pre>";print_r($html_email_user);exit;
            @$this->email->from('admin@parthaedu.com','admin');
            @$this->email->to($email);
            @$this->email->subject('Payment Invoice');
            @$this->email->message($html_email_user);
            @$result=$this->email->send();
		   $data['mail_flag']=false;
		   //sending in mail too
		    //@$this->email->set_mailtype("html");
           // @$html_email_user = $this->load->view('admin/payment/payment_invoice_template',$data, true);
            //echo "<pre>";print_r($html_email_user);exit;
           // @$this->email->from('admin@parthaedu.com','admin');
            //@$this->email->to($email);
            //@$this->email->subject('Payment Invoice');
           // @$this->email->message($html_email_user);
           // @$result=$this->email->send();
		   
		   $this->load->view('admin/thankyou_view',$data);
		  
		} else {
		echo "Invalid Signature";
		}
		
	}
	function sendToPayment()
	{
		p($_POST); exit;
		$user_id=$this->input->post('user_id');
		$role_id=$this->input->post('role_id');
		$amount=$this->input->post('amount');
		$send['user_id']=$user_id;
		$send['role_id']=$role_id;
		$send['amount']=$amount;
		$return = $this->sendToUrl($send);
		
	}
	function responseme()
	{
		$transactionResponse = new TransactionResponse();
		$transactionResponse->setRespHashKey("KEYRESP123657234");
		
		// p($_POST);exit;
		if($transactionResponse->validateResponse($_POST)){
			$sessdata = $this->session->userdata('sms');
		$user_id=$sessdata[0]->id;
		$transationsid = $this->session->userdata('transations');
			if($_POST['f_code'] == 'F' || $_POST['f_code'] == 'C'){
				$data = $_POST;
				 $save['mmp_txn']=$_POST['mmp_txn'];
			   $save['mer_txn']=$_POST['mer_txn'];
			   $save['amt']=$_POST['amt'];
			   $save['prod']=$_POST['prod'];
			   $save['date']=$_POST['date'];
			   $save['bank_txn']=$_POST['bank_txn'];
			   $save['f_code']=$_POST['f_code'];
			   $save['clientcode']=$_POST['clientcode'];
			   $save['bank_name']=$_POST['bank_name'];
			   $save['merchant_id']=$_POST['merchant_id'];
			   $save['discriminator']=$_POST['discriminator'];
			   $save['ipg_txn_id']=$transationsid;
			   $save['desc']=$_POST['desc'];
			   $save['udf9']=$_POST['udf9'];
			   $result_res=$this->Payment_model->get_response_data($save['ipg_txn_id']);
				
				$save_user=$this->Payment_model->save_response($save);
				$data['payment']=$this->Payment_model->get_save_payment_data($save['mer_txn']);
		   
				$data['userinfo']=$this->Payment_model->get_student_details($user_id,$data['payment']->program_id);
				$save['signature']=$_POST['signature'];
			   $save['user_id']=$user_id;
			   $data['mail_flag']=false;
			   $msg = 'Dear '.$sessdata[0]->first_name.",\n";
				$msg.= "Your Payment ".ucwords(str_replace("_"," ",$data['payment']->payment_type))." for ".$data['payment']->semester_id."  failed due to $_POST[desc]. with payment ID $save[mer_txn]. Please quote this ID for any clearification.";
				if(count($result_res)==0)
					send_sms($msg,$sessdata[0]->contact_number);
				$this->load->view('admin/failure_view',$data);
			}else{
		   //echo "Transaction Processed <br/>";
		   
		  
		  // print_r($_POST);
		   
		   $save['mmp_txn']=$_POST['mmp_txn'];
		   $save['mer_txn']=$_POST['mer_txn'];
		   $save['amt']=$_POST['amt'];
		   $save['prod']=$_POST['prod'];
		   $save['date']=$_POST['date'];
		   $save['bank_txn']=$_POST['bank_txn'];
		   $save['f_code']=$_POST['f_code'];
		   $save['clientcode']=$_POST['clientcode'];
		   $save['bank_name']=$_POST['bank_name'];
		   $save['auth_code']=$_POST['auth_code'];
		   $save['ipg_txn_id']=$_POST['ipg_txn_id'];
		   $save['merchant_id']=$_POST['merchant_id'];
		   $save['desc']=$_POST['desc'];
		   $save['udf9']=$_POST['udf9'];
		   $save['discriminator']=$_POST['discriminator'];
		   $save['surcharge']=$_POST['surcharge'];
		   $save['CardNumber']=$_POST['CardNumber'];
		   $save['udf1']=$_POST['udf1'];
		   $save['udf2']=$_POST['udf2'];
		   $save['udf3']=$_POST['udf3'];
		   $save['udf4']=$_POST['udf4'];
		   $save['udf5']=$_POST['udf5'];
		   $save['udf6']=$_POST['udf6'];
		   $save['signature']=$_POST['signature'];
		   $save['user_id']=$user_id;
		   //p($save); exit;
		    $result_res=$this->Payment_model->get_response_data($save['ipg_txn_id']);
		   $save_user=$this->Payment_model->save_response($save);
		   $data['payment_row']=$this->Payment_model->get_save_payment_by_id($user_id,$save['mer_txn']);
		   $data['payment']=$this->Payment_model->get_save_payment_data($save['mer_txn']);
		   
		   $data['userinfo']=$this->Payment_model->get_student_details($user_id,$data['payment']->program_id);
		   //p($data['userinfo']); exit;
		   
			$data['mail_flag']=false;
			if(count($result_res)==0){ $data['mail_flag']=true;
		     //sending mail here
		    @$this->email->set_mailtype("html");
            @$html_email_user = $this->load->view('admin/thankyou_view',$data, true);
            //echo "<pre>";print_r($html_email_user);exit;
            $this->load->config('email');
			$this->email->from($this->config->item('from_email'), $this->config->item('from_name'));
            @$this->email->to($sessdata[0]->email);
            @$this->email->subject('Payment Invoice - '.ucwords(str_replace("_"," ",$data['payment']->payment_type))." for ".$data['payment']->semester_id);
            @$this->email->message($html_email_user);
            @$result=$this->email->send();

		   $data['mail_flag']=false;
		   $msg = 'Dear '.$sessdata[0]->first_name.",\n";
				$msg.= "Your Payment ".ucwords(str_replace("_"," ",$data['payment']->payment_type))." for ".$data['payment']->semester_id."  is succcessfully done with payment ID $save[mer_txn]. Please quote this ID for any clearification.";
				send_sms($msg,$sessdata[0]->contact_number);
			}
		   $this->load->view('admin/thankyou_view',$data);
		}
		//unset($_POST);
		} else {
		echo "Invalid Signature";
		}
	}
	function viewProcess(){
		
		    $data['page_title']="Process Details";
			
			$this->load->view('admin/profile/student_page_view',$data);  
		
	}
	function downloadReceipt($transaction_id){
		$sessdata = $this->session->userdata('sms');
		$user_id=$sessdata[0]->id;
		if($this->input->post('submit'))
			$transaction_id = $this->input->post('transaction_id');	
			$data['payment_row']=$this->Payment_model->get_save_payment_by_id($user_id,$transaction_id);
			$data['payment']=$this->Payment_model->get_save_payment_data($transaction_id);
			$data['userinfo']=$this->Payment_model->get_student_details($user_id,$data['payment']->program_id);
			//$data['userinfo']=$this->Payment_model->get_student_details($user_id);
			$data['payment_type']=$data['payment']->payment_type;
			$html=$this->load->view('admin/thankyou_view',$data, true);
			$pdfFilePath = "transaction_history.pdf";
			//load mPDF library
			$this->load->library('m_pdf');
			//generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
		   //download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
			exit;
	}
	

}
?>