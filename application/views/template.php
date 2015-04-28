<?php
	$user['UserDetails'] = $data['UserDetails'];
	$user['pagename'] = $page_name;
	$this->load->view('header',$user);
	$this->load->view($page_name,$data);	
	$this->load->view('footer');

?>