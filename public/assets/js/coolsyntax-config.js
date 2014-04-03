/*global jQuery:false */
(function($) {
	'use strict';

	/////////////////////
	// Document Ready //
	/////////////////////
	$(function() {
		var codeToHighlight = $('pre');

		///////////////////////////////////
		// Transform pre into textarea //
		///////////////////////////////////
		codeToHighlight.click(function(e) {
			e.preventDefault();

			var pre = $(this);

			// Remove the "click to select" hint
			$('.wpcs-code-select').remove();

			// Create a copy of the code in a textarea, and disable spellcheck
			var textarea = $('<textarea class="wpcs-code-copy" spellcheck="false">' + pre.text() + '</textarea>');
			pre.hide().after(textarea);

			// Resize textarea to match its content and select content
			if (jQuery().autosize) {
				textarea.autosize().select();
			} else {
				textarea.select();
			}

		});

		//////////////////////////
		// Give hint to users //
		//////////////////////////
		codeToHighlight.css('position', 'relative');
		codeToHighlight.hover(function() {
			$(this).append('<span class="wpcs-code-select">Click to select</span>');
			$('.wpcs-code-select').fadeIn();
		}, function() {
			$('.wpcs-code-select').remove();
		});

		/////////////////////////////////////////
		// Click outside remove the textarea //
		/////////////////////////////////////////
		/// http://stackoverflow.com/questions/152975/how-to-detect-a-click-outside-an-element
		$(document).on('focusout', '.wpcs-code-copy', function(e) {
			e.preventDefault();
			$(this).prev('pre').show();
			$(this).remove();
		});
	});

}(jQuery));