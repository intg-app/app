<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'libraries/SforcePartnerClient.php');
require_once (APPPATH . 'libraries/SforceHeaderOptions.php');

class Rest_model extends CI_Model {

  
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
	}
    

  function getServiceAvailability($service_Id,$provider_Id){
		ini_set("soap.wsdl_cache_enabled", "0");

		$sfdc = new SforcePartnerClient();

		$SoapClient = $sfdc->createConnection(PARTNERWSDL); 
		$location = $this->session->userdata('location');
		$sessionId = $this->session->userdata('sessionId');
		$loginResult = false; 
		//$loginResult = $sfdc->login($userName, '#KS726san');
		$parsedURL = parse_url($location); 

		define ("_SFDC_SERVER_", substr($parsedURL['host'],0,strpos($parsedURL['host'], '.'))); 
		define ("_WS_NAME_", 'SETUP_Organization_WS'); 
		define ("_WS_WSDL_", BKSL2WEBSERVICE); 
		define ("_WS_ENDPOINT_", 'https://' . _SFDC_SERVER_ . '.salesforce.com/services/wsdl/class/BKSL2/' . _WS_NAME_); 
		define ("_WS_NAMESPACE_", 'http://soap.sforce.com/schemas/class/BKSL2/' . _WS_NAME_);  

		$client = new SoapClient(_WS_WSDL_); 
		$sforce_header = new SoapHeader(_WS_NAMESPACE_, "SessionHeader", array("sessionId" => $sessionId)); 
		$client->__setSoapHeaders(array($sforce_header));
				
		// Setup data to send into the web service
		$requestArray = array();
		$requestArray[] = array('key'=>'SELECTEDSERVICE','value'=>$service_Id ,'values' =>array($service_Id));
		$requestArray3  =array();
		$requestArray3[] = array('key'=>'PROVIDER','value'=>$provider_Id);
		$requestArray2 = array('eventType'=> 'WORKINGHOUR','valueMap'=>$requestArray,'BSLMap' => $requestArray3);
		$reqArr = array(
					'request'=>$requestArray2
					);
		
		// Call the web service
		$response = $client->INTF_GetDefaultSchedules_WS($reqArr);
		//$response = $client->__getFunctions();
		//print_r($response->result);
		echo  $response->result->quickResponse;exit;
  }
  function rescheduleAppointment($inputArray,$contactDetails){
  	ini_set("soap.wsdl_cache_enabled", "0");
  
  	$sfdc = new SforcePartnerClient();
  
  	$SoapClient = $sfdc->createConnection(PARTNERWSDL);
  	$location = $this->session->userdata('location');
  	$sessionId = $this->session->userdata('sessionId');
  	$loginResult = false;
  	//$loginResult = $sfdc->login($userName, '#KS726san');
  	$parsedURL = parse_url($location);
  
  	define ("_SFDC_SERVER_", substr($parsedURL['host'],0,strpos($parsedURL['host'], '.')));
  	define ("_WS_NAME_", 'SETUP_Organization_WS');
  	define ("_WS_WSDL_", BKSL2WEBSERVICE);
  	define ("_WS_ENDPOINT_", 'https://' . _SFDC_SERVER_ . '.salesforce.com/services/wsdl/class/BKSL2/' . _WS_NAME_);
  	define ("_WS_NAMESPACE_", 'http://soap.sforce.com/schemas/class/BKSL2/' . _WS_NAME_);
  
  	$client = new SoapClient(_WS_WSDL_);
  	$sforce_header = new SoapHeader(_WS_NAMESPACE_, "SessionHeader", array("sessionId" => $sessionId));
  	$client->__setSoapHeaders(array($sforce_header));
  	// Setup data to send into the web service
  	//print_r($inputArray);exit;
  	 
  	$requestArray = array();
  	$requestArray[] = array('key'=>'SELECTEDDATE','value'=>$inputArray['SELECTEDDATE']);
  	$requestArray[] = array('key'=>'PROVIDER','value'=>$inputArray['provider']);
  	$requestArray[] = array('key'=>'SELECTEDSLOTS','value'=>$inputArray['slot']);
  	$objContact = array();
  	$objContact['Id'] =  $inputArray['contactId'];
  	//$objContact['Id'] =  'a01280000024OgP';
  	 
  	if($inputArray['ObjType'] == 'CUSTOMER'){
  		$objContact['BKSL2__LastName__c'] = $contactDetails->LastName;
  		$objContact['BKSL2__FirstName__c'] = $contactDetails->FirstName;
  		$objContact['BKSL2__Email__c'] = $contactDetails->Email;
  		$objContact['BKSL2__Phone__c'] = $contactDetails->Phone;
  		$requestArray[] = array('key'=>'CUSTOMER','objCustomer'=>$objContact);
  	}else if($inputArray['ObjType'] == 'CONTACT'){
  		$objContact['LastName'] = $contactDetails->LastName;
  		$objContact['FirstName'] = $contactDetails->FirstName;
  		$objContact['Email'] = $contactDetails->Email;
  		$objContact['Phone'] = $contactDetails->Phone;
  		$requestArray[] = array('key'=>'CONTACT','objContact'=>$objContact);
  	}else if ($inputArray['ObjType'] = 'LEAD'){
  		$objContact['LastName'] = $contactDetails->LastName;
  		$objContact['FirstName'] = $contactDetails->FirstName;
  		$objContact['Email'] = $contactDetails->Email;
  		$objContact['MobilePhone'] = $contactDetails->Phone;
  		$requestArray[] = array('key'=>'LEAD','objLead'=>$objContact);
  		 
  	}
  	$objServiceRequest['Name'] = $inputArray['serviceName'];
  	$objServiceRequest['BKSL2__Service__c'] = $inputArray['serviceId'];
  	//$objServiceRequest['Id'] = $inputArray['srqId'];
  	$objServiceRequest['BKSL2__Status__c'] = $inputArray['appointmentStatus'];
  	$requestArray[] = array('key'=>'RESCHEDULESERVICEREQUEST','value'=>$inputArray['srqId']);
  	$requestArray[] = array('key'=>'SERVICEREQUEST','objServiceRequest'=>$objServiceRequest);
  	/* 	 $requestArray3  =array();
  	 $requestArray3[] = array('key'=>'PROVIDER','value'=>$provider_Id); */
  	$requestArray2 = array('valueMap'=>$requestArray);
  	$reqArr = array(
  			'request'=>$requestArray2
  	);
  	$slotArr =(array)explode("_",$inputArray['slot']);
  	$slotArr = json_decode(json_encode($slotArr),TRUE);
  	//print_r($slotArr[0]);exit;
  	$start = "".$inputArray['dateString']." ".$slotArr[0].":".$slotArr[1].":00";
  	$end = "".$inputArray['dateString']." ".$slotArr[2].":".$slotArr[3].":00";
  	//print_r($start);exit;
  	// Call the web service
  	$response = $client->INTF_BookAppointment_WS($reqArr);
  	//$response = $client->__getFunctions();
  	//print_r($response);exit;
  	$organizationId = $this->session->userdata('OrganizationId');
  	if($response->result->success){
  		$data =array(
  				'Salesforce_Id' => $response->result->quickResponse,
  				'Name' =>$inputArray['serviceName'],
  				'Organization_Id ' => $organizationId,
  				'Contact_Id' => $inputArray['contactId'],
  				'Service_Id' => $inputArray['serviceId'],
  				'Start_Date' => date('Y-m-d H:i:s', strtotime($start)),
  				'End_Date' => date('Y-m-d H:i:s', strtotime($end)),
  				'Status' => $inputArray['appointmentStatus'],
  				'Provider' => $inputArray['provider']
  		);
  		$this->db->where(' Id', $inputArray['Id']);
  		$this->db->update('appointments', $data);
  	}
  	echo  json_encode($response->result->quickResponse);
  }
  function bookAppointment($inputArray,$contactDetails){
  	ini_set("soap.wsdl_cache_enabled", "0");
  
  	$sfdc = new SforcePartnerClient();
  
  	$SoapClient = $sfdc->createConnection(PARTNERWSDL);
  	$location = $this->session->userdata('location');
  	$sessionId = $this->session->userdata('sessionId');
  	$loginResult = false;
  	//$loginResult = $sfdc->login($userName, '#KS726san');
  	$parsedURL = parse_url($location);
  
  	define ("_SFDC_SERVER_", substr($parsedURL['host'],0,strpos($parsedURL['host'], '.')));
  	define ("_WS_NAME_", 'SETUP_Organization_WS');
  	define ("_WS_WSDL_", BKSL2WEBSERVICE);
  	define ("_WS_ENDPOINT_", 'https://' . _SFDC_SERVER_ . '.salesforce.com/services/wsdl/class/BKSL2/' . _WS_NAME_);
  	define ("_WS_NAMESPACE_", 'http://soap.sforce.com/schemas/class/BKSL2/' . _WS_NAME_);
  
  	$client = new SoapClient(_WS_WSDL_);
  	$sforce_header = new SoapHeader(_WS_NAMESPACE_, "SessionHeader", array("sessionId" => $sessionId));
  	$client->__setSoapHeaders(array($sforce_header));
  	// Setup data to send into the web service
  	//print_r($inputArray);exit;
  	
  	$requestArray = array();
  	$requestArray[] = array('key'=>'SELECTEDDATE','value'=>$inputArray['SELECTEDDATE']);
  	$requestArray[] = array('key'=>'SELECTEDSERVICE','value'=>$inputArray['serviceId'] );
  	$requestArray[] = array('key'=>'PROVIDER','value'=>$inputArray['provider']);
  	$requestArray[] = array('key'=>'SELECTEDSLOTS','value'=>$inputArray['slot']);
  	$requestArray[] = array('key'=>'FINDEXISTINGCUSTOMER','value'=>TRUE);
  	$objContact = array();
  	//$objContact['Id'] =  $inputArray['contactId']; 
  	//$objContact['Id'] =  'a01280000024OgP';
  	
  	if($inputArray['ObjType'] == 'CUSTOMER'){
  		$objContact['BKSL2__LastName__c'] = $contactDetails->LastName;
  		$objContact['BKSL2__FirstName__c'] = $contactDetails->FirstName;
  		$objContact['BKSL2__Email__c'] = $contactDetails->Email;
  		$objContact['BKSL2__Phone__c'] = $contactDetails->Phone;
  		$requestArray[] = array('key'=>'CUSTOMER','objCustomer'=>$objContact);
  	}else if($inputArray['ObjType'] == 'CONTACT'){
  		$objContact['LastName'] = $contactDetails->LastName;
  		$objContact['FirstName'] = $contactDetails->FirstName;
  		$objContact['Email'] = $contactDetails->Email;
  		$objContact['Phone'] = $contactDetails->Phone;
  		$requestArray[] = array('key'=>'CONTACT','objContact'=>$objContact);
  	}else if ($inputArray['ObjType'] = 'LEAD'){
  		$objContact['LastName'] = $contactDetails->LastName;
  		$objContact['FirstName'] = $contactDetails->FirstName;
  		$objContact['Email'] = $contactDetails->Email;
  		$objContact['MobilePhone'] = $contactDetails->Phone;
  		$requestArray[] = array('key'=>'LEAD','objLead'=>$objContact);
  	
  	}
  	$objServiceRequest['Name'] = $inputArray['serviceName'];
  	$objServiceRequest['BKSL2__Service__c'] = $inputArray['serviceId'];
  	$objServiceRequest['BKSL2__Status__c'] = $inputArray['appointmentStatus'];
  	
  	$requestArray[] = array('key'=>'SERVICEREQUEST','objServiceRequest'=>$objServiceRequest);
	/* 	 $requestArray3  =array();
		  	$requestArray3[] = array('key'=>'PROVIDER','value'=>$provider_Id); */
  	$requestArray2 = array('valueMap'=>$requestArray);
  	$reqArr = array(
  			'request'=>$requestArray2
  	);
  	$slotArr =(array)explode("_",$inputArray['slot']);
  	$slotArr = json_decode(json_encode($slotArr),TRUE);
  	//print_r($slotArr[0]);exit;
  	$start = "".$inputArray['dateString']." ".$slotArr[0].":".$slotArr[1].":00";
  	$end = "".$inputArray['dateString']." ".$slotArr[2].":".$slotArr[3].":00";
  	//print_r($start);exit;
  	// Call the web service
  	$response = $client->INTF_BookAppointment_WS($reqArr);
  	//$response = $client->__getFunctions();
  	//print_r($response);exit;
  	$organizationId = $this->session->userdata('OrganizationId');
  	if($response->result->success){  		
  		$data =array(
  				'Salesforce_Id' => $response->result->quickResponse,
  				'Name' =>$inputArray['serviceName'],
  				'Organization_Id ' => $organizationId,
  				'Contact_Id' => $inputArray['contactId'],
  				'Service_Id' => $inputArray['serviceId'],
  				'Start_Date' => date('Y-m-d H:i:s', strtotime($start)),
  				'End_Date' => date('Y-m-d H:i:s', strtotime($end)),
  				'Status' => $inputArray['appointmentStatus'],
  				'Provider' => $inputArray['provider']
  		);
  		
  		$this->db->insert('appointments', $data);
  	}
  	echo  json_encode($response->result->quickResponse);
  }
  function SyncContacts()
  {
  	$location = $this->session->userdata('location');
  	$sessionId = $this->session->userdata('sessionId');
  	$mySforceConnection = new SforcePartnerClient();
  	$sforceSoapClient = $mySforceConnection->createConnection(PARTNERWSDL);
  	$mySforceConnection->setEndpoint($location);
  	$mySforceConnection->setSessionHeader($sessionId);
  	$query = "SELECT Birthdate,BKSL2__Critical_Notification__c,BKSL2__Facebook_Content__c,BKSL2__Facebook_ID__c,BKSL2__Gender__c,Description,Email,EmailBouncedDate,FirstName,HomePhone,Id,Languages__c,LastName,MailingCity,MailingCountry,MailingPostalCode,MailingState,MailingStreet,MobilePhone,Name,Phone,Title FROM Contact";
  	$response = $mySforceConnection->query($query);
  	$inputs = array();
  	for ($response->rewind(); $response->pointer < $response->size; $response->next()) {
  		$record = $response->current();
  		$data =array(
  				'Name' => $record->fields->Name,
  				'Salesforce_Id' => $record->Id,
  				'Email' => $record->fields->Email,
  				'Mobile' => $record->fields->MobilePhone,
  				'Phone' => $record->fields->Phone,
  				'LastName' => $record->fields->LastName,
  				'FirstName' => $record->fields->FirstName,
  				'MailingCountry' => $record->fields->MailingCountry,
  				'MailingPostalCode' => $record->fields->MailingPostalCode,
  				'MailingCity' => $record->fields->MailingCity,
  				'MailingStreet' => $record->fields->MailingStreet,
  				'Critical_Notification' => $record->fields->BKSL2__Critical_Notification__c,
  				'Description' => $record->fields->Description
  		);
  		array_push($inputs,$data);
  		//print_r($data);
  	}
  	$this->db->insert_batch('contacts', $inputs);
  	//$this->db->update_batch('contacts', $inputs, 'Salesforce_Id');
  	//print_r($response);exit;
  	return $response;
  }
  function SyncService()
  {
  	$location = $this->session->userdata('location');
  	$sessionId = $this->session->userdata('sessionId');
  	$mySforceConnection = new SforcePartnerClient();
  	$sforceSoapClient = $mySforceConnection->createConnection(PARTNERWSDL);
  	$mySforceConnection->setEndpoint($location);
  	$mySforceConnection->setSessionHeader($sessionId);
  	$query = "SELECT BKSL2__Access__c,BKSL2__Active__c,BKSL2__Additional_Information_Fieldset__c,BKSL2__Allow_Waitinglist__c,BKSL2__Assignment_Type__c,BKSL2__Availability_Count__c,BKSL2__Available_On__c,BKSL2__Break_Hours__c,BKSL2__Business_Hours__c,BKSL2__Cost__c,BKSL2__Description__c,BKSL2__Display_Type__c,BKSL2__Duration_Time__c,BKSL2__Duration_Unit__c,BKSL2__Email_Notification_Template__c,BKSL2__Initiate_Expert_Calculation__c,BKSL2__Is_Valid_Service__c,BKSL2__Mode_of_Notification__c,BKSL2__Next_Expert_Starts__c,BKSL2__Next_Preferred_Expert__c,BKSL2__Next_slot_start_after__c,BKSL2__Notification_Frequency__c,BKSL2__Picture__c,BKSL2__Preferred_Expert__c,BKSL2__Provider__c,BKSL2__Recalculate_Service_Expert_Now__c,BKSL2__Service_Calendar_Id__c,BKSL2__Service_Category__c,BKSL2__Service_Grouping_Unit__c,BKSL2__SMS_Confirmation_Template__c,BKSL2__SMS_Notification_Template__c,BKSL2__Working_Hours__c,CreatedById,CreatedDate,Id,IsDeleted,LastActivityDate,LastModifiedById,LastModifiedDate,Name,OwnerId,SystemModstamp FROM BKSL2__Service__c";
  	$response = $mySforceConnection->query($query);
  	$inputs = array();
  	for ($response->rewind(); $response->pointer < $response->size; $response->next()) {
  		$record = $response->current();
  		$data =array(
  				'Name' => $record->fields->Name,
  				'Salesforce_Id' => $record->Id,
  				'Provider' => $record->fields->BKSL2__Provider__c,
  				'DurationTime' => $record->fields->BKSL2__Duration_Unit__c,
  				'DurationUnit' => $record->fields->BKSL2__Duration_Time__c,
  				'DisplayType' => $record->fields->BKSL2__Display_Type__c,
  				'PreferredExpert' => $record->fields->BKSL2__Preferred_Expert__c,
  				'Description' => $record->fields->BKSL2__Description__c
  		);
  		array_push($inputs,$data);
  		//print_r($data);
  	}
  	$this->db->insert_batch('services', $inputs);
  	//$this->db->update_batch('contacts', $inputs, 'Salesforce_Id');
  	//print_r($response);exit;
  	return $response;
  }
  function SyncExpert()
  {
  	$location = $this->session->userdata('location');
  	$sessionId = $this->session->userdata('sessionId');
  	$mySforceConnection = new SforcePartnerClient();
  	$sforceSoapClient = $mySforceConnection->createConnection(PARTNERWSDL);
  	$mySforceConnection->setEndpoint($location);
  	$mySforceConnection->setSessionHeader($sessionId);
  	$query = "SELECT BKSL2__Active__c,BKSL2__Business_Hours__c,BKSL2__Email__c,BKSL2__Is_Call_Notification__c,BKSL2__Is_Email_Notification__c,BKSL2__Is_SMS_Notification__c,BKSL2__Phone__c,BKSL2__Photo__c,BKSL2__Provider__c,BKSL2__Role__c,BKSL2__Salesforce_User__c,BKSL2__Skills__c,BKSL2__Slot_Type__c,BKSL2__Working_Hours__c,CreatedById,CreatedDate,Id,IsDeleted,LastActivityDate,LastModifiedById,LastModifiedDate,Name,OwnerId,SystemModstamp FROM BKSL2__Expert__c";
  	$response = $mySforceConnection->query($query);
  	$inputs = array();
  	for ($response->rewind(); $response->pointer < $response->size; $response->next()) {
  		$record = $response->current();
  		$data =array(
  				'Name' => $record->fields->Name,
  				'Salesforce_Id' => $record->Id,
  				'Provider' => $record->fields->BKSL2__Provider__c,
  				'Email' => $record->fields->BKSL2__Email__c,
  				'Phone' => $record->fields->BKSL2__Phone__c,
  		);
  		array_push($inputs,$data);
  		//print_r($data);
  	}
  	$this->db->insert_batch('experts', $inputs);
  	//$this->db->update_batch('contacts', $inputs, 'Salesforce_Id');
  	//print_r($response);exit;
  	return $response;
  }
  function SyncExpertService()
  {
  	$location = $this->session->userdata('location');
  	$sessionId = $this->session->userdata('sessionId');
  	$mySforceConnection = new SforcePartnerClient();
  	$sforceSoapClient = $mySforceConnection->createConnection(PARTNERWSDL);
  	$mySforceConnection->setEndpoint($location);
  	$mySforceConnection->setSessionHeader($sessionId);
  	$query = "SELECT BKSL2__Description__c,BKSL2__Expert__c,BKSL2__Service__c,CreatedById,CreatedDate,Id,IsDeleted,LastModifiedById,LastModifiedDate,Name,SystemModstamp FROM BKSL2__Expert_Service__c";
  	$response = $mySforceConnection->query($query);
  	$inputs = array();
  	for ($response->rewind(); $response->pointer < $response->size; $response->next()) {
  		$record = $response->current();
  		$data =array(
  				'Name' => $record->fields->Name,
  				'Salesforce_Id' => $record->Id,
  				'Expert_Id' => $record->fields->BKSL2__Expert__c,
  				'Service_Id' => $record->fields->BKSL2__Service__c,
  		);
  		array_push($inputs,$data);
  		//print_r($data);
  	}
  	$this->db->insert_batch('expert_service', $inputs);
  	//$this->db->update_batch('contacts', $inputs, 'Salesforce_Id');
  	//print_r($response);exit;
  	return $response;
  }
}
?>