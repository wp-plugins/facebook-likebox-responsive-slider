<?php
defined( 'ABSPATH' ) OR exit;
/**
 * Plugin Name: Facebook Likebox Slider
 * Plugin URI: http://sympies.com/facebook-comment-slider
 * Description: Add a Powerful Facebook Like Box Slider to your Home Page
 * Author: Pantherius
 * Version: 1.03
 * Author URI: http://sympies.com
 */
 
if(!class_exists('facebook_likebox_slider'))
{
	class facebook_likebox_slider
	{
		public static $inserted = 0;
		protected static $instance = null;
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// installation and uninstallation hooks
			register_activation_hook(__FILE__, array('facebook_likebox_slider', 'activate'));
			register_deactivation_hook(__FILE__, array('facebook_likebox_slider', 'deactivate'));
			register_uninstall_hook(__FILE__, array('facebook_likebox_slider', 'uninstall'));
			add_filter( 'wp_footer', array(&$this, 'check_404') );
			if (is_admin())
			{
				require_once(sprintf("%s/settings.php", dirname(__FILE__)));
				$facebook_likebox_slider_settings = new facebook_likebox_slider_settings();
				$plugin = plugin_basename(__FILE__);
				add_filter("plugin_action_links_$plugin", array(&$this, 'plugin_settings_link'));
			}
			else
			{
				if (isset($_SERVER['HTTP_HOST']) AND isset($_SERVER['REQUEST_URI'])) $domain = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				else $domain = get_permalink();
				if ('http://'.$_SERVER['HTTP_HOST'].'/'==$domain||'http://'.$_SERVER['HTTP_HOST']==$domain||'http://www.'.$_SERVER['HTTP_HOST']==$domain||'http://www.'.$_SERVER['HTTP_HOST'].'/'==$domain)
				{
						add_action('init', array(&$this, 'enqueue_custom_scripts_and_styles'));
						if (get_option('setting_appid')) add_action('wp_head', array(&$this, 'add_meta_appid'));
				}
			}
		}
		function check_404( $title ) {
			if (is_404()) print('<div style="display:none">[disable_facebook_likebox_slider]</div>');
		}
		public static function getInstance()
		{
			if (!isset($instance)) 
			{
				$instance = new facebook_likebox_slider;
			}
		return $instance;
		}
		/**
		* Activate the plugin
		**/
		public static function activate()
		{
			if ( ! get_option('setting_hide_icon'))
			{
				add_option('setting_hide_icon' , 'off');
			}
			if ( ! get_option('setting_icon_size2'))
			{
				add_option('setting_icon_size2' , 'medium');
			}
			if ( ! get_option('setting_auto_open2'))
			{
				add_option('setting_auto_open2' , 'on');
			}
			if ( ! get_option('setting_lock_screen'))
			{
				add_option('setting_lock_screen' , 'on');
			}
			if ( ! get_option('setting_closeable'))
			{
				add_option('setting_closeable' , 'on');
			}
			if ( ! get_option('setting_timer'))
			{
				add_option('setting_timer' , '300');
			}
			if ( ! get_option('setting_transparency'))
			{
				add_option('setting_transparency' , '90');
			}
			if ( ! get_option('setting_likebox_message'))
			{
				add_option('setting_likebox_message' , 'Like Our Facebook Page');
			}
			if ( ! get_option('setting_display_once_for_same_user'))
			{
				add_option('setting_display_once_for_same_user' , 'off');
			}
			if ( ! get_option('setting_disable_on_mobile'))
			{
				add_option('setting_disable_on_mobile' , 'off');
			}
			if ( ! get_option('setting_display_only_allowed_pages'))
			{
				add_option('setting_display_only_allowed_pages' , 'off');
			}
			if ( ! get_option('setting_localization'))
			{
				add_option('setting_localization' , 'en_US');
			}
			if ( ! get_option('setting_direction2'))
			{
				add_option('setting_direction2' , 'right');
			}
			if ( ! get_option('setting_no_post_to_show'))
			{
				add_option('setting_no_post_to_show' , '5');
			}
			if ( ! get_option('setting_vertical_distance2'))
			{
				add_option('setting_vertical_distance2' , '20');
			}
			if ( ! get_option('setting_home_page_style'))
			{
				add_option('setting_home_page_style' , 'likebox');
			}
		}
		/**
		* Deactivate the plugin
		**/
		public static function deactivate()
		{
			if (get_option('setting_keep_settings')!='on')
			{
				unregister_setting('facebook_comment_slider-group', 'setting_appid');
				unregister_setting('facebook_comment_slider-group', 'setting_adminid');
				unregister_setting('facebook_comment_slider-group', 'setting_fbsitename');
				unregister_setting('facebook_comment_slider-group', 'setting_home_page_style');
				unregister_setting('facebook_comment_slider-group', 'setting_hide_icon');
				unregister_setting('facebook_comment_slider-group', 'setting_lock_screen');
				unregister_setting('facebook_comment_slider-group', 'setting_closeable');
				unregister_setting('facebook_comment_slider-group', 'setting_timer');
				unregister_setting('facebook_comment_slider-group', 'setting_transparency');
				unregister_setting('facebook_comment_slider-group', 'setting_display_once_for_same_user');
				unregister_setting('facebook_comment_slider-group', 'setting_disable_on_mobile');
				unregister_setting('facebook_comment_slider-group', 'setting_display_only_allowed_pages');
				unregister_setting('facebook_comment_slider-group', 'setting_localization');
				unregister_setting('facebook_comment_slider-group', 'setting_scheme');
				unregister_setting('facebook_comment_slider-group', 'setting_skin');
				unregister_setting('facebook_comment_slider-group', 'setting_hide_alreadyliked');
				unregister_setting('facebook_comment_slider-group', 'setting_keep_settings');
				unregister_setting('facebook_comment_slider_comment_box-group', 'setting_vertical_distance1');
				unregister_setting('facebook_comment_slider_comment_box-group', 'setting_icon_size1');
				unregister_setting('facebook_comment_slider_comment_box-group', 'setting_auto_open1');
				unregister_setting('facebook_comment_slider_comment_box-group', 'setting_message');
				unregister_setting('facebook_comment_slider_comment_box-group', 'setting_specified_page1');
				unregister_setting('facebook_comment_slider_comment_box-group', 'setting_direction1');
				unregister_setting('facebook_comment_slider_comment_box-group', 'setting_no_post_to_show');
				unregister_setting('facebook_comment_slider_comment_box-group', 'setting_icon_url1');
				unregister_setting('facebook_comment_slider_comment_box-group', 'setting_shake1');
				unregister_setting('facebook_comment_slider_like_box-group', 'setting_vertical_distance2');
				unregister_setting('facebook_comment_slider_like_box-group', 'setting_icon_size2');
				unregister_setting('facebook_comment_slider_like_box-group', 'setting_auto_open2');
				unregister_setting('facebook_comment_slider_like_box-group', 'setting_likebox_message');
				unregister_setting('facebook_comment_slider_like_box-group', 'setting_direction2');
				unregister_setting('facebook_comment_slider_like_box-group', 'setting_icon_url2');
				unregister_setting('facebook_comment_slider_like_box-group', 'setting_shake2');
				unregister_setting('facebook_comment_slider_post_box-group', 'setting_vertical_distance3');
				unregister_setting('facebook_comment_slider_post_box-group', 'setting_icon_size3');
				unregister_setting('facebook_comment_slider_post_box-group', 'setting_auto_open3');
				unregister_setting('facebook_comment_slider_post_box-group', 'setting_postbox_message');
				unregister_setting('facebook_comment_slider_post_box-group', 'setting_direction3');
				unregister_setting('facebook_comment_slider_post_box-group', 'setting_icon_url3');
				unregister_setting('facebook_comment_slider_post_box-group', 'setting_shake3');
			}
		}
		
		/**
		* Uninstall the plugin
		**/
		public static function uninstall()
		{
			if (get_option('setting_keep_settings')!='on')
			{
				delete_option('setting_appid');
				delete_option('setting_adminid');
				delete_option('setting_fbsitename');
				delete_option('setting_home_page_style');
				delete_option('setting_hide_icon');
				delete_option('setting_lock_screen');
				delete_option('setting_closeable');
				delete_option('setting_timer');
				delete_option('setting_transparency');
				delete_option('setting_display_once_for_same_user');
				delete_option('setting_disable_on_mobile');
				delete_option('setting_display_only_allowed_pages');
				delete_option('setting_localization');
				delete_option('setting_scheme');
				delete_option('setting_skin');
				delete_option('setting_hide_alreadyliked');
				delete_option('setting_keep_settings');
				delete_option('setting_vertical_distance1');
				delete_option('setting_icon_size1');
				delete_option('setting_auto_open1');
				delete_option('setting_message');
				delete_option('setting_specified_page1');
				delete_option('setting_direction1');
				delete_option('setting_no_post_to_show');
				delete_option('setting_icon_url1');
				delete_option('setting_shake1');
				delete_option('setting_vertical_distance2');
				delete_option('setting_icon_size2');
				delete_option('setting_auto_open2');
				delete_option('setting_likebox_message');
				delete_option('setting_direction2');
				delete_option('setting_icon_url2');
				delete_option('setting_shake2');
				delete_option('setting_vertical_distance3');
				delete_option('setting_icon_size3');
				delete_option('setting_auto_open3');
				delete_option('setting_postbox_message');
				delete_option('setting_direction3');
				delete_option('setting_icon_url3');
				delete_option('setting_shake3');
			}
		}
		
		function add_meta_appid()
		{
			return print('<meta property="fb:app_id" content="'.get_option('setting_appid').'">');
		}
				
		function enqueue_custom_scripts_and_styles() 
		{
		$direction = '';$domain = '';
		if (get_option('setting_direction2')=='right') $direction2 = 'right';
		else $direction2 = 'left';
		if (get_option('setting_closeable')=='on') $closeable = 'true';
		else $closeable = 'false';
		if (get_option('setting_hide_icon')=='off') $hide_icon = 'false';
		else $hide_icon = 'true';
		if (get_option('setting_icon_size2')) $icon_size2 = get_option('setting_icon_size2');
		else $icon_size2 = 'medium';
		if (get_option('setting_auto_open2')=='off') $auto_open2 = 'false';
		else $auto_open2 = 'true';
		if (get_option('setting_lock_screen')=='on') $lock_screen = 'true';
		else $lock_screen = 'false';
		if (get_option('setting_timer')>0) $timer = get_option('setting_timer');
		if (get_option('setting_transparency')>=0) $transparency = get_option('setting_transparency');
		else $transparency = '90';
		if (get_option('setting_likebox_message')) $likebox_message = get_option('setting_likebox_message');
		else $likebox_message = 'Follow Us on Facebook';
		if (get_option('setting_display_once_for_same_user')=='on') $dofsu = 'true';
		else $dofsu = 'false';
		if (get_option('setting_disable_on_mobile')=='on') $dom = 'true';
		else $dom = 'false';
		if (get_option('setting_display_only_allowed_pages')=='on') $doap = 'true';
		else $doap = 'false';
		if (get_option('setting_no_post_to_show')>0) $no_post_to_show = get_option('setting_no_post_to_show');
		else $no_post_to_show = 5;
		if (get_option('setting_localization')) $local = get_option('setting_localization');
		else $local = 'en_US';
		if (get_option('setting_appid')) $appid = get_option('setting_appid');
		else $appid = 'false';
		if (get_option('setting_scheme')) $scheme = get_option('setting_scheme');
		else $scheme = 'light';
		if (get_option('setting_skin')) $skin = get_option('setting_skin');
		else $skin = 'default';
		if (get_option('setting_hide_alreadyliked')=='on') $hal = true;
		else $hal = false;
		if (get_option('setting_shake2')) $shake2 = get_option('setting_shake2');
		else $shake2 = '0';
		if (get_option('setting_icon_url2')) $icon_url2 = get_option('setting_icon_url2');
		else $icon_url2 = '';
		if (get_option('setting_vertical_distance2')) $vertical_distance2 = get_option('setting_vertical_distance2');
		else $vertical_distance2 = '30';
		if (get_option('setting_home_page_style')) $home_page_style = get_option('setting_home_page_style');
		else $home_page_style = 'likebox';
		if (get_option('setting_fbsitename')) $fbsitename = get_option('setting_fbsitename');
		else $fbsitename = '';
		if (isset($_SERVER['HTTP_HOST']) AND isset($_SERVER['REQUEST_URI'])) $domain = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		else $domain = get_permalink();
		$channel_url = plugins_url( '/templates/channel.html' , __FILE__ );
		$xid = md5($domain);

		/* params for demo start */
		if (isset($_REQUEST['s_direction'])) $direction1 = $_REQUEST['s_direction'];
		if (isset($_REQUEST['s_closeable'])) $closeable = $_REQUEST['s_closeable'];
		if (isset($_REQUEST['s_hide_icon'])) $hide_icon = $_REQUEST['s_hide_icon'];
		if (isset($_REQUEST['s_icon_size'])) $icon_size1 = $_REQUEST['s_icon_size'];
		if (isset($_REQUEST['s_auto_open'])) $auto_open1 = $_REQUEST['s_auto_open'];
		if (isset($_REQUEST['s_lock_screen'])) $lock_screen = $_REQUEST['s_lock_screen'];
		if (isset($_REQUEST['s_timer'])) $timer = $_REQUEST['s_timer'];
		if (isset($_REQUEST['s_transparency'])) $transparency = $_REQUEST['s_transparency'];
		if (isset($_REQUEST['s_message'])) $message = $_REQUEST['s_message'];
		if (isset($_REQUEST['s_localization'])) $local = $_REQUEST['s_localization'];
		if (isset($_REQUEST['s_scheme'])) $scheme = $_REQUEST['s_scheme'];
		if (isset($_REQUEST['s_shake'])) $shake1 = $_REQUEST['s_shake'];
		if (isset($_REQUEST['s_vertical'])) $vertical_distance1 = $_REQUEST['s_vertical'];
		if (isset($_REQUEST['s_icon_url'])) $icon_url1 = $_REQUEST['s_icon_url'];
		if (isset($_REQUEST['s_skin'])) $skin = $_REQUEST['s_skin'];
		
		/* params for demo end */
			$currentstyle = "home";
			wp_enqueue_style('facebook_likebox_slider_style', plugins_url( '/templates/assets/css/facebook_likebox_slider.css' , __FILE__ ));
			wp_enqueue_style('jquery_ui_style', plugins_url( '/templates/assets/css/jquery-ui.css' , __FILE__ ));
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-core',array('jquery'));
			wp_enqueue_script('jquery-effects-core',array('jquery'));
			wp_enqueue_script('jquery-effects-fade',array('jquery-effects-core'));
			wp_enqueue_script('jquery-effects-slide',array('jquery-effects-core'));
			wp_enqueue_script('jquery-effects-shake',array('jquery-effects-core'));
			wp_enqueue_script('jquerymousewheel',plugins_url('/templates/assets/js/jquery.mousewheel.js' , __FILE__ ), array('jquery'),'1.0.0.1',true );
			wp_enqueue_script('jscrollpane',plugins_url('/templates/assets/js/jquery.jscrollpane.min.js' , __FILE__ ),array('jquery'),'1.0.0.1',true);
			wp_register_script( "facebook_likebox_slider_script", plugins_url('/templates/assets/js/facebook_likebox_slider.min.js' , __FILE__ ), array('jquery','jquery-ui-core','jquery-effects-core','jquery-effects-fade','jquery-effects-slide','jquery-effects-shake'),'1.0.1.0',false );
			wp_localize_script( 'facebook_likebox_slider_script', 'flb_params', array( 'direction2'=>$direction2, 'closeable'=>$closeable, 'timer'=>$timer, 'transparency'=>$transparency, 'hide_icon'=>$hide_icon, 'icon_size2'=>$icon_size2, 'auto_open2'=>$auto_open2, 'lock_screen'=>$lock_screen, 'likebox_message'=>$likebox_message, 'dofsu'=>$dofsu, 'dom'=>$dom, 'doap'=>$doap, 'no_post_to_show'=>$no_post_to_show, 'appid'=>$appid, 'vertical_distance2'=>$vertical_distance2, 'home_page_style'=>'likebox', 'fbsitename'=>$fbsitename, 'currentstyle'=>$currentstyle, 'channel_url'=>$channel_url, 'local'=>$local, 'xid'=>$xid, 'scheme' => $scheme, 'skin' => $skin, 'hide_alreadyliked' => $hal, 'shake2' => $shake2, 'icon_url2' => $icon_url2));
			wp_enqueue_script( 'facebook_likebox_slider_script' );

		}
		/**
		* Add the settings link to the plugins page
		**/
		function plugin_settings_link($links)
		{ 
			$settings_link = '<a href="options-general.php?page=facebook_likebox_slider">Settings</a>';
			array_unshift($links, $settings_link); 
			return $links; 
		}
	}
}
if(class_exists('facebook_likebox_slider'))
{
	// call the main class
	$facebook_likebox_slider = facebook_likebox_slider::getInstance();
}
?>