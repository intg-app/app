<div class="padding">
<div class="full col-sm-9">
	<h4 style="margin-bottom: 0px;"><span style="border-bottom: 2px solid #7D8E9E;">Current Appointment</span></h4>
	<hr/>
	<div id="CurrentAppointment">
		<div class="row">
			<div class="col-md-12">
				<?php 
				
				//print_r($appointmentDetails);exit;
				foreach ($appointmentDetails as $app): ?>
				 <?php 
				//echo $app->Start_Date;
				//echo date();
				if(mysql_to_unix($app->Start_Date) > mysql_to_unix(time())){
				
					$datestring = "%l,%M %d";
					$timestring = "at %h:%i %A";
					$time = strtotime($app->Start_Date); // Get the current timestamps
					
					// Assign the formatted date to variable so that we can use it to
					// our view file. We can use it on our view as $current_date
					//echo mdate($datestring, $time);exit;
					?>
				<div class="well well-sm">
					<div class="row">
						<div class="col-sm-5">
							<h5 class="appointmentName"><?=$app->Name;?></h5>
							<p class="appointmentType help-text">New Test</p>
						</div>
						<div class="col-sm-3">
							<p></p>
							<div class="well well-xs thumbnail" style="margin-bottom:0;">
								 <div class="caption">
									<p>
									<a href="<?=base_url().'main/reschedule?Id='.$app->Id;?>" class="btn btn-sm btn-default" rel="tooltip" title="Modify"><i class="fa fa-pencil"></i> Modify</a>
									<a href="<?=base_url().'main/cancel?Id='.$app->Id;?>" class="btn btn-sm btn-default" rel="tooltip" title="Cancel"><i class="fa fa-times"></i> Cancel</a>
									</p>
								</div>
								<div class="row">
									<div class="col-xs-2" ><i class="fa fa-clock-o" style="font-size: 2.7em;"></i></div>
									<div class="col-xs-1"></div>
									<div class="col-xs-9" style="font-size: 12px;"><span><?=mdate($datestring, $time)?><span style="display: block;"><?=mdate($timestring, $time)?></span></span></div>
								</div>
							</div>
						</div>
						<div class="col-sm-4 text-center" >
							<p></p>
							<a href="<?=base_url().'main/view/'.$app->Id;?>" class="btn btn-info" >View</a>
							<p></p>
						</div>
					</div>
				</div>
				<?php }?>
			  <?php endforeach; ?>
			</div>
		</div>
	</div>	
	<h4 style="margin-bottom: 0px;"><span style="border-bottom: 2px solid #7D8E9E;">Past Appointment</span></h4>
	<hr/>
	<div id="PastAppointment">
		<div class="row">
			<div class="col-md-12">
				<?php 
				//print_r($appointmentDetails);exit;
				foreach ($appointmentDetails as $app): ?>
				 <?php 
				//echo $app->Start_Date;
				//echo date();
				if(mysql_to_unix($app->Start_Date) < mysql_to_unix(time())){
				
					$datestring = "%l,%M %d";
					$timestring = "at %h:%i %A";
					$time = strtotime($app->Start_Date); // Get the current timestamps
					
					// Assign the formatted date to variable so that we can use it to
					// our view file. We can use it on our view as $current_date
					//echo mdate($datestring, $time);exit;
					?>
				<div class="well well-sm">
					<div class="row">
						<div class="col-sm-5">
							<h5 class="appointmentName"><?=$app->Name;?></h5>
							<p class="appointmentType help-text">New Test</p>
						</div>
						<div class="col-sm-3">
							<p></p>
							<div class="well well-xs thumbnail" style="margin-bottom:0;">
								 <div class="caption">
									<p>
									<a href="" class="btn btn-sm btn-default" rel="tooltip" title="Modify"><i class="fa fa-pencil"></i> Modify</a>
									<a href="" class="btn btn-sm btn-default" rel="tooltip" title="Cancel"><i class="fa fa-times"></i> Cancel</a>
									</p>
								</div>
								<div class="row">
									<div class="col-xs-2" ><i class="fa fa-clock-o" style="font-size: 2.7em;"></i></div>
									<div class="col-xs-1"></div>
									<div class="col-xs-9" style="font-size: 12px;"><span><?=mdate($datestring, $time)?><span style="display: block;"><?=mdate($timestring, $time)?></span></span></div>
								</div>
							</div>
						</div>
						<div class="col-sm-4 text-center" >
							<p></p>
							<button class="btn btn-info" >View</button>
							<p></p>
						</div>
					</div>
				</div>
				<?php }?>
			  <?php endforeach; ?>
			</div>
		</div>
	</div>	
</div><!-- /col-9 -->
</div><!-- /padding -->