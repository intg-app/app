<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'libraries/SforcePartnerClient.php');
class User_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
	}
    function validate_userlogin($inputs){
		$this->db->select('Username, Password,Id, Email,Organization_Id,Contact_Id');
		$this->db->from('users');
		$this->db->where('Username', $inputs['uname']);
		$this->db->where('Password', $inputs['pwd']);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	function getContactDetails($ContactId,$organizationId){	
		$this->db->select('Id,Organization_Id,Name,Salesforce_Id,Email,Phone,FirstName,LastName,Salutation,Mobile,MailingCity,MailingCountry,MailingPostalCode,MailingState,MailingStreet,Critical_Notification,Description	');
		$this->db->from('contacts');
		$this->db->where('Id', $ContactId);
		$this->db->where('Organization_Id', $organizationId);
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->row();
	}
	function getAppoitmentDetails($ContactId,$organizationId){
		$this->db->select('*');
		$this->db->from('appointments');
		$this->db->where('Organization_Id', $organizationId);
		$this->db->where('Contact_Id', $ContactId);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result();
	}
	function getOrganizationDetails($organizationId){
		$this->db->select('*');
		$this->db->from('organization');
		$this->db->where('Salesforce_Id', $organizationId);
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->row();
	}
	function getServiceRequestDetails($appId,$organizationId){
		$this->db->select('*');
		$this->db->from('appointments');
		$this->db->where(array('Id' => $appId,'Organization_Id' => $organizationId));
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->row();
	}
	function getExpertDetails($ContactId,$organizationId){	
		$this->db->select('*');
		$this->db->from('experts');
		$this->db->where('Organization_Id', $organizationId);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result();
	}
	function getServiceDetails($ContactId,$organizationId){	
		$this->db->select('*');
		$this->db->from('services');
		$this->db->where('Organization_Id', $organizationId);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result();
	}
    function getExpertByService($ServiceId,$organizationId){	
		$this->db->select('*');
		$this->db->from('expert_service');
		$this->db->where('Organization_Id', $organizationId);
		$this->db->where('Service_Id', $ServiceId);
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->result();
	}
}
?>