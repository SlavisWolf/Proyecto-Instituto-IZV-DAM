<!-- navigation -->
				<nav class="navbar navbar-default">
						<!-- navbar-header -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="<?php echo get_option('Home');?>" class="hvr-underline-from-center active"><?php _e("Home","mi_school");?></a></li>
								<li><a href="<?php echo get_page_link(get_page_by_title('News')->ID); ?>" class="hvr-underline-from-center"><?php _e("News","mi_school");?></a></li>
								<li><a href="<?php echo get_option('Home');?>#servicios" class="hvr-underline-from-center <?php echo is_front_page() ? "scroll" : "" ?>"><?php echo  __("Services","mi_school")?></a></li>
								<li><a href="<?php echo get_option('Home');?>#gallery" class="hvr-underline-from-center <?php echo is_front_page() ? "scroll" : "" ?>"><?php _e("Gallery","mi_school");?></a></li>
								<li><a href="<?php echo get_option('Home');?>#contact" class="hvr-underline-from-center <?php echo is_front_page() ? "scroll" : "" ?>"><?php _e("Contact Us","mi_school");?></a></li>
								<li><a href="<?php echo get_page_link(get_page_by_title('Activities')->ID);?>" class="hvr-underline-from-center"><?php _e("Activities","mi_school");?></a></li>
							</ul>
						</div>
						<div class="clearfix"> </div>	
				</nav>
				
			
	<!-- //navigation -->
