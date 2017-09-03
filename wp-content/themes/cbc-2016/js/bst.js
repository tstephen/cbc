(function ($) {
	
	"use strict";

	$(document).ready(function() {

		// Comments
		$(".commentlist li").addClass("panel panel-default");
		$(".comment-reply-link").addClass("btn btn-default");
	
		// Forms
		$('select, input[type=text], input[type=email], input[type=password], textarea').addClass('form-control');
		$('input[type=submit]').addClass('btn btn-primary');
		
		// Sermon contact form
		jQuery('.sermon-contact:first').empty().append('<span class="dashicons dashicons-testimonial"></span><a class="sermon-contact-button" href="#">Ask a question or make a comment</a>');
		jQuery('.sermon-contact:first .sermon-contact-button')
			.click(function() {
				jQuery('html, body').animate({
					scrollTop: jQuery(".sermon-contact:first").offset().top
				}, 2000);
				jQuery('.sermon-form:first').slideDown();
			});

	});

}(jQuery));
