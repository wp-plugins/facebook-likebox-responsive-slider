jQuery(document).ready(function() {
	var fbcommentslider = jQuery.noConflict();
	fbcommentslider(function() {
	fbcommentslider("#facebook_likebox_slider_tabs").tabs();
	fbcommentslider('.open-tab').click(function (event) {
		fbcommentslider( "#facebook_likebox_slider_tabs" ).tabs( "option", "active", 0 );
    });
	});
});
