<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getTotalAppointment'))
{
    function getTotalAppointment($ContactId,$organizationId)
    {
			$ci=& get_instance();
			$ci->load->database(); 

			$ci->db->where(array('Contact_Id' => $ContactId,'Organization_Id' => $organizationId));
			return $ci->db->count_all_results('appointments');
    }   
}
if ( ! function_exists('getCompletedAppointment'))
{
    function getCompletedAppointment($ContactId,$organizationId)
    {
			$ci=& get_instance();
			$ci->load->database(); 

			$ci->db->where(array('Contact_Id' => $ContactId,'Organization_Id' => $organizationId));
			$ci->db->where('Status', 'Completed');
			return $ci->db->count_all_results('appointments');
    }   
}
if ( ! function_exists('getCanceledAppointment'))
{
    function getCanceledAppointment($ContactId,$organizationId)
    {
			$ci=& get_instance();
			$ci->load->database(); 

			$ci->db->where(array('Contact_Id' => $ContactId,'Organization_Id' => $organizationId));
			$ci->db->where('Status', 'Canceled');
			$ci->db->where('Status', 'Cancelled');
			return $ci->db->count_all_results('appointments');
    }   
}