<?php
if(!class_exists('facebook_likebox_slider_settings'))
{
	class facebook_likebox_slider_settings extends facebook_likebox_slider
	{
	/**
	* Construct the plugin object
	**/
	public function __construct()
	{
		/**
		* include required files
		**/
		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		require_once(ABSPATH.'wp-includes/pluggable.php');
		/**
		* register actions, hook into WP's admin_init action hook
		**/
		add_action('admin_init', array(&$this, 'admin_init'));
		add_action('admin_menu', array(&$this, 'add_menu'));
		}
		/**
		* include custom scripts and style to the admin page
		**/
		function enqueue_admin_custom_scripts_and_styles() {
			wp_enqueue_style('facebook_likebox_slider_style', plugins_url( '/templates/assets/css/facebook_likebox_slider_settings.css' , __FILE__ ));
			wp_enqueue_style('jquery_ui_style', plugins_url( '/templates/assets/css/jquery-ui.css' , __FILE__ ));
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-core',array('jquery'));
			wp_enqueue_script('jquery-ui-tabs',array('jquery-ui-core'));
			wp_enqueue_script('fbcs_admin', plugins_url( '/templates/assets/js/fbcs_admin.js' , __FILE__ ) , array('jquery','jquery-ui-core'),'100017', true);
		}
		/**
		* initialize datas on wp admin
		**/
		public function admin_init()
		{
		$settings_page = '';
			if (isset($_REQUEST['page'])) $settings_page = $_REQUEST['page'];
			if ($settings_page=='facebook_likebox_slider') add_action('admin_head', array(&$this, 'enqueue_admin_custom_scripts_and_styles'));

			// register your custom settings - general settings
			register_setting('facebook_likebox_slider-group', 'setting_appid');
			register_setting('facebook_likebox_slider-group', 'setting_fbsitename');
			register_setting('facebook_likebox_slider-group', 'setting_hide_icon');
			register_setting('facebook_likebox_slider-group', 'setting_lock_screen');
			register_setting('facebook_likebox_slider-group', 'setting_closeable');
			register_setting('facebook_likebox_slider-group', 'setting_timer');
			register_setting('facebook_likebox_slider-group', 'setting_transparency');
			register_setting('facebook_likebox_slider-group', 'setting_display_once_for_same_user');
			register_setting('facebook_likebox_slider-group', 'setting_localization');
			register_setting('facebook_likebox_slider-group', 'setting_scheme');
			register_setting('facebook_likebox_slider-group', 'setting_skin');
			register_setting('facebook_likebox_slider-group', 'setting_hide_alreadyliked');
			register_setting('facebook_likebox_slider-group', 'setting_disable_on_mobile');
			register_setting('facebook_likebox_slider-group', 'setting_keep_settings');
				// add your settings section
				add_settings_section('facebook_likebox_slider-section', '', array(&$this, 'settings_section_facebook_likebox_slider'), 'facebook_likebox_slider');
			// add your setting's fields
			add_settings_field('facebook_likebox_slider-setting_appid', 'Facebook App ID (required)', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_appid', 'field_value' => '', 'other' => 'MAXLENGTH="70" size="70"'));
			add_settings_field('facebook_likebox_slider-setting_fbsitename', 'Facebook Page Name (required)', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_fbsitename', 'field_value' => '', 'other' => 'MAXLENGTH="70" size="48" placeholder="eg.: sympies"'));
			add_settings_field('facebook_likebox_slider-setting_hide_icon', 'Hide icon', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_hide_icon', 'field_value' => '', 'options' => array("On"=>"on","Off"=>"off"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_lock_screen', 'Lock screen', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_lock_screen', 'field_value' => '', 'options' => array("On"=>"on","Off"=>"off"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_closeable', 'User can close the slider', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_closeable', 'field_value' => '', 'options' => array("On"=>"on","Off"=>"off"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_timer', 'Timer (in seconds)', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_timer', 'field_value' => '', 'other' => 'onkeyup="this.value = this.value.replace(/[^0-9\s]/g, \'\');" MAXLENGTH="3" size="3"'));
			add_settings_field('facebook_likebox_slider-setting_transparency', 'Transparency (percentage)', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_transparency', 'field_value' => '', 'other' => 'onkeyup="this.value = this.value.replace(/[^0-9\s]/g, \'\');" MAXLENGTH="3" size="3"'));
			add_settings_field('facebook_likebox_slider-setting_display_once_for_same_user', 'Display once per user', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_display_once_for_same_user', 'field_value' => '', 'options' => array("On"=>"on","Off"=>"off"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_localization', 'Language', array(&$this, 'settings_field_input_select'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_localization', 'field_value' => '', 'other' => 'localization'));
			add_settings_field('facebook_likebox_slider-setting_scheme', 'Style', array(&$this, 'settings_field_input_select'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_scheme', 'field_value' => '', 'other' => 'scheme'));
			add_settings_field('facebook_likebox_slider-setting_skin', 'Skin', array(&$this, 'settings_field_input_select'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_skin', 'field_value' => '', 'other' => 'skin'));
			add_settings_field('facebook_likebox_slider-setting_disable_on_mobile', 'Disable on mobile', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_disable_on_mobile', 'field_value' => '', 'options' => array("On"=>"on","Off"=>"off"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_hide_alreadyliked', 'Hide Likebox for already Liked', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_hide_alreadyliked', 'field_value' => '', 'options' => array("On"=>"on","Off"=>"off"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_keep_settings', 'Keep Settings', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider', 'facebook_likebox_slider-section', array('field' => 'setting_keep_settings', 'field_value' => '', 'options' => array("On"=>"on","Off"=>"off"), 'other' => ''));
						
			// register your custom settings - comment box settings
			register_setting('facebook_likebox_slider_comment_box-group', 'setting_vertical_distance1');
			register_setting('facebook_likebox_slider_comment_box-group', 'setting_icon_size1');
			register_setting('facebook_likebox_slider_comment_box-group', 'setting_auto_open1');
			register_setting('facebook_likebox_slider_comment_box-group', 'setting_message');
			register_setting('facebook_likebox_slider_comment_box-group', 'setting_direction1');
			register_setting('facebook_likebox_slider_comment_box-group', 'setting_specified_page1');
			register_setting('facebook_likebox_slider_comment_box-group', 'setting_no_post_to_show');
			register_setting('facebook_likebox_slider_comment_box-group', 'setting_icon_url1');
			register_setting('facebook_likebox_slider_comment_box-group', 'setting_shake1');
				// add your settings section
				add_settings_section('facebook_likebox_slider_comment_box-section', '', array(&$this, 'settings_section_facebook_likebox_slider'), 'facebook_likebox_slider_comment_box');
			add_settings_field('facebook_likebox_slider-setting_vertical_distance1', 'Icon Vertical Distance (5-95 / in percentage)', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider_comment_box', 'facebook_likebox_slider_comment_box-section', array('field' => 'setting_vertical_distance1', 'field_value' => '', 'other' => 'onkeyup="this.value = this.value.replace(/[^0-9\s]/g, \'\'); MAXLENGTH="2" size="5"'));
			add_settings_field('facebook_likebox_slider-setting_icon_size1', 'Icon size', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider_comment_box', 'facebook_likebox_slider_comment_box-section', array('field' => 'setting_icon_size1', 'field_value' => '', 'options' => array("Small"=>"small","Medium"=>"medium","Large"=>"large"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_auto_open1', 'Auto open at bottom of the page', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider_comment_box', 'facebook_likebox_slider_comment_box-section', array('field' => 'setting_auto_open1', 'field_value' => '', 'options' => array("On"=>"on","Off"=>"off"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_message', 'Message for Comment Box', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider_comment_box', 'facebook_likebox_slider_comment_box-section', array('field' => 'setting_message', 'field_value' => '', 'other' => 'MAXLENGTH="70" size="70"'));
			add_settings_field('facebook_likebox_slider-setting_icon_url1', 'Icon url (optional - leave empty for default)', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider_comment_box', 'facebook_likebox_slider_comment_box-section', array('field' => 'setting_icon_url1', 'field_value' => '', 'other' => 'MAXLENGTH="200" size="70"'));
			add_settings_field('facebook_likebox_slider-setting_direction1', 'Direction', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider_comment_box', 'facebook_likebox_slider_comment_box-section', array('field' => 'setting_direction1', 'field_value' => '', 'options' => array("Left"=>"left","Right"=>"right"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_specified_page1', 'Display on', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider_comment_box', 'facebook_likebox_slider_comment_box-section', array('field' => 'setting_specified_page1', 'field_value' => '', 'options' => array("All"=>"all","Posts"=>"posts","Pages"=>"pages","Both"=>"both"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_no_post_to_show', 'Number of posts to display', array(&$this, 'settings_field_input_select'), 'facebook_likebox_slider_comment_box', 'facebook_likebox_slider_comment_box-section', array('field' => 'setting_no_post_to_show', 'field_value' => '', 'min' => 1, 'max' => 6, 'default' => 5, 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_shake1', 'Icon animation', array(&$this, 'settings_field_input_select'), 'facebook_likebox_slider_comment_box', 'facebook_likebox_slider_comment_box-section', array('field' => 'setting_shake1', 'field_value' => '', 'other' => 'shake'));

			// register your custom settings - like box settings
			register_setting('facebook_likebox_slider_like_box-group', 'setting_vertical_distance2');
			register_setting('facebook_likebox_slider_like_box-group', 'setting_icon_size2');
			register_setting('facebook_likebox_slider_like_box-group', 'setting_auto_open2');
			register_setting('facebook_likebox_slider_like_box-group', 'setting_likebox_message');
			register_setting('facebook_likebox_slider_like_box-group', 'setting_direction2');
			register_setting('facebook_likebox_slider_like_box-group', 'setting_icon_url2');
			register_setting('facebook_likebox_slider_like_box-group', 'setting_shake2');
				// add your settings section
				add_settings_section('facebook_likebox_slider_like_box-section', '', array(&$this, 'settings_section_facebook_likebox_slider'), 'facebook_likebox_slider_like_box');
			add_settings_field('facebook_likebox_slider-setting_vertical_distance2', 'Icon Vertical Distance (5-95 / in percentage)', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider_like_box', 'facebook_likebox_slider_like_box-section', array('field' => 'setting_vertical_distance2', 'field_value' => '', 'other' => 'onkeyup="this.value = this.value.replace(/[^0-9\s]/g, \'\'); MAXLENGTH="2" size="5"'));
			add_settings_field('facebook_likebox_slider-setting_icon_size2', 'Icon size', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider_like_box', 'facebook_likebox_slider_like_box-section', array('field' => 'setting_icon_size2', 'field_value' => '', 'options' => array("Small"=>"small","Medium"=>"medium","Large"=>"large"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_auto_open2', 'Auto open at bottom of the page', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider_like_box', 'facebook_likebox_slider_like_box-section', array('field' => 'setting_auto_open2', 'field_value' => '', 'options' => array("On"=>"on","Off"=>"off"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_likebox_message', 'Message for Like Box', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider_like_box', 'facebook_likebox_slider_like_box-section', array('field' => 'setting_likebox_message', 'field_value' => '', 'other' => 'MAXLENGTH="70" size="70"'));
			add_settings_field('facebook_likebox_slider-setting_icon_url2', 'Icon url (optional - leave empty for default)', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider_like_box', 'facebook_likebox_slider_like_box-section', array('field' => 'setting_icon_url2', 'field_value' => '', 'other' => 'MAXLENGTH="200" size="70"'));
			add_settings_field('facebook_likebox_slider-setting_direction2', 'Direction', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider_like_box', 'facebook_likebox_slider_like_box-section', array('field' => 'setting_direction2', 'field_value' => '', 'options' => array("Left"=>"left","Right"=>"right"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_shake2', 'Icon animation', array(&$this, 'settings_field_input_select'), 'facebook_likebox_slider_like_box', 'facebook_likebox_slider_like_box-section', array('field' => 'setting_shake2', 'field_value' => '', 'other' => 'shake'));
			// register your custom settings - post box settings
			register_setting('facebook_likebox_slider_post_box-group', 'setting_vertical_distance3');
			register_setting('facebook_likebox_slider_post_box-group', 'setting_icon_size3');
			register_setting('facebook_likebox_slider_post_box-group', 'setting_auto_open3');
			register_setting('facebook_likebox_slider_post_box-group', 'setting_postbox_message');
			register_setting('facebook_likebox_slider_post_box-group', 'setting_direction3');
			register_setting('facebook_likebox_slider_post_box-group', 'setting_icon_url3');
			register_setting('facebook_likebox_slider_post_box-group', 'setting_shake3');
				// add your settings section
				add_settings_section('facebook_likebox_slider_post_box-section', '', array(&$this, 'settings_section_facebook_likebox_slider'), 'facebook_likebox_slider_post_box');
			add_settings_field('facebook_likebox_slider-setting_vertical_distance3', 'Icon Vertical Distance (5-95 / in percentage)', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider_post_box', 'facebook_likebox_slider_post_box-section', array('field' => 'setting_vertical_distance3', 'field_value' => '', 'other' => 'onkeyup="this.value = this.value.replace(/[^0-9\s]/g, \'\'); MAXLENGTH="2" size="5"'));
			add_settings_field('facebook_likebox_slider-setting_icon_size3', 'Icon size', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider_post_box', 'facebook_likebox_slider_post_box-section', array('field' => 'setting_icon_size3', 'field_value' => '', 'options' => array("Small"=>"small","Medium"=>"medium","Large"=>"large"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_auto_open3', 'Auto open at bottom of the page', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider_post_box', 'facebook_likebox_slider_post_box-section', array('field' => 'setting_auto_open3', 'field_value' => '', 'options' => array("On"=>"on","Off"=>"off"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_postbox_message', 'Message for Wall', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider_post_box', 'facebook_likebox_slider_post_box-section', array('field' => 'setting_postbox_message', 'field_value' => '', 'other' => 'MAXLENGTH="70" size="70"'));
			add_settings_field('facebook_likebox_slider-setting_icon_url3', 'Icon url (optional - leave empty for default)', array(&$this, 'settings_field_input_text'), 'facebook_likebox_slider_post_box', 'facebook_likebox_slider_post_box-section', array('field' => 'setting_icon_url3', 'field_value' => '', 'other' => 'MAXLENGTH="200" size="70"'));
			add_settings_field('facebook_likebox_slider-setting_direction3', 'Direction', array(&$this, 'settings_field_input_radio'), 'facebook_likebox_slider_post_box', 'facebook_likebox_slider_post_box-section', array('field' => 'setting_direction3', 'field_value' => '', 'options' => array("Left"=>"left","Right"=>"right"), 'other' => ''));
			add_settings_field('facebook_likebox_slider-setting_shake3', 'Icon animation', array(&$this, 'settings_field_input_select'), 'facebook_likebox_slider_post_box', 'facebook_likebox_slider_post_box-section', array('field' => 'setting_shake3', 'field_value' => '', 'other' => 'shake'));
			// Possibly do additional admin_init tasks
		}
		/**
		* This function provides special inputs for settings fields
		**/
		public function settings_field_input_special($args)
			{		
			$other = $args['other'];
			$options = $args['options'];
			$key = '';	
			// Get the field name from the $args array or get the value of this setting
			$field = $args['field'];
			if ($args['field_value']) $value = $args['field_value'];
			else $value = get_option($field);
			foreach($options as $key=>$opt) {
			if ($value==$opt OR (!$value AND $opt=="3")) $selected = 'checked="true"';
			else $selected = "";
				if ($key=="Custom") {
				echo sprintf('<input type="radio" name="%s" id="%s%s" '.$selected.' value="%s" /><label for="%s%s"> '.$key.'</label><br />', $field, $field, $opt, $opt, $field, $opt);
				$custom = get_option('setting_style_notification_custom');
				if (!$custom) $custom = '[div onclick="document.location=\'{permalink}\'" id="wpusertracker_notification" class="wpusertracker_notification_{position}" style="color:#FC0303;padding: 10px;"]someone had just start to read: [br /][center][a href="{permalink}"]{post_title}[/a][/center][/div]';
				echo sprintf('<textarea rows="7" cols="60" name="%s_custom" id="%s_custom" />%s</textarea>', $field, $field, $custom);
				}
				else {
				echo sprintf('<input type="radio" name="%s" id="%s%s" '.$selected.' value="%s" /><label for="%s%s"> '.$key.'</label><br />', $field, $field, $opt, $opt, $field, $opt);
				}
			}
		}
		/**
		* This function provides radio inputs for settings fields
		**/
        public function settings_field_input_radio($args)
        {
			$key = '';
             $other = $args['other'];
            $options = $args['options'];
 			// Get the field name from the $args array or get the value of this setting
			$field = $args['field'];
			if ($args['field_value']) $value = $args['field_value'];
			else $value = get_option($field);
            // echo a proper input type="radio"
			foreach($options as $key=>$opt) 
			{
				if ($value==$opt OR (!$value AND $opt=="off")) $selected = 'checked="true"';
				else $selected = "";
				echo sprintf('<input type="radio" name="%s" id="%s%s" '.$selected.' value="%s" /> <label for="%s%s"> '.$key.'</label> ', $field, $field, $opt, $opt, $field, $opt);
			}
		}
		/**
		* This function provides text inputs for settings fields
		**/
		public function settings_field_input_text($args)
		{
			$other = $args['other'];
			// Get the field name from the $args array or get the value of this setting
			$field = $args['field'];
			if ($args['field_value']) $value = $args['field_value'];
			else $value = get_option($field);
			// echo a proper input type="text"
			if ($field == 'setting_fbsitename') print('<span style="margin-top:5px;">http://facebook.com/</span>');
			if (!empty($other)) echo sprintf('<input type="text" name="%s" id="%s" value="%s" %s />', $field, $field, $value, $other);
			else echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
		}
		/**
		* This function provides textarea inputs for settings fields
		**/
		public function settings_field_input_textarea($args)
		{
			$other = $args['other'];
			// Get the field name from the $args array or get the value of this setting
			$field = $args['field'];
			if ($args['field_value']) $value = $args['field_value'];
			else $value = get_option($field);
			// echo a proper input type="textarea"
			if (!empty($other)) echo sprintf('<textarea name="%s" id="%s" %s />%s</textarea>', $field, $field, $other, $value);
			else echo sprintf('<textarea name="%s" id="%s" />%s</textarea>', $field, $field, $value);
		}
		/**
		* This function provides select inputs for settings fields
		**/
		public function settings_field_input_select($args)
		{
			// Get the field name from the $args array or get the value of this setting
			$field = $args['field'];
			if ($args['field_value']) $value = $args['field_value'];
			else $value = get_option($field);
			if (!$value) $value = 'en_US';
			if ($args['other']=='localization')
			{
				$languages = Array
				("Afrikaans" => af_ZA,
					"Albanian" => sq_AL,
					"Arabic" => ar_AR,
					"Armenian" => hy_AM,
					"Azerbaijani" => az_AZ,
					"Basque" => eu_ES,
					"Belarusian" => be_BY,
					"Bengali" => bn_IN,
					"Bosnian" => bs_BA,
					"Bulgarian" => bg_BG,
					"Catalan" => ca_ES,
					"Cebuano" => cx_PH,
					"Croatian" => hr_HR,
					"Czech" => cs_CZ,
					"Danish" => da_DK,
					"Dutch" => nl_NL,
					"English (Pirate)" => en_PI,
					"English (UK)" => en_GB,
					"English (US)" => en_US,
					"English (Upside Down)" => en_UD,
					"Esperanto" => eo_EO,
					"Estonian" => et_EE,
					"Faroese" => fo_FO,
					"Filipino" => tl_PH,
					"Finnish" => fi_FI,
					"French (Canada)" => fr_CA,
					"French (France)" => fr_FR,
					"Frisian" => fy_NL,
					"Galician" => gl_ES,
					"Georgian" => ka_GE,
					"German" => de_DE,
					"Greek" => el_GR,
					"Guarani" => gn_PY,
					"Hebrew" => he_IL,
					"Hindi" => hi_IN,
					"Hungarian" => hu_HU,
					"Icelandic" => is_IS,
					"Indonesian" => id_ID,
					"Irish" => ga_IE,
					"Italian" => it_IT,
					"Japanese" => ja_JP,
					"Javanese" => jv_ID,
					"Kannada" => kn_IN,
					"Khmer" => km_KH,
					"Korean" => ko_KR,
					"Kurdish" => ku_TR,
					"Latin" => la_VA,
					"Latvian" => lv_LV,
					"Leet Speak" => fb_LT,
					"Lithuanian" => lt_LT,
					"Macedonian" => mk_MK,
					"Malay" => ms_MY,
					"Malayalam" => ml_IN,
					"Nepali" => ne_NP,
					"Norwegian (bokmal)" => nb_NO,
					"Norwegian (nynorsk)" => nn_NO,
					"Pashto" => ps_AF,
					"Persian" => fa_IR,
					"Polish" => pl_PL,
					"Portuguese (Brazil)" => pt_BR,
					"Portuguese (Portugal)" => pt_PT,
					"Punjabi" => pa_IN,
					"Romanian" => ro_RO,
					"Russian" => ru_RU,
					"Serbian" => sr_RS,
					"Simplified Chinese (China)" => zh_CN,
					"Sinhala" => si_LK,
					"Slovak" => sk_SK,
					"Slovenian" => sl_SI,
					"Spanish" => es_LA,
					"Spanish (Spain)" => es_ES,
					"Swahili" => sw_KE,
					"Swedish" => sv_SE,
					"Tamil" => ta_IN,
					"Telugu" => te_IN,
					"Thai" => th_TH,
					"Traditional Chinese (Hong Kong)" => zh_HK,
					"Traditional Chinese (Taiwan)" => zh_TW,
					"Turkish" => tr_TR,
					"Ukrainian" => uk_UA,
					"Urdu" => ur_PK,
					"Vietnamese" => vi_VN,
					"Welsh" => cy_GB
				);
				echo sprintf('<select name="%s" id="%s">', $field, $field);
				foreach($languages as $key=>$lng)
				{
					$selected = '';
					echo('<option value="'.$lng.'" '.selected($value,$lng,false).'>'.$key.'</option>');
				}
				echo('</select>');
			}
			elseif ($args['other']=='scheme')
			{
			echo sprintf('<select name="%s" id="%s" style="width: 200px;">', $field, $field);
					echo('<option value="light" '.selected($value,'light',false).'>Light</option>');
					echo('<option value="dark" '.selected($value,'dark',false).'>Dark</option>');
				echo('</select>');
			}
			elseif ($args['other']=='skin')
			{
			echo sprintf('<select name="%s" id="%s" style="width: 200px;">', $field, $field);
					echo('<option value="default" '.selected($value,'default',false).'>Default</option>');
					echo('<option value="minimal" '.selected($value,'minimal',false).'>Minimal</option>');
				echo('</select>');
			}
			elseif ($args['other']=='shake')
			{
			echo sprintf('<select name="%s" id="%s" style="width: 200px;">', $field, $field);
					echo('<option value="0" '.selected($value,'0',false).'>Disabled</option>');
					echo('<option value="heartbeat" '.selected($value,'heartbeat',false).'>Heartbeat</option>');
					echo('<option value="5000" '.selected($value,'5000',false).'>Shake 5sec</option>');
					echo('<option value="10000" '.selected($value,'10000',false).'>Shake 10sec</option>');
					echo('<option value="15000" '.selected($value,'15000',false).'>Shake 15sec</option>');
					echo('<option value="20000" '.selected($value,'20000',false).'>Shake 20sec</option>');
					echo('<option value="25000" '.selected($value,'25000',false).'>Shake 25sec</option>');
					echo('<option value="30000" '.selected($value,'30000',false).'>Shake 30sec</option>');
					echo('<option value="35000" '.selected($value,'35000',false).'>Shake 35sec</option>');
					echo('<option value="40000" '.selected($value,'40000',false).'>Shake 40sec</option>');
					echo('<option value="45000" '.selected($value,'45000',false).'>Shake 45sec</option>');
					echo('<option value="50000" '.selected($value,'50000',false).'>Shake 50sec</option>');
					echo('<option value="55000" '.selected($value,'55000',false).'>Shake 55sec</option>');
					echo('<option value="60000" '.selected($value,'60000',false).'>Shake 1min</option>');
					echo('<option value="120000" '.selected($value,'120000',false).'>Shake 2min</option>');
					echo('<option value="180000" '.selected($value,'180000',false).'>Shake 3min</option>');
					echo('<option value="240000" '.selected($value,'240000',false).'>Shake 4min</option>');
					echo('<option value="300000" '.selected($value,'300000',false).'>Shake 5min</option>');
				echo('</select>');
			}
			else
			{
			if (isset($args['min'])) $field_min = $args['min'];
			if (isset($args['max'])) $field_max = $args['max'];
			if (isset($args['default'])) $field_default = $args['default'];
				if (!isset($field_min)) $field_min = 1;
				if (!isset($field_max)) $field_max = 10;
				if (!isset($field_default)) $field_default = 5;
			// echo a proper select element
				echo sprintf('<select name="%s" id="%s">', $field, $field);
				for($i=$field_min;$i<=$field_max;$i++) {
					$selected = '';
					if ($value==$i) $selected = 'selected = "true"';
					if (!$value AND $i==$field_default) $selected = 'selected = "true"';
					echo('<option value="'.$i.'" '.$selected.'>'.$i.'</option>');
				}
				echo('</select>');
			}
		}
		/**
		* add a menu
		**/		
		public function add_menu()
		{
			// Add a page to manage this plugin's settings
			add_options_page('FB Likebox Slider', 'FB Likebox Slider', 'manage_options', 'facebook_likebox_slider', array(&$this, 'plugin_settings_page'));
		}
		/**
		* Menu Callback
		**/		
		public function plugin_settings_page()
		{
			if(!current_user_can('manage_options'))
			{
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}
			// Render the settings template
			include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
		}
		public function settings_section_facebook_likebox_slider()
		{
		
		}
	}
}
?>