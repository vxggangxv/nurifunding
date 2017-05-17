(function ($) {

	new gnMenu( document.getElementById( 'gn-menu' ) );


	//jQuery for page scrolling feature - requires jQuery Easing plugin
	$(function() {
		$('.gn-menu li a').bind('click', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 1500, 'easeInOutExpo');
			event.preventDefault();
		});
		$('a.scroll').bind('click', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 1500, 'easeInOutExpo');
			event.preventDefault();
		});

		//nivo lightbox
		$('.gallery-item a').nivoLightbox({
			effect: 'fadeScale',                             // The effect to use when showing the lightbox
			theme: 'default',                           // The lightbox theme to use
			keyboardNav: true,                          // Enable/Disable keyboard navigation (left/right/escape)
			clickOverlayToClose: true,                  // If false clicking the "close" button will be the only way to close the lightbox
			onInit: function(){},                       // Callback when lightbox has loaded
			beforeShowLightbox: function(){},           // Callback before the lightbox is shown
			afterShowLightbox: function(lightbox){},    // Callback after the lightbox is shown
			beforeHideLightbox: function(){},           // Callback before the lightbox is hidden
			afterHideLightbox: function(){},            // Callback after the lightbox is hidden
			onPrev: function(element){},                // Callback when the lightbox gallery goes to previous item
			onNext: function(element){},                // Callback when the lightbox gallery goes to next item
			errorMessage: 'The requested content cannot be loaded. Please try again later.' // Error message when content can't be loaded
		});

		/* title클릭시 새창 오픈 */
		$("body").on("click", ".nivo-lightbox-theme-default .nivo-lightbox-title", function() {
			//console.log("hi");
			var url = $(this).text();
			console.log(url);
			window.open(url, '_blank');
		});
		/* Waypoints */
	  wayP();
	  /* btnTop */
	  btnTopDisplay();
	  
	});


})(jQuery);

/* Waypoints */
function wayP() {
  $('.wp1').waypoint(function () {
      $('.wp1').addClass('animated fadeIn');
  }, {
      offset: '75%'
  });
  $("#my_skill > div").each(function(idx, item){
    $(item).addClass("blind");
    $(item).waypoint(function () {
      $(item).addClass('animated bounceIn');
    }, {
        offset: '75%'
    });
  });
  $(".gallery-item > div").each(function(idx, item){
    $(item).addClass("blind");
    $(item).waypoint(function () {
      $(item).addClass('animated flipInX');
    }, {
        offset: '75%'
    });
  });
  $('.wp2').waypoint(function () {
      $('.wp2').addClass('animated fadeInLeft');
  }, {
      offset: '95%'
  });
      
}

/* btnTop Display*/
function btnTopDisplay() {
	var $btn = $("#btnTop");
	$(window).on('scroll',function() {
		var scroll = $(window).scrollTop();
		if(scroll >= 90){
			$btn.fadeIn("fast");
		}else {
			$btn.fadeOut("fast");
		}
	});
	$btn.on('click', function() {
		$("body, html").stop().animate({
			'scrollTop' : 0
		}, 1500, "easeInOutExpo");
	});
}