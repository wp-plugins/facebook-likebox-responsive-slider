jQuery(window).load(function(){
	  jQuery('.pop-up-screen, .overlay').fadeIn();

     jQuery('.close').on('click', function(){
	  jQuery('.pop-up-screen, .overlay').fadeOut();
     });
});