(function ($) {
	
	"use strict";

	$(document).ready(function() {

		// Comments
		$(".commentlist li").addClass("panel panel-default");
		$(".comment-reply-link").addClass("btn btn-default");
	
		// Forms
		$('select, input[type=text], input[type=email], input[type=password], textarea').addClass('form-control');
		$('input[type=submit]').addClass('btn btn-primary');
		
		// Add missing container to sermon manager template
		jQuery('body.single-wpfc_sermon').addClass('container');
		jQuery('body.single-wpfc_sermon #sidebar').hide();

		// Sermon contact form
		jQuery('.sermon-contact:eq(0), .sermon-contact:eq(1), .sermon-contact:eq(2)').empty().append('<span class="dashicons dashicons-testimonial"></span><a class="sermon-contact-button" href="#">Ask a question or make a comment</a>');
		jQuery('.sermon-contact:eq(0) .sermon-contact-button')
			.click(function() {
				jQuery('html, body').animate({
					scrollTop: jQuery(".sermon-contact:eq(0)").offset().top
				}, 2000);
				jQuery('.sermon-form:eq(0)').slideDown();
			});
		jQuery('.sermon-contact:eq(1) .sermon-contact-button')
			.click(function() {
				jQuery('html, body').animate({
					scrollTop: jQuery(".sermon-contact:eq(1)").offset().top
				}, 2000);
				jQuery('.sermon-form:eq(1)').slideDown();
			});
		jQuery('.sermon-contact:eq(2) .sermon-contact-button')
			.click(function() {
				jQuery('html, body').animate({
					scrollTop: jQuery(".sermon-contact:eq(2)").offset().top
				}, 2000);
				jQuery('.sermon-form:eq(2)').slideDown();
			});

	});

}(jQuery));
