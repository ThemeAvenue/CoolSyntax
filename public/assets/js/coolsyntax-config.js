/*global jQuery:false */
(function ($) {
	'use strict';

	/////////////////////
	// Document Ready //
	/////////////////////
	$(function () {
		var pre = $('pre');
		pre.css('position', 'relative');

		pre.each(function (index, el) {

			// Define variables and retrieve all style associated with the <pre>
			var pre = $(this),
				preHeight = $(this).outerHeight(),
				preMarginB = $(this).css('marginBottom');

			//////////////////////////////////////////
			// onCLICK: transform into textarea //
			//////////////////////////////////////////
			pre.click(function (e) {
				e.preventDefault();

				// Remove the "click to select" hint
				$('.wpcs-code-select').remove();

				// Create a copy of the code in a textarea, and disable spellcheck
				var textarea = $('<textarea class="wpcs-code-copy" spellcheck="false">' + pre.text() + '</textarea>');
				textarea.css({
					height: preHeight,
					marginBottom: preMarginB
				});
				pre.hide().after(textarea);

				// Select content
				textarea.select();

			});

			////////////////////////////////////
			// onHOVER: Give hint to users //
			////////////////////////////////////
			pre.hover(function () {
				$(this).append('<span class="wpcs-code-select">Click to select</span>');
				$('.wpcs-code-select').fadeIn();
			}, function () {
				$('.wpcs-code-select').remove();
			});


		});

		/////////////////////////////////////////
		// Click outside remove the textarea //
		/////////////////////////////////////////
		/// http://stackoverflow.com/questions/152975/how-to-detect-a-click-outside-an-element
		$(document).on('focusout', '.wpcs-code-copy', function (e) {
			e.preventDefault();
			$(this).prev('pre').show();
			$(this).remove();
		});
	});

}(jQuery));