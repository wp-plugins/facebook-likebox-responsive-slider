/**********************************
* facebook_likebox_slider.js
* title: Facebook LikeBox Slider
* description: Display a Like Box on the Home Page of your website
* version: 1.0
* author: Pantherius
* website: http://sympies.com
*
* release date: 24-10-2014
**********************************/ 

jQuery(document).ready(function() {
if ( typeof flb_params !== 'undefined')
{
	jQuery('body').flbslider();
}
});

(function( jQuery ){
    var methods = {
    init : function(options) {
	defaults = { 
			"appid":"000000000000000",					//Facebook APP ID
			"fbsitename":"sympies",						//Facebook Fan Page name without http://facebook.com/
			"home_page_style":"",						//turn Comment Slider to Like Box or Fan Page Wall on the homepage - likebox or postbox
			"currentstyle":"",							//set it to 'home' on the homepage if you using the home_page_style option - home or empty
			"hide_icon":"false",						//hide all icons, you can combine it with the auto open option - true or false
			"auto_open2":"false",						//auto open the Like Box Slider at the bottom of the page - true or false
			"direction2":"left",						//position of the Facebook Like Box Slider - left or right
			"closeable":"true",							//allow or disallow to close the slider for the users - true or false
			"timer":"300",								//countdown timer to close the opened slider, if you set the closeable option to false in seconds
			"transparency":"90",						//transparency for the locked screen/transparent background in percentages
			"icon_size2":"medium",						//icon size for the Like Box - small, medium or large
			"lock_screen":"true",						//set the screen locked with a transparent background when the slider opens
			"likebox_message":"Like Our Facebook Page",	//message on the top for Likebox Slider
			"vertical_distance2":"50",					//vertical position of the Like Box icon related to the top in percentages
			"dofsu":"false",							//display once for the same user - true or false
			"doap":"false",								//disable on all pages - true or false (you can enable it with [enable_facebook_comment_slider] in the content)
			"no_post_to_show":"3",						//number of posts to show on Comment Box
			"channel_url":"js/channel.html",			//path for channel file to get higher synchronization performance
			"shake2":"0",								//shake animation time for Like Box in millisecs, eg: 5000 for 5sec
			"scheme":"light",							//light or dark
			"icon_url2":"",								//absolute url of the icon for Like Box
			"local":"en_US",							//localization of the sliders
			"hide_alreadyliked":true,					//hide the LikeBox for user who already liked
			"skin":"default"
	  };
	if ( typeof flb_params !== 'undefined') options = flb_params;
	var options = jQuery.extend({}, defaults, options);
if (options.dom=='true'&&jQuery('body').flbslider('detectmob')==true)
{
}
else
{
var lastScrollTop = 0;
var fbtimer_start = 0;
var tid = 0;
var opened = false;
var closeable_lock = '';
var block_autoopen = false;
var fcs_enabled_on_this_page = '';
var likebox_facebook_comment_slider = '';
var postbox_facebook_comment_slider = '';
var disable_facebook_comment_slider = '';
var slidernotice1 = '';
var slidernotice2 = '';
var slidernotice3 = '';
var fbinit_called = false;
fbforce = true;
opened_slider = '';
boxtype = '';
scriptloaded = false;
parentbox = '';
if (options.skin=='default') {space = 8;bspace = 6;}
else {space = 4;bspace = 2;}

function getString(number_value)
{
	return number_value.toString();
}
function check_shortcodes()
{
jQuery("body").children().each(function(){
		if ((jQuery(this).html()!=undefined)&&(jQuery("body").text().indexOf("[enable_facebook_comment_slider]")>=0)) 
		{
		jQuery(this).html(jQuery(this).html().replace("[enable_facebook_comment_slider]","<div style='display:none;'>[enable_facebook_comment_slider]</div>"));
		fcs_enabled_on_this_page = 'true';
		}
		if ((jQuery(this).html()!=undefined)&&(jQuery("body").text().indexOf("[likebox_facebook_comment_slider]")>=0)) 
		{
		jQuery(this).html(jQuery(this).html().replace("[likebox_facebook_comment_slider]","<div style='display:none;'>[likebox_facebook_comment_slider]</div>"));
		likebox_facebook_comment_slider = "true";
		}
		if ((jQuery(this).html()!=undefined)&&(jQuery("body").text().indexOf("[postbox_facebook_comment_slider]")>=0)) 
		{
		jQuery(this).html(jQuery(this).html().replace("[postbox_facebook_comment_slider]","<div style='display:none;'>[postbox_facebook_comment_slider]</div>"));
		postbox_facebook_comment_slider = "true";
		}
		if ((jQuery(this).html()!=undefined)&&(jQuery("body").text().indexOf("[disable_facebook_comment_slider]")>=0)) 
		{
		jQuery(this).html(jQuery(this).html().replace("[disable_facebook_comment_slider]","<div style='display:none;'>[disable_facebook_comment_slider]</div>"));
		disable_facebook_comment_slider = "true";
		}
})
}
check_shortcodes();
	if ((jQuery("body").html()!=undefined))
	{
	if ((options.doap!='true')||(((jQuery("body").html()!=undefined)&&options.doap=='true'&&(fcs_enabled_on_this_page=='true')))||(likebox_facebook_comment_slider=="true")||(postbox_facebook_comment_slider=="true"))
	{
		var facebook_comment_slider_likebox = '';
		var facebook_comment_slider_postbox = '';
		var facebook_comment_slider_autocommenter = '';
		var facebook_comment_slider_closeable = '';
		var facebook_comment_slider_timer = '';
		var fbroot = '';
		var fbicon1 = '';
		var fbicon2 = '';
		var fbicon3 = '';
		var fbcs_scheme = '';
		var fbcs_scheme_name = 'light';
		if (scriptloaded==false)
		{
		var deletecookieonlike = "var fbcsdparams = [ 'fbcsslider_liked', '0', -999, 'days' ];jQuery('body').flbslider('setCookie',fbcsdparams);"
		if (options.hide_alreadyliked==true){var setcookieonlike = "var fbcscparams = [ 'fbcsslider_liked', '1', 999, 'days' ];jQuery('body').flbslider('setCookie',fbcscparams);"}
		else {var setcookieonlike = "";}
		var fbscript = document.createElement( 'script' );
		fbscript.type = 'text/javascript';
		fbscript = "<script type='text/javascript'>(function(d, s, id){var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) {return;}js = d.createElement(s); js.id = id;js.src = 'http://connect.facebook.net/"+options.local+"/all.js';fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));window.fbAsyncInit = function(){FB.init({ appId: '"+options.appid+"',channelUrl : '"+options.channel_url+"',status: true,cookie: true,xfbml: true});FB.Event.subscribe('comment.create', function(response){jQuery('body').flbslider('remove');});FB.Event.subscribe('xfbml.render', function(response){jQuery('body').flbslider('resize');});FB.Event.subscribe('edge.create', function(response){jQuery('body').flbslider('remove');"+setcookieonlike+"});FB.Event.subscribe('edge.remove', function(response){"+deletecookieonlike+"});};</script>";
		jQuery('body').append( fbscript);
		scriptloaded = true;
		}
		if (options.scheme!=undefined) {
			if (options.scheme=='dark')
			{
				fbcs_scheme = 'data-colorscheme="dark"';
				fbcs_scheme_name = options.scheme;
			}
			if (options.scheme=='light'||options.scheme=='')
			{
				fbcs_scheme = 'data-colorscheme="light"';
				fbcs_scheme_name = options.scheme;
			}
		}
		if (options.direction2=='left'&&options.hide_icon=='false') 
		{
			if (options.icon_url2==undefined||options.icon_url2=='') fbicon2 = '<h2 style="left:-70px;top:'+options.vertical_distance2+'%" class="fbicon_like_left icon_'+options.icon_size2+'"></h2>';
			else {
			var imgSrc = options.icon_url2;
			var _width, _height;
			jQuery("<img/>").attr("src", imgSrc).load(function() {
				_width = this.width; 
				_height = this.height;
			 });
			fbicon2 = '<h2 style="left:-'+(_width+50)+'px;top:'+options.vertical_distance2+'%" class="fbcs_left"><img src="'+options.icon_url2+'" /></h2>';
			}
		}
		if (options.direction2=='right'&&options.hide_icon=='false') 
		{
			if (options.icon_url2==undefined||options.icon_url2=='') fbicon2 = '<h2 style="right:-70px;top:'+options.vertical_distance2+'%" class="fbicon_like_right icon_'+options.icon_size2+'"></h2>';
			else {
			var imgSrc = options.icon_url2;
			var _width, _height;
			jQuery("<img/>").attr("src", imgSrc).load(function() {
				_width = this.width; 
				_height = this.height;
			 });
			fbicon2 = '<h2 style="right:-'+(_width+50)+'px;top:'+options.vertical_distance2+'%" class="fbcs_right"><img src="'+options.icon_url2+'" /></h2>';
			}
		}
		if (options.closeable=='true') closeable_lock='onclick="jQuery(\'body\').flbslider(\'remove\')"';
		if (jQuery('#fb-root').length==0) jQuery("body").prepend('<div id="fb-root"></div>');
		if (jQuery('#bglock').length==0) jQuery("body").prepend('<div id="bglock" '+closeable_lock+'> </div>');
		if (options.closeable=='true') facebook_comment_slider_closeable = '<a class="close_facebook_comment_slider"></a>';
		if (options.timer>0) facebook_comment_slider_timer = '<span class="fb_ac_counter"></span>';
		if ((jQuery('body').flbslider('getCookie','fbcsslider_liked')!='1'||options.hide_alreadyliked==false)&&((likebox_facebook_comment_slider=='true')||(options.currentstyle=='home'&&options.home_page_style=='likebox')))
		{
		if (options.fbsitename=='') slidernotice2 = 'Facebook Site Name missing';
		facebook_comment_slider_likebox = '<div class="autocommenter facebook_comment_slider_likebox"><div class="autocommenter_inside autocommenter_'+options.skin+'_'+fbcs_scheme_name+' autocommenter_top"><div class="autocommenter_line"><span class="message_'+fbcs_scheme_name+'">'+options.likebox_message+facebook_comment_slider_timer+'</span>'+facebook_comment_slider_closeable+'</div><div class="fbcommentbox" class="'+options.direction2+'_side_fbbox"><div class="fb-like-box" data-width="460" data-href="https://www.facebook.com/'+options.fbsitename+'" data-colorscheme="'+fbcs_scheme_name+'" data-show-faces="true" data-header="false" data-stream="false" data-height="470" data-show-border="false"></div>'+slidernotice2+'</div><div id="powered">Powered by <a href="https://wordpress.org/plugins/facebook-likebox-slider">Facebook LikeBox Slider</a></div></div>'+fbicon2+'</div>';
		if (jQuery(".facebook_comment_slider_likebox").length!=1) jQuery('body').prepend( facebook_comment_slider_likebox );
		}
		if (jQuery('body').flbslider('detectmob')==true) {jQuery(".autocommenter").css("width","80%");}
		if (jQuery('#bglock').length)
		{
			jQuery('#bglock').css("filter","alpha(opacity="+getString(options.transparency)+")");
			jQuery('#bglock').css("-khtml-opacity",""+getString(parseInt(options.transparency)/100)+"");
			jQuery('#bglock').css("-moz-opacity",""+getString(parseInt(options.transparency)/100)+"");
			jQuery('#bglock').css("opacity",""+getString(parseInt(options.transparency)/100)+"");
		}
		if (options.direction2=='left') 
		{
			jQuery('.facebook_comment_slider_likebox').css("left",'-'+(parseInt(jQuery(".facebook_comment_slider_likebox").width())+space)+'px');
			 jQuery( ".facebook_comment_slider_likebox h2" ).animate({
				left: (jQuery(".facebook_comment_slider_likebox").width()+bspace)+'px'
				}, 1500, "easeInBounce", function() {
				// Animation complete.
					if (parseInt(options.shake2)>0) {setInterval(function(){if (opened==false) {jQuery( ".facebook_comment_slider_likebox h2" ).effect( "shake", {direction: "up"} );}},parseInt(options.shake2));}
					if (options.shake2=='heartbeat') jQuery(".facebook_comment_slider_likebox h2").addClass("heartbeat");
				});
		}
		if (options.direction2=='right') 
		{
			jQuery('.facebook_comment_slider_likebox').css("right",'-'+(jQuery(".facebook_comment_slider_likebox").width())+'px');
			 jQuery( ".facebook_comment_slider_likebox h2" ).animate({
				right: (jQuery(".facebook_comment_slider_likebox").width())+'px'
				}, 1500, "easeInBounce", function() {
				// Animation complete.
					if (parseInt(options.shake2)>0) {setInterval(function(){if (opened==false) {jQuery( ".facebook_comment_slider_likebox h2" ).effect( "shake", {direction: "up"} );}},parseInt(options.shake2));}
					if (options.shake2=='heartbeat') jQuery(".facebook_comment_slider_likebox h2").addClass("heartbeat");
				});
		}
		jQuery(".close_facebook_comment_slider").click(function() {
			jQuery('body').flbslider('remove',opened_slider);
		});
		jQuery(".fcs_open_likebox").click(function() {
			jQuery('body').flbslider('openlikebox');
		})
		jQuery(".fcs_close_likebox").click(function() {
			jQuery('body').flbslider('closelikebox');
		})
		jQuery(".fcs_close").click(function() {
			jQuery('body').flbslider('close');
		})
		jQuery(".fcs_hide").click(function() {
			jQuery('body').flbslider('hide');
		})
		jQuery(".fcs_show").click(function() {
			jQuery('body').flbslider('show');
		})
		jQuery(".facebook_comment_slider_likebox h2").click(function() {
		if (parentbox==""||parentbox==undefined) {var parent_div = jQuery(this).parent();}
		else {var parent_div = jQuery(parentbox);}
		//if (parentbox!='') {jQuery(this).off('trigger');jQuery(this).on('click');}
		parentbox = '';
		if (jQuery(parent_div).find("h2").attr("class").indexOf("left")!=-1) var thisdirection = "left";
		else var thisdirection = "right";
			if (thisdirection=='left') 
			{
				block_autoopen = true;
				if (parseInt(jQuery(parent_div).css("left").replace("px",""))<-5) {divscroller(false,parent_div);return true;}
				if (parseInt(jQuery(parent_div).css("left").replace("px",""))>=-5&&options.closeable=='true') {jQuery('body').flbslider('remove',parent_div);return true;}
			}
			if (thisdirection=='right')
			{
				block_autoopen = true;
				if (parseInt(jQuery(parent_div).css("right").replace("px",""))<-5) {divscroller(false,parent_div);return true;}
				if (parseInt(jQuery(parent_div).css("right").replace("px",""))>=-5&&options.closeable=='true') {jQuery('body').flbslider('remove',parent_div);return true;}
			}
		});
	}
	}

	jQuery('.fbcommentbox').jScrollPane({
			showArrows: true,
			autoReinitialise:true,
			autoReinitialiseDelay:10,
			verticalGutter:-15
		});

	jQuery(window).resize(function() {
	fbforce = true;
	jQuery('body').flbslider('resize');
	});

	jQuery(window).scroll(function() 
	{
		var st = jQuery(this).scrollTop();
		if(jQuery(window).scrollTop() + jQuery(window).height() > jQuery(document).height() - ((jQuery(document).height()/100)*10)&&st > lastScrollTop&&opened==false)
		{
		if (jQuery(".facebook_comment_slider_likebox").length==1)
		{
				if ((parseInt(jQuery(".facebook_comment_slider_likebox").css("left").replace("px",""))<-5&&options.direction2=='left')||(parseInt(jQuery(".facebook_comment_slider_likebox").css("right").replace("px",""))<-5&&options.direction2=='right'))
				{
					if (options.auto_open2=='true'&&(jQuery('body').flbslider('getCookie','autocommenter')!='1'||options.dofsu=='false')&&(jQuery('.facebook_comment_slider_likebox')!=undefined))
					{
						if (options.dofsu=='true') visitor_rememberer();
						opened = true;
						if (block_autoopen==false) opened_slider = jQuery('.facebook_comment_slider_likebox');divscroller(true,opened_slider);
					}
				}
		}
		}
		lastScrollTop = st;
	});
	
	function visitor_rememberer()
	{
		var fbcscparams = [ 'autocommenter', '1', 999, 'days' ];
		jQuery('body').flbslider('setCookie',fbcscparams);
	}
	
	function divscroller(timer,boxtype)
	{
	opened_slider = boxtype;
		jQuery(".autocommenter").css("z-index","10");
		jQuery(opened_slider).css("z-index","9999999");
	if ((jQuery(".fbcommentbox iframe").length==0))
	{
		FB.XFBML.parse(document, function(){jQuery('body').flbslider('resize');});
	}
	if (jQuery("#twitter_timeline_autocommenter h2").length==1) jQuery("#twitter_timeline_autocommenter").css("z-index","10999");	
		jQuery('.fb_ltr').css("width",jQuery(".fbcommentbox").width()-20+'px');
		jQuery('.fbcommentbox span:first').css("width",jQuery(".fbcommentbox").width()+10+"px");
		jQuery('.facebook_comment_slider_likebox .fbcommentbox span:first').css("padding-left","0px");
		jQuery("."+jQuery(boxtype).attr("class").replace("autocommenter ","")+" h2").removeClass("heartbeat");
		if (options.lock_screen=='true') 
		{
			jQuery("#bglock").fadeIn(1000);
		}
		var screen_width = jQuery(window).width();
		if ((options.direction2=='left'&&jQuery(boxtype).attr("class").replace("autocommenter ","")=="facebook_comment_slider_likebox")) 
		{
			if (timer==true) jQuery(boxtype).animate({left: "-5px"}, 1000, "easeOutBounce", callback);
			else jQuery(boxtype).animate({left: "-5px"}, 1000, "easeOutBounce", function(){opened = true;});
		}
		if ((options.direction2=='right'&&jQuery(boxtype).attr("class").replace("autocommenter ","")=="facebook_comment_slider_likebox")) 
		{
			if (timer==true) jQuery(boxtype).animate({right: "-5px"}, 1000, "easeOutBounce", callback);
			else jQuery(boxtype).animate({right: "-5px"}, 1000, "easeOutBounce", function(){opened = true;});
		}
		opened = true;
	}

	function callback() {
		if (options.timer>0)
		{
			if (!tid) fbtimer_start = options.timer;
			if ((options.timer>0)&&(!tid)&&(options.closeable=='false')) tid = setInterval(function(){fb_ac_timer()}, 1000);
		}
		opened = true;
	}

	function fb_ac_timer() {
		if (parseInt(fbtimer_start)<1) {clearInterval(tid);jQuery('body').flbslider('remove',opened_slider);}
		jQuery(".fb_ac_counter").html(" "+fbtimer_start+" sec");
		fbtimer_start--;
	}


}
},
	setCookie : function(params)
	{
	var c_name = params[0];
	var value = params[1];
	var dduntil = params[2];
	var mode = params[3];
		if (mode=='days')
		{
			var exdate=new Date();
			exdate.setDate(exdate.getDate() + parseInt(dduntil));
			var c_value=escape(value) + ((dduntil==null) ? "" : "; expires="+exdate.toUTCString()) + "; path=/";
			document.cookie=c_name + "=" + c_value;		
		}
		if (mode=='minutes')
		{
			var now=new Date();
			var time = now.getTime();
			time += parseInt(dduntil);
			now.setTime(time);
			var c_value=escape(value) + ((dduntil==null) ? "" : "; expires="+now.toUTCString()) + "; path=/";
			document.cookie=c_name + "=" + c_value;
		}
	},
	getCookie : function(c_name) 
	{
		var c_value = document.cookie;
		var c_start = c_value.indexOf(" " + c_name + "=");
		if (c_start == -1)
		  {
		  c_start = c_value.indexOf(c_name + "=");
		  }
		if (c_start == -1)
		  {
		  c_value = null;
		  }
		else
		  {
		  c_start = c_value.indexOf("=", c_start) + 1;
		  var c_end = c_value.indexOf(";", c_start);
		  if (c_end == -1)
		  {
		c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start,c_end));
		}
		return c_value;
	},
    destroy : function() {
		jQuery(".autocommenter").remove();
		jQuery("#fb-root").remove();
		jQuery("#bglock").remove();		
		return 1;
	},
	openlikebox : function()
	{
	   if (parentbox=='') 
		{
			parentbox = '.facebook_comment_slider_likebox';
			jQuery( ".facebook_comment_slider_likebox h2" ).trigger( "click" );
		}
	},
	closelikebox : function()
	{
		jQuery('body').flbslider('remove','.facebook_comment_slider_likebox');
	},
	close : function()
	{
		jQuery('body').flbslider('remove');
	},
	hide : function()
	{
		jQuery('.autocommenter').css("display","none");
	},
	show : function()
	{
		jQuery('.autocommenter').css("display","block");
	},
	detectmob : function()
	{
	   if(window.innerWidth <= 800 && window.innerHeight <= 600) {
		 return true;
	   } else {
		 return false;
	   }
	},
	remove : function(boxtype)
	{
	if ( typeof flb_params !== 'undefined') options = flb_params;
	var options = jQuery.extend({}, defaults, options);
	if (boxtype==undefined||boxtype=='') boxtype = opened_slider;
	if (jQuery("#twitter_timeline_autocommenter h2").length==1) jQuery("#twitter_timeline_autocommenter h2").fadeIn(250);
		if (jQuery('#bglock').length)
		{
			jQuery("#bglock").fadeOut(1000);
		}
		if ((options.direction2=='left'&&jQuery(boxtype).attr("class").replace("autocommenter ","")=="facebook_comment_slider_likebox")) jQuery(boxtype).animate({left: "-"+(parseInt(jQuery(boxtype).width())+space)+"px"}, 1000, "easeOutBounce",function(){if (jQuery("#twitter_timeline_autocommenter h2").length==1) jQuery("#twitter_timeline_autocommenter").css("z-index","11000");});
		if ((options.direction2=='right'&&jQuery(boxtype).attr("class").replace("autocommenter ","")=="facebook_comment_slider_likebox")) jQuery(boxtype).animate({right: "-"+(jQuery(boxtype).width())+"px"}, 1000, "easeOutBounce",function(){if (jQuery("#twitter_timeline_autocommenter h2").length==1) jQuery("#twitter_timeline_autocommenter").css("z-index","11000");});
	},
	resize : function()
	{
	if ( typeof flb_params !== 'undefined') options = flb_params;
	var options = jQuery.extend({}, defaults, options);
		if (jQuery(".facebook_comment_slider_likebox").length==1)
	{
			if (jQuery('body').flbslider('detectmob')==true) {jQuery(".facebook_comment_slider_likebox").css("width","80%");}
			else jQuery('.facebook_comment_slider_likebox').css("width",'35%');
			jQuery('.facebook_comment_slider_likebox').css("height",'80%');
			jQuery('.facebook_comment_slider_likebox .fbcommentbox').css("width",(jQuery(".facebook_comment_slider_likebox .autocommenter_inside").width())+'px');
			jQuery('.facebook_comment_slider_likebox .fbcommentbox').css("height",(jQuery(".facebook_comment_slider_likebox .autocommenter_inside").height()-55)+'px');
			jQuery('.facebook_comment_slider_likebox .fb_ltr').css("height",(jQuery(".facebook_comment_slider_likebox .fbcommentbox").height()/100*90)+'px');
			jQuery('.facebook_comment_slider_likebox .fb_ltr').css("width",jQuery(".facebook_comment_slider_likebox .fbcommentbox").width()-20+'px');
			jQuery('.facebook_comment_slider_likebox .fbcommentbox span:first').css("width",jQuery(".facebook_comment_slider_likebox .fbcommentbox").width()+10+"px");
			if (parseInt(jQuery(".facebook_comment_slider_likebox").css("left").replace("px",""))<-5) jQuery('.facebook_comment_slider_likebox').css("left",'-'+(jQuery(".facebook_comment_slider_likebox").width()+space)+'px');
			if (parseInt(jQuery(".facebook_comment_slider_likebox").css("right").replace("px",""))<-5) jQuery('.facebook_comment_slider_likebox').css("right",'-'+(jQuery(".facebook_comment_slider_likebox").width())+'px');
		if (options.direction2=='left') jQuery('.facebook_comment_slider_likebox h2').css("left",(parseInt(jQuery(".facebook_comment_slider_likebox").width())+bspace)+'px');
		if (options.direction2=='right') jQuery('.facebook_comment_slider_likebox h2').css("left",'-'+jQuery(".facebook_comment_slider_likebox h2").width()+'px');
			jQuery('.facebook_comment_slider_likebox .fbcommentbox span:first').css("padding-left","0px");
			jQuery(".facebook_comment_slider_likebox .fb-like-box").attr("data-width",(jQuery(".facebook_comment_slider_likebox").width()-30)+'px');
	}
		if (fbforce==true) {
		if (typeof(FB) != 'undefined' && FB != null ) {FB.XFBML.parse();}
		fbforce = false;
		}
		else return false;
	}
    };
jQuery.fn.flbslider = function(methodOrOptions) {
        if ( methods[methodOrOptions] ) {
            return methods[ methodOrOptions ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof methodOrOptions === 'object' || ! methodOrOptions ) {
            return methods.init.apply( this, arguments );
        } else {
            jQuery.error( 'Method ' +  methodOrOptions + ' does not exist on jQuery.flbslider' );
        }    
    };
})( jQuery );
