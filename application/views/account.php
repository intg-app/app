<?php 
$ContactId = $this->session->userdata('ContactId');
$organizationId = $this->session->userdata('OrganizationId');
$contactSFId = $this->session->userdata('contactSFId');
?>
<link href="<?php echo base_url(); ?>css/account.css" rel="stylesheet" />
<div class="padding">
<div class="full col-sm-9">
	<!--<div class="row">
		<div class="col-md-offset-1 col-md-10">
    	 <div class="well profile">
            <div class="col-sm-12">
                <div class="col-xs-12 col-sm-8">
                    <h3><?php echo $UserDetails->Name; ?></h3>
                    <p>Email:<?php echo $UserDetails->Email; ?></p>
                    <p>Phone:<?php echo $UserDetails->Phone; ?></p>
                    <p>Mobile:<?php echo $UserDetails->Mobile; ?></p>
                    <p>Address:
                        <span class="street"><?php echo $UserDetails->MailingStreet; ?></span> 
                        <span class="city"><?php echo $UserDetails->MailingCity; ?></span>
                        <span class="state"><?php echo $UserDetails->MailingState; ?></span>
                        <span class="country"><?php echo $UserDetails->MailingCountry; ?></span>
                    </p>
                </div>             
                <div class="col-xs-12 col-sm-4 text-center">
                    
                </div>
            </div>            
            <div class="col-xs-12 divider text-center">
                <div class="col-xs-12 col-sm-4 emphasis total">
                    <h2><strong><?php echo getTotalAppointment($contactSFId,$organizationId);?></strong></h2>                    
                    <p><small>Total Appointments</small></p>
                </div>
                <div class="col-xs-12 col-sm-4 emphasis completed">
                    <h2><strong><?php echo getCompletedAppointment($contactSFId,$organizationId);?></strong></h2>                    
                    <p><small>Completed</small></p>
                </div>
                <div class="col-xs-12 col-sm-4 emphasis cancelled">
                    <h2><strong><?php echo getCanceledAppointment($contactSFId,$organizationId);?></strong></h2>                    
                    <p><small>Canceled</small></p>
                </div>
            </div>
    	 </div>                 
		</div>
		<div class="col-md-offset-1 col-md-10 text-center">
			<button type="button" class="btn btn-primary"><span class="fa fa-pencil"></span> Edit Profile</button>
		</div>
	</div>-->
    <div class="row profile">
		<div class="col-md-3">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<img src="<?php echo base_url();?>/images/administrator.png" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						<?php echo $UserDetails->Name; ?>
					</div>
					<div class="profile-usertitle-job">
						<!-- <span class="street"><?php echo $UserDetails->MailingStreet; ?></span> 
                        <span class="city"><?php echo $UserDetails->MailingCity; ?></span>
                        <span class="state"><?php echo $UserDetails->MailingState; ?></span>
                        <span class="country"><?php echo $UserDetails->MailingCountry; ?></span> -->
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS 
				<div class="profile-userbuttons">
					<button type="button" class="btn btn-success btn-sm">Follow</button>
					<button type="button" class="btn btn-danger btn-sm">Message</button>
				</div>
				 END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li class="active">
							<a href="#Overview" aria-controls="Overview" role="tab" data-toggle="tab">
							<i class="glyphicon glyphicon-home"></i>
							Overview </a>
						</li>
						<li>
							<a href="#Settings" aria-controls="Settings" role="tab" data-toggle="tab">
							<i class="glyphicon glyphicon-user"></i>
							Account Settings </a>
						</li>
						<li>
							<a href="#" target="_blank">
							<i class="glyphicon glyphicon-ok"></i>
							Tasks </a>
						</li>
						<li>
							<a href="#">
							<i class="glyphicon glyphicon-flag"></i>
							Help </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>
		<div class="col-md-9">
			<div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="Overview">
			        <div class="profile-content">
			        	 <blockquote>
		                <p><?php echo $UserDetails->Name; ?></p> <small><cite title="Source Title"><span class="street"><?php echo $UserDetails->MailingStreet; ?></span> 
                        <span class="city"><?php echo $UserDetails->MailingCity; ?></span>
                        <span class="state"><?php echo $UserDetails->MailingState; ?></span>
                        <span class="country"><?php echo $UserDetails->MailingCountry; ?></span><i class="glyphicon glyphicon-map-marker"></i></cite></small>
		            </blockquote>
		            <p> <i class="glyphicon glyphicon-envelope"></i> <?php echo $UserDetails->Email; ?>
		                <br
		                /> <i class="glyphicon glyphicon-phont"></i> <?php echo $UserDetails->Phone; ?>
		               </p>
					   <div class="col-xs-12 divider text-center">
		                <div class="col-xs-12 col-sm-4 emphasis total">
		                    <h2><strong><?php echo getTotalAppointment($contactSFId,$organizationId);?></strong></h2>                    
		                    <p><small>Total Appointments</small></p>
		                </div>
		                <div class="col-xs-12 col-sm-4 emphasis completed">
		                    <h2><strong><?php echo getCompletedAppointment($contactSFId,$organizationId);?></strong></h2>                    
		                    <p><small>Completed</small></p>
		                </div>
		                <div class="col-xs-12 col-sm-4 emphasis cancelled">
		                    <h2><strong><?php echo getCanceledAppointment($contactSFId,$organizationId);?></strong></h2>                    
		                    <p><small>Canceled</small></p>
		                </div>
		            </div>
	            </div>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="Settings">
		    	<div class="profile-content">
		    		 <div class="col-xs-12 divider text-center">
		                <div class="col-xs-12 col-sm-4 emphasis total">
		                    <h2><strong><?php echo getTotalAppointment($contactSFId,$organizationId);?></strong></h2>                    
		                    <p><small>Total Appointments</small></p>
		                </div>
		                <div class="col-xs-12 col-sm-4 emphasis completed">
		                    <h2><strong><?php echo getCompletedAppointment($contactSFId,$organizationId);?></strong></h2>                    
		                    <p><small>Completed</small></p>
		                </div>
		                <div class="col-xs-12 col-sm-4 emphasis cancelled">
		                    <h2><strong><?php echo getCanceledAppointment($contactSFId,$organizationId);?></strong></h2>                    
		                    <p><small>Canceled</small></p>
		                </div>
		    	</div>
		    </div>
		   
		  </div>
        
		</div>
	</div>
</div><!-- /col-9 -->
</div><!-- /padding -->
