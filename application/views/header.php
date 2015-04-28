<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Booking Social</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo  base_url(); ?>css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo  base_url(); ?>css/styles.css" rel="stylesheet">
    <link href="<?php echo  base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
	<script src="<?php echo  base_url(); ?>js/jquery.js"></script>
  </head>

  <body>
  <?php
  	$homeClass='';
  	$createClass='';
  	$profileClass='';
 	if($pagename == 'home')
 		$homeClass='active';
 	else if($pagename == 'appointments')
 		$createClass='active';
 	else if($pagename == 'account')
 		$profileClass='active';
?>
<div class="wrapper">
    <div class="box">
        <div class="row row-offcanvas row-offcanvas-left">
            <!-- sidebar -->
            <div class="column col-sm-1 col-xs-1 sidebar-offcanvas" id="sidebar">
              	<div class="nav hidden-xs">
          			<img style="width: 85%;" src="<?php echo base_url(); ?>images/logo_dark_bg_200.png"/>
            	</div>
               <br class="hidden-xs"/>
			   <br class="visible-xs"/>
			   <br class="visible-xs"/>
                <ul class="nav hidden-xs" id="lg-menu">
                    <li class="<?php echo $homeClass;?> text-center" ><a href="<?php echo  base_url(); ?>main/home"><i class="glyphicon glyphicon-calendar fa-2x"></i><br/>Appointments</a></li>
                    <li class="<?php echo $createClass;?> text-center"><a href="<?php echo  base_url(); ?>main/create"><i class="fa fa-plus fa-2x"></i><br/>Create</a></li>
                    <li class="<?php echo $profileClass;?> text-center"><a href="<?php echo  base_url(); ?>main/account"><i class="fa fa-user fa-2x"></i><br/>Profile</a></li>
                    <li class="text-center"><a href="#"><i class="glyphicon glyphicon-refresh fa-2x"></i><br/>Refresh</a></li>
                </ul>
              	<!-- tiny only nav-->
              <ul class="nav visible-xs" id="xs-menu">
                  	<li class="<?php echo $homeClass;?>"><a href="<?php echo  base_url(); ?>main/home" class="text-center"><i class="glyphicon glyphicon-calendar"></i></a></li>
                    <li class="<?php echo $createClass;?>"><a href="<?php echo  base_url(); ?>main/create" class="text-center"><i class="fa fa-plus"></i></a></li>
                  	<li class="<?php echo $profileClass;?>"><a href="<?php echo  base_url(); ?>main/account" class="text-center"><i class="fa fa-user"></i></a></li>
                    <li ><a href="#" class="text-center"><i class="glyphicon glyphicon-refresh"></i></a></li>
                </ul>
              
            </div>
            <!-- /sidebar -->
          
            <!-- main right col -->
            <div class="column col-sm-11 col-xs-11" id="main">
                
                <!-- top nav -->
              	<div class="navbar navbar-blue navbar-static-top text-center">  
                    <div class="navbar-header">
					  <a href="<?php echo base_url(); ?>main/createAppointment" class="navbar-toggle"><i class="fa fa-plus"></i></a>
					  <span class="headertitle visible-xs"><img  style="float: left;padding: 10px 12px 0px 12px;width: 100px;" src="<?php echo base_url(); ?>images/logo_dark_bg_200.png"/></span>
					  
                      <a href="<?php echo base_url(); ?>main/createAppointment" class="navbar-brand logo hidden-xs"><i class="fa fa-plus"></i></a>
                  	</div>
					<span class="headertitle hidden-xs">Appointment</span>
                    <ul class="nav navbar-nav navbar-right hidden-xs">
					  <li style="line-height: 3.5;"><?php echo $UserDetails->Name; ?></li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i></a>
                        <ul class="dropdown-menu">
                          <li><a href="<?php echo base_url();?>main/account">Settings</a></li>
                          <li><a href="<?php echo base_url();?>main/logout">Logout</a></li>
                        </ul>
                      </li>
                    </ul>
                </div>
                <!-- /top nav -->
              
           