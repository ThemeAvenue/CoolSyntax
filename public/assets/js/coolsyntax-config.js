/*global jQuery:false */
(function ($) {
	'use strict';

	/////////////////////
	// Document Ready //
	/////////////////////
	$(function () {
		$('pre').click(function (e) {
			e.preventDefault();
			var pre = $(this),
				code = pre.text();

			// Create a copy of the code in a textarea, and disable spellcheck
			var textarea = $('<textarea class="wpcs-code-copy" spellcheck="false">' + code + '</textarea>');
			pre.hide().after(textarea);

			// Resize textarea to match its content and select content
			textarea.autosize().select();

		});

		/* Click outside remove the textarea */
		// http://stackoverflow.com/questions/152975/how-to-detect-a-click-outside-an-element
		$(document).on('focusout', '.wpcs-code-copy', function (e) {
			e.preventDefault();
			$(this).prev('pre').show();
			$(this).remove();
		});
	});

}(jQuery));