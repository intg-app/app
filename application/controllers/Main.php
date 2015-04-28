<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require_once(APPPATH . 'libraries/SforcePartnerClient.php');
class Main extends CI_Controller  {

	 function __construct() {
      
        // then execute the parent constructor anyway
        parent::__construct();
		$this->ci =& get_instance();
		  $this->load->helper('url');
		  $this->load->library('session');
		  $this->load->helper('date');
		  $this->load->model('rest_model');
		  $this->load->model('user_model');
    }
	
	public function index()
	{
		$this->sync();
	}
	public function login()
	{
		if(!$this->session->userdata('LoginStatus')){
			if($this->input->post('username') != null){
				$uname= $this->input->post('username');
				$pwd= $this->input->post('password');
				$inputs = array(
					'uname' => $uname,
					'pwd' => $pwd
				);
				
				$result = $this->user_model->validate_userlogin($inputs);
				
				if($result != null){
					//print_r($result);exit;
					$this->session->set_userdata('ContactId',$result->Contact_Id);
					$this->session->set_userdata('OrganizationId',$result->Organization_Id);
					$this->session->set_userdata('LoginStatus',TRUE);
					$OrgDetails = $this->user_model->getOrganizationDetails($result->Organization_Id);
					$contactDetails = $this->user_model->getContactDetails($result->Contact_Id,$result->Organization_Id);
					$this->session->set_userdata('contactSFId',$contactDetails->Salesforce_Id);
					$this->session->set_userdata('Username',$OrgDetails->Integration_Username);
					$this->session->set_userdata('Password',$OrgDetails->Integration_Password);
					$this->session->set_userdata('LoginID',$result->Id);
					$mySforceConnection = new SforcePartnerClient();
			        $mySforceConnection->createConnection(PARTNERWSDL);
			        $mySforceConnection->login($OrgDetails->Integration_Username, $OrgDetails->Integration_Password);
					$mySforceConnection->getLocation();
					$this->session->set_userdata('location',$mySforceConnection->getLocation());
					$this->session->set_userdata('sessionId',$mySforceConnection->getSessionId());
					$this->session->set_userdata('wsdl',PARTNERWSDL);
					redirect('main/home');					
				}else{
					$this->load->view('login');
				}
			}else{
				$this->load->view('login');
		    }
	   }else{
			redirect('main/home');	
	   }
	}
	Public function home(){
		if($this->session->userdata('LoginStatus')){
			$contactId = $this->session->userdata('ContactId');
			$organizationId = $this->session->userdata('OrganizationId');
			$contactSFId = $this->session->userdata('contactSFId');
			$data['UserDetails'] = $this->user_model->getContactDetails($contactId,$organizationId);
			$data['OrgDetails'] = $this->user_model->getContactDetails($contactId,$organizationId);
			$data['appointmentDetails'] = $this->user_model->getAppoitmentDetails($contactSFId,$organizationId);
			$page = array(
				'page_name' => 'home',
				'data' =>$data
			);
			$this->load->view('template',$page);
		}else{
			redirect('main/login');	
		}
	}
	Public function create(){
		if($this->session->userdata('LoginStatus')){
			$contactId = $this->session->userdata('ContactId');
			$organizationId = $this->session->userdata('OrganizationId');
			$data['UserDetails'] = $this->user_model->getContactDetails($contactId,$organizationId);
			$data['OrgDetails'] = $this->user_model->getOrganizationDetails($organizationId);
			$data['serviceDetails'] = $this->user_model->getServiceDetails($contactId,$organizationId);
			$page = array(
				'page_name' => 'appointments',
				'data' =>$data
			);
			$this->load->view('template',$page);
		}else{
			redirect('main/login');	
		}
	}
	Public function reschedule(){
		if($this->session->userdata('LoginStatus')){
			$contactId = $this->session->userdata('ContactId');
			$appId = $this->input->get('Id');
			$organizationId = $this->session->userdata('OrganizationId');
			$data['UserDetails'] = $this->user_model->getContactDetails($contactId,$organizationId);
			$data['OrgDetails'] = $this->user_model->getOrganizationDetails($organizationId);
			$data['app'] = $this->user_model->getServiceRequestDetails($appId,$organizationId);
			$page = array(
					'page_name' => 'reschedule',
					'data' =>$data
			);
	
			$this->load->view('template',$page);
		}else{
			redirect('main/login');
		}
	}
	Public function account(){
		if($this->session->userdata('LoginStatus')){
			$contactId = $this->session->userdata('ContactId');
			$organizationId = $this->session->userdata('OrganizationId');
			$contactSFId = $this->session->userdata('contactSFId');
			$data['UserDetails'] = $this->user_model->getContactDetails($contactId,$organizationId);
			$data['OrgDetails'] = $this->user_model->getContactDetails($contactId,$organizationId);
			
			$page = array(
				'page_name' => 'account',
				'data' =>$data
			);
			//print_r($page);exit;
			$this->load->view('template',$page);
		}else{
			redirect('main/login');	
		}
	}
	Public function appointments(){
		if($this->session->userdata('LoginStatus')){
			$contactId = $this->session->userdata('ContactId');
			$organizationId = $this->session->userdata('OrganizationId');
			$data['UserDetails'] = $this->user_model->getContactDetails($contactId,$organizationId);
			$data['OrgDetails'] = $this->user_model->getContactDetails($contactId,$organizationId);
		
			$page = array(
				'page_name' => 'appointments',
				'data' =>$data
			);
			$this->load->view('template',$page);
		}else{
			redirect('main/login');	
		}
	}
	Public function logout()
	{
		
		$sess_array = $this->session->all_userdata();
		foreach($sess_array as $key =>$val){
			if($key!='session_id'
					&& $key!='last_activity'
					&& $key!='ip_address'
					&& $key!='user_agent'
					&& $key!='RESERVER_KEY_HERE')$this->session->unset_userdata($key);
		}
		$this->session->sess_destroy();
		$this->session->set_userdata('LoginStatus',FALSE);
		redirect('main/login');
	}
	Public function sync()
	{
		//echo $this->session->userdata('serviceid');exit;
		//if($this->session->userdata('sessionId')=='')
		//{
		$mySforceConnection = new SforcePartnerClient();
		
        $mySforceConnection->createConnection(PARTNERWSDL);
        $mySforceConnection->login('ramesh.k@bksl.com.dev', '#KS726san');
		$mySforceConnection->getLocation();
		//$query = "SELECT Id,Name FROM Contact";
		//$response = $mySforceConnection->query($query);
		//print_r($response);exit;
		$this->session->set_userdata('location',$mySforceConnection->getLocation());
		$this->session->set_userdata('sessionId',$mySforceConnection->getSessionId());
		$this->session->set_userdata('wsdl',PARTNERWSDL);
		$this->rest_model->SyncContacts();
		$this->rest_model->SyncService();
		$this->rest_model->SyncExpert();
		$this->rest_model->SyncExpertService();
		//}else{
			
		//}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */