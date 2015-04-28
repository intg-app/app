	 </div>
            <!-- /main -->
        </div>
    </div>
</div>
	<link href="<?php echo  base_url(); ?>css/styles.css" rel="stylesheet">
    <script src="<?php echo  base_url(); ?>js/bootstrap.min.js"></script>
	<script>
		$( document ).ready(function() {
			//$("[rel='tooltip']").tooltip();    
		 
			$('.thumbnail').hover(
				function(){
					$(this).find('.caption').slideDown(250); //.fadeIn(250)
				},
				function(){
					$(this).find('.caption').slideUp(250); //.fadeOut(205)
				}
			); 
		});
	</script>
  </body>
</html>
