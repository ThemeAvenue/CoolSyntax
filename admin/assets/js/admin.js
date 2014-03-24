(function ($) {
	"use strict";

	////////////////
	// Functions //
	////////////////
	function init() {
		tinyMCEPopup.resizeToInnerSize();
	}

	var entityMap = {
		"&": "&amp;",
		"<": "&lt;",
		">": "&gt;",
		'"': '&quot;',
		"'": '&#39;',
		"/": '&#x2F;'
	};

	function escapeHtml(string) {
		return String(string).replace(/[&<>"'\/]/g, function (s) {
			return entityMap[s];
		});
	}

	function insertCS() {
		var csWrap,
			csLanguage = $('#cs-language').val(),
			csCode = $('#cs-code').val();

		csWrap = '<pre><code class="lang-' + csLanguage + '">' + escapeHtml(csCode) + '</code></pre>';
		console.log(csLanguage, csCode);

		if (window.tinyMCE) {
			/* Old 3.0 API */
			// window.tinyMCE.execInstanceCommand(window.tinyMCE.activeEditor.id, 'mceInsertContent', false, csWrap);

			/* New 4.0 API */
			window.tinyMCE.execCommand('mceInsertContent', false, csWrap);

			/* Close Thickbox */
			self.parent.tb_remove();
		}
		return;
	}

	/////////////////////
	// Document Ready //
	/////////////////////
	$(function () {

		console.log('TinyMCE version:' + tinymce.majorVersion + '.' + tinymce.minorVersion);

		$('.wpcs-insert-code').on('click', function (e) {
			e.preventDefault();
			insertCS();
		});

		$('.wpcs-lang-select > select').sort(function (a, b) {
			if (a.text > b.text) return 1;
			else if (a.text < b.text) return -1;
			else return 0;
		});

		$('.wpcs-lang-favorite > button').on('click', function (e) {
			e.preventDefault();
			var language = $(this).attr('title');
			console.log(language);
			$('#cs-language').val(language);
		});

		if (jQuery().autosize) {
			$('.wpcs-textarea').autosize();
		}

	});

}(jQuery));