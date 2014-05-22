(function ($) {
	tinymce.create(
		'tinymce.plugins.myPlugin', {
			/**
			 * @param tinymce.Editor editor
			 * @param string url
			 */
			init: function (ed, url) {
				/**
				 *  register a new button
				 */

				///////////////////////////////////////////////////////////////////////////
				// http://www.tinymce.com/wiki.php/Tutorial:Migration_guide_from_3.x //
				///////////////////////////////////////////////////////////////////////////
				ed.addButton(
					'coolsyntax_button', {
						cmd: 'my_plugin_button_cmd',
						title: ed.getLang('myPlugin.buttonTitle', 'Add Code'),
						image: url + '/button.png',
						onPostRender: function () {
							var ctrl = this;

							///////////////////////////////////////
							// Allow editing of selection //
							///////////////////////////////////////
							if (window.tinyMCE) {

								var version = tinymce.majorVersion;

								if (version < 4) {
									/* Old 3.0 API */
									ed.onNodeChange.add(function (ed, cm, node) {
										console.log(e.element);
									});
									ed.onNodeChange.add(function (ed, cm, n) {
										active = ed.formatter.match('my_plugin_button_cmd');
										ctrl = ed.controlManager.get('coolsyntax_button').setActive(active);
									});

								} else {
									/* New 4.0 API */
									ed.on('NodeChange', function (e) {
										ctrl.active(e.element.nodeName == 'CODE');
										if (e.element.nodeName == 'CODE') {
											console.log(e.element, e.element.nodeName);
											// e.element.className += ' pre-active';
											// @TODO: retrieve the code as string and insert into textarea
											// document.getElementById('cs-code').value = e.element;
										} else {
											// @TODO: remove class .pre-active from all nodes
											// e.element.classList.remove('pre-active');
										}
									});
								}
							}
						}
					}
				);

				/**
				 * and a new command
				 */

				ed.addCommand(
					'my_plugin_button_cmd',
					function () {
						// triggers the thickbox
						var width = jQuery(window).width(),
							H = jQuery(window).height(),
							W = (720 < width) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show('Insert Code', '#TB_inline?width=' + W + '&height=400&inlineId=coolsyntax-dialog');
					}
				);

			}
		});

	// register plugin
	tinymce.PluginManager.add('coolsyntax', tinymce.plugins.myPlugin);

})();