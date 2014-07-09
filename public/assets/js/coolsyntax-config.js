/*global jQuery:false */
(function ($) {
	'use strict';

	$(function () {
		var pre = $('pre.coolsyntax');
		pre.each(function (index, el) {

			Prism.highlightAll(false, function () {

				// Define variables and retrieve all style associated with the <pre>
				// Needs to get height() after the highlighting is done (See http://prismjs.com/extending.html)

				var pre = $(el),
					preHeight = pre.outerHeight(),
					preMarginB = pre.css('marginBottom');

				var newEl = {
					hint: $('<span>', {
						class: 'wpcs-code-select',
						text: 'Click to select'
					}),
					textarea: $('<textarea>', {
						class: 'wpcs-code-copy',
						id: 'wpcs-' + index,
						spellcheck: 'false',
						html: pre.text(),
						outerHeight: preHeight
					})
				};

				newEl.textarea.css('marginBottom', preMarginB);

				//////////////////////////////////////////
				// onCLICK: transform into textarea //
				//////////////////////////////////////////
				pre.click(function (e) {
					e.preventDefault();

					// Remove the "click to select" hint
					newEl.hint.remove();

					// Insert the copy of the textarea's code after the textarea
					pre.hide().after(newEl.textarea);

					// Select content
					newEl.textarea.select();

				});

				////////////////////////////////////
				// onHOVER: Give hint to users //
				////////////////////////////////////
				pre.hover(function () {
					newEl.hint.appendTo($(this));
				}, function () {
					newEl.hint.remove();
				});

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