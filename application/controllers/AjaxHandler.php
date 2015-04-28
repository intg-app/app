<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AjaxHandler extends CI_Controller  {

	 function __construct() {
      
        // then execute the parent constructor anyway
        parent::__construct();
		$this->ci =& get_instance();
		  $this->load->helper('url');
		  $this->load->helper('xml');
		  $this->load->library('session');
		  $this->load->model('rest_model');
		  $this->load->model('user_model');
    }
	public function getExpertsByService()
	{
		$service_Id = $this->input->get('service');
		$result = $this->user_model->getExpertByService($service_Id);
		echo json_encode($result);		
	}
	
	Public function getServiceAvailability(){
		$service_Id = $this->input->get('service');
		$provider_Id = $this->input->get('provider');
		//print_r($this->input->get());exit;
		$response = $this->rest_model->getServiceAvailability($service_Id,$provider_Id);
		echo json_encode($response);
	}

	Public function bookAppointment(){
		//print_r($this->input->post());exit;
		$inputArray = $this->input->post();
		$Contact_Id = $this->session->userdata('ContactId');
		$Organization_Id = $this->session->userdata('OrganizationId');
		$contactDetails = $this->user_model->getContactDetails($Contact_Id,$Organization_Id);
		$response = $this->rest_model->bookAppointment($inputArray,$contactDetails);
	 	print_r($response);exit;
		echo json_encode($response);
	}
	Public function rescheduleAppointment(){
		//print_r($this->input->post());exit;
		$inputArray = $this->input->post();
		$Contact_Id = $this->session->userdata('ContactId');
		$Organization_Id = $this->session->userdata('OrganizationId');
		$contactDetails = $this->user_model->getContactDetails($Contact_Id,$Organization_Id);
		$response = $this->rest_model->rescheduleAppointment($inputArray,$contactDetails);
		print_r($response);exit;
		echo json_encode($response);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */