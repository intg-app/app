<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>Booking Social</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>css/login.css" rel="stylesheet" />

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
	  <!-- <div id="login-page">
	  	<div class="container ">
			<div class="col-md-6 col-md-offset-3">
		      <form class="form-login" action="<?php echo  base_url('main/login'); ?>" method="POST">
		        <h2 class="form-login-heading">Login</h2>
		        <div class="login-wrap">
		            <input type="text" name="username" class="form-control" placeholder="User name" autofocus>
		            <br>
		            <input type="password" name="password" class="form-control" placeholder="Password">
					<br>
		            <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i>Enter</button>
		        </div>
		      </form>	  	
		  </div>
	  	</div>
	  </div>
	<div id="fullscreen_bg" class="fullscreen_bg"/>
	
	<div class="container text-center">
	
		<form class="form-signin" action="<?php echo  base_url('main/login'); ?>" method="POST">
			<h1 class="form-signin-heading text-muted"><img src="<?php echo base_url(); ?>images/logo_white_bg_200.png" /></h1>
		
			<input type="text" class="form-control" placeholder="Username" name="username" required="" autofocus="">
			<input type="password" class="form-control" name="password" placeholder="Password" required="">
			<br/>
			
			<button class="btn btn-lg btn-primary btn-block" type="submit">
				Log In
			</button>
		</form>
		<p style="Color:#FFF;">Email: support@bookingsocial.com &copy 2015 Booking Social</p>
	</div>-->
	<div class="container">
	    <div class="row">
	        <div class="col-sm-6 col-md-4 col-md-offset-4">
	            <div class="account-wall">
	                <h2 class="text-center">
	                	<img src="<?php echo base_url(); ?>images/logo_white_bg_200.png" alt="">
	               	</h2>
	                <form class="form-signin" action="<?php echo  base_url('main/login'); ?>" method="POST">
	                <input type="text" class="form-control" placeholder="Username" name="username" required autofocus>
	                <input type="password" class="form-control" placeholder="Password" required name="password" >
	                <button class="btn btn-lg btn-primary btn-block" type="submit">
	                    Log In</button>
	        
	                <a href="#" class="pull-right need-help">Forget Password/Username</a><span class="clearfix"></span>
	                </form>
	            </div>
				<p style="Color:#FFF;">support@bookingsocial.com &copy 2015 Booking Social</p>
	            	        </div>
	    </div>
	</div>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
  </body>
</html>
