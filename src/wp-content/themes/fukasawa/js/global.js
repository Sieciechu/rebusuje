jQuery(document).ready(function($) {
	
	
	
	$blocks = $(".posts");

	$blocks.imagesLoaded(function(){

		// Fade blocks in after images are ready (prevents jumping and re-rendering)
		$(".post-container").fadeIn();
	});
	
	
	// Toggle navigation
	$(".nav-toggle").on("click", function(){	
		$(this).toggleClass("active");
		$(".mobile-navigation").slideToggle();
	});
	
	
	// Hide mobile-menu > 1000
	$(window).resize(function() {
		if ($(window).width() > 1000) {
			$(".nav-toggle").removeClass("active");
			$(".mobile-navigation").hide();
		}
	});

	// make small navbar after scroll
	$(document).scroll(function(e){
		var scrollTop = $(document).scrollTop();
		if(scrollTop > 0){
			//console.log(scrollTop);
			$('#top-menu').addClass("small");
		} else {
			$('#top-menu').removeClass("small");
		}
	});

});

