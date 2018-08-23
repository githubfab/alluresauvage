jQuery(document).ready(function($) {

	"use strict";
	
	// Sticky Menu
	var stickyNavTop = $('#top-bar').offset().top;
	 
	var stickyNav = function(){
	var scrollTop = $(window).scrollTop();

	if (scrollTop > 0) { 
		$('#top-bar').addClass('sticky');
	} else {
		$('#top-bar').removeClass('sticky'); 
	}
	};
	 
	stickyNav();
	 
	$(window).scroll(function() {
	  stickyNav();
	});
	
	// Menu
	$('#nav-wrapper .menu').slicknav({
		prependTo:'#slick-mobile-menu',
		label:'Show Menu',
		allowParentLinks: true
	});
	
	// BXslider
	
	$('#featured-area .bxslider, .fullimage-gallery .bxslider').bxSlider({
		adaptiveHeight: true,
		mode: 'fade',
		pager: false,
		/*auto: ($(".bxslider div.slide-item").length > 1) ? true: false,*/
		auto: false,
		pause: 7000,
		nextText: '<i class="fa fa-angle-right"></i>',
		prevText: '<i class="fa fa-angle-left"></i>',
		onSliderLoad: function(){
			$(".sideslides").css("visibility", "visible");
		}
	});
	
	$('.post-img .bxslider').bxSlider({
	  adaptiveHeight: true,
	  mode: 'fade',
	  pager: false,
	  captions: true,
	  nextText: '<i class="fa fa-angle-right"></i>',
	  prevText: '<i class="fa fa-angle-left"></i>',
	  onSliderLoad: function(){
			$(".sideslides").css("visibility", "visible");
		}
	});
	
	$('#top-search a').on('click', function ( e ) {
		e.preventDefault();
    	$('#show-search').animate({width:'toggle'});
    });
	$('#show-search a').on('click', function ( e ) {
		e.preventDefault();
    	$('#show-search').animate({width:'toggle'});
    });
	
	// Fitvids
	$(document).ready(function(){
		$(".sp-container, .post-video-full").fitVids();
	});
	
});