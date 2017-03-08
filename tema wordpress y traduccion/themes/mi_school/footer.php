<!-- footer -->
	<div class="footer" id="footer">
		<div class="container">
			<div class="col-md-4 agileinfo_footer_grid">
				<h4><?php _e("About us","mi_school");?></h4>
				<p><?php _e("We are a public center and our goal is to achieve and ensure the quality of the service we provide to society. We are passionate about our work and equality, solidarity and freedom are some of the axes of our Educational Project.","mi_school")?></p>
			</div>
			<div class="col-md-4 agileinfo_footer_grid mid-w3l nav2">
				
			</div>
			<div class="col-md-4 agileinfo_footer_grid">
				<h4><?php _e("Address","mi_school");?></h4>
				<ul>
					<li><?php _e("Address","mi_school");?> : Calle Primavera, 26-28, 18008 Granada</li>
					<li>E-mail : secretaria.ieszaidinvergeles@gmail.com</li>
					<li><?php _e("Phone Number","mi_school");?> : 958 89 38 50</li>
					<li>Fax : 958 12 89 05</li>
				</ul>
			</div>
			
		</div>
	</div>
	




<!-- js -->
<script type="text/javascript" src="<?php  echo bloginfo('template_directory');?>/inc/js/jquery-2.1.4.min.js"></script>


<script src="<?php  echo bloginfo('template_directory');?>/inc/js/jquery.chocolat.js"></script>
		<!-- <link rel="stylesheet" href="css/chocolat.css" type="text/css" media="screen"> -->
		<!--light-box-files -->
		<script>
		$(function() {
			$('.gallery-grid a').Chocolat();
		});
		</script>
 <!-- required-js-files-->
		
							<!-- <link href="css/owl.carousel.css" rel="stylesheet"> -->
							    <script src="<?php  echo bloginfo('template_directory');?>/inc/js/owl.carousel.js"></script>
							        <script>
							    $(document).ready(function() {
							      $("#owl-demo").owlCarousel({
							        items : 1,
							        lazyLoad : true,
							        autoPlay : true,
							        navigation : false,
							        navigationText :  false,
							        pagination : true,
							      });
							    });
							    </script>
								 <!--//required-js-files-->

<script src="<?php  echo bloginfo('template_directory');?>/inc/js/responsiveslides.min.js"></script>
		<script>
				$(function () {
					$("#slider").responsiveSlides({
						auto: true,
						pager:false,
						nav: true,
						speed: 1000,
						namespace: "callbacks",
						before: function () {
							$('.events').append("<li>before event fired.</li>");
						},
						after: function () {
							$('.events').append("<li>after event fired.</li>");
						}
					});
				});
			</script>
			

<!-- start-smoth-scrolling -->
<script type="text/javascript" src="<?php  echo bloginfo('template_directory');?>/inc/js/move-top.js"></script>
<script type="text/javascript" src="<?php  echo bloginfo('template_directory');?>/inc/js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->

	<!-- bottom-top -->
	<!-- smooth scrolling -->
		<script type="text/javascript">
			$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/								
			$().UItoTop({ easingType: 'easeOutQuart' });
			});
		</script>
		<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	<!-- //smooth scrolling -->
	<!--// bottom-top -->
<script type="text/javascript" src="<?php  echo bloginfo('template_directory');?>/inc/js/bootstrap-3.1.1.min.js"></script>

	
</body>

</html>
<!-- //footer -->