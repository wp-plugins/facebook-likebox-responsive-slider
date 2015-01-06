<div class="wrap">
	<br /><br />
	<h3>Facebook Comment Slider Settings<hr /></h3>
	<?php
	/*
	if (isset($this->action_result)) {?>
	<div class="updated settings-error" id="setting-error-settings_updated"> 
		<p><strong><?php print($this->action_result);?></strong></p>
	</div>
	<?php }*/?>
	<br /><br />
	<div id="facebook_likebox_slider_tabs">
		<ul>
			<li><a href="#facebook_likebox_slider_settings">Settings</a></li>
			<li><a href="#facebook_likebox_slider_comment_box">Comment Box</a></li>
			<li><a href="#facebook_likebox_slider_like_box">Like Box</a></li>
			<li><a href="#facebook_likebox_slider_post_box">Fan Page Wall</a></li>
			<li><a href="#plugin_directory">Plugin Directory</a></li>
			<li><a href="#help">Help</a></li>
		</ul>
	<div id="facebook_likebox_slider_settings">
			<p>    
			This version is add the Like Box to the Home Page only.<br>If you would like to use it on any Page/Post with Comments Box and Fan Page Wall, you can use the <a href="http://sympies.com/facebook-comment-slider/?utm_source=wordpress.org&utm_medium=free%20version&utm_campaign=Facebook%20Like%20Box%20Slider">Pro Version.</a>
			<form method="post" action="options.php#facebook_likebox_slider_settings"> 
					<?php @settings_fields('facebook_likebox_slider-group'); ?>
					<?php @do_settings_fields('facebook_likebox_slider-group'); ?>
					<?php do_settings_sections('facebook_likebox_slider'); ?>
					<?php @submit_button(); ?>
				</form>

			</p>
	</div>
	<div id="facebook_likebox_slider_comment_box">
			<p>    
				<form method="post" action="options.php#facebook_likebox_slider_comment_box"> 
					<?php @settings_fields('facebook_likebox_slider_comment_box-group'); ?>
					<?php @do_settings_fields('facebook_likebox_slider_comment_box-group'); ?>
					<?php do_settings_sections('facebook_likebox_slider_comment_box'); ?>
				</form>
			<div class="pro-version-div">Facebook Comment Box is a Pro Version Feature. <br><a href="http://sympies.com/facebook-comment-slider/?utm_source=wordpress.org&utm_medium=free%20version&utm_campaign=Facebook%20Like%20Box%20Slider">View the Pro Version here.</a></div>
			</p>
	</div>
	<div id="facebook_likebox_slider_like_box">
			<p>
			This version is add the Like Box to the Home Page only.<br>If you would like to use it on any Page/Post with Comments Box and Fan Page Wall, you can use the <a href="http://sympies.com/facebook-comment-slider/?utm_source=wordpress.org&utm_medium=free%20version&utm_campaign=Facebook%20Like%20Box%20Slider">Pro Version.</a><br>Facebook Page Name is required on the <a class="open-tab" href="#facebook_likebox_slider_settings">Settings tab</a>
				<form method="post" action="options.php#facebook_likebox_slider_like_box"> 
					<?php @settings_fields('facebook_likebox_slider_like_box-group'); ?>
					<?php @do_settings_fields('facebook_likebox_slider_like_box-group'); ?>
					<?php do_settings_sections('facebook_likebox_slider_like_box'); ?>
					<?php @submit_button(); ?>
				</form>
			</p>
	</div>
	<div id="facebook_likebox_slider_post_box">
			<p>    
				<form method="post" action="options.php#facebook_likebox_slider_post_box"> 
					<?php @settings_fields('facebook_likebox_slider_post_box-group'); ?>
					<?php @do_settings_fields('facebook_likebox_slider_post_box-group'); ?>
					<?php do_settings_sections('facebook_likebox_slider_post_box'); ?>
				</form>
			</p>
			<div class="pro-version-div">Facebook Fan Page Wall is a Pro Version Feature. <br><a href="http://sympies.com/facebook-comment-slider/?utm_source=wordpress.org&utm_medium=free%20version&utm_campaign=Facebook%20Like%20Box%20Slider">View the Pro Version here.</a></div>
	</div>
		<div id="plugin_directory">
		<p>
			<p>    
			<iframe src="http://sympies.com/static/plugin_directory.html"></iframe>
			</p>
		</p>

		</div>
		<div id="help">
		<p>
			<h3>Help<br /><hr /></h3>
			<p>    
			To see the full documentation, please click on the following link: <a target="_blank" href="<?php print(plugins_url( '/documentation/index.html' , __FILE__ ));?>">Documentation</a>
			</p><br /><br />
			<br /><br />
		</p>
		</div>
	</div>
</div>